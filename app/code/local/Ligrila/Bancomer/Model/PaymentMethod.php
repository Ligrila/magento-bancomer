<?php

/**
*
*	Implementación del TPV del bancomer
*	@author Leandro Emanuel López <info@ligrila.com>
*/

class Ligrila_Bancomer_Model_PaymentMethod extends Mage_Payment_Model_Method_Abstract {
	//changing the payment to different from cc payment type ....
	const	PAYMENT_TYPE_AUTH	=	'AUTHORIZATION';
	const	PAYMENT_TYPE_SALE	=	'SALE';

	protected	$_code  = 'bancomer';
	protected	$_formBlockType = 'bancomer/standard_form';
	protected	$_allowCurrencyCode = array(
	'ADP','AED','AFA','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZM','BAM','BBD','BDT','BGL','BGN','BHD','BIF','BMD','BND','BOB',
	'BOV','BRL','BSD','BTN','BWP','BYR','BZD','CAD','CDF','CHF','CLF','CLP','CNY','COP','CRC','CUP','CVE','CYP','CZK','DJF','DKK',
	'DOP','DZD','ECS','ECV','EEK','EGP','ERN','ETB','EUR','FJD','FKP','GBP','GEL','GHC','GIP','GMD','GNF','GTQ','GWP','GYD','HKD',
	'HNL','HRK','HTG','HUF','IDR','ILS','INR','IQD','IRR','ISK','JMD','JOD','JPY','KES','KGS','KHR','KMF','KPW','KRW','KWD','KYD',
	'KZT','LAK','LBP','LKR','LRD','LSL','LTL','LVL','LYD','MAD','MDL','MGF','MKD','MMK','MNT','MOP','MRO','MTL','MUR','MVR','MWK',
	'MXN','MXV','MYR','MZM','NAD','NGN','NIO','NOK','NPR','NZD','OMR','PAB','PEN','PGK','PHP','PKR','PLN','PYG','QAR','ROL','RUB',
	'RUR','RWF','SAR','SBD','SCR','SDD','SEK','SGD','SHP','SIT','SKK','SLL','SOS','SRG','STD','SVC','SYP','SZL','THB','TJS','TMM',
	'TND','TOP','TPE','TRL','TRY','TTD','TWD','TZS','UAH','UGX','USD','UYU','UZS','VEB','VND','VUV','XAF','XCD','XOF','XPF','YER',
	'YUM','ZAR','ZMK','ZWD'
	);

	public function getSession() {
		return	Mage::getSingleton('bancomer/session');
	}

	/**
	* Get checkout session namespace
	*
	* @return Mage_Checkout_Model_Session
	*/
	public function getCheckout() {
		return	Mage::getSingleton('checkout/session');
	}

	/**
	* Get current quote
	*
	* @return Mage_Sales_Model_Quote
	*/
	public function getQuote() {
		return	$this->getCheckout()->getQuote();
	}

	/**
	* Using internal pages for input payment data
	*
	* @return bool
	*/
	public function canUseInternal() {
		return	false;
	}

	/**
	* Using for multiple shipping address
	*
	* @return bool
	*/
	public function canUseForMultishipping() {
		return	true;
	}


	/*validate the currency code is avaialable to use for bancomer or not*/
	public function validate() {
		parent::validate();
		$currency_code = $this->getQuote()->getBaseCurrencyCode();
		if(!in_array($currency_code,$this->_allowCurrencyCode)) {
			Mage::throwException(Mage::helper()->__('Currency code (%s) is not compatible with Bancomer',$currency_code));
		}
		return	$this;
	}

	public function onOrderValidate(Mage_Sales_Model_Order_Payment $payment) {
		return	$this;
	}

	public function onInvoiceCreate(Mage_Sales_Model_Invoice_Payment $payment) {
	}

	public function canCapture() {
		return true;
	}

	public function getOrderPlaceRedirectUrl() {
		return Mage::getUrl('bancomer/standard/redirect');
	}

	//
	// Convert from Magento currency to Bancomer currency
	//
	public function convertToBancomerCurrency($cur) {
		switch ($cur) {
			case "ADP": return "020";
			case "AED": return "784";
			case "AFA": return "004";
			case "ALL": return "008";
			case "AMD": return "051";
			case "ANG": return "532";
			case "AOA": return "973";
			case "ARS": return "032";
			case "AUD": return "036";
			case "AWG": return "533";
			case "AZM": return "031";
			case "BAM": return "977";
			case "BBD": return "052";
			case "BDT": return "050";
			case "BGL": return "100";
			case "BGN": return "975";
			case "BHD": return "048";
			case "BIF": return "108";
			case "BMD": return "060";
			case "BND": return "096";
			case "BOB": return "068";
			case "BOV": return "984";
			case "BRL": return "986";
			case "BSD": return "044";
			case "BTN": return "064";
			case "BWP": return "072";
			case "BYR": return "974";
			case "BZD": return "084";
			case "CAD": return "124";
			case "CDF": return "976";
			case "CHF": return "756";
			case "CLF": return "990";
			case "CLP": return "152";
			case "CNY": return "156";
			case "COP": return "170";
			case "CRC": return "188";
			case "CUP": return "192";
			case "CVE": return "132";
			case "CYP": return "196";
			case "CZK": return "203";
			case "DJF": return "262";
			case "DKK": return "208";
			case "DOP": return "214";
			case "DZD": return "012";
			case "ECS": return "218";
			case "ECV": return "983";
			case "EEK": return "233";
			case "EGP": return "818";
			case "ERN": return "232";
			case "ETB": return "230";
			case "EUR": return "978";
			case "FJD": return "242";
			case "FKP": return "238";
			case "GBP": return "826";
			case "GEL": return "981";
			case "GHC": return "288";
			case "GIP": return "292";
			case "GMD": return "270";
			case "GNF": return "324";
			case "GTQ": return "320";
			case "GWP": return "624";
			case "GYD": return "328";
			case "HKD": return "344";
			case "HNL": return "340";
			case "HRK": return "191";
			case "HTG": return "332";
			case "HUF": return "348";
			case "IDR": return "360";
			case "ILS": return "376";
			case "INR": return "356";
			case "IQD": return "368";
			case "IRR": return "364";
			case "ISK": return "352";
			case "JMD": return "388";
			case "JOD": return "400";
			case "JPY": return "392";
			case "KES": return "404";
			case "KGS": return "417";
			case "KHR": return "116";
			case "KMF": return "174";
			case "KPW": return "408";
			case "KRW": return "410";
			case "KWD": return "414";
			case "KYD": return "136";
			case "KZT": return "398";
			case "LAK": return "418";
			case "LBP": return "422";
			case "LKR": return "144";
			case "LRD": return "430";
			case "LSL": return "426";
			case "LTL": return "440";
			case "LVL": return "428";
			case "LYD": return "434";
			case "MAD": return "504";
			case "MDL": return "498";
			case "MGF": return "450";
			case "MKD": return "807";
			case "MMK": return "104";
			case "MNT": return "496";
			case "MOP": return "446";
			case "MRO": return "478";
			case "MTL": return "470";
			case "MUR": return "480";
			case "MVR": return "462";
			case "MWK": return "454";
			case "MXN": return "484";
			case "MXV": return "979";
			case "MYR": return "458";
			case "MZM": return "508";
			case "NAD": return "516";
			case "NGN": return "566";
			case "NIO": return "558";
			case "NOK": return "578";
			case "NPR": return "524";
			case "NZD": return "554";
			case "OMR": return "512";
			case "PAB": return "590";
			case "PEN": return "604";
			case "PGK": return "598";
			case "PHP": return "608";
			case "PKR": return "586";
			case "PLN": return "985";
			case "PYG": return "600";
			case "QAR": return "634";
			case "ROL": return "642";
			case "RUB": return "643";
			case "RUR": return "810";
			case "RWF": return "646";
			case "SAR": return "682";
			case "SBD": return "090";
			case "SCR": return "690";
			case "SDD": return "736";
			case "SEK": return "752";
			case "SGD": return "702";
			case "SHP": return "654";
			case "SIT": return "705";
			case "SKK": return "703";
			case "SLL": return "694";
			case "SOS": return "706";
			case "SRG": return "740";
			case "STD": return "678";
			case "SVC": return "222";
			case "SYP": return "760";
			case "SZL": return "748";
			case "THB": return "764";
			case "TJS": return "972";
			case "TMM": return "795";
			case "TND": return "788";
			case "TOP": return "776";
			case "TPE": return "626";
			case "TRL": return "792";
			case "TRY": return "949";
			case "TTD": return "780";
			case "TWD": return "901";
			case "TZS": return "834";
			case "UAH": return "980";
			case "UGX": return "800";
			case "USD": return "840";
			case "UYU": return "858";
			case "UZS": return "860";
			case "VEB": return "862";
			case "VND": return "704";
			case "VUV": return "548";
			case "XAF": return "950";
			case "XCD": return "951";
			case "XOF": return "952";
			case "XPF": return "953";
			case "YER": return "886";
			case "YUM": return "891";
			case "ZAR": return "710";
			case "ZMK": return "894";
			case "ZWD": return "716";
		}
		return "";
	}

	public function getCheckoutParams() {
		$a = $this->getQuote()->getShippingAddress();

		$order = Mage::getModel('sales/order');
		$order->loadByIncrementId($this->getCheckout()->getLastRealOrderId());
		
		$convertor = Mage::getModel('sales/convert_order');
		$invoice = $convertor->toInvoice($order); 

		$amount = $order->getTotalDue();
		$Ds_Merchant_Order = $this->getCheckout()->getLastRealOrderId();


		$bancomerHelper = Mage::helper('bancomer');
		
		$Ds_Merchant_MerchantCode = $this->getConfigData('comercio_id');
		$Ds_Merchant_Terminal = $this->getConfigData('terminal_id');
		$idTransaccion = $bancomerHelper->idTransaccion();
		$clave = $this->getConfigData('clave');

		$Ds_Merchant_MerchantURL = Mage::getUrl('bancomer/standard/response/localizador/'.$Ds_Merchant_Order);
		$callback = $this->getCallbackUrl();
		$Ds_Merchant_Currency = $this->convertToBancomerCurrency($order->getOrderCurrencyCode());
		$amount = $bancomerHelper->formatImporte($amount);
		$Ds_Merchant_Amount = $amount;
// 		$Ds_Merchant_Currency = 484;


		// Digest = SHA-1(Ds_Merchant_Amount     + Ds_Merchant_Order 
		// + Ds_Merchant_MerchantCode    + Ds_Merchant_Currency 
		// + Ds_Merchant_TransactionType + CLAVE SECRETA)
		$Ds_Merchant_TransactionType = 0;

		$Ds_Merchant_MerchantSignature = sha1("$Ds_Merchant_Amount$Ds_Merchant_Order$Ds_Merchant_MerchantCode$Ds_Merchant_Currency$Ds_Merchant_TransactionType$clave");



		$peticion = array(
			'Ds_Merchant_Amount' => $Ds_Merchant_Amount,
			'Ds_Merchant_Currency' => $Ds_Merchant_Currency,
			'Ds_Merchant_Order' => $Ds_Merchant_Order,
			'Ds_Merchant_ProductDescription' => sprintf(Mage::helper('bancomer')->__('Order %s'),$Ds_Merchant_Order),
			'Ds_Merchant_MerchantCode' => $Ds_Merchant_MerchantCode,
			'Ds_Merchant_MerchantURL' => $Ds_Merchant_MerchantURL,
			'Ds_Merchant_UrlOK' => $callback,
			'Ds_Merchant_UrlKO' => $callback . '?action=cancel',
			'Ds_Merchant_MerchantSignature' => $Ds_Merchant_MerchantSignature,
			'Ds_Merchant_TransactionType' => $Ds_Merchant_TransactionType,
			'Ds_Merchant_Terminal' => $Ds_Merchant_Terminal
			
		); 

		$params = array(
			'peticion' => $peticion,
			'windowstate' => $this->getConfigData('windowstate')
		);

		//guardamos el id de la transaccion en la orden
		$order->bancomer_pago_id = $idTransaccion;
		$order->bancomer_status = "SIN_PROCESAR";
		$order->save();
		return $params;
	}
	/**
		Cuando se produce un error en la petición: ej. no se puede pagar, error de firma, etc
	*/


	function processResponse($params){
		if(isset($params['Ds_Amount'])&&isset($params['Ds_Order'])&&isset($params['Ds_MerchantCode'])&&isset($params['Ds_currency'])&&isset($params['Ds_Response'])&&isset($params['Ds_Signature'])&&isset($params['localizador'])){
			$Ds_Amount = $params['Ds_Amount'];
			$Ds_Order = $params['Ds_Order'];
			$Ds_MerchantCode = $params['Ds_MerchantCode'];
			$Ds_Currency = $params['Ds_currency'];
			$Ds_Response = $params['Ds_Response'];
			$Ds_Signature = $params['Ds_Signature'];
			$clave = $this->getConfigData('clave');
			$localizador = $params['localizador'];
			$firma = strtoupper(sha1("$Ds_Amount$Ds_Order$Ds_MerchantCode$Ds_Currency$Ds_Response$clave"));

			if($firma==$Ds_Signature){
					$response = (int)$Ds_Response;
					if($response===0){
						//aceptado
						$this->peticionCorrecta($params,$localizador);
					} else{
						$comment = Mage::helper('bancomer')->__("Transaction refused by the bank : %s",$Ds_Response);
						$this->errorPeticion($localizador,$comment);
					}
			} else{
					die("Invalid signature");
			}

		} else{
			die("Invalid request");
		}
	}

	public function errorPeticion($orderID,$comment){
		$orderStatus = $this->getConfigData('error_status');
		// Load the order number
		$order = Mage::getModel('sales/order')->loadByIncrementId($orderID);
		if($order->bancomer_status == 'SUCCESS'){
			return;
		}
		if (((int)$this->getConfigData('sendmailorderconfirmation')) == 1) {
			$order->sendOrderUpdateEmail(true,$comment);
		}
		$order->setState($orderStatus,$orderStatus,$comment);
		$order->bancomer_status = 'ERROR';
		$order->bancomer_message = $comment;
		$order->save();
	}

	/**
		aquí se entra cuando la petición es correcta. Pero no quiere decir que el pago haya sido realizado. El metodo
		analiza la información y en caso de que haya error se llama a this->errorPeticion
	*/
	public function peticionCorrecta($params,$orderID){
		$transaccionID = $params['Ds_Order'];

		$orderStatus = $this->getConfigData('order_status');

		$order = Mage::getModel('sales/order')->loadByIncrementId($orderID);

		if (((int)$this->getConfigData('sendmailorderconfirmation')) == 1) {
			$order->sendNewOrderEmail();
		}

		$comment = Mage::helper('bancomer')->__("Payment was made correctly with transaction id : %s",$transaccionID);


		$order->bancomer_status = 'SUCCESS';

		$order->bancomer_message = $comment;

		if((bool)$this->getConfigData('autoinvoice')){
			$invoice = $order->prepareInvoice();
			$invoice->register()->capture();
			Mage::getModel('core/resource_transaction')
				->addObject($invoice)
				->addObject($invoice->getOrder())
				->save();
			$comment .= Mage::helper('bancomer')->__('<br />Invoice #%s created', $invoice->getIncrementId());
		}

		$order->setState($orderStatus,$orderStatus,$comment);

		$order->save();
	}

	public function getCallbackUrl(){
		return Mage::getUrl('bancomer/standard/callback');
	}

	public function createFormBlock($name) {
		$block	= $this->getLayout()->createBlock('bancomer/standard_form', $name)
			->setMethod('bancomer_standard')
			->setPayment($this->getPayment())
			->setTemplate('bancomer/form.phtml');

		return	$block;
	}


	public function getBancomerUrl() {
		return 'https://www.bancomer.eglobal.com.mx/sis/entradaPagos';
	}
}
?>