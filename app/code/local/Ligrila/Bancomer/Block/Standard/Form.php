<?php
class Ligrila_Bancomer_Block_Standard_Form extends Mage_Payment_Block_Form {
	protected function _construct() {
		$this->setTemplate('bancomer/form.phtml');
		parent::_construct();
	}
}