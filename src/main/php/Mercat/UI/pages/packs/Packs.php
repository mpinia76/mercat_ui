<?php
namespace Mercat\UI\pages\packs;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIPackCriteria;

use Mercat\UI\components\grid\model\PackGridModel;

use Mercat\UI\service\UIPackService;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\Pack;
use Mercat\Core\criteria\PackCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los packs.
 * 
 * @author Marcos
 * @since 27/03/2019
 * 
 */
class Packs extends MercatPage{

	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "packs.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "pack.agregar") );
		$menuOption->setPageName("PackAgregar");
		$menuOption->addParam("productoOid",RastyUtils::getParamGET("productoOid"));
		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuGroup->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("Productos");
		$menuGroup->addMenuOption( $menuOption );
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "Packs";
		
	}	

	public function getModelClazz(){
		return get_class( new PackGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIPackCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$xtpl->assign("agregar_label", $this->localize("pack.agregar") );
	}

}
?>