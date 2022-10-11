<?php

namespace Mercat\UI\components\form\vendedor;

use Mercat\UI\components\filter\model\UIVendedorCriteria;

use Mercat\UI\service\finder\VendedorFinder;



use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;



use Rasty\utils\LinkBuilder;

/**
 * Formulario para vendedor

 * @author Marcos
 * @since 21/07/2020
 */
class VendedorForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Vendedor
	 */
	private $vendedor;
	
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nombre");
		$this->addProperty("comision");
		$this->addProperty("telefono");
		$this->addProperty("mayorista");
		$this->addProperty("mail");
		$this->addProperty("direccion");
		$this->setBackToOnSuccess("Vendedores");
		$this->setBackToOnCancel("Vendedores");
		
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "VendedorForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_nombre", $this->localize("vendedor.nombre") );
		$xtpl->assign("lbl_comision", $this->localize("vendedor.comision") );
		
		$xtpl->assign("lbl_telefono", $this->localize("vendedor.telefono") );
		$xtpl->assign("lbl_mayorista", $this->localize("vendedor.mayorista") );
		$xtpl->assign("lbl_mail", $this->localize("vendedor.mail") );
		$xtpl->assign("lbl_direccion", $this->localize("vendedor.direccion") );
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	public function getVendedor()
	{
	    return $this->vendedor;
	}

	public function setVendedor($vendedor)
	{
	    $this->vendedor = $vendedor;
	    
	}
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}

	
	
	
}
?>