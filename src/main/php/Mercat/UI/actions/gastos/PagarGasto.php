<?php
namespace Mercat\UI\actions\gastos;

use Mercat\UI\utils\MercatUIUtils;
use Mercat\Core\utils\MercatUtils;


use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Gasto;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se paga un gasto
 * 
 * @author Marcos
 * @since 09/03/2018
 */
class PagarGasto extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		//tomamos la gasto y la cuenta con la cuenta se paga
		$gastoOid = RastyUtils::getParamGET("gastoOid");
		$cuentaOid = RastyUtils::getParamGET("cuentaOid");
		
		$backTo = MercatUIUtils::isAdminLogged()?"AdminHome":"CajaHome";
		
		$forward->addParam( "gastoOid", $gastoOid );
		try {

			
			//recuperamos el gasto.
			$gasto = UIServiceFactory::getUIGastoService()->get( $gastoOid );
			
			//recuperamos la cuenta
			$cuenta = UIServiceFactory::getUICuentaService()->get( $cuentaOid );

			$user = RastySecurityContext::getUser();
			$user = MercatUtils::getUserByUsername($user->getUsername());
			
			UIServiceFactory::getUIGastoService()->pagar($gasto, $cuenta, $user);			
			
			$forward->setPageName( $backTo );
		
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "GastoPagar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
		}
		
		return $forward;
		
	}

}
?>