<?php
namespace Mercat\UI\actions\conceptoGastos;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\ConceptoGasto;
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
 * se eliminar un concepto de gasto
 * 
 * @author Marcos
 * @since 09/03/2018
 */
class EliminarConceptoGasto extends JsonAction{

	
	public function execute(){

		try {

			$conceptoGastoOid = RastyUtils::getParamGET("conceptoGastoOid");
			
			//obtenemos la conceptoGasto
			$conceptoGasto = UIServiceFactory::getUIConceptoGastoService()->get($conceptoGastoOid);

			UIServiceFactory::getUIConceptoGastoService()->delete($conceptoGasto);
			
			$result["info"] = Locale::localize("conceptoGasto.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>