<?php
namespace Mercat\UI\pages\bancos\depositar;


use Mercat\UI\components\filter\model\UIBancoCriteria;

use Mercat\UI\service\finder\BancoFinder;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\utils\MercatUIUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;
use Rasty\utils\LinkBuilder;

use Rasty\Grid\filter\model\UICriteria;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class DepositarEfectivo extends MercatPage{

	private $fechaHora;
	private $banco;

	private $monto;
	private $observaciones;

	private $error;

	public function __construct(){
		$this->setFechaHora( new \Datetime() );
		$this->banco = UIServiceFactory::getUIBancoService()->getCuentaBAPRO();

	}

	protected function parseLabels(XTemplate $xtpl){

		$xtpl->assign("legend",  $this->localize( "banco.depositarEfectivo.legend" ) );

		$xtpl->assign("lbl_fechaHora",  $this->localize( "depositarEfectivo.fechaHora" ) );
		$xtpl->assign("lbl_montoDepositar",  $this->localize( "depositarEfectivo.montoDepositar" ) );
		$xtpl->assign("lbl_observaciones",  $this->localize( "depositarEfectivo.observaciones" ) );
		$xtpl->assign("lbl_banco",  $this->localize( "depositarEfectivo.banco" ) );

		$xtpl->assign("banco_legend",  $this->localize( "banco.depositarEfectivo.banco_legend" ) );

		$xtpl->assign("lbl_submit",  $this->localize( "form.aceptar" ) );
		$xtpl->assign("lbl_cancel",  $this->localize( "form.cancelar" ) );

	}

	protected function parseXTemplate(XTemplate $xtpl){

		/*labels*/
		$this->parseLabels($xtpl);



		$banco = $this->getBanco();

		if( !empty($banco) ){

			$xtpl->assign("action", $this->getLinkActionDepositarEfectivo() );
			$xtpl->assign("cancel",  $this->getLinkCajaHome() );

		}else{
		}

		$msg = $this->getError();

		if( !empty($msg) ){

			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
	}

	public function getTitle(){
		return $this->localize("banco.depositarEfectivo.title") ;
	}

	public function getType(){

		return "DepositarEfectivo";

	}


	public function getBanco()
	{
	    return $this->banco;
	}

	public function setBanco($banco)
	{
	    $this->banco = $banco;
	}

	public function getMonto()
	{
	    return $this->monto;
	}

	public function setMonto($monto)
	{
	    $this->monto = $monto;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
	}

	public function getError()
	{
	    return $this->error;
	}

	public function setError($error)
	{
	    $this->error = $error;
	}


	public function getBancos(){

		$bancos = UIServiceFactory::getUIBancoService()->getList( new UIBancoCriteria() );

		return $bancos;

	}

	public function getBancoFinderClazz(){

		return get_class( new BancoFinder() );

	}

	public function setBancoOid( $bancoOid ){

		if(!empty($bancoOid)){

			$banco = UIServiceFactory::getUIBancoService()->get($bancoOid);
			$this->banco = $banco;
		}

	}

	public function getFechaHora()
	{
	    return $this->fechaHora;
	}

	public function setFechaHora($fechaHora)
	{
	    $this->fechaHora = $fechaHora;
	}
}
?>
