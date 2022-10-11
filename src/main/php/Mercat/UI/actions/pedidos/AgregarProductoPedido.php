<?php
namespace Mercat\UI\actions\pedidos;

use Mercat\UI\utils\MercatUIUtils;
use Mercat\Core\utils\MercatUtils;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Pedido;
use Mercat\Core\model\DetallePedido;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se cobra una pedido en efectivo
 *
 * @author Marcos
 * @since 02/09/2020
 */
class AgregarProductoPedido extends Action{


	public function execute(){

		$forward = new Forward();


		//tomamos la pedido
		$pedidoOid = RastyUtils::getParamGET("pedidoOid");
		$forward->addParam( "pedidoOid", $pedidoOid );
		try {


			//la recuperamos la pedido.
			$pedido = UIServiceFactory::getUIPedidoService()->get( $pedidoOid );





			$detalles = MercatUIUtils::getDetallesPedidoSession();



			$total=0;
			$costo=0;
			foreach ($detalles as $detallejson) {
				$detalle = new DetallePedido();

				$detalle->setCantidad( $detallejson["cantidad"] );
				$detalle->setPrecioUnitario( $detallejson["precioUnitario"] );

				$detalle->setProducto( UIServiceFactory::getUIProductoService()->get($detallejson["producto_oid"]) );

				$pedido->addDetalle( $detalle );
				$total += round($detallejson["cantidad"]*$detallejson["precioUnitario"],2);

			}
			$monto = $pedido->getMonto();

			$pedido->setMonto($monto+$total);


			//print_r($pedido);

			$user = RastySecurityContext::getUser();
			$user = MercatUtils::getUserByUsername($user->getUsername());



			UIServiceFactory::getUIPedidoService()->agregarProducto($pedido,$user);

			$forward->setPageName( "Pedidos" );


		} catch (RastyException $e) {

			$forward->setPageName( "PedidoAgregarProducto" );
			$forward->addError( Locale::localize($e->getMessage())  );

		}

		return $forward;

	}

}
?>
