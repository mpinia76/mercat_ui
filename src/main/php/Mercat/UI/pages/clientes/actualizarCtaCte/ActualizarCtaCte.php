<?php
namespace Mercat\UI\pages\clientes\actualizarCtaCte;


use Mercat\UI\service\finder\ClienteFinder;

use Mercat\UI\service\finder\CuentaFinder;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\utils\MercatUIUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;
use Rasty\utils\LinkBuilder;

use Rasty\Grid\filter\model\UICriteria;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;



class ActualizarCtaCte extends MercatPage{

	private $cliente;
	
	private $monto;
	private $observaciones;

	private $error;
	
	public function __construct(){
		
		/*if( MercatUIUtils::isCajaSelected() )
			$this->destino = MercatUIUtils::getCaja();*/
		
		$cliente = UIServiceFactory::getUIClienteService()->get( RastyUtils::getParamGET("clienteOid") );
		
		if( !empty( $cliente)  ){
			$this->setCliente($cliente);
		}
	}

	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("legend",  $this->localize( "cuentaCorriente.actualizar.legend" ) );

		
		$xtpl->assign("lbl_monto",  $this->localize( "cobrarCtaCte.monto" ) );
		$xtpl->assign("lbl_observaciones",  $this->localize( "cobrarCtaCte.observaciones" ) );
		$xtpl->assign("lbl_cliente",  $this->localize( "cobrarCtaCte.cliente" ) );
		//$xtpl->assign("lbl_destino",  $this->localize( "cobrarCtaCte.destino" ) );
		
		$xtpl->assign("ctacte_legend",  $this->localize( "actualizarCtaCte.ctacte_legend" ) );
		
		
		
		
		$xtpl->assign("lbl_submit",  $this->localize( "form.aceptar" ) );
		$xtpl->assign("lbl_cancel",  $this->localize( "form.cancelar" ) );
		
	}

	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels*/
		$this->parseLabels($xtpl);
		
		$xtpl->assign("action", $this->getLinkActionActualizarCuentaCorriente() );
		$xtpl->assign("cancel",  $this->getLinkClientesCtaCte() );
			
		$msg = $this->getError();
		
		if( !empty($msg) ){
			
			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
	}
	
	public function getTitle(){
		return $this->localize("actualizarCtaCte.title") ;
	}

	public function getType(){
		
		return "ActualizarCtaCte";
		
	}	


	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}

	public function getMonto()
	{
	    return $this->monto;
	}

	public function setMonto($monto)
	{
	    $this->monto = $monto;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
	}

	public function getError()
	{
	    return $this->error;
	}

	public function setError($error)
	{
	    $this->error = $error;
	}
	
	
	
	public function getCuentaFinderClazz(){
		
		return get_class( new CuentaFinder() );
		
	}
	
	
	public function getClienteFinderClazz(){
		
		return get_class( new ClienteFinder() );
		
	}



	public function getDestino()
	{
	    return $this->destino;
	}

	public function setDestino($destino)
	{
	    $this->destino = $destino;
	}
}
?>