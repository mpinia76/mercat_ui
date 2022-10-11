<?php
namespace Mercat\UI\actions\productos;

use Mercat\UI\components\form\producto\ProductoForm;

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
 * se realiza la actualización de un producto.
 * 
 * @author Marcos
 * @since 06/03/2018
 */
class ModificarProducto extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("ProductoModificar");
		
		$productoForm = $page->getComponentById("productoForm");
			
		$oid = $productoForm->getOid();
						
		try {

			//obtenemos el producto.
			$producto = UIServiceFactory::getUIProductoService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$productoForm->fillEntity($producto);
			
			//guardamos los cambios.
			UIServiceFactory::getUIProductoService()->update( $producto );
			
			$forward->setPageName( $productoForm->getBackToOnSuccess() );
			$forward->addParam( "productoOid", $producto->getOid() );
			
			$productoForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "ProductoModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$productoForm->save();
			
		}
		return $forward;
		
	}

}
?>