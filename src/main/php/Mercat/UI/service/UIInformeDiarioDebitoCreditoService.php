<?php
namespace Mercat\UI\service;

use Mercat\UI\components\filter\model\UIInformeDiarioDebitoCreditoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\model\InformeDiarioDebitoCredito;

use Mercat\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para Informes Diarios de débitos y créditos.
 * 
 * @author Marcos
 * @since 12/10/2022
 */
class UIInformeDiarioDebitoCreditoService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIInformeDiarioDebitoCreditoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIInformeDiarioDebitoCreditoCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getInformeDiarioDebitoCreditoService();
			
			$informeDiarioDebitoCreditos = $service->getList( $criteria );
	
			return $informeDiarioDebitoCreditos;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
		
	public function get( $oid ){

		try{

			$service = ServiceFactory::getInformeDiarioDebitoCreditoService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}

	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getInformeDiarioDebitoCreditoService();
			$informeDiarioDebitoCreditos = $service->getCount( $criteria );
			
			return $informeDiarioDebitoCreditos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	public function getDebitosCreditosPendientes(){
		

		try{
				
				
			$service = ServiceFactory::getInformeDiarioDebitoCreditoService();
			$informeDiarioDebitoCreditos = $service->getPendientes();

			return $informeDiarioDebitoCreditos;
				
		} catch (\Exception $e) {
				
			throw new RastyException($e->getMessage());
				
		}
		
	}
	
	public function add( InformeDiarioDebitoCredito $informeDiarioDebitoCredito ){

		try{

			$service = ServiceFactory::getInformeDiarioDebitoCreditoService();
		
			return $service->add( $informeDiarioDebitoCredito );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( InformeDiarioDebitoCredito $informeDiarioDebitoCredito ){

		try{

			$service = ServiceFactory::getInformeDiarioDebitoCreditoService();
		

			return $service->update( $informeDiarioDebitoCredito );
		
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
}
?>