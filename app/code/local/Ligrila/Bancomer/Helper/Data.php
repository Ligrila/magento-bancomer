<?php

/**
 * Bancomer data helper
 */
class Ligrila_Bancomer_Helper_Data extends Mage_Core_Helper_Abstract {
	public function __construct(){
	}

	public function formatImporte($importe){
		$ret = (string) number_format($importe, 2,'.','');
		$ret = str_replace(".","",$ret);
		return (int) $ret;
		
	}
	public function importeFirma($importe){
		$explo_preu=explode(",",$importe);// formatear el importe de 87,5 a 875
		if (empty($explo_preu[1])){
			$explo_preu[1] = null;
		}
		$preuTemp=$explo_preu[1];
		if(strlen($preuTemp)==1) $preuTemp=$preuTemp.'0'; //En el caso de tener: XX.5 pasamo a XX.50
		elseif(strlen($preuTemp)==0) $preuTemp='00'; //En el caso de tener: XX pasamo a XX00 (añadiendo dos ceros finales)

		$importe_formateado=$explo_preu[0].$preuTemp; //Guardamos el importe formateado para el calculo de la firma
		return $importe_formateado;

	}
	static function idTransaccion(){
		$y=substr(date('y'),strlen(date('y'))-1,strlen(date('y')));
		$ddd=date('z'); //Devuelve el día del año desde 0 a 365
		if($ddd < 10) $ddd= '00'.$ddd; //añadimos 2 ceros en el caso de ser menos de 10
		else if($ddd > 9 && $ddd < 100) $ddd= '0'.$ddd; //añadimos un 0 en el caso de ser mayor de 9 y menor de 100
		$hh=date('H'); //Devuelve la hora en formato 00 a 24
		$mm=date('i'); //Devuelve los minutos desde 00 a 59
		$ss=date('s'); //Devueve los segundos en 00 a 59
		$an=rand('11','99'); //Devuelve un valor aleatorio ente 10-99
		return "$y$ddd$hh$mm$ss$an";
	}
}