<?php

namespace Mercat\UI\components\filter\informeSemanal;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\filter\model\UIInformeSemanalCriteria;
use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\components\grid\model\InformeSemanalGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar informesSemanales
 * 
 * @author Marcos
 * @since 14/10/2022
 */
class InformeSemanalFilter extends Filter{
		
	public function getType(){
		
		return "InformeSemanalFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new InformeSemanalGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIInformeSemanalCriteria()) );
		
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("mes");
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		//$this->fillInput("nombre", $this->getInitialText() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_mes",  $this->localize("criteria.mes") );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "InformeSemanalModificar") );
		
		
	}
	
	
	
	public function getMeses(){
		
		$meses = MercatUIUtils::getMeses();
		
		return $meses;
		
	}
	
}
?>