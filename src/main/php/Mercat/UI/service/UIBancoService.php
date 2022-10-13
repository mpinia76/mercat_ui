<?php
namespace Mercat\UI\service;

use Mercat\UI\components\filter\model\UIBancoCriteria;


use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mercat\Core\service\ServiceFactory;

use Mercat\Core\utils\MercatUtils;
use Mercat\Core\model\Banco;
use Mercat\Core\model\Transferencia;

use Cose\Security\model\User;
use Rasty\security\RastySecurityContext;


/**
 * 
 * UI service para Banco.
 * 
 * @author Marcos
 * @since 13-10-2022
 */
class UIBancoService {
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIBancoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIBancoCriteria $uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getBancoService();
			
			$bancos = $service->getList( $criteria );
	
			return $bancos;

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			
	}
	
	
	public function get( $oid ){

		try {
			
			$service = ServiceFactory::getBancoService();
			
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
		
	public function getCuentaBAPRO(){
		
		try {
			
			return MercatUtils::getCuentaBAPRO();

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}	
		
	}
	

	public function depositarEfectivo(Banco $banco, $monto, $observaciones ){

		try{
			
			//recuperamos la caja chica.
			$cajaChica = UIServiceFactory::getUIMercatervice()->getCajaChica();
			
			$user = RastySecurityContext::getUser();
			$user = MercatUtils::getUserByUsername($user->getUsername());
			
			$transferencia = new Transferencia();
			$transferencia->setOrigen( $cajaChica );
			$transferencia->setDestino( $banco );
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
	 * retorna los saldos de todos los bancos
	 */
	public function getSaldoBancos(){
		
		$bancos = $this->getList(new UIBancoCriteria());
		$saldos = 0;
		foreach ($bancos as $banco) {
			$saldos += $banco->getSaldo();
		}
		return $saldos;
	}
}
?>