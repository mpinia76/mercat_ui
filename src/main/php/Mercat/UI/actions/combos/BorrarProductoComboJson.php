<?php
namespace Mercat\UI\actions\combos;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIProductoService;

use Mercat\UI\service\UIServiceFactory;

use Mercat\Core\model\ProductoCombo;

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
 * se borra un producto de combo para la edición
 * en sesión.
 * 
 * @author Marcos
 * @since 29/08/2019
 */
class BorrarProductoComboJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			//indice del producto a eliminar.
			$index = RastyUtils::getParamPOST("index");
			if(empty($index))
				$index = 0;
			//eliminamos el producto dado el índice
			MercatUIUtils::borrarProductoComboSession($index);
			
			$productos = MercatUIUtils::getProductosComboSession();
			$result["productos"] = $productos;
			
			$result["importe"] = 0;
			foreach ($productos as $productojson) {
				$result["importe"] += $productojson["subtotal"];
			}
			
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>