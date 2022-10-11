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
 * Balance del anio.
 *
 * @author Marcos
 * @since 07-10-2019
 */
class BalanceAnio extends RastyComponent{

	private $fecha;

	public function getType(){

		return "BalanceAnio";

	}

	public function __construct(){
		$fecha = new DateTime();
		$this->setFecha($fecha);

	}

	protected function parseLabels(XTemplate $xtpl){

		$xtpl->assign("lbl_anio",  $this->localize( "balanceAnio.anio" ) );
		$xtpl->assign("lbl_mes",  $this->localize( "balanceAnio.mes" ) );
		$xtpl->assign("lbl_ventas",  $this->localize( "balanceAnio.ventas" ) );

		$xtpl->assign("lbl_ganancia",  $this->localize( "balanceAnio.ganancia" ) );
		$xtpl->assign("lbl_comisiones",  $this->localize( "venta.comision" ) );
        $xtpl->assign("lbl_gastos",  $this->localize( "balanceDia.gastos" ) );
		$xtpl->assign("detalle_mes_legend",  $this->localize( "balanceAnio.detalle_mes.legend" ) );


	}

	protected function parseXTemplate(XTemplate $xtpl){
		ini_set('max_execution_time', '0');
		$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "filter" );
		$componentConfig->setType( $this->getFilterType() );

	    $this->filter = ComponentFactory::buildByType($componentConfig, $this);



		$this->filter->fill( );

		$criteria = $this->filter->getCriteria();

		/*labels*/
		$this->parseLabels($xtpl);

		$fecha = $criteria->getFecha();
		if(empty($fecha))
			$fecha = new DateTime();


        $serviceGasto = UIServiceFactory::getUIGastoService();
        $criteriaGasto = new UIGastoCriteria();
        $criteriaGasto->setFiltroPredefinido(0);
        $criteriaGasto->setYear($fecha);

        $gastoSaldo = $serviceGasto->getTotales($criteriaGasto);


		$criteriaVenta = new UIVentaCriteria();

		$criteriaVenta->setYear( $fecha);
		$criteriaVenta->setCliente( $criteria->getCliente());
		$criteriaVenta->setVendedor( $criteria->getVendedor());

		$saldos = UIServiceFactory::getUIVentaService()->getGananciasProducto($criteriaVenta, $criteria,1 );

		//$balance = UIServiceFactory::getUIBalanceService()->getBalanceAnio($fecha);


		$balances = array();

		$anio = $fecha->format("Y");

		$meses = MercatUIUtils::getMeses();

		for ($mes = 1; $mes <=12; $mes++) {
			$balances[$mes] = array( "ventas" => 0,

										"ganancias" => 0,
										"mes_nombre" => $meses[$mes]);
		}


		$xtpl->assign("anio",  $fecha->format("Y"));
		/*$xtpl->assign("totalGastos",  MercatUIUtils::formatMontoToView($balance["gastos"]) );
		$xtpl->assign("totalPagos",  MercatUIUtils::formatMontoToView($balance["pagos"]) );*/
		$xtpl->assign("totalVentas",  'Negocio: '.MercatUIUtils::formatMontoToView($saldos["ventas"]).' - Hielo: '.MercatUIUtils::formatMontoToView($saldos["ventashielo"]) );
		//$xtpl->assign("totalComisiones",  MercatUIUtils::formatMontoToView($balance["comisiones"]) );
        /*if ($criteria->getVendedor())  {
            $ganancia = ($criteria->getVendedor()->getOid()==1)?$saldos['ganancias']-$gastoSaldo:$saldos['ganancias'];
        }
        else $ganancia =$saldos['ganancias']-$gastoSaldo;*/
        $ganancia =$saldos['ganancias'];
		$xtpl->assign("totalGanancia",  'Negocio: '.MercatUIUtils::formatMontoToView($ganancia).' - Hielo: '.MercatUIUtils::formatMontoToView($saldos["gananciashielo"])  );
		$xtpl->assign("totalComisiones",  'Negocio: '.MercatUIUtils::formatMontoToView((-1)*$saldos["comisiones"]).' - Hielo: '.MercatUIUtils::formatMontoToView((-1)*$saldos["comisioneshielo"])  );
        $xtpl->assign("totalGastos",  MercatUIUtils::formatMontoToView((-1)*$gastoSaldo)  );
		if ($saldos['productos']) {
			$productos='';

			foreach ($saldos['productos']['cant'] as $key => $cantidad) {
				//print_r($producto);
				$productos .=$saldos['productos']['nombre'][$key].' Vendidos: '.$cantidad.' <br>';
			}
			$xtpl->assign("productos",  $productos);
		}
		if ($saldos['clientes']) {
			$clientes='';
			$clienteIdAnt='';
			foreach ($saldos['clientes']['cant'] as $key => $cantidad) {
				$arrayKey = explode('-', $key);
				if ($clienteIdAnt!=$arrayKey[0]) {
					$clientes .=$saldos['clientes']['cliente'][$arrayKey[0]].'<br>';
				}
				$clientes .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$saldos['productos']['nombre'][$arrayKey[1]].' Vendidos: '.$cantidad.' <br>';
				$clienteIdAnt=$arrayKey[0];
			}
			$xtpl->assign("clientes",  $clientes);
		}

		$detalles = $balances;

		for ($mes = 1; $mes <=12; $mes++) {

			$xtpl->assign("mes",  $detalles[$mes]["mes_nombre"] );

            $year = MercatUIUtils::yearOfDate($criteria->getFecha());

            $fecha = new DateTime($year.'-'.$mes.'-01');

            $criteriaGastoMes = new UIGastoCriteria();
            $criteriaGastoMes->setFiltroPredefinido(0);
            $criteriaGastoMes->setMes($fecha);

            $gastoSaldoMes = $serviceGasto->getTotales($criteriaGastoMes);


			$criteriaVentaMes = new UIVentaCriteria();







			$criteriaVentaMes->setMes( $fecha);
			$criteriaVentaMes->setCliente( $criteria->getCliente());
            $criteriaVentaMes->setVendedor( $criteria->getVendedor());
			$saldos = UIServiceFactory::getUIVentaService()->getGananciasProducto($criteriaVentaMes, $criteria,1 );

            /*if ($criteria->getVendedor())  {
                $ganancias = ($criteria->getVendedor()->getOid()==1)?$saldos['ganancias']-$gastoSaldoMes:$saldos['ganancias'];
            }
            else $ganancias =$saldos['ganancias']-$gastoSaldoMes;*/
            $ganancias =$saldos['ganancias'];
			$xtpl->assign("ventas",  'Negocio: '.MercatUIUtils::formatMontoToView($saldos["ventas"]).' - Hielo: '.MercatUIUtils::formatMontoToView($saldos["ventashielo"]) );
			/*$xtpl->assign("gastos",  MercatUIUtils::formatMontoToView($detalles[$mes]["gastos"]) );
			$xtpl->assign("pagos",  MercatUIUtils::formatMontoToView($detalles[$mes]["pagos"]) );
			*/

			$xtpl->assign("ganancia",  'Negocio: '.MercatUIUtils::formatMontoToView($ganancias).' - Hielo: '.MercatUIUtils::formatMontoToView($saldos["gananciashielo"])  );
			$xtpl->assign("comisiones",  'Negocio: '.MercatUIUtils::formatMontoToView((-1)*$saldos["comisiones"]).' - Hielo: '.MercatUIUtils::formatMontoToView((-1)*$saldos["comisioneshielo"])  );
            $xtpl->assign("gastos",  MercatUIUtils::formatMontoToView((-1)*$gastoSaldoMes)  );
			if ($saldos['productos']) {
				$productos='';

				foreach ($saldos['productos']['cant'] as $key => $cantidad) {
					//print_r($producto);
					$productos .=$saldos['productos']['nombre'][$key].' Vendidos: '.$cantidad.' <br>';
				}
				$xtpl->assign("producto",  $productos);
			}
			if ($saldos['clientes']) {
				$clientes='';
				$clienteIdAnt='';
				foreach ($saldos['clientes']['cant'] as $key => $cantidad) {
					$arrayKey = explode('-', $key);
					if ($clienteIdAnt!=$arrayKey[0]) {
						$clientes .='<strong>'.$saldos['clientes']['cliente'][$arrayKey[0]].'</strong><br>';
					}
					$clientes .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$saldos['productos']['nombre'][$arrayKey[1]].' Vendidos: '.$cantidad.' <br>';
					$clienteIdAnt=$arrayKey[0];
				}
				$xtpl->assign("cliente",  $clientes);
			}
			$xtpl->parse("main.detalle_mes.mes");

		}

		$xtpl->parse("main.detalle_mes");

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
