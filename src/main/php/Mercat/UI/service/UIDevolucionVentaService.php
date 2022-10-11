<?php
namespace Mercat\UI\service;

use Mercat\UI\components\filter\model\UIDevolucionVentaCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\model\DevolucionVenta;

use Mercat\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para devolucions.
 * 
 * @author Marcos
 * @since 15/08/2020
 */
class UIDevolucionVentaService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIDevolucionVentaService();
			
		}
		return self::$instance; 
	}

	
	public function getByCriteria( UIDevolucionVentaCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getDevolucionVentaService();
			
			$devolucion = $service->getSingleResult( $criteria );
	
			return $devolucion;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	
	public function getList( UIDevolucionVentaCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getDevolucionVentaService();
			
			$devolucions = $service->getList( $criteria );
	
			return $devolucions;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getDevolucionVentaService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( DevolucionVenta $devolucion ){

		try{

			$service = ServiceFactory::getDevolucionVentaService();
		
			return $service->add( $devolucion );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( DevolucionVenta $devolucion ){

		try{

			$service = ServiceFactory::getDevolucionVentaService();
		
			return $service->update( $devolucion );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getDevolucionVentaService();
			$devolucions = $service->getCount( $criteria );
			
			return $devolucions;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function delete(DevolucionVenta $devolucion){

		try {
			
			$service = ServiceFactory::getDevolucionVentaService();
			
			return $service->delete($devolucion->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
}
?>