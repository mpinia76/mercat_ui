<?php

namespace Mercat\UI\components\form\pack;

use Mercat\UI\components\filter\model\UIPackCriteria;

use Mercat\UI\service\finder\PackFinder;



use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mercat\Core\model\Pack;

use Mercat\Core\model\Producto;


use Rasty\utils\LinkBuilder;

/**
 * Formulario para pack

 * @author Marcos
 * @since 28/03/2019
 */
class PackForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Pack
	 */
	private $pack;
	
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nombre");
		$this->addProperty("codigo");
		$this->addProperty("cantidad");
		$this->addProperty("producto");
		
		$this->addProperty("costo");
		
		$this->addProperty("precioLista");
		$this->addProperty("precioEfectivo");
		
		$this->addProperty("porcentajeGanancia");
		$this->addProperty("porcentajeGanancia2");
		
		
		
		$this->setBackToOnSuccess("Packs");
		$this->setBackToOnCancel("Packs");
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "PackForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		$producto = UIServiceFactory::getUIProductoService()->get( RastyUtils::getParamPOST("productoOid") );
		
		
		if( !empty( $producto)  ){
			$entity->setProducto($producto);
			
		}
		
		$entity->setFecha(new \Datetime() );
		
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_codigo", $this->localize("pack.codigo") );
		$xtpl->assign("lbl_nombre", $this->localize("pack.nombre") );
		$xtpl->assign("lbl_cantidad", $this->localize("pack.cantidad") );
		
		if (RastyUtils::getParamGET("productoOid")) {
			$producto = UIServiceFactory::getUIProductoService()->get( RastyUtils::getParamGET("productoOid") );
		}
		else{
			$producto = $this->getPack()->getProducto();
		}
		
		
		if( !empty( $producto)  ){
			$xtpl->assign("lbl_producto",  $producto->__toString() );
			$xtpl->assign("productoOid",  $producto->getOid() );
			
		}
		
		$xtpl->assign("lbl_costo", $this->localize("pack.costo") );
		
		$xtpl->assign("lbl_precioLista", $this->localize("pack.precioLista") );
		$xtpl->assign("lbl_precioEfectivo", $this->localize("pack.precioEfectivo") );
		$xtpl->assign("lbl_porcentajeGanancia", $this->localize("producto.porcentajeGanancia") );
		$xtpl->assign("lbl_porcentajeGanancia2", $this->localize("producto.porcentajeGanancia2") );
		
		
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	public function getPack()
	{
	    return $this->pack;
	}

	public function setPack($pack)
	{
	    $this->pack = $pack;
	    
	}
	
	public function getLinkCancel(){
		if (RastyUtils::getParamGET("productoOid")) {
			$producto = UIServiceFactory::getUIProductoService()->get( RastyUtils::getParamGET("productoOid") );
		}
		else{
			$producto = $this->getPack()->getProducto();
		}
		$params = array('productoOid'=>$producto->getOid());
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}


	
	
	
	
}
?>