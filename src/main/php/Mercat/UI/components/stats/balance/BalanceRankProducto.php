<?php

namespace Mercat\UI\components\stats\balance;

use DateTime;
use Mercat\UI\components\filter\model\UIGastoCriteria;
use Mercat\UI\service\UIVentaService;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Mercat\Core\model\Caja;

use Rasty\utils\LinkBuilder;

use Rasty\factory\ComponentConfig;

use Rasty\factory\ComponentFactory;

use Mercat\UI\components\filter\model\UIVentaCriteria;

/**
 * Balance del rankProducto.
 *
 * @author Marcos
 * @since 22-10-2020
 */
class BalanceRankProducto extends RastyComponent{

	private $fecha;

	public function getType(){

		return "BalanceRankProducto";

	}

	public function __construct(){
		$fecha = new DateTime();
		$this->setFecha($fecha);

	}

	protected function parseLabels(XTemplate $xtpl){

		$xtpl->assign("lbl_rankProducto",  $this->localize( "balanceRankProducto.rankProducto" ) );
		$xtpl->assign("lbl_producto",  $this->localize( "combo.producto.producto" ) );
        $xtpl->assign("lbl_cantidad",  $this->localize( "combo.producto.cantidad" ) );
		$xtpl->assign("detalle_productos_legend",  $this->localize( "menu.balances.rankproductos" ) );


	}

	protected function parseXTemplate(XTemplate $xtpl){
		ini_set('max_execution_time', '0');
		$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "balancerankproductofilter" );
		$componentConfig->setType( $this->getFilterType() );

	    $this->filter = ComponentFactory::buildByType($componentConfig, $this);



		$this->filter->fill( );

		$criteria = $this->filter->getCriteria();



		/*labels*/
		$this->parseLabels($xtpl);


        $criteriaVenta = new UIVentaCriteria();

		$fechaDesde = $criteria->getFechaDesde();


		$criteriaVenta->setFechaDesde( $fechaDesde);

        $fechaHasta = $criteria->getFechaHasta();

        $criteriaVenta->setFechaHasta( $fechaHasta);


		$criteriaVenta->setVendedor( $criteria->getVendedor());

        //print_r($criteriaVenta);

		$productos = UIServiceFactory::getUIVentaService()->getRankingProductos($criteriaVenta,$criteria);

        foreach ($productos as $producto) {
            //print_r($producto);
            //$productos .=$saldos['productos']['nombre'][$key].' Vendidos: '.$cantidad.' <br>';

            $xtpl->assign("producto",  $producto['tipo'].' '.$producto['marca'].' '.$producto['producto']);

            $xtpl->assign("cantidad",  number_format($producto['canttotal'],0,',','.'));
            $xtpl->parse("main.rank_productos.productos");
        }






		$xtpl->parse("main.rank_productos");

	}



	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	protected function initObserverEventType(){
		//TODO $this->addEventType( "Venta" );
	}

	public function getFilterType()
	{
	    return $this->filterType;
	}

	public function setFilterType($filterType)
	{
	    $this->filterType = $filterType;
	}
}
?>
