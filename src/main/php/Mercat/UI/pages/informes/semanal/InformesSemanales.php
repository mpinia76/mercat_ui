<?php
namespace Mercat\UI\pages\informes\semanal;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIInformeSemanalCriteria;

use Mercat\UI\components\grid\model\InformeSemanalGridModel;

use Mercat\UI\service\UIInformeSemanalService;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\InformeSemanal;
use Mercat\Core\criteria\InformeSemanalCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los informes semanales.
 * 
 * @author Marcos
 * @since 14/10/2022
 * 
 */
class InformesSemanales extends MercatPage{

	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "informesSemanales.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.informesSemanales.agregar") );
		$menuOption->setPageName("InformeSemanalAgregar");
		$menuOption->setIconClass( "icon-agregar fg-green" );
		$menuGroup->addMenuOption( $menuOption );
		
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "menu.informesSemanales.reportes") );
//		$menuOption->setPageName( "InformeSemanalStats" );
//		$menuOption->setIconClass( "icon-stats" );
//		$menuGroup->addMenuOption( $menuOption );
//		
//		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "InformesSemanales";
		
	}	

	public function getModelClazz(){
		return get_class( new InformeSemanalGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIInformeSemanalCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$xtpl->assign("agregar_label", $this->localize("informeSemanal.agregar") );
	}

}
?>