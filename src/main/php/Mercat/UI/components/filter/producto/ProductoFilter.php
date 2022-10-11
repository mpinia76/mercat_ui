<?php

namespace Mercat\UI\components\filter\producto;

use Mercat\UI\components\filter\model\UIProductoCriteria;

use Mercat\UI\components\grid\model\ProductoGridModel;

use Mercat\UI\components\filter\model\UIVendedorCriteria;

use Mercat\UI\service\finder\VendedorFinder;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

use Mercat\UI\service\UIServiceFactory;

/**
 * Filtro para buscar productos
 * 
 * @author Marcos
 * @since 02/03/2018
 */
class ProductoFilter extends Filter{
		
	public function getType(){
		
		return "ProductoFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new ProductoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIProductoCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarProducto");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("codigo");
		$this->addProperty("nombre");
		$this->addProperty("tipoProducto");
		$this->addProperty("marcaProducto");
		$this->addProperty("filtroPredefinido");
		$this->addProperty("vendedor");
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		/*$this->fillInput("nombre", $this->getInitialText() );
		$this->fillInput("tipoProducto", $this->getInitialText() );
		$this->fillInput("marcaProducto", $this->getInitialText() );*/
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_codigo",  $this->localize("producto.codigo") );
		$xtpl->assign("lbl_nombre",  $this->localize("producto.nombre") );
		$xtpl->assign("lbl_tipoProducto",  $this->localize("producto.tipoProducto") );
		$xtpl->assign("lbl_marcaProducto",  $this->localize("producto.marcaProducto") );
		$xtpl->assign("lbl_predefinidos",  $this->localize("criteria.predefinidos") );
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "ProductoModificar") );
		
		$xtpl->assign("lbl_vendedor", $this->localize("venta.vendedor") );
	}
	
	public function getFiltrosPredefinidos(){
		
		$items = array();
		
		$items[ UIProductoCriteria::POR_VENCER ] = $this->localize("producto.filter.porVencer");
		$items[ UIProductoCriteria::STOCK_MINIMO ] = $this->localize("producto.filter.debajoStockMinimo");
		
		
		
		return $items;
		
	}
	
	public function getVendedorFinderClazz(){
		
		return get_class( new VendedorFinder() );
		
	}	
	
	
	public function getVendedores(){
		
		$vendedores = UIServiceFactory::getUIVendedorService()->getList( new UIVendedorCriteria());
		
		return $vendedores;
	}
}
?>