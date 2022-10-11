<?php
namespace Mercat\UI\components\grid\model;

use Mercat\UI\components\grid\formats\GridImporteFormat;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\filter\model\UIVentaCriteria;
use Mercat\UI\components\filter\model\UIVendedorCriteria;

use Mercat\UI\components\filter\model\UIGastoCriteria;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

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
 * Model para la grilla de movimientos de cuenta.
 *
 * @author Marcos
 * @since 07/04/2018
 */
class MovimientoVentaGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();

    }

    public function getService(){

    	return UIServiceFactory::getUIMovimientoVentaService();
    }

	public function getFilter(){
//
    	$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "movimientoVentasfilter" );
		$componentConfig->setType( "MovimientoVentaFilter" );
//
//		//TODO esto setearlo en el .rasty
	    return ComponentFactory::buildByType($componentConfig, $this);

    	/*$filter = new UIGastoCriteria();

		return $filter;  */

    }

	protected function initModel() {

		$this->setHasCheckboxes( false );

		$column = GridModelBuilder::buildColumn( "oid", "movimientoCaja.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "fecha", "movimientoCaja.fecha", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i:s") );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "descripcion", "movimientoCaja.concepto", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "observaciones", "movimientoCaja.observaciones", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "haber", "movimientoCaja.haber", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "debe", "movimientoCaja.debe", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
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

//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "menu.producto.modificar") );
//		$menuOption->setPageName( "ProductoModificar" );
//		$menuOption->addParam("oid",$item->getOid());
//		$menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
//		$options[] = $menuOption ;
//
//
		/*
		$menuOption = new MenuActionAjaxOption();
		$menuOption->setLabel( $this->localize( "menu.producto.eliminar") );
		$menuOption->setActionName( "EliminarProducto" );
		$menuOption->setConfirmMessage( $this->localize( "producto.eliminar.confirm.msg") );
		$menuOption->setConfirmTitle( $this->localize( "producto.eliminar.confirm.title") );
		$menuOption->setOnSuccessCallback( "eliminarCallback" );
		$menuOption->addParam("oid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/eliminar_32.png" );
		$options[] = $menuOption ;
		*/
		$group->setMenuOptions( $options );

		return array( $group );

	}

	public function getHeaderContent(){
		$filter = $this->getFilter();
		$filter->fill( $this->getDefaultOrderField(), $this->getDefaultOrderType() );
		//print_r($filter->getCriteria());

		$serviceGasto = UIServiceFactory::getUIGastoService();
		$criteria = new UIGastoCriteria();
		$criteria->setFiltroPredefinido(0);
		$criteria->setFechaDesde($filter->getCriteria()->getFechaDesde());
		$criteria->setFechaHasta($filter->getCriteria()->getFechaHasta());

		$gastoSaldo = $serviceGasto->getTotales($criteria);
		//print_r($filter);

		$service = UIServiceFactory::getUIVentaService();

		$criteria = new UIVentaCriteria();
		$criteria->setFiltroPredefinido(0);
		$criteria->setFechaDesde($filter->getCriteria()->getFechaDesde());
		$criteria->setFechaHasta($filter->getCriteria()->getFechaHasta());

		$arraySaldo = $service->getTotales($criteria);

		$todoString = 'Bruto: <strong>'.MercatUIUtils::formatMontoToView($arraySaldo['saldo']).'</strong> Neto: <strong>'.MercatUIUtils::formatMontoToView($arraySaldo['ganancia']-$gastoSaldo).'</strong> Comisiones: <strong>'.MercatUIUtils::formatMontoToView((-1)*$arraySaldo['comision']).'</strong>';
		$todoString .= '<br><strong>Hielo</strong> - Bruto: <strong>'.MercatUIUtils::formatMontoToView($arraySaldo['ventashielo']).'</strong> Neto: <strong>'.MercatUIUtils::formatMontoToView($arraySaldo['gananciashielo']).'</strong> Comisiones: <strong>'.MercatUIUtils::formatMontoToView((-1)*$arraySaldo['comisioneshielo']).'</strong>';
		$vendedores = UIServiceFactory::getUIVendedorService()->getList( new UIVendedorCriteria());
		foreach ($vendedores as $vendedor) {
			$criteria = new UIVentaCriteria();
			$criteria->setFiltroPredefinido(0);
			$criteria->setFechaDesde($filter->getCriteria()->getFechaDesde());
			$criteria->setFechaHasta($filter->getCriteria()->getFechaHasta());
			$criteria->setVendedor($vendedor);
			$arraySaldo = $service->getTotales($criteria);
			$ganancia = ($vendedor->getOid()==1)?$arraySaldo['ganancia']-$gastoSaldo:$arraySaldo['ganancia'];
			$todoString .= '<br><strong>'.$vendedor.'</strong> - Bruto: <strong>'.MercatUIUtils::formatMontoToView($arraySaldo['saldo']).'</strong> Neto: <strong>'.MercatUIUtils::formatMontoToView($ganancia).'</strong> Comisiones: <strong>'.MercatUIUtils::formatMontoToView((-1)*$arraySaldo['comision']).'</strong>';
			$todoString .= '<br><strong>Hielo - '.$vendedor.'</strong> - Bruto: <strong>'.MercatUIUtils::formatMontoToView($arraySaldo['ventashielo']).'</strong> Neto: <strong>'.MercatUIUtils::formatMontoToView($arraySaldo['gananciashielo']).'</strong> Comisiones: <strong>'.MercatUIUtils::formatMontoToView((-1)*$arraySaldo['comisioneshielo']).'</strong>';

		}


		return $todoString;
	}

}
?>
