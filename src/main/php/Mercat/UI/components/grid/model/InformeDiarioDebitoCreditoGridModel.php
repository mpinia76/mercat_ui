<?php
namespace Mercat\UI\components\grid\model;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\grid\formats\GridImporteFormat;

use Mercat\UI\components\grid\formats\GridEstadoInformeDiarioDebitoCreditoFormat;

use Mercat\UI\components\filter\model\UIInformeDiarioDebitoCreditoCriteria;

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
 * Model para la grilla de Informes Diarios de Debito y Credito.
 * 
 * @author Marcos
 * @since 14/10/2022
 */
class InformeDiarioDebitoCreditoGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIInformeDiarioDebitoCreditoService();
    }
    
    public function getFilter(){
	    
    	$filter = new UIInformeDiarioDebitoCreditoCriteria();
		return $filter;    	
    }
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "informeDiarioDebitoCredito.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "fecha", "informeDiarioDebitoCredito.fecha", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y") );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "fechaVencimiento", "informeDiarioDebitoCredito.fechaVencimiento", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y") );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "debito", "informeDiarioDebitoCredito.debito", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "credito", "informeDiarioDebitoCredito.credito", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "estado", "informeDiarioDebitoCredito.estado", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridEstadoInformeDiarioDebitoCreditoFormat() );
		$this->addColumn( $column );
		
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
		
		if( $item->podesEditarte() ){

			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.informesDiariosDebitoCredito.modificar") );
			$menuOption->setPageName( "InformeDiarioDebitoCreditoModificar" );
			$menuOption->addParam("oid",$item->getOid());
			//$menuOption->setImageSource( $this->getWebPath() . "css/images/pagar_32.png" );
			$menuOption->setIconClass( "icon-editar" );
			$options[] = $menuOption ;
			
		}
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
	
	public function getRowStyleClass($item){
		
		//return MercatUIUtils::getEstadoInformeSemanalCss($item->getEstado());
		
	}
	
}
?>