<?php
namespace Mercat\UI\pages\caja\rendir;

use Mercat\UI\service\UICuentaCorrienteService;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\utils\MercatUIUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;
use Rasty\utils\LinkBuilder;

use Mercat\Core\model\Caja;

use Rasty\Grid\filter\model\UICriteria;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class RendirCaja extends MercatPage{

	private $caja;
	private $ventasOnline;
	private $pagosOnline;
	private $fecha;
	
	public function __construct(){
		

		$this->fecha = new \DateTime();

		if(MercatUIUtils::isCajaSelected())
			$this->caja = MercatUIUtils::getCaja();
		else	
			$this->caja = new Caja();
		
	}

	public function setCajaOid($oid){
		if(!empty($oid)){
			$caja = UIServiceFactory::getUICajaService()->get( $oid );
			$this->setCaja($caja);
		}
	}
	
	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("lbl_saldo",  $this->localize( "caja.saldo" ) );
		$xtpl->assign("lbl_saldoInicial",  $this->localize( "caja.saldoInicial" ) );
		$xtpl->assign("lbl_ventas",  $this->localize( "caja.ventas" ) );
		$xtpl->assign("lbl_pagos",  $this->localize( "caja.pagos" ) );
		$xtpl->assign("lbl_gastos",  $this->localize( "caja.gastos" ) );
		$xtpl->assign("lbl_pagosCtasCtes",  $this->localize( "caja.pagos.ctasctes" ) );
		$xtpl->assign("lbl_ventasCtasCtes",  $this->localize( "caja.ventas.ctasctes" ) );
		$xtpl->assign("lbl_ventasOnline",  $this->localize( "caja.ventas.online" ) );
		$xtpl->assign("lbl_pagosOnline",  $this->localize( "caja.pagos.online" ) );
		
		$xtpl->assign("lbl_rendirCaja",  $this->localize( "caja.rendir" ) );
//		$xtpl->assign("lbl_submit",  $this->localize( "form.aceptar" ) );
//		$xtpl->assign("lbl_cancel",  $this->localize( "form.cancelar" ) );

		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels*/
		$this->parseLabels($xtpl);
		
		$ventasCtasCtes = UIServiceFactory::getUICuentaCorrienteService()->getTotalesVenta( $this->getFecha() );
		$xtpl->assign("ventasCtasCtes",  MercatUIUtils::formatMontoToView( $ventasCtasCtes) );
		$xtpl->assign("ventasCtasCtesUnformat",  $ventasCtasCtes );
		
		$pagosCtasCtes = UIServiceFactory::getUICuentaCorrienteService()->getTotalesPago( $this->getFecha() );
		$xtpl->assign("pagosCtasCtes",  MercatUIUtils::formatMontoToView( $pagosCtasCtes) );
		$xtpl->assign("pagosCtasCtesUnformat",  $pagosCtasCtes );
		
		$caja = $this->getCaja();
		
		if( !empty($caja )){

			$xtpl->assign("saldo",  MercatUIUtils::formatMontoToView($caja->getSaldo()) );	
			$xtpl->assign("saldoInicial",  MercatUIUtils::formatMontoToView($caja->getSaldoInicial()) );
			$xtpl->assign("saldoInicialUnformat", $caja->getSaldoInicial() );
			
			$gastos = UIServiceFactory::getUIGastoService()->getTotalesCuenta($caja);
			$xtpl->assign("gastos",  MercatUIUtils::formatMontoToView($gastos) );
			$xtpl->assign("gastosUnformat",  $gastos );
		
			$pagos = UIServiceFactory::getUIPagoPremioService()->getTotalesCuenta($caja);
			$xtpl->assign("pagos",  MercatUIUtils::formatMontoToView($pagos) );
			$xtpl->assign("pagosUnformat", $pagos );
			
			$ventas = UIServiceFactory::getUIVentaService()->getTotalesCuenta($caja);
			$xtpl->assign("ventas",  MercatUIUtils::formatMontoToView($ventas) );
			$xtpl->assign("ventasUnformat", $ventas );
					
		}
		
	}
	
	public function getTitle(){
		return $this->localize("caja.rendir.title") ;
	}

	public function getType(){
		
		return "RendirCaja";
		
	}	


	public function getCaja()
	{
	    return $this->caja;
	}

	public function setCaja($caja)
	{
	    $this->caja = $caja;
	}

	public function getVentasOnline()
	{
	    return $this->ventasOnline;
	}

	public function setVentasOnline($ventasOnline)
	{
	    $this->ventasOnline = $ventasOnline;
	}

	public function getPagosOnline()
	{
	    return $this->pagosOnline;
	}

	public function setPagosOnline($pagosOnline)
	{
	    $this->pagosOnline = $pagosOnline;
	}
	
	
	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}
	

	public function setStrFecha($strFecha){
		if( !empty($strFecha) ){
			$fecha = MercatUIUtils::newDateTime($strFecha) ;
			$this->setFecha($fecha);
		}
	}
	
}
?>