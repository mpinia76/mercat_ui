<?php
namespace Mercat\UI\actions\tiposProducto;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\TipoProducto;
use Mercat\Core\utils\MercatUtils;

use Rasty\actions\JsonAction;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se eliminar un tipo de documento
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class EliminarTipoProducto extends JsonAction{

	
	public function execute(){

		try {

			$tipoProductoOid = RastyUtils::getParamGET("tipoProductoOid");
			
			//obtenemos la tipoProducto
			$tipoProducto = UIServiceFactory::getUITipoProductoService()->get($tipoProductoOid);

			UIServiceFactory::getUITipoProductoService()->delete($tipoProducto);
			
			$result["info"] = Locale::localize("tipoProducto.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>