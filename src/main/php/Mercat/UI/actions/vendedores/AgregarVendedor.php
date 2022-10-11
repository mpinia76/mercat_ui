<?php
namespace Mercat\UI\actions\vendedores;


use Mercat\UI\components\form\vendedor\VendedorForm;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Vendedor;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una Vendedor.
 * 
 * @author Marcos
 * @since 21/07/2020
 */
class AgregarVendedor extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("VendedorAgregar");
		
		$vendedorForm = $page->getComponentById("vendedorForm");
		
		try {

			//creamos un nuevo vendedor.
			$vendedor = new Vendedor();
			
			//completados con los datos del formulario.
			$vendedorForm->fillEntity($vendedor);
			
			//print_r($vendedor->getDetalles());
			//agregamos la vendedor.
			UIServiceFactory::getUIVendedorService()->add( $vendedor );
			
			$forward->setPageName( $vendedorForm->getBackToOnSuccess() );
			$forward->addParam( "vendedorOid", $vendedor->getOid() );			
		
			$vendedorForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "VendedorAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$vendedorForm->save();
		}
		
		return $forward;
		
	}

}
?>