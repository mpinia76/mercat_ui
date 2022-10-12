<?php
namespace Mercat\UI\actions\empleados;

use Mercat\UI\components\form\empleado\EmpleadoForm;

use Mercat\UI\service\UIServiceFactory;
use Mercat\UI\utils\MercatUtils;

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
 * se realiza la actualización de un empleado.
 * 
 * @author Marcos
 * @since 12/10/2022
 */
class ModificarEmpleado extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("EmpleadoModificar");
		
		$empleadoForm = $page->getComponentById("empleadoForm");
			
		$oid = $empleadoForm->getOid();
						
		try {

			//obtenemos el empleado.
			$empleado = UIServiceFactory::getUIEmpleadoService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$empleadoForm->fillEntity($empleado);
			
			//guardamos los cambios.
			UIServiceFactory::getUIEmpleadoService()->update( $empleado );
			
			$forward->setPageName( $empleadoForm->getBackToOnSuccess() );
			$forward->addParam( "empleadoOid", $empleado->getOid() );
			
			$empleadoForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "EmpleadoModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$empleadoForm->save();
			
		}
		return $forward;
		
	}

}
?>