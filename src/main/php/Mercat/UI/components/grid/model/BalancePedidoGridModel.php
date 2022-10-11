<?php
namespace Mercat\UI\components\grid\model;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\grid\formats\GridImporteFormat;

use Mercat\UI\components\grid\formats\GridEstadoPedidoFormat;

use Mercat\UI\components\filter\model\UIPedidoCriteria;

use Mercat\Core\model\EstadoPedido;

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
 * Model para la grilla de Pedidos.
 *
 * @author Marcos
 * @since 23/10/2020
 */
class BalancePedidoGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();

    }

    public function getService(){

    	return UIServiceFactory::getUIPedidoService();
    }



    public function getFilter(){
        //
        $componentConfig = new ComponentConfig();
        $componentConfig->setId( "balancepedidofilter" );
        $componentConfig->setType( "BalancePedidoFilter" );
//
//		//TODO esto setearlo en el .rasty
        return ComponentFactory::buildByType($componentConfig, $this);


    }


	protected function initModel() {

		$this->setHasCheckboxes( false );

		$column = GridModelBuilder::buildColumn( "oid", "pedido.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );

        $column = GridModelBuilder::buildColumn( "proveedor", "pedido.proveedor", 20, EntityGrid::TEXT_ALIGN_LEFT );
        $this->addColumn( $column );


		$column = GridModelBuilder::buildColumn( "fechaHora", "pedido.fechaHora", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i") );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "fechaHoraRecibido", "pedido.fechaHoraRecibido", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i") );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "monto", "pedido.monto", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );



		$column = GridModelBuilder::buildColumn( "estado", "pedido.estado", 20, EntityGrid::TEXT_ALIGN_LEFT, new GridEstadoPedidoFormat() );
		$this->addColumn( $column );


	}

	public function getDefaultFilterField() {
        return "fechaHora";
    }

	public function getDefaultOrderField(){
		return "fechaHora";
	}

	public function getDefaultOrderType(){
		return "DESC";
	}



	public function getRowStyleClass($item){

		return MercatUIUtils::getEstadoPedidoCss($item->getEstado());

	}


    public function getHeaderContent(){
        $filter = $this->getFilter();
        $filter->fill( $this->getDefaultOrderField(), $this->getDefaultOrderType() );

        $service = $this->getService();






        return 'Total: '.MercatUIUtils::formatMontoToView($service->getTotales($filter->getCriteria()));
    }

}
?>
