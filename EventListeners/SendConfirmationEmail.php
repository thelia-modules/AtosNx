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

namespace AtosNx\EventListeners;

use Atos\Atos;
use AtosNx\AtosNx;
use Thelia\Core\Event\Order\OrderEvent;

/**
 * Class SendEmailConfirmation
 * @package Atos\EventListeners
 * @author manuel raynaud <mraynaud@openstudio.fr>
 * @author franck allimant <franck@cqfdev.fr>
 */
class SendConfirmationEmail extends \Atos\EventListeners\SendConfirmationEmail
{
    /**
     * @param OrderEvent $event
     *
     * @throws \Exception if the message cannot be loaded.
     */
    public function sendConfirmationOrNotificationEmail(OrderEvent $event)
    {
        if (Atos::getConfigValue('send_confirmation_message_only_if_paid')) {
            // We send the order confirmation email only if the order is paid
            $order = $event->getOrder();

            if (! $order->isPaid() && $order->getPaymentModuleId() == AtosNx::getModuleId()) {
                $event->stopPropagation();
            }
        }
    }
}
