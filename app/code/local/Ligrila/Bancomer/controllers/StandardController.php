<?php

/**
*
*	Implementación del TPV del bancomer
*	@author Leandro Emanuel López <info@ligrila.com>
*/

class Ligrila_Bancomer_StandardController extends Mage_Core_Controller_Front_Action {

	protected function _expireAjax() {
		if (!Mage::getSingleton('checkout/session')->getQuote()->hasItems()) {
			$this->getResponse()->setHeader('HTTP/1.1','403 Session Expired');
			exit;
		}
	}

	/**
	 * Get singleton
	 *
	 * @return Ligrila_Bancomer_Model_PaymentMethod
	 */
	public function getStandard() {
		return Mage::getSingleton('bancomer/paymentMethod');
	}
	 
	/**
	 * When a customer chooses Bancomer on Checkout/Payment page
	 *
	 */
	public function redirectAction() {
		$session = Mage::getSingleton('checkout/session');
		if($session->getLastOrderId()){
			$session->setBancomerStandardQuoteId($session->getQuoteId());
			$state	=	Mage::getModel('bancomer/paymentMethod')->getConfigData('redirect_status');
			$order	=	Mage::getModel('sales/order')->load($session->getLastOrderId());
			/*
			PROTECCION DE PEDIDOS YA REALIZADOS
			*/
			if($order->bancomer_status=='SUCCESS'){
				$this->_redirect('checkout/onepage/success');
				return;
			}
			$order->setState($state,$state,Mage::helper('bancomer')->__('Entring to TPV'),false);
			$order->save();
			$this->loadLayout();
			$block = $this->getLayout()->createBlock('bancomer/standard_redirect');
			$this->getLayout()->getBlock('content')->append($block);
			$this->renderLayout();
		}
	}

	public function responseAction(){
		$params = $this->getRequest()->getParams();

		if(!empty($params)){
			$bancomer = Mage::getModel('bancomer/paymentMethod');
			$bancomer->processResponse($params);
		}

	}
	
	public function callbackAction() {
		$params = $this->getRequest()->getParams();
		if(isset($params['action']) && $params['action'] == 'cancel'){
				$session = Mage::getSingleton('checkout/session');
				$session->addError(Mage::helper('bancomer')->__('Payment canceled'),false);
				$this->_redirect('checkout');
				return;
		}
		$this->loadLayout();
		$this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');
		$this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('bancomer/standard_callback'));
 		$this->renderLayout();
	}
}