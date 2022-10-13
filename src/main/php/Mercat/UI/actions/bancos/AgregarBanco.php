<?php
namespace Mercat\UI\actions\bancos;


use Mercat\UI\components\form\banco\BancoForm;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Banco;

use Mercat\UI\utils\MercatUIUtils;
use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una Banco.
 *
 * @author Marcos
 * @since 06/03/2021
 */
class AgregarBanco extends Action{


	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("BancoAgregar");

		$bancoForm = $page->getComponentById("bancoForm");

		try {

			//creamos una nueva banco.
			$banco = new Banco();


			//completados con los datos del formulario.
			$bancoForm->fillEntity($banco);

            $banco->setFecha( new \Datetime() );
           // $banco->setSite(MercatUIUtils::getAdminSiteLogged());



			//agregamos el banco.
			UIServiceFactory::getUIBancoService()->add( $banco );

			$forward->setPageName( $bancoForm->getBackToOnSuccess() );
			$forward->addParam( "bancoOid", $banco->getOid() );

			$bancoForm->cleanSavedProperties();


		} catch (RastyException $e) {

			$forward->setPageName( "BancoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );

			//guardamos lo ingresado en el form.
			$bancoForm->save();
		}

		return $forward;

	}

}
?>
