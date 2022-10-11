<?php
namespace Mercat\UI\actions\packs;

use Mercat\UI\components\form\pack\PackForm;

use Mercat\UI\service\UIServiceFactory;
use Mercat\UI\utils\MercatUtils;

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
 * se realiza la actualización de un pack.
 * 
 * @author Marcos
 * @since 28/03/2019
 */
class ModificarPack extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("PackModificar");
		
		$packForm = $page->getComponentById("packForm");
			
		$oid = $packForm->getOid();
						
		try {

			//obtenemos el pack.
			$pack = UIServiceFactory::getUIPackService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$packForm->fillEntity($pack);
			
			//guardamos los cambios.
			UIServiceFactory::getUIPackService()->update( $pack );
			
			$forward->setPageName( $packForm->getBackToOnSuccess() );
			$forward->addParam( "productoOid", $pack->getProducto()->getOid() );		
			
			$packForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "PackModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$packForm->save();
			
		}
		return $forward;
		
	}

}
?>