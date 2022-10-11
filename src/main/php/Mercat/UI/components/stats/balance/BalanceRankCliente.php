<?php

namespace Mercat\UI\components\stats\balance;

use DateTime;

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
 * @since 23-10-2020
 */
class BalanceRankCliente extends RastyComponent{

	private $fecha;

	public function getType(){

		return "BalanceRankCliente";

	}

	public function __construct(){
		$fecha = new DateTime();
		$this->setFecha($fecha);

	}

	protected function parseLabels(XTemplate $xtpl){

		$xtpl->assign("lbl_rankCliente",  $this->localize( "balanceRankCliente.rankCliente" ) );
		$xtpl->assign("lbl_cliente",  $this->localize( "venta.cliente" ) );
        $xtpl->assign("lbl_saldo",  $this->localize( "combo.monto" ) );
        $xtpl->assign("lbl_ctacte",  $this->localize( "forma.pago.ctacte" ) );
		$xtpl->assign("detalle_clientes_legend",  $this->localize( "menu.balances.rankclientes" ) );


	}

	protected function parseXTemplate(XTemplate $xtpl){
		ini_set('max_execution_time', '0');
		$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "balancerankclientefilter" );
		$componentConfig->setType( $this->getFilterType() );

	    $this->filter = ComponentFactory::buildByType($componentConfig, $this);



		$this->filter->fill( );

		$criteria = $this->filter->getCriteria();



		/*labels*/
		$this->parseLabels($xtpl);






		$clientes = UIServiceFactory::getUIVentaService()->getRankingClientes($criteria);
        //print_r($clientes);
        foreach ($clientes as $cliente) {

            $cl = UIServiceFactory::getUIClienteService()->get($cliente['oid']);

            $xtpl->assign("cliente",  $cliente['nombre']);

            $xtpl->assign("saldo",  MercatUIUtils::formatMontoToView($cliente['saldo']));
            $xtpl->assign("ctacte",  MercatUIUtils::formatMontoToView($cl->getSaldo()));

            $xtpl->parse("main.rank_clientes.clientes");
        }






		$xtpl->parse("main.rank_clientes");

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
