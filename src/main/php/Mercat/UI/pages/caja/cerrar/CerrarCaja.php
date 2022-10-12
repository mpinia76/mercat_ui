<?php
namespace Mercat\UI\pages\caja\cerrar;

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

class CerrarCaja extends MercatPage{

	private $caja;
	
	public function __construct(){
		

		$this->caja = new Caja();
		
	}

	public function setCajaOid($oid){
		if(!empty($oid)){
			$caja = UIServiceFactory::getUICajaService()->get( $oid );
			$this->setCaja($caja);
		}
	}
	
	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("legend",  $this->localize( "caja.cerrar.legend" ) );
		
		$xtpl->assign("lbl_submit",  $this->localize( "form.aceptar" ) );
		$xtpl->assign("lbl_cancel",  $this->localize( "form.cancelar" ) );
		
	}

	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels*/
		$this->parseLabels($xtpl);
		
		
		$caja = $this->getCaja();
		
		if( !empty($caja) ){
			
			
			$xtpl->assign("cajaOid",  $caja->getOid() );
			$xtpl->assign("action",  $this->getLinkActionCerrarCaja() );
			$xtpl->assign("cancel",  $this->getLinkCajaHome() );
			
			$xtpl->assign("linkCerrarCaja", $this->getLinkCerrarCaja( $this->getCaja() ) );
			
		}else{
		}
	}
	
	public function getTitle(){
		return $this->localize("caja.cerrar.title") ;
	}

	public function getType(){
		
		return "CerrarCaja";
		
	}	


	public function getCaja()
	{
	    return $this->caja;
	}

	public function setCaja($caja)
	{
	    $this->caja = $caja;
	}
}
?>