<?php

namespace Mercat\UI\components\filter\movimiento;


use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\grid\model\MovimientoVentaGridModel;

use Mercat\UI\components\filter\model\UIMovimientoVentaCriteria;


use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar movimientos de Venta
 * 
 * @author Marcos
 * @since 14-03-2018
 */
class MovimientoVentaFilter extends Filter{
		
	
	
	public function getType(){
		
		return "MovimientoVentaFilter";
	}
	
	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new MovimientoVentaGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIMovimientoVentaCriteria()) );
		
		
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el banco con bapro
		//$this->fillInput("cuenta", UIServiceFactory::getUIBancoService()->getCajaBAPRO() );
		
		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_fechaDesde",  $this->localize( "criteria.fechaDesde" ) );
		$xtpl->assign("lbl_fechaHasta",  $this->localize( "criteria.fechaHasta" ) );
		
		
	}
	
	
	
}
?>