<?php

namespace Mercat\UI\components\form\proveedor;

use Mercat\UI\components\filter\model\UIProveedorCriteria;

use Mercat\UI\service\finder\ProveedorFinder;



use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mercat\Core\model\Proveedor;


use Mercat\Core\model\CondicionIva;

use Rasty\utils\LinkBuilder;

/**
 * Formulario para proveedor

 * @author Marcos
 * @since 02/03/2018
 */
class ProveedorForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Proveedor
	 */
	private $proveedor;
	
	
	public function __construct($backToOnSuccess="Proveedors"){
		
		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nombre");
		
		$this->addProperty("condicionIva");
		$this->addProperty("documento");
		$this->addProperty("cuit");
		$this->addProperty("razonSocial");
		
		$this->addProperty("telefono");
		$this->addProperty("celular");
		$this->addProperty("mail");
		$this->addProperty("direccion");
		$this->addProperty("observaciones");

		
		
		$url = parse_url($_SERVER['REQUEST_URI']);
		if (isset($url['query'])) {
			$arrayParametros = explode("&",$url['query']);
			foreach ($arrayParametros as $parametro) {
				$arrayParametro = explode("=",$parametro);
				if ($arrayParametro[0]=="onSuccessCallback") {
					$backToOnSuccess = $arrayParametro[1];
				}
			}
		}
		
		
		$this->setBackToOnSuccess($backToOnSuccess);
		$this->setBackToOnCancel($backToOnSuccess);
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "ProveedorForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		//uppercase para el nombre
		//$entity->setNombre( strtoupper( $entity->getNombre() ) );
		$entity->setFecha(new \Datetime() );
		$entity->setUltModificacion(new \Datetime() );
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_nombre", $this->localize("proveedor.nombre") );
		$xtpl->assign("lbl_condicionIva", $this->localize("proveedor.condicionIva") );
		$xtpl->assign("lbl_documento", $this->localize("proveedor.documento") );
		
		$xtpl->assign("lbl_razonSocial", $this->localize("proveedor.razonSocial") );
		$xtpl->assign("lbl_telefono", $this->localize("proveedor.telefono") );
		$xtpl->assign("lbl_celular", $this->localize("proveedor.celular") );
		$xtpl->assign("lbl_mail", $this->localize("proveedor.mail") );
		$xtpl->assign("lbl_direccion", $this->localize("proveedor.direccion") );
		$xtpl->assign("lbl_observaciones", $this->localize("proveedor.observaciones") );

		$xtpl->assign("lbl_cuit", $this->localize("proveedor.cuit") );
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	public function getProveedor()
	{
	    return $this->proveedor;
	}

	public function setProveedor($proveedor)
	{
	    $this->proveedor = $proveedor;
	    
	}
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}


	public function getCondicionesIva(){
		
		return MercatUIUtils::localizeEntities(CondicionIva::getItems());
	}
	

	
}
?>