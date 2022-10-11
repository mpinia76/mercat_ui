<?php

namespace Mercat\UI\components\filter\balance;

use Mercat\UI\components\filter\model\UIProductoCriteria;

use Mercat\UI\components\filter\model\UIVendedorCriteria;
use Mercat\UI\service\finder\VendedorFinder;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

use Mercat\UI\service\UIServiceFactory;

/**
 * Filtro para buscar balances
 * 
 * @author Marcos
 * @since 08/10/2019
 */
class BalanceDiaFilter extends Filter{
		
	
	
	public function getType(){
		
		return "BalanceDiaFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
			
		
		$this->setUicriteriaClazz( get_class( new UIProductoCriteria()) );
		
		
		
		$this->addProperty("fecha");
		$this->addProperty("nombre");
		$this->addProperty("tipoProducto");
		$this->addProperty("marcaProducto");
		$this->addProperty("cliente");
		$this->addProperty("vendedor");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		
		
		parent::parseXTemplate($xtpl);
		
	
		
		
		$xtpl->assign("lbl_fecha",  $this->localize("gasto.fecha") );
		$xtpl->assign("lbl_nombre",  $this->localize("producto.nombre") );
		$xtpl->assign("lbl_tipoProducto",  $this->localize("producto.tipoProducto") );
		$xtpl->assign("lbl_marcaProducto",  $this->localize("producto.marcaProducto") );
		$xtpl->assign("lbl_cliente",  $this->localize("venta.cliente") );
		$xtpl->assign("lbl_vendedor",  $this->localize("venta.vendedor") );
		
		
		
		
		
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