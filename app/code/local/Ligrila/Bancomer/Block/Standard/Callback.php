<?php
class Ligrila_Bancomer_Block_Standard_Callback extends Mage_Core_Block_Template {

	protected function _construct() {
		parent::_construct();
		$session = Mage::getSingleton('checkout/session');
		$order	= Mage::getModel('sales/order')->load($session->getLastOrderId());
		$status = $order->bancomer_status;

		if ($status == 'ERROR' ){
			$message = $order->bancomer_message;
			$session->addError($message);
			$callback = Mage::getUrl('checkout/cart');
		} else{
			if (! is_null($status) && $status == 'SUCCESS' ){
				$callback = Mage::getUrl('checkout/onepage/success');
			} else{
				$callback = Mage::getUrl('/');
			}
		}

		$this->setTemplate('bancomer/callback.phtml');
		$this->assign("callbackUrl", $callback );
	}
}