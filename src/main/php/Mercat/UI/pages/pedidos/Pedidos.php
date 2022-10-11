<?php
namespace Mercat\UI\pages\pedidos;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIPedidoCriteria;

use Mercat\UI\components\grid\model\PedidoGridModel;

use Mercat\UI\service\UIPedidoService;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\Pedido;
use Mercat\Core\criteria\PedidoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los pedidos.
 * 
 * @author Marcos
 * @since 10-07-2020
 * 
 */
class Pedidos extends MercatPage{

	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "pedidos.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "pedido.agregar") );
		$menuOption->setPageName("PedidoAgregar");
		$menuOption->setIconClass( "icon-nuevo-pedido");
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "Pedidos";
		
	}	

	public function getModelClazz(){
		return get_class( new PedidoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIPedidoCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$xtpl->assign("agregar_label", $this->localize("pedido.agregar") );
	}

}
?>