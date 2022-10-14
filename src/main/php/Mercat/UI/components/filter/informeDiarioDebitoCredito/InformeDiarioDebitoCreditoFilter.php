<?php

namespace Cuentas\UI\components\filter\informeDiarioDebitoCredito;

use Cuentas\UI\utils\CuentasUIUtils;

use Cuentas\UI\components\filter\model\UIInformeDiarioDebitoCreditoCriteria;
use Cuentas\UI\service\UIServiceFactory;

use Cuentas\UI\components\grid\model\InformeDiarioDebitoCreditoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar informesDiariosDebitoCredito
 * 
 * @author Bernardo
 * @since 14/04/2015
 */
class InformeDiarioDebitoCreditoFilter extends Filter{
		
	public function getType(){
		
		return "InformeDiarioDebitoCreditoFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new InformeDiarioDebitoCreditoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIInformeDiarioDebitoCreditoCriteria()) );
		
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("mes");
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		//$this->fillInput("nombre", $this->getInitialText() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_mes",  $this->localize("criteria.mes") );
		$xtpl->assign("lbl_estado",  $this->localize("criteria.estado") );
		
		
		
	}
	
	public function getMeses(){
		
		$meses = CuentasUIUtils::getMeses();
		
		return $meses;
		
	}
	
	public function getEstados(){
		
		$items = array();
		
		foreach (CuentasUIUtils::getEstadosInformeDiarioDebitoCredito() as $key => $value) {
			$items[ $key ] = CuentasUIUtils::localize($value);
		}
		
		return $items;
		
		
	}
}
?>