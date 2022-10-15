<?php
namespace Mercat\UI\service;

use Mercat\UI\utils\MercatUIUtils;
use Mercat\Core\utils\MercatUtils;

use Mercat\UI\components\filter\model\UIEmpleadoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\model\Empleado;
use Mercat\Core\model\Caja;
use Mercat\Core\model\Transferencia;

use Mercat\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\security\RastySecurityContext;

/**
 * 
 * UI service para caja.
 * 
 * @author Marcos
 * @since 12/10/2022
 */
class UICajaService {
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UICajaService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UICajaCriteria $uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getCajaService();
			
			$cajas = $service->getList( $criteria );
	
			return $cajas;

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			
	}
	
	public function getCajaAbiertaByEmpleado(Empleado $empleado){
		
		try{
		
			$service = ServiceFactory::getCajaService();
			
			$caja = $service->getCajaAbiertaByEmpleado($empleado);
	
			return $caja;

		} catch (\Exception $e) {
			
			return null;
			
		}	
		
	}
	
	public function get( $oid ){

		try {
			
			$service = ServiceFactory::getCajaService();
			
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function add( Caja $caja ){

		try {
			
			$service = ServiceFactory::getCajaService();
			
			return $service->add( $caja );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}

	public function abrirCaja( Caja $caja, User $user ){

		try {
			
			$service = ServiceFactory::getCajaService();
			
			return $service->abrirCaja( $caja, $user );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function cerrarCaja( Caja $caja, User $user ){

		try {
			
			$service = ServiceFactory::getCajaService();
			
			$service->cerrarCaja( $caja, $user );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getMovimientos( Caja $caja ){

		try {
			
			$service = ServiceFactory::getMovimientoMercatervice();
			
			$movimientos = $service->getMovimientos( $caja );

			return $movimientos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function retirarEfectivo( $monto, $observaciones ){

		try{
			
			//recuperamos la caja chica.
			$cajaChica = UIServiceFactory::getUICuentaService()->getCajaChica();
			
			//recuperamos la caja actual
			$caja = UIServiceFactory::getUICajaService()->get( MercatUIUtils::getCaja()->getOid() );

			$user = RastySecurityContext::getUser();
			$user = MercatUtils::getUserByUsername($user->getUsername());
			
			$transferencia = new Transferencia();
			$transferencia->setOrigen( $caja );
			$transferencia->setDestino( $cajaChica );
			$transferencia->setMonto( $monto );
			$transferencia->setFechaHora( new \Datetime() );
			$transferencia->setObservaciones( $observaciones );
			$transferencia->setUser( $user );
			
			UIServiceFactory::getUITransferenciaService()->add( $transferencia );			
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
		
	}

	/**
	 * retorna todas las cajas abiertas
	 * @throws RastyException
	 */
	public function getCajasAbiertas( \DateTime $fecha=null){
		
		try{
		
			$service = ServiceFactory::getCajaService();
			
			$cajas = $service->getCajasAbiertas($fecha);
	
			return $cajas;

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}	
		
	}
	
	/**
	 * retorna los saldos de todas las cajas abiertas
	 */
	public function getSaldoCajas(){
		
		$cajas = $this->getCajasAbiertas();
		$saldos = 0;
		foreach ($cajas as $caja) {
			$saldos += $caja->getSaldo();
		}
		return $saldos;
	}
	
	/**
	 * retorna todas las cajas de la fecha indicada
	 * @throws RastyException
	 */
	public function getCajasFecha( \DateTime $fecha){
		
		try{
		
			$service = ServiceFactory::getCajaService();
			
			$cajas = $service->getCajasFecha($fecha);
	
			return $cajas;

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}	
		
	}
	
	public function ingresarEfectivo( $monto, $observaciones ){

		try{
			
			//recuperamos la caja chica.
			$cajaChica = UIServiceFactory::getUICuentaService()->getCajaChica();
			
			//recuperamos la caja actual
			$caja = UIServiceFactory::getUICajaService()->get( MercatUIUtils::getCaja()->getOid() );

			$user = RastySecurityContext::getUser();
			$user = MercatUtils::getUserByUsername($user->getUsername());
			
			$transferencia = new Transferencia();
			$transferencia->setOrigen( $cajaChica );
			$transferencia->setDestino( $caja );
			$transferencia->setMonto( $monto );
			$transferencia->setFechaHora( new \Datetime() );
			$transferencia->setObservaciones( $observaciones );
			$transferencia->setUser( $user );
			
			UIServiceFactory::getUITransferenciaService()->add( $transferencia );			
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
		
	}
}
?>