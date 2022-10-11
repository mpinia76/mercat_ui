<?php

namespace Mercat\UI\components\form\conceptoMovimiento;

use Mercat\UI\components\filter\model\UIConceptoMovimientoCriteria;

use Mercat\UI\service\finder\ConceptoMovimientoFinder;



use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;



use Rasty\utils\LinkBuilder;

/**
 * Formulario para conceptoMovimiento

 * @author Marcos
 * @since 12/03/2018
 */
class ConceptoMovimientoForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var ConceptoMovimiento
	 */
	private $conceptoMovimiento;
	
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nombre");
		
		$this->setBackToOnSuccess("ConceptoMovimientos");
		$this->setBackToOnCancel("ConceptoMovimientos");
		
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "ConceptoMovimientoForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_nombre", $this->localize("conceptoMovimiento.nombre") );
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	public function getConceptoMovimiento()
	{
	    return $this->conceptoMovimiento;
	}

	public function setConceptoMovimiento($conceptoMovimiento)
	{
	    $this->conceptoMovimiento = $conceptoMovimiento;
	    
	}
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}

	
	
	
}
?>