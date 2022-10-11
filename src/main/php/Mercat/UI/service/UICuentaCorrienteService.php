<?php
namespace Mercat\UI\service;

use Mercat\UI\components\filter\model\UICuentaCorrienteCriteria;

use Mercat\UI\utils\MercatUIUtils;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\model\Cliente;
use Mercat\Core\model\CuentaCorriente;
use Mercat\Core\model\Cuenta;
use Mercat\Core\model\Transferencia;

use Mercat\Core\service\ServiceFactory;

use Mercat\Core\utils\MercatUtils;

use Cose\Security\model\User;
use Rasty\security\RastySecurityContext;

/**
 * 
 * UI service para CuentaCorriente.
 * 
 * @author Marcos
 * @since 23-03-2018
 */
class UICuentaCorrienteService {
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UICuentaCorrienteService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UICuentaCorrienteCriteria $uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getCuentaCorrienteService();
			
			$cuentas = $service->getList( $criteria );
	
			return $cuentas;

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			
	}
	
	
	public function get( $oid ){

		try {
			
			$service = ServiceFactory::getCuentaCorrienteService();
			
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
		
	public function getMovimientos( CuentaCorriente $cuenta ){

		try {
			
			$service = ServiceFactory::getMovimientoCuentaService();
			
			$movimientos = $service->getMovimientos( $cuenta );

			return $movimientos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	

	
	public function add( CuentaCorriente $cuentaCorriente ){

		try {
			
			$service = ServiceFactory::getCuentaCorrienteService();
			
			return $service->add( $cuentaCorriente );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getTotalesVenta( \DateTime $fecha=null ){

		try {
			
			$service = ServiceFactory::getCuentaCorrienteService();
			
			return $service->getTotalesVenta( $fecha ) ;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getTotalesPago( \DateTime $fecha=null ){

		try {
			
			$service = ServiceFactory::getCuentaCorrienteService();
			
			return $service->getTotalesPago( $fecha ) ;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}	
	
	public function cobrarDeuda(Cliente $cliente, Cuenta $destino, $monto, $observaciones ){

		try{
			
			if(!$cliente->hasCuentaCorriente())
				throw new RastyException( "cobrarCtaCte.cuentaCorriente.required");
			
			$user = RastySecurityContext::getUser();
			$user = MercatUtils::getUserByUsername($user->getUsername());
			
			
			$service = ServiceFactory::getCuentaCorrienteService();
			
			$service->cobrarDeuda($cliente, $destino, $monto, $observaciones, $user);
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
		
	}
	
	public function actualizarDeuda(Cliente $cliente, Cuenta $destino, $monto, $observaciones ){

		try{
			
			if(!$cliente->hasCuentaCorriente())
				throw new RastyException( "cobrarCtaCte.cuentaCorriente.required");
			
			$user = RastySecurityContext::getUser();
			$user = MercatUtils::getUserByUsername($user->getUsername());
			
			
			$service = ServiceFactory::getCuentaCorrienteService();
			
			$service->actualizarDeuda($cliente, $destino, $monto, $observaciones, $user);
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
		
	}
	
	/**
	 * retorna los saldos de todas las ctas ctes
	 */
	public function getSaldoCtasCtes(){
		
		$ctas = $this->getList(new UICuentaCorrienteCriteria());
		$saldos = 0;
		foreach ($ctas as $ctaCte) {
			$saldos += $ctaCte->getSaldo();
		}
		return $saldos;
	}
}
?>