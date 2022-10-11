<?php

namespace Cuentas\UI\Test\gastos;

use Cuentas\UI\service\UIServiceFactory;

include_once dirname(__DIR__). '/conf/init.php';

use Cuentas\UI\Test\GenericTest;


class ListGastosAnioTest extends GenericTest{
	
	/**
	 */
	public function test(){

		$this->log("listando gastos", __CLASS__);
		
		$gastos = UIServiceFactory::getUIGastoService()->getTotalesAnioPorMesConcepto(2015);
		
		$this->logObject($gastos);
		
		$this->log("Anio: " . $gastos["anio"], __CLASS__);
		$this->log("Totales: " . $gastos["totales"], __CLASS__);
		
		$detalles = $gastos["detalles"];
		
		foreach ($detalles as $concepto => $detalleConceptoPorMes) {
			
			$this->log("***********************************", __CLASS__);
			$this->log("Concepto: " . $concepto, __CLASS__);
			$this->log("***********************************", __CLASS__);
			
			for ($mes = 1; $mes <=12; $mes++) {
				$this->log("Mes $mes: " . $detalleConceptoPorMes[$mes], __CLASS__);

			}
			$this->log("Total x Concepto " .  $detalleConceptoPorMes["total"], __CLASS__);
						
		}
		
		
		
	}
}
?>