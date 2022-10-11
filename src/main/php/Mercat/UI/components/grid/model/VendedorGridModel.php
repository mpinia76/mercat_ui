<?php
namespace Mercat\UI\components\grid\model;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\grid\formats\GridImporteFormat;
use Mercat\UI\components\grid\formats\GridBooleanFormat;
use Mercat\UI\components\grid\formats\GridPorcentajeFormat;

use Mercat\UI\components\filter\model\UIVendedorCriteria;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Mercat\Core\model\EstadoVendedor;

use Rasty\Grid\entitygrid\EntityGrid;
use Rasty\Grid\entitygrid\model\EntityGridModel;
use Rasty\Grid\entitygrid\model\GridModelBuilder;
use Rasty\Grid\filter\model\UICriteria;
use Rasty\Grid\entitygrid\model\GridDatetimeFormat;
use Mercat\UI\service\UIServiceFactory;
use Rasty\utils\RastyUtils;
use Rasty\utils\Logger;

use Rasty\Menu\menu\model\MenuOption;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuActionOption;
use Rasty\Menu\menu\model\MenuActionAjaxOption;

/**
 * Model para la grilla de Vendedores.
 * 
 * @author Marcos
 * @since 21-07-2020
 */
class VendedorGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIVendedorService();
    }
    
   
    
	public function getFilter(){
//    	
    	$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "vendedoresfilter" );
		$componentConfig->setType( "VendedorFilter" );
//		
//		//TODO esto setearlo en el .rasty
	    return ComponentFactory::buildByType($componentConfig, $this);
	    
    	/*$filter = new UIGastoCriteria();
    	
		return $filter;  */
		
    }
    
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "vendedor.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "nombre", "vendedor.nombre", 20, EntityGrid::TEXT_ALIGN_LEFT);
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "telefono", "vendedor.telefono", 30, EntityGrid::TEXT_ALIGN_RIGHT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "direccion", "vendedor.direccion", 30, EntityGrid::TEXT_ALIGN_LEFT) ;
		$this->addColumn( $column );
		
		
		
		$column = GridModelBuilder::buildColumn( "comision", "vendedor.comision", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridPorcentajeFormat() );
		
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "mayorista", "vendedor.mayorista", 5, EntityGrid::TEXT_ALIGN_CENTER, new GridBooleanFormat() );
		
		$this->addColumn( $column );
				
		
	}

	
	
	public function getDefaultFilterField() {
        return "oid";
    }

	public function getDefaultOrderField(){
		return "oid";
	}    

	public function getDefaultOrderType(){
		return "DESC";
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
		$menuOption->setLabel( $this->localize( "menu.vendedores.modificar") );
		$menuOption->setPageName( "VendedorModificar" );
		$menuOption->addParam("oid",$item->getOid());
		
		$menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
		$options[] = $menuOption ;

		
		
						
		
		
		$menuOption = new MenuActionAjaxOption();
		$menuOption->setLabel( $this->localize( "menu.vendedor.eliminar") );
		$menuOption->setActionName( "EliminarVendedor" );
		$menuOption->setConfirmMessage( $this->localize( "vendedor.eliminar.confirm.msg") );
		$menuOption->setConfirmTitle( $this->localize( "vendedor.eliminar.confirm.title") );
		$menuOption->setOnSuccessCallback( "eliminarCallback" );
		$menuOption->addParam("vendedorOid",$item->getOid());
		
		$menuOption->setImageSource( $this->getWebPath() . "css/images/eliminar_32.png" );
		$options[] = $menuOption ;
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
	
	
    
}
?>