<?php
namespace Mercat\UI\actions\ventas;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\form\venta\VentaForm;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Venta;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una Venta.
 * 
 * @author Marcos
 * @since 09/03/2018
 */
class AgregarVenta extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("VentaAgregar");
		
		$ventaForm = $page->getComponentById("ventaForm");
		
		try {

			//creamos un nuevo venta.
			$venta = new Venta();
			
			//completados con los datos del formulario.
			$ventaForm->fillEntity($venta);
			
			//MercatUIUtils::setVendedorSession($venta->getVendedor()->getOid());
            MercatUIUtils::setVendedorSession(1);
			
			//print_r($venta->getDetalles());
			//agregamos la venta.
			UIServiceFactory::getUIVentaService()->add( $venta );
			
			$forward->setPageName( $ventaForm->getBackToOnSuccess() );
			$forward->addParam( "ventaOid", $venta->getOid() );			
		
			$ventaForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "VentaAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$ventaForm->save();
		}
		
		return $forward;
		
	}

}
?>