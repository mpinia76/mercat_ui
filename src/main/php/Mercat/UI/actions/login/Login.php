<?php
namespace Mercat\UI\actions\login;

use DateTime;
use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;

use Mercat\Core\utils\MercatUtils;


use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;



/**
 * se realiza el login contra el core.
 *
 * @author Marcos
 * @since 01/03/2018
 */
class Login extends Action{

	public function isSecure(){
		return false;
	}

	public function execute(){

		$forward = new Forward();
		try {


			RastySecurityContext::login( RastyUtils::getParamPOST("username"), RastyUtils::getParamPOST("password") );

			//MercatUIUtils::setSucursal( MercatUtils::getSucursalDefault() );

			$user = RastySecurityContext::getUser();

			$user = MercatUtils::getUserByUsername($user->getUsername());

			if( MercatUtils::isEmpleado($user)){

				$empleado = UIServiceFactory::getUIEmpleadoService()->getEmpleadoByUser( $user );

			}elseif( MercatUtils::isAdmin($user)){

				$empleado = MercatUtils::getEmpleadoDefault();
				MercatUIUtils::loginAdmin($user);

			}else{

				//TODO
			}
//print_r($empleado);
			MercatUIUtils::login( $empleado );
			//buscamos la caja que esté abierta para el empleado
			$caja = UIServiceFactory::getUICajaService()->getCajaAbiertaByEmpleado($empleado);
			MercatUIUtils::setCaja($caja);

			if( MercatUIUtils::isAdminLogged() )
				$forward->setPageName( $this->getForwardAdmin() );
			elseif( MercatUIUtils::isCajaSelected() )
				$forward->setPageName( $this->getForwardEmpleado() );
			else //si no hay caja abierta, lo enviamos a abrir una nueva.
				$forward->setPageName( $this->getForwardCaja() );

		} catch (RastyException $e) {

			$forward->setPageName( $this->getErrorForward() );
			$forward->addError( $e->getMessage() );

		}

		return $forward;

	}

	protected function getForwardEmpleado(){
		return "VentasHome";
	}

	protected function getForwardAdmin(){
		return "AdminHome";
	}

	protected function getForwardCaja(){
		//si hay cajas abiertas lo enviamos a seleccionar una de ellas.

		if( MercatUIUtils::isAdminLogged() )

			$cajas = UIServiceFactory::getUICajaService()->getCajasAbiertas();

		else

			$cajas = UIServiceFactory::getUICajaService()->getCajasAbiertas( new DateTime() );


		if(count($cajas) > 0)
			return "SeleccionarCaja";
		else
			return "AbrirCaja";
	}

	protected function getErrorForward(){
		return "Login";
	}
}
?>
