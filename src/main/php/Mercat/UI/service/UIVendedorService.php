<?php
namespace Mercat\UI\service;

use Mercat\UI\components\filter\model\UIVendedorCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\model\Vendedor;


use Mercat\Core\service\ServiceFactory;


use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para Vendedor.
 * 
 * @author Marcos
 * @since 21/07/2020
 */
class UIVendedorService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIVendedorService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIVendedorCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getVendedorService();
			
			$vendedores = $service->getList( $criteria );
	
			return $vendedores;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	
	
	public function get( $oid ){

		try{
			
			$service = ServiceFactory::getVendedorService();
		
			return $service->get( $oid );
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function add( Vendedor $vendedor ){

		try {
			
			$service = ServiceFactory::getVendedorService();
			
			return $service->add( $vendedor );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}

	public function update( Vendedor $vendedor ){

		try{

			$service = ServiceFactory::getVendedorService();
		
			return $service->update( $vendedor );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getVendedorService();
			$vendedores = $service->getCount( $criteria );
			
			return $vendedores;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	public function delete(Vendedor $vendedor){

		try {
			
			$service = ServiceFactory::getVendedorService();
			
			return $service->delete($vendedor->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
	
}
?>