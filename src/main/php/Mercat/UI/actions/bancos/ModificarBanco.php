<?php
namespace Mercat\UI\actions\bancos;

use Mercat\UI\components\form\banco\BancoForm;

use Mercat\UI\service\UIServiceFactory;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Rasty\i18n\Locale;

use Rasty\factory\PageFactory;

/**
 * se realiza la actualización de una banco.
 *
 * @author Marcos
 * @since 05/03/2018
 */
class ModificarBanco extends Action{


	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("BancoModificar");

		$bancoForm = $page->getComponentById("bancoForm");

		$oid = $bancoForm->getOid();

		try {

			//obtenemos la banco.
			$banco = UIServiceFactory::getUIBancoService()->get($oid );

			//lo editamos con los datos del formulario.
			$bancoForm->fillEntity($banco);

			//guardamos los cambios.
			UIServiceFactory::getUIBancoService()->update( $banco );

			$forward->setPageName( $bancoForm->getBackToOnSuccess() );
			$forward->addParam( "bancoOid", $banco->getOid() );

			$bancoForm->cleanSavedProperties();

		} catch (RastyException $e) {

			$forward->setPageName( "BancoModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );

			//guardamos lo ingresado en el form.
			$bancoForm->save();

		}
		return $forward;

	}

}
?>
