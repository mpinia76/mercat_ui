<?php

namespace Mercat\UI\components\stats\movimientos;

use Mercat\UI\components\filter\model\UIMovimientoCajaCriteria;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\Grid\filter\model\UICriteria;

use Rasty\utils\XTemplate;

use Mercat\Core\model\Cuenta;

use Rasty\utils\LinkBuilder;

/**
 * Últimos movimientos de una cuenta.
 * 
 * @author Marcos
 * @since 12/10/2022
 */
class UltimosMovimientos extends RastyComponent{
		
	private $cuenta;
	
	private $cantidad;
	
	public function getType(){
		
		return "UltimosMovimientos";
		
	}

	public function __construct(){
		
	}

	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("lbl_importe",  $this->localize( "stats.ventas.importe" ) );
		
	}

	protected function getMovimientos(){
		
		$cantidad = $this->getCantidad();
		if(empty($cantidad))
			$cantidad = 4;
			
		$cuenta = $this->getCuenta();
		if( $cuenta!=null && $cuenta->getOid()>0 ){
			$criteria = new UIMovimientoCajaCriteria();
			$criteria->setCuenta( $this->getCuenta() );
			$criteria->setPage(1);
			$criteria->setRowPerPage($cantidad);
			$criteria->addOrder("fecha", UICriteria::TYPE_DESC);
			$movimientos = UIServiceFactory::getUIMovimientoCajaService()->getEntities($criteria);
		}else{
			
			$movimientos = array();
		}
		
		return $movimientos;
	}
	
	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels de la agenda*/
		$this->parseLabels($xtpl);
		
		//buscamos los últimos movimientos
		$movimientos = $this->getMovimientos();
		
		$even = true;
		$first = true;
		$last = count($movimientos)-1;
		$index=0;
		foreach ($movimientos as $movimiento) {
			
			$haber = $movimiento->getHaber();
			$debe = $movimiento->getDebe();
			if( $haber > 0 ){
				$monto = $haber;	
				$xtpl->assign("montoCss",  "haber" );
			} else{
				$monto = $debe;
				$xtpl->assign("montoCss",  "debe" );
			}
			
			$movCss = ($even)?"movimiento_even":"movimiento_odd";

			if( $first )
				$movCss .= " movimiento_first";
			elseif ($last == $index )	
				$movCss .= " movimiento_last";
				
			$xtpl->assign("movimientoCss", $movCss );
			$xtpl->assign("monto",  MercatUIUtils::formatMontoToView( $monto ) );
			$xtpl->assign("saldo",  MercatUIUtils::formatMontoToView( $movimiento->getSaldo() ) );
			$xtpl->assign("concepto",  $movimiento->getDescripcion()  );
			$xtpl->assign("fecha",  MercatUIUtils::formatTimeToView($movimiento->getFecha())  );
			
			if( $movimiento->podesAnularte() ){
				//$xtpl->parse("main.movimiento.anular");	
			}
			$xtpl->parse("main.movimiento");
			
			$even = !$even;
			$first = false;
			$index++;
		}
		
		
		
	}
	

	protected function initObserverEventType(){
		$this->addEventType( "MovimientoCaja" );
	}
	
	public function setCuentaOid($cuentaOid){
		//TODO
		if( !empty($cuentaOid) ){
			//$caja = UIServiceFactory::getUICajaService()->get($cajaOid);
			//$this->setCaja($caja);
		}
	}


	public function getCuenta()
	{
	    return $this->cuenta;
	}

	public function setCuenta($cuenta)
	{
	    $this->cuenta = $cuenta;
	}

	public function getCantidad()
	{
	    return $this->cantidad;
	}

	public function setCantidad($cantidad)
	{
	    $this->cantidad = $cantidad;
	}
}
?>