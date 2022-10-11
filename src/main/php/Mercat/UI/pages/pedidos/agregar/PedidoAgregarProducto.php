<?php
namespace Mercat\UI\pages\pedidos\agregar;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\service\finder\ProductoFinder;

use Mercat\Core\utils\MercatUtils;
use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\pages\MercatPage;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Pedido;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

use Mercat\Core\model\DetallePedido;


use Rasty\utils\LinkBuilder;

class PedidoAgregarProducto extends MercatPage{

	/**
	 * pedido a devolver.
	 * @var Pedido
	 */
	private $pedido;

	private $error;

	private $detalle;

	public function __construct(){

		//inicializamos el pedido.
		$pedido = new Pedido();


		$this->setPedido($pedido);


	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Pedidos");
//		$menuGroup->addMenuOption( $menuOption );
//

		return array($menuGroup);
	}

	public function getTitle(){
		return $this->localize( "venta.agregar.producto.title" );
	}

	public function getType(){

		return "PedidoAgregarProducto";

	}

	protected function parseXTemplate(XTemplate $xtpl){

		MercatUIUtils::setDetallesPedidoSession( array() );

		$xtpl->assign( "pedido_legend", $this->localize( "agregarProducto.pedido.legend") );
		$xtpl->assign( "forma_pago_legend", $this->localize( "agregarProducto.forma_pago.legend") );

		$xtpl->assign("detalles_legend", $this->localize("pedido.agregar.detalles_legend") );
		$xtpl->assign("lbl_detalle_nombre", $this->localize( "pedido.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "pedido.detalle.precio" ) );
		$xtpl->assign("lbl_detalle_cantidad", $this->localize( "pedido.detalle.cantidad" ) );
		$xtpl->assign("lbl_detalle_subtotal", $this->localize( "pedido.detalle.subtotal" ) );



		$xtpl->assign( "linkAgregarProductoPedido", $this->getLinkActionAgregarProductoPedido($this->getPedido()) );


		$xtpl->assign("linkAgregarDetalle", $this->getLinkActionAgregarDetalle() );
		$xtpl->assign("linkBorrarDetalle", $this->getLinkActionBorrarDetalle() );





		$msg = $this->getError();

		if( !empty($msg) ){

			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
		$xtpl->assign( "lbl_submit", $this->localize("agregarProducto.confirm") );
		$xtpl->assign( "lbl_cancel", $this->localize("agregarProducto.cancel") );
	}


	public function getPedido()
	{
	    return $this->pedido;
	}

	public function setPedido($pedido)
	{
	    $this->pedido = $pedido;
	}

	public function setPedidoOid($pedidoOid)
	{
		if(!empty($pedidoOid)){
			$pedido = UIServiceFactory::getUIPedidoService()->get($pedidoOid);
			$this->setPedido($pedido);
		}


	}

	public function getProductoFinderClazz(){

		return get_class( new ProductoFinder() );

	}

	public function getDetalle()
	{
	    return $this->detalle;
	}

	public function setDetalle($detalle)
	{
	    $this->detalle = $detalle;
	}


	public function getLinkActionAgregarDetalle(){

		return LinkBuilder::getActionAjaxUrl( "AgregarDetallePedidoJson") ;

	}



	public function getLinkActionBorrarDetalle(){

		return LinkBuilder::getActionAjaxUrl( "BorrarDetallePedidoJson") ;

	}

	public function getMsgError(){
		return "";
	}

	public function getError()
	{
	    return $this->error;
	}

	public function setError($error)
	{
	    $this->error = $error;
	}
}
?>
