<?php

namespace Cuentas\UI\Test\clientes;

use Cuentas\UI\components\filter\model\UIClienteCriteria;

use Cuentas\UI\service\UIServiceFactory;

include_once dirname(__DIR__). '/conf/init.php';

use Cuentas\UI\Test\GenericTest;


class ListClientesTest extends GenericTest{
	
	/**
	 */
	public function test(){

		$this->log("listando clientes", __CLASS__);
		
		$clientes = UIServiceFactory::getUIClienteService()->getList(new UIClienteCriteria());
		foreach ($clientes as $cliente) {
			$this->log("cliente " . $cliente->getNombre(), __CLASS__);
		}
		
		
		
	}
}
?>