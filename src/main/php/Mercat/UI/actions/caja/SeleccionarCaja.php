<?php
namespace Mercat\UI\actions\caja;

use Mercat\UI\utils\MercatUIUtils;
use Mercat\Core\utils\MercatUtils;

use Mercat\UI\service\UIServiceFactory;

use Mercat\Core\model\Caja;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;
use Rasty\exception\RastyDuplicatedException;
use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;

/**
 * se selecciona una caja
 * 
 * @author Marcos
 * @since 12-10-2022
 */
class SeleccionarCaja extends Action{

	
	public function execute(){

		$forward = new Forward();

		try {

			//obtenemos la caja a seleccionar.
			$cajaOid = RastyUtils::getParamPOST("caja");
			
			if(!empty($cajaOid)){
				$caja = UIServiceFactory::getUICajaService()->get( $cajaOid );
	
				MercatUIUtils::setCaja( $caja );	
			}else{
				
				MercatUIUtils::setCaja( null );
			}
			
			
			
			$forward->setPageName( "CajaHome" );
			
		} catch (RastyDuplicatedException $e) {
		
			$forward->setPageName( "SeleccionarCaja" );
			$forward->addError( $e->getMessage() );
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "SeleccionarCaja" );
			$forward->addError(Locale::localize($e->getMessage()) );
			
		}
		
		return $forward;
		
	}

}
?>