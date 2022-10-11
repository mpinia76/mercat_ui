<?php
namespace Mercat\UI\actions\ventas;

use Mercat\UI\utils\MercatUIUtils;



use Mercat\UI\service\UIServiceFactory;



use Rasty\actions\JsonAction;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;

use Rasty\app\RastyMapHelper;
use Rasty\factory\ComponentFactory;
use Rasty\factory\ComponentConfig;

use Rasty\utils\Logger;

/**
 * se agregar un detalle de venta para la edición
 * en sesión.
 * 
 * @author Marcos
 * @since 23/07/2020
 */
class ConsultarVendedorMayoristaJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			

			$vendedor = RastyUtils::getParamPOST("vendedor");
			
		
			$oVendedor = UIServiceFactory::getUIVendedorService()->get( $vendedor );
			
		
			
			
			MercatUIUtils::setDetallesVentaSession( array() );
			MercatUIUtils::setDetallesPresupuestoSession( array() );
			
			$result["detalles"] =  array();
			
			
			$result["mayorista"] = $oVendedor->getMayorista();
			
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>