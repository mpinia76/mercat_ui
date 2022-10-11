<?php

namespace Mercat\UI\components\form\conceptoGasto;

use Mercat\UI\components\filter\model\UIConceptoGastoCriteria;

use Mercat\UI\service\finder\ConceptoGastoFinder;



use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;



use Rasty\utils\LinkBuilder;

/**
 * Formulario para conceptoGasto

 * @author Marcos
 * @since 07/03/2018
 */
class ConceptoGastoForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var ConceptoGasto
	 */
	private $conceptoGasto;
	
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nombre");
		
		$this->setBackToOnSuccess("ConceptoGastos");
		$this->setBackToOnCancel("ConceptoGastos");
		
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "ConceptoGastoForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_nombre", $this->localize("conceptoGasto.nombre") );
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	public function getConceptoGasto()
	{
	    return $this->conceptoGasto;
	}

	public function setConceptoGasto($conceptoGasto)
	{
	    $this->conceptoGasto = $conceptoGasto;
	    
	}
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}

	
	
	
}
?>