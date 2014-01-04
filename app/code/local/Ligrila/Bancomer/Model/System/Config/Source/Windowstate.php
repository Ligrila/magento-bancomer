<?php
class Ligrila_Bancomer_Model_System_Config_Source_Windowstate {
	public function toOptionArray(){
		return array(
			array('value'=>1, 'label'=>Mage::helper('adminhtml')->__('POP Up - Standard (1)')),
			array('value'=>2, 'label'=>Mage::helper('adminhtml')->__('Full Screen - Same Window (2)')),
		);
	}
}