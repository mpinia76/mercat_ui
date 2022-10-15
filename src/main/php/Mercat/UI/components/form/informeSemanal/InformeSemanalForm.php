<?php

namespace Mercat\UI\components\form\informeSemanal;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\service\finder\SucursalFinder;
use Mercat\UI\components\filter\model\UISucursalCriteria;

use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;

use Mercat\Core\model\Sucursal;
use Mercat\Core\model\Empleado;
use Mercat\Core\model\InformeSemanal;

use Rasty\utils\LinkBuilder;

/**
 * Formulario para informeSemanal

 * @author Marcos
 * @since 14/10/2022
 */
class InformeSemanalForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var InformeSemanal
	 */
	private $informeSemanal;
	
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
		$this->addProperty("ventas");
		$this->addProperty("cancelaciones");
		$this->addProperty("pagos");
		$this->addProperty("pagoPorLoteria");
		$this->addProperty("comision");
		$this->addProperty("ajustes");
		$this->addProperty("deuda");
		$this->addProperty("sucursal");
		
		$this->setBackToOnSuccess("InformesSemanales");
		$this->setBackToOnCancel("InformesSemanales");
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "InformeSemanalForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
	
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_fechaDesde", $this->localize("informeSemanal.fechaDesde") );
		$xtpl->assign("lbl_fechaHasta", $this->localize("informeSemanal.fechaHasta") );
		$xtpl->assign("lbl_ventas", $this->localize("informeSemanal.ventas") );
		$xtpl->assign("lbl_cancelaciones", $this->localize("informeSemanal.cancelaciones") );
		$xtpl->assign("lbl_pagos", $this->localize("informeSemanal.pagos") );
		$xtpl->assign("lbl_pagoPorLoteria", $this->localize("informeSemanal.pagoPorLoteria") );
		$xtpl->assign("lbl_comision", $this->localize("informeSemanal.comision") );
		$xtpl->assign("lbl_ajustes", $this->localize("informeSemanal.ajustes") );
		$xtpl->assign("lbl_deuda", $this->localize("informeSemanal.deuda") );
		$xtpl->assign("lbl_sucursal", $this->localize("informeSemanal.sucursal") );
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}

	
	public function getSucursales(){
		
		$sucursales = UIServiceFactory::getUISucursalService()->getList( new UISucursalCriteria() );
		
		return $sucursales;
		
	}
	
	public function getSucursalFinderClazz(){
		
		return get_class( new SucursalFinder() );
		
	}	
	
	
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}
	
	

	public function getInformeSemanal()
	{
	    return $this->informeSemanal;
	}

	public function setInformeSemanal($informeSemanal)
	{
	    $this->informeSemanal = $informeSemanal;
	}
}
?>