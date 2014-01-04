<?php

$installer = $this;
/* @var $installer Ligrila_Bancomer_Model_Mysql4_Setup */

$installer->startSetup();

$installer->addAttribute('order', 'bancomer_status', array());
$installer->addAttribute('order', 'bancomer_message', array());
$installer->addAttribute('order', 'bancomer_pago_id', array());
$installer->endSetup();



