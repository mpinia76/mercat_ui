<?php
namespace Mercat\UI\service;

use Mercat\UI\components\filter\model\UIInformeSemanalCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\model\InformeSemanal;

use Mercat\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para Informes Semanales.
 * 
 * @author Marcos
 * @since 12/10/2022
 */
class UIInformeSemanalService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIInformeSemanalService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIInformeSemanalCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getInformeSemanalService();
			
			$informeSemanals = $service->getList( $criteria );
	
			return $informeSemanals;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
		
	public function get( $oid ){

		try{

			$service = ServiceFactory::getInformeSemanalService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}

	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getInformeSemanalService();
			$informeSemanals = $service->getCount( $criteria );
			
			return $informeSemanals;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function add( InformeSemanal $informeSemanal ){

		try{

			$service = ServiceFactory::getInformeSemanalService();
		
			return $service->add( $informeSemanal );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( InformeSemanal $informeSemanal ){

		try{

			$service = ServiceFactory::getInformeSemanalService();
		
			return $service->update( $informeSemanal );
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function getInformeAnualPorMes($anio){

		try{

			$service = ServiceFactory::getInformeSemanalService();
		
			return $service->getInformeAnualPorMes( $anio );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getInformeAnualPorSemana($anio){

		try{

			$service = ServiceFactory::getInformeSemanalService();
		
			return $service->getInformeAnualPorSemana( $anio );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
}
?>