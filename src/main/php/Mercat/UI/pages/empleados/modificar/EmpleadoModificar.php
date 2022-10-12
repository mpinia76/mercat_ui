<?php
namespace Mercat\UI\pages\empleados\modificar;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\service\UIServiceFactory;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Empleado;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class EmpleadoModificar extends MercatPage{

	/**
	 * empleado a modificar.
	 * @var Empleado
	 */
	private $empleado;

	
	public function __construct(){
		
		//inicializamos el empleado.
		$empleado = new Empleado();
		$this->setEmpleado($empleado);
				
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		return array($menuGroup);
	}
	
	public function setEmpleadoOid($oid){
		
		//a partir del id buscamos el empleado a modificar.
		$empleado = UIServiceFactory::getUIEmpleadoService()->get($oid);
		
		$this->setEmpleado($empleado);
		
	}
	
	public function getTitle(){
		return $this->localize( "empleado.modificar.title" );
	}

	public function getType(){
		
		return "EmpleadoModificar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
	}

	public function getEmpleado(){
		
	    return $this->empleado;
	}

	public function setEmpleado($empleado)
	{
	    $this->empleado = $empleado;
	}
}
?>