<?php

namespace Mercat\UI\components\filter\pack;

use Mercat\UI\service\UIServiceFactory;


use Mercat\UI\components\filter\model\UIPackCriteria;

use Mercat\UI\components\grid\model\PackGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

/**
 * Filtro para buscar packs
 * 
 * @author Marcos
 * @since 26/03/2019
 */
class PackFilter extends Filter{
		
	private $producto;
	
	
	public function getType(){
		
		return "PackFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new PackGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIPackCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarPack");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("codigo");
		$this->addProperty("nombre");
		$this->addProperty("producto");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		/*$this->fillInput("nombre", $this->getInitialText() );
		$this->fillInput("tipoPack", $this->getInitialText() );
		$this->fillInput("marcaPack", $this->getInitialText() );*/
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_codigo",  $this->localize("pack.codigo") );
		$xtpl->assign("lbl_nombre",  $this->localize("pack.nombre") );
		
		
		$producto = UIServiceFactory::getUIProductoService()->get( RastyUtils::getParamGET("productoOid") );
		
		if( !empty( $producto)  ){
			$xtpl->assign("lbl_producto",  $producto->__toString() );
			$xtpl->assign("productoOid",  $producto->getOid() );
			//$this->fillInput("producto", $producto->getOid() );
		}
		
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "PackModificar") );
		
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		$producto = UIServiceFactory::getUIProductoService()->get( RastyUtils::getParamPOST("productoOid") );
		
		$entity->setProducto( $producto );		
		
	}
	
	public function getPack(){
		
	}
	

	

	public function getProducto()
	{
	    return $this->producto;
	}

	public function setProducto($producto)
	{
	    $this->producto = $producto;
	}
}
?>