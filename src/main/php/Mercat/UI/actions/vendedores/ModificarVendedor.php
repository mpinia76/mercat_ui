<?php
namespace Mercat\UI\actions\vendedores;

use Mercat\UI\components\form\vendedor\VendedorForm;

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
 * se realiza la actualización de un vendedor.
 * 
 * @author Marcos
 * @since 21/07/2020
 */
class ModificarVendedor extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("VendedorModificar");
		
		$vendedorForm = $page->getComponentById("vendedorForm");
			
		$oid = $vendedorForm->getOid();
						
		try {

			//obtenemos el vendedor.
			$vendedor = UIServiceFactory::getUIVendedorService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$vendedorForm->fillEntity($vendedor);
			
			//guardamos los cambios.
			UIServiceFactory::getUIVendedorService()->update( $vendedor );
			
			$forward->setPageName( $vendedorForm->getBackToOnSuccess() );
			
			
			$vendedorForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "VendedorModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$vendedorForm->save();
			
		}
		return $forward;
		
	}

}
?>