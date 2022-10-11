<?php

namespace Mercat\UI\components\boxes\cuentaCorriente;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Mercat\Core\model\CuentaCorriente;
use Mercat\Core\model\Cliente;

use Rasty\utils\LinkBuilder;

/**
 * Banco.
 * 
 * @author Marcos
 * @since 23-03-2018
 */
class CuentaCorrienteBox extends RastyComponent{
		
	private $cuentaCorriente;
	
	public function getType(){
		
		return "CuentaCorrienteBox";
		
	}

	public function __construct(){
		
		
	}

	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("lbl_saldo",  $this->localize( "cuentaCorriente.saldo" ) );
		$xtpl->assign("lbl_numero",  $this->localize( "cuentaCorriente.numero" ) );
		$xtpl->assign("lbl_cliente",  $this->localize( "cuentaCorriente.cliente" ) );
		
				
	}
	
	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels*/
		$this->parseLabels($xtpl);
		
		$ctacte = $this->getCuentaCorriente();
		
		if( !empty($ctacte)){
			
			$xtpl->assign("numero",  $ctacte->getNumero() );
			$xtpl->assign("saldo",  MercatUIUtils::formatMontoToView($ctacte->getSaldo()) );
			$xtpl->assign("cliente",  $ctacte->getCliente() );
			
		}
						
	}
	
	
	protected function initObserverEventType(){
		$this->addEventType( "Cliente" );
	}
	
	public function setClienteOid($oid){
		if( !empty($oid) ){
			$cliente = UIServiceFactory::getUIClienteService()->get($oid);
			$this->setCuentaCorriente($cliente->getCuentaCorriente());
		}
	}   
    

	public function getCuentaCorriente()
	{
	    return $this->cuentaCorriente;
	}

	public function setCuentaCorriente($cuentaCorriente)
	{
	    $this->cuentaCorriente = $cuentaCorriente;
	}
}
?>