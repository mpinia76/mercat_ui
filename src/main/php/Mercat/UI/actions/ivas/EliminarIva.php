<?php
namespace Mercat\UI\actions\ivas;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Iva;
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
class EliminarIva extends JsonAction{

	
	public function execute(){

		try {

			$ivaOid = RastyUtils::getParamGET("ivaOid");
			
			//obtenemos la iva
			$iva = UIServiceFactory::getUIIvaService()->get($ivaOid);

			UIServiceFactory::getUIIvaService()->delete($iva);
			
			$result["info"] = Locale::localize("iva.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>