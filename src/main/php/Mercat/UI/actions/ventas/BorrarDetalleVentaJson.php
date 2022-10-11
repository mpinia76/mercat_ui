<?php
namespace Mercat\UI\actions\ventas;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIProductoService;

use Mercat\UI\service\UIServiceFactory;

use Mercat\Core\model\DetalleVenta;

use Rasty\actions\JsonAction;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;

use Rasty\app\RastyMapHelper;
use Rasty\factory\ComponentFactory;
use Rasty\factory\ComponentConfig;

/**
 * se borra un detalle de venta para la edición
 * en sesión.
 * 
 * @author Marcos
 * @since 13/03/2018
 */
class BorrarDetalleVentaJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			//indice del detalle a eliminar.
			$index = RastyUtils::getParamPOST("index");
			if(empty($index))
				$index = 0;
			//eliminamos el detalle dado el índice
			MercatUIUtils::borrarDetalleVentaSession($index);
			
			$detalles = MercatUIUtils::getDetallesVentaSession();
			$result["detalles"] = $detalles;
			
			$result["importe"] = 0;
			foreach ($detalles as $detallejson) {
				$result["importe"] += $detallejson["subtotal"];
			}
			
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>