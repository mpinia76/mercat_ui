<?php
namespace Mercat\UI\service;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\model\Transferencia;

use Mercat\Core\service\ServiceFactory;
use Cose\Security\model\User;

use Mercat\Core\model\Cuenta;

/**
 * 
 * UI service para transferencia.
 * 
 * @author Marcos
 * @since 14/10/2022
 */
class UITransferenciaService {
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UITransferenciaService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UITransferenciaCriteria $uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getTransferenciaService();
			
			$transferencias = $service->getList( $criteria );
	
			return $transferencias;

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			
	}
	
	public function get( $oid ){

		try {
			
			$service = ServiceFactory::getTransferenciaService();
			
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function add( Transferencia $transferencia ){

		try {
			
			$service = ServiceFactory::getTransferenciaService();
			
			return $service->add( $transferencia );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getTotalesCuenta( Cuenta $cuenta=null, \DateTime $fecha=null ){

		try {
			
			$service = ServiceFactory::getMovimientoTransferenciaService();
			
			$totales = $service->getTotales( $cuenta, $fecha );

			return $totales;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}

}
?>