<?php
namespace Mercat\UI\actions\ventas;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIProductoService;

use Mercat\UI\service\UIServiceFactory;

use Mercat\Core\model\DevolucionVenta;

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
 * se borra un devolucion de venta para la edición
 * en sesión.
 * 
 * @author Marcos
 * @since 28/04/2019
 */
class BorrarDevolucionVentaJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			//indice del devolucion a eliminar.
			$index = RastyUtils::getParamPOST("index");
			if(empty($index))
				$index = 0;
			//eliminamos el devolucion dado el índice
			MercatUIUtils::borrarDevolucionVentaSession($index);
			
			$devoluciones = MercatUIUtils::getDevolucionesVentaSession();
			$result["devoluciones"] = $devoluciones;
			
			$result["importe"] = 0;
			foreach ($devoluciones as $devolucionjson) {
				$result["importe"] += $devolucionjson["subtotal"];
			}
			
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>