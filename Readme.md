# Atos-SIPS Multiple Payments Module
------------------------

## English instructions

This module offers to your customers multiple monthly payments of their orders with the Atos SIPS payment system, which is widely used by the french banks under different names: Mercanet, E-Transactions, Citelis, and much more.

### Installation

The Atos version 1.2.0 minimum should be installed and activated on your shop.

#### Manually

Install the Atos module using the Module page of your back office to upload the archive.

You can also extract the archive in the `<thelia root>/local/modules` directory. Be sure that the name of the module's directory is `AtosNx` (and not `AtosNx-master`, for example).

Activate the module from the Modules page of your back-office.

#### composer

```
$ composer require thelia/atos-nx-module:~1.0
```

### Usage

You have to configure the AtosNx module before starting to use it. To do so, go to the "Modules" tab of the Atos module, and enter the instalments count, and the order amount range for which the module will be active. 

## Instructions en français

Ce module est un compagnon du module Atos. Il vous permet de proposer à vos clients de payer leurs commande en plusieurs mensualités sans frais par carte bancaire via la plate-forme Atos SIPS, utilisée par de nombreuses banques françaises sous diverses dénominations commerciales: Mercanet, Citelis, E-Transactions, et bien d'autres.

## Installation

Le module Atos version 1.2.0 minimum doit être installé et activé sur votre boutique.

### Manuellement

Installez ce module directement depuis la page Modules de votre back-office, en envoyant le fichier zip du module.

Vous pouvez aussi décompresser le module, et le placer manuellement dans le dossier ```<thelia_root>/local/modules```. Assurez-vous que le nom du dossier est bien ```Atos```, et pas ```AtosNx-master```

### composer

```
$ composer require thelia/atos-nx-module:~1.0
```

## Utilisation

Pour utiliser le module AtosNx, vous devez tout d'abord le configurer, via la page de configuration du module Atos. Indiquez le nombre de mensualités que vous souhaitez proposer, ainsi que les montants de commande entre lesquels le module sera proposé.
