<?php
namespace Mercat\UI\actions\empleados;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\form\empleado\EmpleadoForm;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Empleado;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de un empleado.
 * 
 * @author Marcos
 * @since 12/10/2022
 */
class AgregarEmpleado extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("EmpleadoAgregar");
		
		$empleadoForm = $page->getComponentById("empleadoForm");
		
		try {

			//creamos un nuevo empleado.
			$empleado = new Empleado();
			
			//completados con los datos del formulario.
			$empleadoForm->fillEntity($empleado);
			
			//agregamos el empleado.
			UIServiceFactory::getUIEmpleadoService()->add( $empleado );
			
			$forward->setPageName( $empleadoForm->getBackToOnSuccess() );
			$forward->addParam( "empleadoOid", $empleado->getOid() );			
		
			$empleadoForm->cleanSavedProperties();
			
		} catch (RastyDuplicatedException $e) {
		
			$forward->setPageName( "EmpleadoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
						
			//guardamos lo ingresado en el form.
			$empleadoForm->save();
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "EmpleadoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
						
			//guardamos lo ingresado en el form.
			$empleadoForm->save();
		}
		
		return $forward;
		
	}

}
?>