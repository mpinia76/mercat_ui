<?php
namespace Mercat\UI\actions\conceptoMovimientos;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\ConceptoMovimiento;
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
 * @since 12/03/2018
 */
class EliminarConceptoMovimiento extends JsonAction{

	
	public function execute(){

		try {

			$conceptoMovimientoOid = RastyUtils::getParamGET("conceptoMovimientoOid");
			
			//obtenemos la conceptoMovimiento
			$conceptoMovimiento = UIServiceFactory::getUIConceptoMovimientoService()->get($conceptoMovimientoOid);

			UIServiceFactory::getUIConceptoMovimientoService()->delete($conceptoMovimiento);
			
			$result["info"] = Locale::localize("conceptoMovimiento.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>