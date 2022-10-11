<?php
namespace Mercat\UI\service\finder;

use Mercat\UI\components\filter\model\UIPackCriteria;

use Mercat\UI\service\UIServiceFactory;

use Rasty\Forms\finder\model\IAutocompleteFinder;

use Rasty\utils\LinkBuilder;
/**
 * 
 * Finder para combos.
 * 
 * @author Marcos
 * @since 07/08/2020
 */
class PackFinder implements  IAutocompleteFinder {
	
	
	public function __construct() {}
	
	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::findEntitiesByText()
	 */
	public function findEntitiesByText( $text, $parent=null ){
		
		$uiCriteria = new UIPackCriteria();
		$uiCriteria->setNombreOTipoOMarca( $text );
		$uiCriteria->setRowPerPage( 10 );
		
		
		$uiCriteria->addOrder("nombre", "ASC");
		return UIServiceFactory::getUIPackService()->getList($uiCriteria);	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::findEntityByCode()
	 */
	function findEntityByCode( $code, $parent=null ){
		
		$oPack= UIServiceFactory::getUIPackService()->get( $code );
		//$oProducto = $oPack->getProducto();
		$oPack->setCantidad($oPack->getCantidad());
		$oPack->setPrecioLista(round($oPack->getPrecioLista()/$oPack->getCantidad(),2));
		$oPack->setPrecioEfectivo(round($oPack->getPrecioEfectivo()/$oPack->getCantidad(),2));
		$oPack->setCosto(round($oPack->getCosto()/$oPack->getCantidad(),2));
		return $oPack;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::getAttributes()
	 */
	public function getAttributes(){
		return array("nombre");		
	}

	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::getAttributesCallback()
	 */
	public function getAttributesCallback(){
		//return array("oid", "producto.codigo", "nombre", "cantidad" );		
		return array("oid","codigo", "nombre", "precioLista", "precioEfectivo", "cantidad", "costo", "producto.codigo");		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::getEntityCode()
	 */
	function getEntityCode( $entity ){
		if( !empty( $entity)  )
		
		return $entity->getOid();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::getEntityLabel()
	 */
	function getEntityLabel( $entity ){
		if( !empty( $entity)  )
		return $entity->__toString();
	}

	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::getEntityFieldCode()
	 */
	function getEntityFieldCode( $entity ){
		return "oid";
	}
	
	/**
	 * mensaje para cuando no hay resultados.
	 * @var string
	 */
	function getEmptyResultLabel(){
		return null;
	}
	
	/**
	 * label para agregar una nueva entity
	 * @var string
	 */
	function getAddEntityLabel(){
		return null;
	}
	
	/**
	 * función javascript a ejecutar para agregar una nueva entity.
	 * si esta property es definida se muestra el link cuando
	 * no hay resultados
	 * @var string
	 */
	function getOnclickAdd(){
		
		return"";
	}
}
?>