<?php

namespace Mercat\UI\components\filter\movimiento;

use Mercat\UI\service\finder\BancoFinder;

use Mercat\UI\components\filter\model\UIBancoCriteria;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\grid\model\MovimientoCajaGridModel;

use Mercat\UI\components\filter\model\UIMovimientoCajaCriteria;

use Mercat\UI\components\filter\model\UIMovimientoCriteria;

use Mercat\UI\components\grid\model\MovimientoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar movimientos de Banco
 * 
 * @author Marcos
 * @since 13-10-2022
 */
class MovimientoBancoFilter extends Filter{
		
	
	
	public function getType(){
		
		return "MovimientoBancoFilter";
	}
	
	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new MovimientoCajaGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIMovimientoCajaCriteria()) );
		
		$this->addProperty("cuenta");
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el banco con bapro
		//$this->fillInput("cuenta", UIServiceFactory::getUIBancoService()->getCuentaBAPRO() );
		
		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_fechaDesde",  $this->localize( "criteria.fechaDesde" ) );
		$xtpl->assign("lbl_fechaHasta",  $this->localize( "criteria.fechaHasta" ) );
		$xtpl->assign("lbl_banco",  $this->localize( "cuenta.banco" ) );
		
	}
	
	public function getBancos(){
		
		$bancos = UIServiceFactory::getUIBancoService()->getList( new UIBancoCriteria() );
		
		return $bancos;
		
	}
	
	public function getBancoFinderClazz(){
		
		return get_class( new BancoFinder() );
		
	}	
	
}
?>