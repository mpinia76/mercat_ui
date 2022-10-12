<?php

namespace Mercat\UI\components\filter\empleado;

use Mercat\UI\components\filter\model\UIEmpleadoCriteria;

use Mercat\UI\components\grid\model\EmpleadoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

/**
 * Filtro para buscar empleados
 * 
 * @author Marcos
 * @since 02/03/2018
 */
class EmpleadoFilter extends Filter{
		
	public function getType(){
		
		return "EmpleadoFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new EmpleadoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIEmpleadoCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarEmpleado");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");

		//print_r(RastyUtils::getParamGET("tieneCtaCte"));
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		/*$this->fillInput("nombre", $this->getInitialText() );
		$this->fillInput("documento", $this->getInitialText() );*/
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_nombre",  $this->localize("empleado.nombre") );

		
		
		
		
	}
	
	
	
}
?>