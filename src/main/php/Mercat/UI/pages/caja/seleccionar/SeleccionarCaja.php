<?php
namespace Mercat\UI\pages\caja\seleccionar;


use Mercat\UI\service\finder\CajaFinder;

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

class SeleccionarCaja extends MercatPage{

	private $caja;
	
	private $error;
	
	public function __construct(){
		
		if(MercatUIUtils::isCajaSelected())
			$this->caja = UIServiceFactory::getUICajaService()->get( MercatUIUtils::getCaja()->getOid() );
		
	}

	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("legend",  $this->localize( "caja.seleccionar.legend" ) );

		$xtpl->assign("caja_legend",  $this->localize( "caja.seleccionar.caja_legend" ) );
		$xtpl->assign("lbl_caja",  $this->localize( "caja" ) );
		
		$xtpl->assign("lbl_submit",  $this->localize( "form.aceptar" ) );
		$xtpl->assign("lbl_cancel",  $this->localize( "form.cancelar" ) );
		
	}

	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels*/
		$this->parseLabels($xtpl);
		
		
		
		$xtpl->assign("action", $this->getLinkActionSeleccionarCaja() );
		$xtpl->assign("cancel",  $this->getLinkCajaHome() );
			
		$msg = $this->getError();
		
		if( !empty($msg) ){
			
			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
	}
	
	public function getTitle(){
		return $this->localize("caja.seleccionar.title") ;
	}

	public function getType(){
		
		return "SeleccionarCaja";
		
	}	


	public function getCaja()
	{
	    return $this->caja;
	}

	public function setCaja($caja)
	{
	    $this->caja = $caja;
	}


	public function getError()
	{
	    return $this->error;
	}

	public function setError($error)
	{
	    $this->error = $error;
	}
	
	
	public function getCajas(){
		
		if( MercatUIUtils::isAdminLogged() )
		
			$cajas = UIServiceFactory::getUICajaService()->getCajasAbiertas();
			
		else 
			
			$cajas = UIServiceFactory::getUICajaService()->getCajasAbiertas( new \DateTime() );
		
		return $cajas;
		
	}
	
	public function getCajaFinderClazz(){
		
		return get_class( new CajaFinder() );
		
	}

	public function setCajaOid( $cajaOid ){
		
		if(!empty($cajaOid)){
			
			$caja = UIServiceFactory::getUICajaService()->get($cajaOid);
			$this->caja = $caja;
		}
		
	}
}
?>