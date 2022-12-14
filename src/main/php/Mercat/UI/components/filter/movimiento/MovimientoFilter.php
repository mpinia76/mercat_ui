<?php

namespace Mercat\UI\components\filter\movimiento;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\grid\model\MovimientoCajaGridModel;

use Mercat\UI\components\filter\model\UIMovimientoCajaCriteria;

use Mercat\UI\components\filter\model\UIMovimientoCriteria;

use Mercat\UI\components\grid\model\MovimientoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

/**
 * Filtro para buscar movimientos
 * 
 * @author Marcos
 * @since 14/03/2018
 */
abstract class MovimientoFilter extends Filter{
		
	private $cuenta;
	
	
	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new MovimientoCajaGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIMovimientoCajaCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarMovimiento");
		
		//agregamos las propiedades a popular en el submit.
		//$this->addProperty("cuenta");
		
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		
		
		//rellenamos el nombre con el texto inicial
		//$this->fillInput("cuenta", MercatUIUtils::getCaja() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_cuenta",  $this->localize("movimientoCaja.cuenta") );
		
		
		$cuenta = $this->getCuenta();
		$xtpl->assign("saldo",  MercatUIUtils::formatMontoToView($cuenta->getSaldo()) );
		$xtpl->assign("cuentaOid",  $cuenta->getOid() );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "MovimientoModificar") );
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		$cuenta = UIServiceFactory::getUICuentaService()->get( RastyUtils::getParamPOST("cuentaOid") );
		
		$entity->setCuenta( $cuenta );		
		
	}

	public function getCuenta()
	{
	    return $this->cuenta;
	}

	public function setCuenta($cuenta)
	{
	    $this->cuenta = $cuenta;
	}
}
?>