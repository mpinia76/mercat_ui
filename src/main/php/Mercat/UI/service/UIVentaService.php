<?php
namespace Mercat\UI\service;

use DateTime;
use Mercat\UI\components\filter\model\UIVentaCriteria;
use Mercat\UI\components\filter\model\UIProductoCriteria;
use Mercat\UI\components\filter\model\UIDetalleVentaCriteria;
use Mercat\UI\components\filter\model\UIDevolucionVentaCriteria;

use Exception;
use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\model\Venta;
use Mercat\Core\model\Cuenta;
use Mercat\Core\model\Caja;

use Mercat\Core\service\ServiceFactory;
use Cose\Security\model\User;

use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

use Rasty\utils\Logger;

/**
 *
 * UI service para Venta.
 *
 * @author Marcos
 * @since 13/03/2018
 */
class UIVentaService  implements IEntityGridService{

	private static $instance;

	private function __construct() {}

	public static function getInstance() {

		if( self::$instance == null ) {

			self::$instance = new UIVentaService();

		}
		return self::$instance;
	}



	public function getList( UIVentaCriteria $uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;

			$service = ServiceFactory::getVentaService();

			$ventas = $service->getList( $criteria );

			return $ventas;

		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function getTotales( UIVentaCriteria $uiCriteria){
		$arraySaldo = array();
		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;

			//$criteria->addOrder("fechaHora", "ASC");

			$service = ServiceFactory::getVentaService();

			$ventas = $service->getList( $criteria );

			$saldo = 0;
			$ganancia = 0;
			$comision = 0;
			$uiProductoCriteria = new UIProductoCriteria();
			$uiProductoCriteria->setTipoProducto('hielo');
			$oProductos = UIServiceFactory::getUIProductoService()->getList( $uiProductoCriteria );
            $ventasoids=array();
            $productosoids=array();
            $arraySaldo['ventashielo'] = 0;
            $arraySaldo['gananciashielo'] = 0;
            $arraySaldo['comisioneshielo'] = 0;
			foreach ($ventas as $venta) {
            	if($venta->podesAnularte()){
            		$saldo += $venta->getMontoPagado();
            		$ganancia += $venta->getGanancia();
            		$comision += $venta->getComision();
            		$ventasoids[]=$venta->getOid();
            			foreach ($oProductos as $oProducto) {
            				$productosoids[]=$oProducto->getOid();
            			}
            	}
            }
            if(count($ventasoids)>0){
            	$uiDetalleVentaCriteria = new UIDetalleVentaCriteria();
	            $uiDetalleVentaCriteria->setVentas($ventasoids);
	            $uiDetalleVentaCriteria->setProductos($productosoids);
	           	$oDetalles = UIServiceFactory::getUIDetalleVentaService()->getList( $uiDetalleVentaCriteria );
	           	foreach ($oDetalles as $oDetalle) {
	           		$totalVenta=round($oDetalle->getPrecioUnitario()*$oDetalle->getCantidad(),1);
		            $costo=round($oDetalle->getCosto()*$oDetalle->getCantidad(),1);
		           	$comisionHielo=0;
		           	//$oVenta= $this->get($oDetalle->getVenta()->getOid());
	           		if ($oDetalle->getVenta()->getComision()) {
	           			$porcentajeComision = round(($oDetalle->getVenta()->getComision()*100)/$oDetalle->getVenta()->getmonto(),1);
	            		$comisionHielo=round($totalVenta*($porcentajeComision/100),1);
	            	}

	            	$arraySaldo['ventashielo'] += $totalVenta;
	            	$arraySaldo['gananciashielo'] += $totalVenta-$costo-$comisionHielo;
	            	$arraySaldo['comisioneshielo'] += $comisionHielo;
	           	}
	           	$uiDevolucionVentaCriteria = new UIDevolucionVentaCriteria();
	            $uiDevolucionVentaCriteria->setVentas($ventasoids);
	            $uiDevolucionVentaCriteria->setProductos($productosoids);
	           	$oDevolucions = UIServiceFactory::getUIDevolucionVentaService()->getList( $uiDevolucionVentaCriteria );
	           	foreach ($oDevolucions as $oDevolucion) {
	           		$totalVenta=round($oDevolucion->getPrecioUnitario()*$oDevolucion->getCantidad(),1);
		            $costo=round($oDevolucion->getCosto()*$oDevolucion->getCantidad(),1);


	            	$arraySaldo['ventashielo'] -= $totalVenta;
	            	$arraySaldo['gananciashielo'] -= $totalVenta-$costo;

	           	}
            }

            $arraySaldo['saldo']=$saldo-$arraySaldo['ventashielo'];
            $arraySaldo['ganancia']=$ganancia-$arraySaldo['gananciashielo'];
            $arraySaldo['comision']=$comision-$arraySaldo['comisioneshielo'];

            return $arraySaldo;


		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function getGanancias( UIVentaCriteria $uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;

			//$criteria->addOrder("fechaHora", "ASC");

			$service = ServiceFactory::getVentaService();

			$ventas = $service->getList( $criteria );

			$saldo = 0;
            foreach ($ventas as $venta) {

            	if($venta->podesAnularte()){
            		$saldo += $venta->getGanancia();
            	}
            }
            return $saldo;


		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function getComisiones( UIVentaCriteria $uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;

			//$criteria->addOrder("fechaHora", "ASC");

			$service = ServiceFactory::getVentaService();

			$ventas = $service->getList( $criteria );

			$saldo = 0;
            foreach ($ventas as $venta) {

            	if($venta->podesAnularte()){
            		$saldo += $venta->getComision();
            	}
            }
            return '-'.$saldo;


		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function getGananciasProducto( UIVentaCriteria $uiCriteria, UIProductoCriteria $uiProductoCriteria, $anual=0){

		$saldo=array();
		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;

			//$criteria->addOrder("fechaHora", "ASC");

			$service = ServiceFactory::getVentaService();

			$ventas = $service->getList( $criteria );


			$ventasoids=array();
			$ventasoidshielo=array();
            $productosoids=array();
            $productosoidshielo=array();

			$saldo['ganancias'] = 0;
			$saldo['ventas'] = 0;
			$saldo['comisiones'] = 0;

			$saldo['productos']['ventas'] = array();
			$saldo['productos']['costo'] = array();
			$saldo['productos']['cant'] = array();
			$saldo['productos']['nombre'] = array();
			$saldo['clientes']['cant'] = array();
			$saldo['clientes']['cliente'] = array();

			$uiHieloCriteria = new UIProductoCriteria();
			$uiHieloCriteria->setTipoProducto('hielo');
			$oHielos = UIServiceFactory::getUIProductoService()->getList( $uiHieloCriteria );
			$saldo['ventashielo'] = 0;
            $saldo['gananciashielo'] = 0;
            $saldo['comisioneshielo'] = 0;
            foreach ($ventas as $venta) {

            	if($venta->podesAnularte()){



            		if (($uiProductoCriteria->getNombre())||($uiProductoCriteria->getTipoProducto())||($uiProductoCriteria->getMarcaProducto())||(!$anual)) {
            			$ventasoids[]=$venta->getOid();
            			$oProductos = UIServiceFactory::getUIProductoService()->getList( $uiProductoCriteria );
            			foreach ($oProductos as $oProducto) {
            				$productosoids[]=$oProducto->getOid();


            			}

            		}
            		//else{
            			$ventasoidshielo[]=$venta->getOid();
            			foreach ($oHielos as $oHielo) {
                            $productosoidshielo[]=$oHielo->getOid();
            			}

            			$saldo['ganancias'] += $venta->getGanancia();
            			$saldo['ventas'] += $venta->getMontoPagado();
            			$saldo['comisiones'] += $venta->getComision();

            		//}

            	}
            }
			if(count($ventasoidshielo)>0){

				if (count($productosoidshielo)>0) {
	            	$uiDetalleVentaCriteria = new UIDetalleVentaCriteria();
		            $uiDetalleVentaCriteria->setVentas($ventasoidshielo);
		            $uiDetalleVentaCriteria->setProductos($productosoidshielo);
		           	$oDetalles = UIServiceFactory::getUIDetalleVentaService()->getList( $uiDetalleVentaCriteria );
		           	foreach ($oDetalles as $oDetalle) {

		           		$totalVenta=round($oDetalle->getPrecioUnitario()*$oDetalle->getCantidad(),1);
			            $costo=round($oDetalle->getCosto()*$oDetalle->getCantidad(),1);
			           	$comision=0;
			           	//$oVenta= $this->get($oDetalle->getVenta()->getOid());
		           		if ($oDetalle->getVenta()->getComision()) {
		           			$porcentajeComision = round(($oDetalle->getVenta()->getComision()*100)/$oDetalle->getVenta()->getmonto(),1);
		            		$comision=round($totalVenta*($porcentajeComision/100),1);
		            	}
                        //echo $totalVenta.'<br>';
		            	$saldo['ventashielo'] += $totalVenta;
		            	$saldo['gananciashielo'] += $totalVenta-$costo-$comision;
		            	$saldo['comisioneshielo'] += $comision;
		           	}

	           		$uiDevolucionVentaCriteria = new UIDevolucionVentaCriteria();
		            $uiDevolucionVentaCriteria->setVentas($ventasoidshielo);
		            $uiDevolucionVentaCriteria->setProductos($productosoidshielo);
		           	$oDevolucions = UIServiceFactory::getUIDevolucionVentaService()->getList( $uiDevolucionVentaCriteria );
		           	foreach ($oDevolucions as $oDevolucion) {
		           		$totalVenta=round($oDevolucion->getPrecioUnitario()*$oDevolucion->getCantidad(),1);
			            $costo=round($oDevolucion->getCosto()*$oDevolucion->getCantidad(),1);
			           	/*$comision=0;
			           	$oVenta= $this->get($oDetalle->getVenta()->getOid());
		           		if ($oVenta->getComision()) {
		           			$porcentajeComision = round(($oVenta->getComision()*100)/$oVenta->getmonto(),1);
		            		$comision=round($totalVenta*($porcentajeComision/100),1);
		            	}*/
                        //echo $totalVenta.'<br>';
		            	$saldo['ventashielo'] -= $totalVenta;
		            	$saldo['gananciashielo'] -= $totalVenta-$costo;
		            	//$saldo['comisioneshielo'] += $comision;
		           	}
	           	}

	           	$saldo['ganancias'] -= $saldo['gananciashielo'];
            	$saldo['ventas'] -= $saldo['ventashielo'];
            	$saldo['comisiones'] -= $saldo['comisioneshielo'];

            	//echo $saldo['ganancias'];
            }


			if(count($ventasoids)>0){
				$saldo['ganancias'] = 0;
				$saldo['ventas'] = 0;
				$saldo['comisiones'] = 0;

				$productosProcesados=array();
				$clienteProductosProcesados=array();
            	$uiDetalleVentaCriteria = new UIDetalleVentaCriteria();
	            $uiDetalleVentaCriteria->setVentas($ventasoids);
	            $uiDetalleVentaCriteria->setProductos($productosoids);
	           	$oDetalles = UIServiceFactory::getUIDetalleVentaService()->getList( $uiDetalleVentaCriteria );
	           	foreach ($oDetalles as $oDetalle) {
	           	    //echo $oDetalle->getVenta()->getCliente()->getOid()."<br>";
	           		$totalVenta=round($oDetalle->getPrecioUnitario()*$oDetalle->getCantidad(),1);
		            $costo=round($oDetalle->getCosto()*$oDetalle->getCantidad(),1);
		           	$comision=0;
		           	$oVenta= $this->get($oDetalle->getVenta()->getOid());
	           		if ($oVenta->getComision()) {
	           			$porcentajeComision = round(($oVenta->getComision()*100)/$oVenta->getmonto(),1);
	            		$comision=round($totalVenta*($porcentajeComision/100),1);
	            	}

	            	$saldo['ventas'] += $totalVenta;
	            	$saldo['ganancias'] += $totalVenta-$costo-$comision;
	            	$saldo['comisiones'] += $comision;
	            	if (in_array($oDetalle->getProducto()->getOid(), $productosProcesados)) {
            			$saldo['productos']['ventas'][$oDetalle->getProducto()->getOid()] += $totalVenta;
	            		$saldo['productos']['costo'][$oDetalle->getProducto()->getOid()] += $costo;
	            		$saldo['productos']['cant'][$oDetalle->getProducto()->getOid()] += $oDetalle->getCantidad();
            		}
            		else{
            			$saldo['productos']['ventas'][$oDetalle->getProducto()->getOid()] = $totalVenta;
            			$saldo['productos']['costo'][$oDetalle->getProducto()->getOid()] = $costo;
            			$saldo['productos']['cant'][$oDetalle->getProducto()->getOid()] = $oDetalle->getCantidad();
            		}
            		$productosProcesados[]=$oDetalle->getProducto()->getOid();


            		$saldo['productos']['nombre'][$oDetalle->getProducto()->getOid()] = $oDetalle->getProducto()->getMarcaProducto()->getNombre().' '.$oDetalle->getProducto()->getNombre();

            		if (in_array($oDetalle->getVenta()->getCliente()->getOid().'-'.$oDetalle->getProducto()->getOid(), $clienteProductosProcesados)) {

	            		$saldo['clientes']['cant'][$oVenta->getCliente()->getOid().'-'.$oDetalle->getProducto()->getOid()] += $oDetalle->getCantidad();
            		}
            		else{

            			$saldo['clientes']['cant'][$oVenta->getCliente()->getOid().'-'.$oDetalle->getProducto()->getOid()] = $oDetalle->getCantidad();
            		}
            		$clienteProductosProcesados[]=$oVenta->getCliente()->getOid().'-'.$oDetalle->getProducto()->getOid();

            		$saldo['clientes']['cliente'][$oVenta->getCliente()->getOid()] = $oVenta->getCliente()->getNombre();
	           	}
	           	$uiDevolucionVentaCriteria = new UIDevolucionVentaCriteria();
	            $uiDevolucionVentaCriteria->setVentas($ventasoids);
	            $uiDevolucionVentaCriteria->setProductos($productosoids);
	           	$oDevolucions = UIServiceFactory::getUIDevolucionVentaService()->getList( $uiDevolucionVentaCriteria );
	           	foreach ($oDevolucions as $oDevolucion) {
	           	    //echo $oDevolucion->getVenta()->getCliente()->getOid();
	           		//$oVenta= $this->get($oDevolucion->getVenta()->getOid());
	           		$totalVenta=round($oDevolucion->getPrecioUnitario()*$oDevolucion->getCantidad(),1);
		            $costo=round($oDevolucion->getCosto()*$oDevolucion->getCantidad(),1);
		           	$totalVenta=$oDevolucion->getPrecioUnitario()*$oDevolucion->getCantidad();
            		$costo=$oDevolucion->getCosto()*$oDevolucion->getCantidad();

            		//echo $saldo['ventas']."<br>";
            		$saldo['ventas'] -= $totalVenta;
            		$saldo['ganancias'] -= $totalVenta-$costo;

            		if (in_array($oDevolucion->getProducto()->getOid(), $productosProcesados)) {
            			$saldo['productos']['ventas'][$oDevolucion->getProducto()->getOid()] -= $totalVenta;
	            		$saldo['productos']['costo'][$oDevolucion->getProducto()->getOid()] -= $costo;
	            		$saldo['productos']['cant'][$oDevolucion->getProducto()->getOid()] -= $oDevolucion->getCantidad();
            		}
            		else{
            			$saldo['productos']['ventas'][$oDevolucion->getProducto()->getOid()] = -$totalVenta;
            			$saldo['productos']['costo'][$oDevolucion->getProducto()->getOid()] = -$costo;
            			$saldo['productos']['cant'][$oDevolucion->getProducto()->getOid()] = -$oDevolucion->getCantidad();
            		}
            		$productosProcesados[]=$oDevolucion->getProducto()->getOid();


            		$saldo['productos']['nombre'][$oDevolucion->getProducto()->getOid()] = $oDevolucion->getProducto()->getMarcaProducto()->getNombre().' '.$oDevolucion->getProducto()->getNombre();
            		//Logger::logObject($clienteProductosProcesados);
            		if (in_array($oDevolucion->getVenta()->getCliente()->getOid().'-'.$oDevolucion->getProducto()->getOid(), $clienteProductosProcesados)) {

	            		$saldo['clientes']['cant'][$oDevolucion->getVenta()->getCliente()->getOid().'-'.$oDevolucion->getProducto()->getOid()] -= $oDevolucion->getCantidad();
            		}
            		else{

            			$saldo['clientes']['cant'][$oDevolucion->getVenta()->getCliente()->getOid().'-'.$oDevolucion->getProducto()->getOid()] = -$oDevolucion->getCantidad();
            		}
            		$clienteProductosProcesados[]=$oDevolucion->getVenta()->getCliente()->getOid().'-'.$oDevolucion->getProducto()->getOid();

            		$saldo['clientes']['cliente'][$oDevolucion->getVenta()->getCliente()->getOid()] = $oVenta->getCliente()->getNombre();
	           	}
	           	ksort($saldo['clientes']['cant']);
                $saldo['ganancias'] -= $saldo['gananciashielo'];
                $saldo['ventas'] -= $saldo['ventashielo'];
                $saldo['comisiones'] -= $saldo['comisioneshielo'];
            }



            return $saldo;


		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function get( $oid ){

		try{

			$service = ServiceFactory::getVentaService();

			return $service->get( $oid );

		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function add( Venta $venta ){

		try {

			$service = ServiceFactory::getVentaService();

			return $service->add( $venta );

		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}


	function getEntitiesCount($uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;

			$service = ServiceFactory::getVentaService();
			$ventas = $service->getCount( $criteria );

			return $ventas;

		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	function getEntities($uiCriteria){

		return $this->getList($uiCriteria);
	}


	public function cobrar(Venta $venta, Cuenta $cuenta, User $user, $monto, $montoActualizado){

		try {

			$service = ServiceFactory::getVentaService();

			return $service->cobrar($venta, $cuenta, $user, $monto, $montoActualizado);

		} catch (Exception $e) {

			throw new RastyException( $e->getMessage() );

		}

	}

	public function agregarProducto(Venta $venta, Cuenta $cuenta,User $user){

		try {

			$service = ServiceFactory::getVentaService();

			return $service->agregarProducto($venta, $cuenta, $user);

		} catch (Exception $e) {

			throw new RastyException( $e->getMessage() );

		}

	}

	public function devolver(Venta $venta, Cuenta $cuenta,User $user){

		try {

			$service = ServiceFactory::getVentaService();

			return $service->devolver($venta, $cuenta, $user);

		} catch (Exception $e) {

			throw new RastyException( $e->getMessage() );

		}

	}

	public function anular(Venta $venta, User $user){

		try {

			$service = ServiceFactory::getVentaService();

			return $service->anular($venta, $user);

		} catch (Exception $e) {

			throw new RastyException( $e->getMessage() );

		}

	}

	public function cobrarCtaCte(Venta $venta, User $user, $monto, $montoActualizado){

		try {

			$service = ServiceFactory::getVentaService();

			return $service->cobrarCtaCte($venta, $user, $monto, $montoActualizado);

		} catch (Exception $e) {

			throw new RastyException( $e->getMessage() );

		}

	}

	public function getTotalesDia( Datetime $fecha ){

		try {

			$service = ServiceFactory::getVentaService();

			return $service->getTotalesDia( $fecha );

		} catch (Exception $e) {

			throw new RastyException( $e->getMessage() );

		}

	}

	public function getTotalesMes( Datetime $fecha ){


		try {

			$service = ServiceFactory::getVentaService();

			return $service->getTotalesMes( $fecha );

		} catch (Exception $e) {

			throw new RastyException( $e->getMessage() );

		}

	}


	public function getTotalesCajaVentasOnlineCtaCte( Caja $caja ){

		try {

			$service = ServiceFactory::getMovimientoVentaService();

			$totales = $service->getTotalesCajaVentasOnlineCtaCte( $caja );

			return $totales;

		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}


	public function getTotalesCuenta( Cuenta $cuenta=null, DateTime $fecha=null ){

		try {

			$service = ServiceFactory::getMovimientoVentaService();

			$totales = $service->getTotales( $cuenta, $fecha );



			return $totales;

		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function getTotalesPagosCtaCte( Cuenta $cuenta=null, DateTime $fecha=null ){

		try {

			$service = ServiceFactory::getMovimientoPagoService();

			$totales = $service->getTotales( $cuenta, $fecha );



			return $totales;

		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function getTotalesCuentaMes( Cuenta $cuenta=null, DateTime $fecha=null ){

		try {

			$service = ServiceFactory::getMovimientoVentaService();

			$totales = $service->getTotalesMes( $cuenta, $fecha );

			return $totales;

		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function getTotalesCuentaAnioPorMes( Cuenta $cuenta=null, $anio ){

		try {

			$service = ServiceFactory::getMovimientoVentaService();

			$totales = $service->getTotalesAnioPorMes( $cuenta, $anio );

			return $totales;

		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

	public function getRankingProductos( UIVentaCriteria $uiCriteria, UIProductoCriteria $uiProductoCriteria){

		try {
            $productosoids=array();
            if (($uiProductoCriteria->getNombre())||($uiProductoCriteria->getTipoProducto())||($uiProductoCriteria->getMarcaProducto())) {

                $oProductos = UIServiceFactory::getUIProductoService()->getList( $uiProductoCriteria );
                foreach ($oProductos as $oProducto) {
                    $productosoids[]=$oProducto->getOid();


                }

            }



            $criteria = $uiCriteria->buildCoreCriteria() ;

			$service = ServiceFactory::getVentaService();

			$productos = $service->getRankProductos($criteria,$productosoids);

			return $productos;

		} catch (Exception $e) {

			throw new RastyException($e->getMessage());

		}
	}

    public function getRankingClientes( UIVentaCriteria $uiCriteria){

        try {




            $criteria = $uiCriteria->buildCoreCriteria() ;

            $service = ServiceFactory::getVentaService();

            $clientes = $service->getRankClientes($criteria);

            return $clientes;

        } catch (Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }



}
?>
