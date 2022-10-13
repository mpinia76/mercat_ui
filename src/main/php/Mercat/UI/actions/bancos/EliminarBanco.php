<?php
namespace Mercat\UI\actions\bancos;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Banco;
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
 * @since 06/03/2021
 */
class EliminarBanco extends JsonAction{


	public function execute(){

		try {

			$bancoOid = RastyUtils::getParamGET("bancoOid");

			//obtenemos la banco
			$banco = UIServiceFactory::getUIBancoService()->get($bancoOid);

			UIServiceFactory::getUIBancoService()->delete($banco);

			$result["info"] = Locale::localize("banco.borrar.success")  ;

		} catch (RastyException $e) {

			$result["error"] = Locale::localize($e->getMessage())  ;

		}

		return $result;

	}
}
?>
