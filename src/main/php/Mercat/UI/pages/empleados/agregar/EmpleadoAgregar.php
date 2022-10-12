<?php
namespace Mercat\UI\pages\empleados\agregar;

use Mercat\UI\pages\MercatPage;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Empleado;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class EmpleadoAgregar extends MercatPage{

	/**
	 * empleado a agregar.
	 * @var Empleado
	 */
	private $empleado;

	
	public function __construct(){
		
		//inicializamos el empleado.
		$empleado = new Empleado();
		
		//$empleado->setNombre("Bernardo");
		//$empleado->setEmail("ber@mail.com");
		$this->setEmpleado($empleado);
		
		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("Empleados");
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "empleado.agregar.title" );
	}

	public function getType(){
		
		return "EmpleadoAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		$empleadoForm = $this->getComponentById("empleadoForm");
		$empleadoForm->fillFromSaved( $this->getEmpleado() );
		
	}


	public function getEmpleado()
	{
	    return $this->empleado;
	}

	public function setEmpleado($empleado)
	{
	    $this->empleado = $empleado;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>