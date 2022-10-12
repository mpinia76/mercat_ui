<?php
namespace Mercat\UI\pages\empleados;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIEmpleadoCriteria;

use Mercat\UI\components\grid\model\EmpleadoGridModel;

use Mercat\UI\service\UIEmpleadoService;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\Empleado;
use Mercat\Core\criteria\EmpleadoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los empleados.
 * 
 * @author Marcos
 * @since 02/03/2018
 * 
 */
class Empleados extends MercatPage{

	
	private $empleadoCriteria;
	
	public function __construct(){
		$empleadoCriteria = new EmpleadoCriteria();
		
		
		$this->setEmpleadoCriteria($empleadoCriteria);
	}
	
	public function getTitle(){
		return $this->localize( "empleados.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "empleado.agregar") );
		$menuOption->setPageName("EmpleadoAgregar");
		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuGroup->addMenuOption( $menuOption );
		
		
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.cobrarCuentaCorriente") );
		$menuOption->setPageName("CobrarCtaCte");
		$menuOption->setImageSource( $this->getWebPath() . "css/images/cobros_48.png" );
		$menuGroup->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.actualizarCuentaCorriente") );
		$menuOption->setPageName("ActualizarCtaCte");
		$menuOption->setImageSource( $this->getWebPath() . "css/images/gastos_32.png" );
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "Empleados";
		
	}	

	public function getModelClazz(){
		return get_class( new EmpleadoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIEmpleadoCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$xtpl->assign("agregar_label", $this->localize("empleado.agregar") );
		
		$empleadoFilter = $this->getComponentById("empleadosFilter");
		
		$empleadoFilter->fillFromSaved( $this->getEmpleadoCriteria() );
	}
	
	public function getEmpleadoCriteria()
	{
	    return $this->empleadoCriteria;
	}

	public function setEmpleadoCriteria($empleadoCriteria)
	{
	    $this->empleadoCriteria = $empleadoCriteria;
	}

}
?>