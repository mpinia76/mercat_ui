<?php
namespace Mercat\UI\actions\conceptoMovimientos;

use Mercat\UI\components\form\conceptoMovimiento\ConceptoMovimientoForm;

use Mercat\UI\service\UIServiceFactory;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Rasty\i18n\Locale;

use Rasty\factory\PageFactory;

/**
 * se realiza la actualización de una conceptoMovimiento.
 * 
 * @author Marcos
 * @since 12/03/2018
 */
class ModificarConceptoMovimiento extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("ConceptoMovimientoModificar");
		
		$conceptoMovimientoForm = $page->getComponentById("conceptoMovimientoForm");
			
		$oid = $conceptoMovimientoForm->getOid();
						
		try {

			//obtenemos la conceptoMovimiento.
			$conceptoMovimiento = UIServiceFactory::getUIConceptoMovimientoService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$conceptoMovimientoForm->fillEntity($conceptoMovimiento);
			
			//guardamos los cambios.
			UIServiceFactory::getUIConceptoMovimientoService()->update( $conceptoMovimiento );
			
			$forward->setPageName( $conceptoMovimientoForm->getBackToOnSuccess() );
			$forward->addParam( "conceptoMovimientoOid", $conceptoMovimiento->getOid() );
			
			$conceptoMovimientoForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "ConceptoMovimientoModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$conceptoMovimientoForm->save();
			
		}
		return $forward;
		
	}

}
?>