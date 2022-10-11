<?php
namespace Mercat\UI\components\grid\model;

use Mercat\UI\components\grid\formats\GridImporteFormat;

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

use Mercat\Core\utils\MercatUtils;



/**
 * Model para la grilla de movimientos de cuenta.
 *
 * @author Marcos
 * @since 14/03/2018
 */
class MovimientoCajaGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();

    }

    public function getService(){

    	return UIServiceFactory::getUIMovimientoCajaService();
    }

    public function getFilter(){
//
//    	$componentConfig = new ComponentConfig();
//	    $componentConfig->setId( "movimientofilter" );
//		$componentConfig->setType( "MovimientoFilter" );
//
//		//TODO esto setearlo en el .rasty
//	    $this->filter = ComponentFactory::buildByType($componentConfig, $this);

    	$filter = new UIMovimientoCajaCriteria();
		return $filter;
    }

	protected function initModel() {

		$this->setHasCheckboxes( false );

		$column = GridModelBuilder::buildColumn( "oid", "movimientoCaja.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "fecha", "movimientoCaja.fecha", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i:s") );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "descripcion", "movimientoCaja.concepto", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );

		/*$column = GridModelBuilder::buildColumn( "observaciones", "movimientoCaja.observaciones", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );*/

		$column = GridModelBuilder::buildColumn( "haber", "movimientoCaja.haber", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "debe", "movimientoCaja.debe", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "saldo", "movimientoCaja.saldo", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );

	}

    public function getRowStyleClass($item){
        //return MercatUIUtils::getEstadoVentaCss($item->getEstado(),$item->getVendedor());
        //print_r($item);
        //echo $item->getUser()->getUserName();
        $user = MercatUtils::getUserByUsername($item->getUser()->getUserName());
        $css="";
        if(! MercatUtils::isAdmin($user)){
            $css="bg-lighterBlue fg-black";
        }
        return $css;

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

		$service = $this->getService();
		$movimiento = $service->get($item->getOid());

		$movimientoClass = get_class( $movimiento );

		//Logger::log($movimientoClass);
		if ($movimientoClass=='Mercat\Core\model\MovimientoVenta') {
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.ventas.pdf") );
			$menuOption->setPdf(1);
			$menuOption->setTarget("_blank");
			$menuOption->setPageName( "VentaPDF" );
			$menuOption->addParam("ventaOid",$movimiento->getVenta()->getOid());
			$menuOption->setImageSource( $this->getWebPath() . "css/images/pdf_16.png" );
			$options[] = $menuOption ;
		}




		$group->setMenuOptions( $options );

		return array( $group );

	}

}
?>
