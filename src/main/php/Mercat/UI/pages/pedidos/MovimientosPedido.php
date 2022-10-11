<?php
namespace Mercat\UI\pages\pedidos;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\components\filter\model\UIMovimientoPedidoCriteria;

use Mercat\UI\components\grid\model\MovimientoPedidoGridModel;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los movimientos de pedido.
 * 
 * @author Marcos
 * @since 10-07-2020
 * 
 */
class MovimientosPedido extends MercatPage{

	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "pedido.movimientos.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "cliente.agregar") );
//		$menuOption->setPageName("ClienteAgregar");
//		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
//		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "MovimientosPedido";
		
	}	

	public function getModelClazz(){
		return get_class( new MovimientoPedidoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIMovimientoPedidoCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		//$xtpl->assign("agregar_label", $this->localize("cliente.agregar") );
	}

//	public function getCaja(){
//
//		//lo fijamos en la cuenta BAPRO.
//		return UIServiceFactory::getUICajaService()->getCajaBAPRO();
//	}
}
?>