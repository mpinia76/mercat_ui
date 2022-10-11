<?php

namespace Mercat\UI\components\filter\vendedor;

use Mercat\UI\service\UIServiceFactory;


use Mercat\UI\components\filter\model\UIVendedorCriteria;

use Mercat\UI\components\grid\model\VendedorGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

/**
 * Filtro para buscar vendedores
 * 
 * @author Marcos
 * @since 21/07/2020
 */
class VendedorFilter extends Filter{
		
	private $producto;
	
	
	public function getType(){
		
		return "VendedorFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new VendedorGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIVendedorCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarVendedor");
		
		//agregamos las propiedades a popular en el submit.
		
		$this->addProperty("nombre");
		
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		/*$this->fillInput("nombre", $this->getInitialText() );
		$this->fillInput("tipoVendedor", $this->getInitialText() );
		$this->fillInput("marcaVendedor", $this->getInitialText() );*/
		
		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("lbl_nombre",  $this->localize("vendedor.nombre") );
		
		
		
		
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "VendedorModificar") );
		
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		
	}
	
	public function getVendedor(){
		
	}
	

	

	
}
?>