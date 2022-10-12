<?php
namespace Mercat\UI\service;

use Mercat\UI\components\filter\model\UIEmpleadoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\model\Empleado;

use Mercat\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para empleados.
 * 
 * @author Marcos
 * @since 12/10/2022
 */
class UIEmpleadoService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIEmpleadoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIEmpleadoCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getEmpleadoService();
			
			$empleados = $service->getList( $criteria );
	
			return $empleados;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getEmpleadoService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( Empleado $empleado ){

		try{

			$service = ServiceFactory::getEmpleadoService();
		
			return $service->add( $empleado );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( Empleado $empleado ){

		try{

			$service = ServiceFactory::getEmpleadoService();
		
			return $service->update( $empleado );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getEmpleadoService();
			$empleados = $service->getCount( $criteria );
			
			return $empleados;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	public function delete(Empleado $empleado){

		try {
			
			$service = ServiceFactory::getEmpleadoService();
			
			return $service->delete($empleado->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
	
	public function getTotalCtaCte( UIEmpleadoCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getEmpleadoService();
			
			$empleados = $service->getList( $criteria );
	
			$saldo = 0;
            foreach ($empleados as $empleado) {
            	
            		$saldo += $empleado->getSaldo();
            	
            }
            return $saldo;
            
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
}
?>