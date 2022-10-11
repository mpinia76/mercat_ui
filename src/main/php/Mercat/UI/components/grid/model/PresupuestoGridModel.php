<?php
namespace Mercat\UI\components\grid\model;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\grid\formats\GridImporteFormat;

use Mercat\UI\components\grid\formats\GridEstadoPresupuestoFormat;

use Mercat\UI\components\filter\model\UIPresupuestoCriteria;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Mercat\Core\model\EstadoPresupuesto;

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
 * Model para la grilla de Presupuestos.
 * 
 * @author Marcos
 * @since 29-03-2019
 */
class PresupuestoGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIPresupuestoService();
    }
    
   
    
	public function getFilter(){
//    	
    	$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "presupuestosfilter" );
		$componentConfig->setType( "PresupuestoFilter" );
//		
//		//TODO esto setearlo en el .rasty
	    return ComponentFactory::buildByType($componentConfig, $this);
	    
    	/*$filter = new UIGastoCriteria();
    	
		return $filter;  */
		
    }
    
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "presupuesto.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "fecha", "presupuesto.fecha", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i:s") );
		$this->addColumn( $column );
		
		
		
		$column = GridModelBuilder::buildColumn( "cliente", "presupuesto.cliente", 20, EntityGrid::TEXT_ALIGN_LEFT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "monto", "presupuesto.monto", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$column->setCssClass("importe");
		$this->addColumn( $column );
		
		
		
		$column = GridModelBuilder::buildColumn( "observaciones", "presupuesto.observaciones", 20, EntityGrid::TEXT_ALIGN_LEFT );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "estado", "presupuesto.estado", 20, EntityGrid::TEXT_ALIGN_LEFT, new GridEstadoPresupuestoFormat() );
		$this->addColumn( $column );
				
		
	}

	public function getRowStyleClass($item){
		
		return MercatUIUtils::getEstadoPresupuestoCss($item->getEstado());
		
	}
	
	public function getDefaultFilterField() {
        return "fecha";
    }

	public function getDefaultOrderField(){
		return "fecha";
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
		
		if( $item->podesAnularte() ){
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.presupuestos.anular") );
			$menuOption->setPageName( "PresupuestoAnular" );
			$menuOption->addParam("presupuestoOid",$item->getOid());
			$menuOption->setIconClass( "icon-anular" );
			$options[] = $menuOption ;
		}
		
		if( $item->podesAprobarte() ){
			/*$menuOption = new MenuActionAjaxOption();
			$menuOption->setLabel( $this->localize( "menu.presupuestos.aprobar") );
			$menuOption->setActionName( "PresupuestoAprobar" );
			$menuOption->setConfirmMessage( $this->localize( "presupuesto.aprobar.confirm.msg") );
			$menuOption->setConfirmTitle( $this->localize( "presupuesto.aprobar.confirm.title") );
			$menuOption->setOnSuccessCallback( "aprobarCallback" );
			$menuOption->addParam("presupuestoOid",$item->getOid());
			$menuOption->setIconClass( "icon-cobrar-venta fg-green" );
			$options[] = $menuOption ;*/
			
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.presupuestos.aprobar") );
			$menuOption->setPageName( "PresupuestoAprobar" );
			$menuOption->addParam("presupuestoOid",$item->getOid());
			$menuOption->setIconClass( "icon-cobrar-venta fg-green" );
			$options[] = $menuOption ;
			
		}
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.presupuestos.pdf") );
		$menuOption->setPdf(1);
		$menuOption->setTarget("_blank");
		$menuOption->setPageName( "PresupuestoPDF" );
		$menuOption->addParam("presupuestoOid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/pdf_16.png" );
		$options[] = $menuOption ;
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
	
	public function getHeaderContent(){
		$filter = $this->getFilter();
		$filter->fill( $this->getDefaultOrderField(), $this->getDefaultOrderType() );
		//print_r($filter->getCriteria());
		$service = $this->getService();
			
		
			
		
		
		
		return 'Total: '.MercatUIUtils::formatMontoToView($service->getTotales($filter->getCriteria()));
	}
    
}
?>