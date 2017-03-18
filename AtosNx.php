<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace AtosNx;

use Atos\Atos;
use Atos\Model\AtosCurrencyQuery;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Model\Order;

class AtosNx extends Atos
{
    /** @var string */
    const DOMAIN_NAME = 'atosnx';
    
    public function postActivation(ConnectionInterface $con = null)
    {
        // Setup some default values
        if (null === Atos::getConfigValue('nx_minimum_amount', null)) {
            Atos::setConfigValue('nx_minimum_amount', 0);
            Atos::setConfigValue('nx_maximum_amount', 0);
            Atos::setConfigValue('nx_nb_installments', 3);
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function checkMinMaxAmount()
    {
        // Check if total order amount is in the module's limits
        $order_total = $this->getCurrentOrderTotalAmount();
        
        $min_amount = Atos::getConfigValue('nx_minimum_amount', 0);
        $max_amount = Atos::getConfigValue('nx_maximum_amount', 0);
    
        $nb_installments = Atos::getConfigValue('nx_nb_installments', 1);

        $valid =
            $order_total > 0
            &&
            $nb_installments > 1
            &&
            ($min_amount <= 0 || $order_total >= $min_amount) && ($max_amount <= 0 || $order_total <= $max_amount);
        
        return $valid;
    }
    
    /**
     * @inheritdoc
     */
    public function pay(Order $order)
    {
        $atosCurrency = AtosCurrencyQuery::create()->findPk(
            $order->getCurrency()->getCode()
        );
    
        if (null == $atosCurrency) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Atos does not supprot this currency : %s",
                    $order->getCurrency()->getCode()
                )
            );
        }
    
        // Set the multiple times payment param
        $orderTotal = $this->getCurrentOrderTotalAmount();
        
        $installementsCount = Atos::getConfigValue('nx_nb_installments', 3);
        
        $installements = intval($orderTotal/$installementsCount);
        
        $initial = $installements + ($orderTotal - 3 * $installements);
        
        $this
            ->addParam("capture_mode", "PAYMENT_N")
            ->addParam("capture_day", 1)
            ->addParam("data", sprintf(
                "'NB_PAYMENT=%d;PERIOD=30;INITIAL_AMOUNT=%d;'",
                $installementsCount,
                number_format($initial, $atosCurrency->getDecimals(), '', ''))
            );
        
        return parent::pay($order);
    }
}
