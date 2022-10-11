<?php
namespace Mercat\UI\pages\presupuestos;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIPresupuestoCriteria;

use Mercat\UI\components\grid\model\PresupuestoGridModel;

use Mercat\UI\service\UIPresupuestoService;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\Presupuesto;
use Mercat\Core\criteria\PresupuestoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;
use Rasty\utils\LinkBuilder;

/**
 * Página para consultar los presupuestos.
 * 
 * @author Marcos
 * @since 29-03-2019
 * 
 */
class Presupuestos extends MercatPage{
	private $presupuesto;
	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "presupuestos.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.presupuestos.agregar") );
		$menuOption->setPageName("PresupuestoAgregar");
		$menuOption->setIconClass( "icon-agregar");
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "Presupuestos";
		
	}	

	public function getModelClazz(){
		return get_class( new PresupuestoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIPresupuestoCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$presupuestoOid = ( $this->getPresupuesto())?$this->getPresupuesto()->getOid():'';
		$xtpl->assign( "presupuestoOid", $presupuestoOid );
		$params = array('presupuestoOid'=>$presupuestoOid);
		$xtpl->assign("linkPresupuestoPDF",  LinkBuilder::getPdfUrl( "PresupuestoPDF", $params) );
		
		$xtpl->assign("agregar_label", $this->localize("presupuesto.agregar") );
	}
	
	public function setPresupuestoOid($presupuestoOid)
	{
		if(!empty($presupuestoOid)){
			$presupuesto = UIServiceFactory::getUIPresupuestoService()->get($presupuestoOid);
			$this->setPresupuesto($presupuesto);
		}
		
	    
	}


	public function getPresupuesto()
	{
	    return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
	    $this->presupuesto = $presupuesto;
	}

}
?>