<?php
namespace Mercat\UI\pages\informes\debitosCreditos;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIInformeDiarioDebitoCreditoCriteria;

use Mercat\UI\components\grid\model\InformeDiarioDebitoCreditoGridModel;

use Mercat\UI\service\UIInformeDiarioDebitoCreditoService;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\InformeDiarioDebitoCredito;
use Mercat\Core\criteria\InformeDiarioDebitoCreditoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los informes semanales.
 * 
 * @author Marcos
 * @since 12/10/2022
 * 
 */
class InformesDiariosDebitoCredito extends MercatPage{

	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "informesDiariosDebitoCredito.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.informesDiariosDebitoCredito.agregar") );
		$menuOption->setPageName("InformeDiarioDebitoCreditoAgregar");
		$menuOption->setIconClass( "icon-agregar fg-green" );
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "InformesDiariosDebitoCredito";
		
	}	

	public function getModelClazz(){
		return get_class( new InformeDiarioDebitoCreditoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIInformeDiarioDebitoCreditoCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$xtpl->assign("agregar_label", $this->localize("informeDiarioDebitoCredito.agregar") );
	}

}
?>