<?php
namespace Mercat\UI\pages\tiposProducto;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\components\filter\model\UITipoProductoCriteria;

use Mercat\UI\components\grid\model\TipoProductoGridModel;

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
 * @since 05-03-2018
 * 
 */
class TiposProducto extends MercatPage{

	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "tipoProducto.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "tipoProducto.agregar") );
		$menuOption->setPageName("TipoProductoAgregar");
		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "TiposProducto";
		
	}	

	public function getModelClazz(){
		return get_class( new TipoProductoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UITipoProductoCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$xtpl->assign("agregar_label", $this->localize("tipoProducto.agregar") );
	}


}
?>