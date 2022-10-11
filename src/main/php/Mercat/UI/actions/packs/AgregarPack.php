<?php
namespace Mercat\UI\actions\packs;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\form\pack\PackForm;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Pack;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de un pack.
 * 
 * @author Marcos
 * @since 28/03/2019
 */
class AgregarPack extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("PackAgregar");
		
		$packForm = $page->getComponentById("packForm");
		
		try {

			//creamos un nuevo pack.
			$pack = new Pack();
			
			//completados con los datos del formulario.
			$packForm->fillEntity($pack);
			
			//agregamos el pack.
			UIServiceFactory::getUIPackService()->add( $pack );
			
			$forward->setPageName( $packForm->getBackToOnSuccess() );
			$forward->addParam( "productoOid", $pack->getProducto()->getOid() );			
		
			$packForm->cleanSavedProperties();
			
		} catch (RastyDuplicatedException $e) {
		
			$forward->setPageName( "PackAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
						
			//guardamos lo ingresado en el form.
			$packForm->save();
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "PackAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
						
			//guardamos lo ingresado en el form.
			$packForm->save();
		}
		
		return $forward;
		
	}

}
?>