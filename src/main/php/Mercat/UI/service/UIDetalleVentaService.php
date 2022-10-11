<?php
namespace Mercat\UI\service;

use Mercat\UI\components\filter\model\UIDetalleVentaCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\model\DetalleVenta;

use Mercat\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para detalles.
 * 
 * @author Marcos
 * @since 15/08/2020
 */
class UIDetalleVentaService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIDetalleVentaService();
			
		}
		return self::$instance; 
	}

	
	public function getByCriteria( UIDetalleVentaCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getDetalleVentaService();
			
			$detalle = $service->getSingleResult( $criteria );
	
			return $detalle;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	
	public function getList( UIDetalleVentaCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getDetalleVentaService();
			
			$detalles = $service->getList( $criteria );
	
			return $detalles;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getDetalleVentaService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( DetalleVenta $detalle ){

		try{

			$service = ServiceFactory::getDetalleVentaService();
		
			return $service->add( $detalle );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( DetalleVenta $detalle ){

		try{

			$service = ServiceFactory::getDetalleVentaService();
		
			return $service->update( $detalle );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getDetalleVentaService();
			$detalles = $service->getCount( $criteria );
			
			return $detalles;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function delete(DetalleVenta $detalle){

		try {
			
			$service = ServiceFactory::getDetalleVentaService();
			
			return $service->delete($detalle->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
}
?>