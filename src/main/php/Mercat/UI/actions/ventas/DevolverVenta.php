<?php
namespace Mercat\UI\actions\ventas;

use Mercat\UI\utils\MercatUIUtils;
use Mercat\Core\utils\MercatUtils;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Venta;
use Mercat\Core\model\DevolucionVenta;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;

use Rasty\utils\Logger;

/**
 * se cobra una venta en efectivo
 * 
 * @author Marcos
 * @since 28/04/2019
 */
class DevolverVenta extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		
		//tomamos la venta
		$ventaOid = RastyUtils::getParamGET("ventaOid");
		$forward->addParam( "ventaOid", $ventaOid );
		try {

			
			//la recuperamos la venta.
			$venta = UIServiceFactory::getUIVentaService()->get( $ventaOid );
			
			$devoluciones = MercatUIUtils::getDevolucionesVentaSession();
			
		
		
			$total=0;
			$costo=0;	
			Logger::logObject($devoluciones);
			foreach ($devoluciones as $devolucionjson) {
				$devolucion = new DevolucionVenta();
				
				$devolucion->setCantidad( $devolucionjson["cantidad"] );
				$devolucion->setPrecioUnitario( $devolucionjson["precioUnitario"] );
				$devolucion->setCosto( $devolucionjson["costo"] );
				$devolucion->setStockActualizado( $devolucionjson["stockActualizado"] );
				$devolucion->setProducto( UIServiceFactory::getUIProductoService()->get($devolucionjson["producto_oid"]) );
				
				$venta->addDevolucion( $devolucion );
				$total += $devolucionjson["cantidad"]*$devolucionjson["precioUnitario"];
				$costo += $devolucionjson["cantidad"]*$devolucionjson["costo"];
			}
			$venta->setMontoDevolucion($total);
			$ganancia=($venta->getGanancia()!=0)?$venta->getGanancia()-($total-$costo):0;
			$venta->setGanancia($ganancia);
			
			//print_r($venta);
			
			$user = RastySecurityContext::getUser();
			$user = MercatUtils::getUserByUsername($user->getUsername());
			
			
			if( $venta->getCliente()->hasCuentaCorriente() ){
				$cuenta = $venta->getCliente()->getCuentaCorriente();
			}
			else{
				$cuenta = MercatUtils::getCuentaUnica();
			}
			
			
			UIServiceFactory::getUIVentaService()->devolver($venta,$cuenta,$user);			
			
			$forward->setPageName( "Ventas" );
		
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "VentaDevolver" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
		}
		
		return $forward;
		
	}

}
?>