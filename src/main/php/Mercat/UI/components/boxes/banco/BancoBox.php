<?php

namespace Mercat\UI\components\boxes\banco;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Mercat\Core\model\Banco;

use Rasty\utils\LinkBuilder;

/**
 * Banco.
 *
 * @author Bernardo
 * @since 11-06-2014
 */
class BancoBox extends RastyComponent{

	private $banco;

	public function getType(){

		return "BancoBox";

	}

	public function __construct(){


	}

	protected function parseLabels(XTemplate $xtpl){

		$xtpl->assign("lbl_cbu",  $this->localize( "banco.cbu" ) );
		$xtpl->assign("lbl_saldo",  $this->localize( "banco.saldo" ) );
		$xtpl->assign("lbl_numero",  $this->localize( "banco.numero" ) );
		$xtpl->assign("lbl_titular",  $this->localize( "banco.titular" ) );
		$xtpl->assign("lbl_saldoInicial",  $this->localize( "banco.saldoInicial" ) );
		$xtpl->assign("lbl_nombre",  $this->localize( "banco.nombre" ) );
		$xtpl->assign("lbl_cuit",  $this->localize( "banco.cuit" ) );


	}

	protected function parseXTemplate(XTemplate $xtpl){

		/*labels*/
		$this->parseLabels($xtpl);

		$banco = $this->getBanco();

		if( !empty($banco )){

			$xtpl->assign("numero",  $banco->getNumero() );
			$xtpl->assign("nombre",  $banco->getNombre() );
			$xtpl->assign("cbu",  $banco->getCbu() );
			$xtpl->assign("saldo",  MercatUIUtils::formatMontoToView($banco->getSaldo()) );
			$xtpl->assign("saldoInicial",  MercatUIUtils::formatMontoToView($banco->getSaldoInicial()) );
			$xtpl->assign("titular",  $banco->getTitular() );
			$xtpl->assign("cuit",  $banco->getCuit() );

		}

	}


	protected function initObserverEventType(){
		$this->addEventType( "Banco" );
	}

	public function setBancoOid($oid){
		if( !empty($oid) ){
			$banco = UIServiceFactory::getUIBancoService()->get($oid);
			$this->setBanco($banco);
		}
	}


	public function getBanco()
	{
	    return $this->banco;
	}

	public function setBanco($banco)
	{
	    $this->banco = $banco;
	}
}
?>
