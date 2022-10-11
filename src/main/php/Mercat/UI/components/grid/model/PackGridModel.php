<?php
namespace Mercat\UI\components\grid\model;

use Mercat\UI\components\grid\formats\GridImporteFormat;
use Mercat\UI\components\grid\formats\GridPrecioListaFormat;
use Mercat\UI\components\grid\formats\GridPrecioEfectivoFormat;
use Mercat\UI\components\grid\formats\GridPorcentajeFormat;
use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\filter\model\UIPackCriteria;

use Rasty\Grid\entitygrid\EntityGrid;
use Rasty\Grid\entitygrid\model\EntityGridModel;
use Rasty\Grid\entitygrid\model\GridModelBuilder;
use Rasty\Grid\filter\model\UICriteria;

use Mercat\Core\utils\MercatUtils;

use Mercat\UI\service\UIServiceFactory;
use Rasty\utils\RastyUtils;
use Rasty\utils\Logger;
use Rasty\security\RastySecurityContext;

use Rasty\Menu\menu\model\MenuOption;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuActionOption;
use Rasty\Menu\menu\model\MenuActionAjaxOption;

use Rasty\Grid\entitygrid\model\GridDatetimeFormat;

/**
 * Model para la grilla de packs.
 * 
 * @author Marcos
 * @since 27/03/2019
 */
class PackGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIPackService();
    }
    
    public function getFilter(){
    	
    	$filter = new UIPackCriteria();
		return $filter;    	
    }
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "pack.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "codigo", "pack.codigo", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "nombre", "pack.nombre", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "producto", "pack.producto", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "cantidad", "pack.cantidad", 10, EntityGrid::TEXT_ALIGN_RIGHT) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "costo", "pack.costo", 10, EntityGrid::TEXT_ALIGN_RIGHT ,  new GridImporteFormat()) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "porcentajeGanancia", "producto.porcentajeGanancia", 10, EntityGrid::TEXT_ALIGN_RIGHT, new GridPorcentajeFormat() );
		$column->setCssClass("no-phone no-tablet");
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "precioEfectivo", "pack.precioEfectivo", 10, EntityGrid::TEXT_ALIGN_RIGHT  ,  new GridImporteFormat()) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "porcentajeGanancia2", "producto.porcentajeGanancia2", 10, EntityGrid::TEXT_ALIGN_RIGHT, new GridPorcentajeFormat() );
		$column->setCssClass("no-phone no-tablet");
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "precioLista", "pack.precioLista", 10, EntityGrid::TEXT_ALIGN_RIGHT ,  new GridImporteFormat()) ;
		$this->addColumn( $column );
		
	
		
	}

	public function getDefaultFilterField() {
        return "nombre";
    }

	public function getDefaultOrderField(){
		return "nombre";
	}    

    
    /**
	 * opciones de menú dado el item
	 * @param unknown_type $item
	 */
	public function getMenuGroups( $item ){
	
		$group = new MenuGroup();
		$group->setLabel("grupo");
		$options = array();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.packs.modificar") );
		$menuOption->setPageName( "PackModificar" );
		$menuOption->addParam("oid",$item->getOid());
		
		$menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
		$options[] = $menuOption ;

		
		
						
		
		
		$menuOption = new MenuActionAjaxOption();
		$menuOption->setLabel( $this->localize( "menu.pack.eliminar") );
		$menuOption->setActionName( "EliminarPack" );
		$menuOption->setConfirmMessage( $this->localize( "pack.eliminar.confirm.msg") );
		$menuOption->setConfirmTitle( $this->localize( "pack.eliminar.confirm.title") );
		$menuOption->setOnSuccessCallback( "eliminarCallback" );
		$menuOption->addParam("packOid",$item->getOid());
		
		$menuOption->setImageSource( $this->getWebPath() . "css/images/eliminar_32.png" );
		$options[] = $menuOption ;
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
    
}
?>