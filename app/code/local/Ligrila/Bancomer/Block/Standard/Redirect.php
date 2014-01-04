<?php
class Ligrila_Bancomer_Block_Standard_Redirect extends Mage_Core_Block_Template {

	protected function _construct() {
		$standard = Mage::getModel('bancomer/paymentMethod');
		$p = $standard->getCheckoutParams();
		$this->assign("peticion",$p['peticion']);
		$this->assign("windowstate",$p['windowstate']);
		$this->assign("action",$standard->getBancomerUrl());
	}
}