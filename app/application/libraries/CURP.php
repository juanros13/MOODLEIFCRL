<?php

	class CURP 
	{
		protected $urlWSDL = "http://wsrenapo.stps.gob.mx/WsConsultaCURPSEP.svc?singleWsdl";
		
		public function __construct() { }
		
		public function getDataByCURP($curp)
		{
			try
			{
				
				$clienteCURP = new SoapClient($this->urlWSDL);
				$params = array
				(
					"datos"=>array
					(
						"cveCurp"=>$curp
					)
				);
			 	$userData = $clienteCURP->consultarPorCurpO($params);		
								
				return $userData;
			}
			catch(Execption $e)
			{
				return null;
			}
		}
	}

?>
