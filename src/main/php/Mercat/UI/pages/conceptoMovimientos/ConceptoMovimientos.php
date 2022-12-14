<?php
namespace Mercat\UI\pages\conceptoMovimientos;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\components\filter\model\UIConceptoMovimientoCriteria;

use Mercat\UI\components\grid\model\ConceptoMovimientoGridModel;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los movimientos de banco.
 * 
 * @author Marcos
 * @since 12-03-2018
 * 
 */
class ConceptoMovimientos extends MercatPage{

	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "conceptoMovimiento.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "conceptoMovimiento.agregar") );
		$menuOption->setPageName("ConceptoMovimientoAgregar");
		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "ConceptoMovimientos";
		
	}	

	public function getModelClazz(){
		return get_class( new ConceptoMovimientoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIConceptoMovimientoCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$xtpl->assign("agregar_label", $this->localize("conceptoMovimiento.agregar") );
	}


}
?>