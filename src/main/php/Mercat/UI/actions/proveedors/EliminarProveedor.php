<?php
namespace Mercat\UI\actions\proveedors;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Proveedor;
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
 * @since 10/07/2020
 */
class EliminarProveedor extends JsonAction{

	
	public function execute(){

		try {

			$proveedorOid = RastyUtils::getParamGET("proveedorOid");
			
			//obtenemos la proveedor
			$proveedor = UIServiceFactory::getUIProveedorService()->get($proveedorOid);

			UIServiceFactory::getUIProveedorService()->delete($proveedor);
			
			$result["info"] = Locale::localize("proveedor.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>