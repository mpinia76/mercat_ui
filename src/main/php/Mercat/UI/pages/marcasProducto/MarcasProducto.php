<?php
namespace Mercat\UI\pages\marcasProducto;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\components\filter\model\UIMarcaProductoCriteria;

use Mercat\UI\components\grid\model\MarcaProductoGridModel;

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
class MarcasProducto extends MercatPage{

	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "marcaProducto.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "marcaProducto.agregar") );
		$menuOption->setPageName("MarcaProductoAgregar");
		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "MarcasProducto";
		
	}	

	public function getModelClazz(){
		return get_class( new MarcaProductoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIMarcaProductoCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$xtpl->assign("agregar_label", $this->localize("marcaProducto.agregar") );
	}


}
?>