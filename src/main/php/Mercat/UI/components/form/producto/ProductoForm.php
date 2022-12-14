<?php

namespace Mercat\UI\components\form\producto;

use Mercat\UI\components\filter\model\UIProductoCriteria;

use Mercat\UI\service\finder\ProductoFinder;

use Mercat\UI\components\filter\model\UITipoProductoCriteria;

use Mercat\UI\service\finder\TipoProductoFinder;

use Mercat\UI\components\filter\model\UIMarcaProductoCriteria;

use Mercat\UI\service\finder\MarcaProductoFinder;

use Mercat\UI\components\filter\model\UIIvaCriteria;

use Mercat\UI\service\finder\IvaFinder;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mercat\Core\model\Producto;

use Mercat\Core\model\TipoProducto;
use Mercat\Core\model\MarcaProducto;
use Mercat\Core\model\Iva;

use Rasty\utils\LinkBuilder;

/**
 * Formulario para producto

 * @author Marcos
 * @since 02/03/2018
 */
class ProductoForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Producto
	 */
	private $producto;
	
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nombre");
		$this->addProperty("codigo");
		$this->addProperty("tipoProducto");
		$this->addProperty("marcaProducto");
		$this->addProperty("iva");
		$this->addProperty("stock");
		$this->addProperty("costo");
		$this->addProperty("stockMinimo");
		$this->addProperty("porcentajeGanancia");
		$this->addProperty("porcentajeGanancia2");
		$this->addProperty("precioLista");
		$this->addProperty("precioEfectivo");
		
		$this->addProperty("descripcion");
		
		$this->addProperty("vencimiento");
		
		
		
		$this->setBackToOnSuccess("Productos");
		$this->setBackToOnCancel("Productos");
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "ProductoForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		$entity->setFecha(new \Datetime() );
		
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_codigo", $this->localize("producto.codigo") );
		$xtpl->assign("lbl_nombre", $this->localize("producto.nombre") );
		$xtpl->assign("lbl_tipoProducto", $this->localize("producto.tipoProducto") );
		$xtpl->assign("lbl_marcaProducto", $this->localize("producto.marcaProducto") );
		$xtpl->assign("lbl_costo", $this->localize("producto.costo") );
		$xtpl->assign("lbl_stock", $this->localize("producto.stock") );
		$xtpl->assign("lbl_stockMinimo", $this->localize("producto.stockMinimo") );
		$xtpl->assign("lbl_porcentajeGanancia", $this->localize("producto.porcentajeGanancia") );
		$xtpl->assign("lbl_porcentajeGanancia2", $this->localize("producto.porcentajeGanancia2") );
		$xtpl->assign("lbl_precioLista", $this->localize("producto.precioLista") );
		$xtpl->assign("lbl_precioEfectivo", $this->localize("producto.precioEfectivo") );
		
		
		$xtpl->assign("lbl_descripcion", $this->localize("producto.descripcion") );
		
		$xtpl->assign("lbl_iva", $this->localize("producto.iva") );
		$xtpl->assign("lbl_vencimiento", $this->localize("producto.vencimiento") );
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	public function getProducto()
	{
	    return $this->producto;
	}

	public function setProducto($producto)
	{
	    $this->producto = $producto;
	    
	}
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}


	public function getTipoProductoFinderClazz(){
		
		return get_class( new TipoProductoFinder() );
		
	}	
	
	
	public function getTiposProducto(){
		$criteria = new UITipoProductoCriteria();
		
		$criteria->addOrder("nombre", "ASC");
		$tiposProducto = UIServiceFactory::getUITipoProductoService()->getList( $criteria);
		
		return $tiposProducto;
	}
	
	public function getMarcaProductoFinderClazz(){
		
		return get_class( new MarcaProductoFinder() );
		
	}	
	
	
	public function getMarcasProducto(){
		$criteria = new UIMarcaProductoCriteria();
		
		$criteria->addOrder("nombre", "ASC");
		$marcasProducto = UIServiceFactory::getUIMarcaProductoService()->getList( $criteria);
		
		
		return $marcasProducto;
	}
	
	public function getIvaFinderClazz(){
		
		return get_class( new IvaFinder() );
		
	}	
	
	
	public function getIvas(){
		
		$ivas = UIServiceFactory::getUIIvaService()->getList( new UIIvaCriteria() );
		
		return $ivas;
	}
}
?>