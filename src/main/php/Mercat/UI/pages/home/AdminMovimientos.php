<?php
namespace Mercat\UI\pages\home;

use Datetime;
use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIEmpleadoCriteria;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\components\filter\model\UIVentaCriteria;

use Mercat\UI\utils\MercatUIUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;
use Rasty\utils\LinkBuilder;

use Mercat\Core\model\Empleado;

use Rasty\Grid\filter\model\UICriteria;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;
use Rasty\Menu\menu\model\MenuActionOption;

use Rasty\security\RastySecurityContext;

class AdminMovimientos extends AdminHome{

	private $caja;
	private $cajaChica;
	private $empleado;

	/**
	 * @return mixed
	 */
	public function getEmpleado()
	{
		return $this->empleado;
	}

	/**
	 * @param mixed $empleado
	 */
	public function setEmpleado($empleado): void
	{
		$this->empleado = $empleado;
	}

	/**
	 * @return mixed
	 */
	public function getCaja()
	{
		return $this->caja;
	}

	/**
	 * @param mixed $caja
	 */
	public function setCaja($caja): void
	{
		$this->caja = $caja;
	}

	/**
	 * @return mixed
	 */
	public function getCajaChica()
	{
		return $this->cajaChica;
	}

	/**
	 * @param mixed $cajaChica
	 */
	public function setCajaChica($cajaChica): void
	{
		$this->cajaChica = $cajaChica;
	}

	public function __construct(){
		$this->setEmpleado(MercatUIUtils::getEmpleadoLogged());

		if( MercatUIUtils::isCajaSelected() ){
			$caja = UIServiceFactory::getUICajaService()->get(MercatUIUtils::getCaja()->getOid());
			$this->setCaja( $caja );
		}

		$this->setCajaChica( UIServiceFactory::getUICuentaService()->getCajaChica() );
	}







	protected function parseXTemplate(XTemplate $xtpl){

		$title = $this->localize("admin_home.title");
		$subtitle = $this->localize("admin_home.subtitle");
		$xtpl->assign("app_title", $title );
		//$xtpl->assign("app_subtitle", $subtitle );

		$this->parseMenuUser($xtpl);



		$this->parseLinks($xtpl);

		$this->parseSaldos($xtpl);

		if( MercatUIUtils::isAdminLogged() ){
			$this->parseMenuAdmin($xtpl);
		}
	}

	public function parseLinks( XTemplate $xtpl){

		$xtpl->assign("menu_admin", $this->localize("menu.admin") );






		$xtpl->assign("menu_caja", $this->localize("menu.caja") );
		$xtpl->assign("menu_cajaTarjeta", $this->localize("menu.cajaTarjeta") );
		$xtpl->assign("menu_cajaCtaCte", $this->localize("menu.cajaCtaCte") );

		$xtpl->assign("menu_bancos", $this->localize("menu.bancos") );
		$xtpl->assign("linkBancos", $this->getLinkBancos() );

		$xtpl->assign("menu_ctasctes", $this->localize("menu.cuentasCorrientes") );

		$xtpl->assign("menu_caja", $this->localize("menu.caja") );
		$xtpl->assign("menu_cajaTarjeta", $this->localize("menu.cajaTarjeta") );
		$xtpl->assign("menu_cajaCtaCte", $this->localize("menu.cajaCtaCte") );

		$xtpl->assign("menu_cajaChica", $this->localize("menu.cajaChica") );

		$xtpl->assign("menu_total", $this->localize("menu.total") );
	}



	public function parseSaldos(XTemplate $xtpl){




		if( MercatUIUtils::isCajaSelected() ){
			$xtpl->assign("saldo_caja", MercatUIUtils::formatMontoToView( $this->getCaja()->getSaldo()) );

			$xtpl->assign("linkMovimientosCaja", $this->getLinkMovimientosCajaActual());

		}else{
			$xtpl->assign("saldo_caja", MercatUIUtils::formatMontoToView( 0) );
		}

		$xtpl->assign("saldo_cajaChica", MercatUIUtils::formatMontoToView( $this->getCajaChica()->getSaldo() ) );
		$xtpl->assign("linkMovimientosCajaChica", $this->getLinkMovimientosCajaChica());

		$xtpl->assign("saldo_bancos", MercatUIUtils::formatMontoToView( UIServiceFactory::getUIBancoService()->getSaldoBancos() ) );
		$xtpl->assign("linkMovimientosBanco", $this->getLinkMovimientosBanco());



		$xtpl->assign("saldo_cajaCtaCte", MercatUIUtils::formatMontoToView( UIServiceFactory::getUIMovimientoCajaService()->getTotalesCtasCtesDia(new Datetime())) );


		$xtpl->assign("linkMovimientosCajaCtaCte", $this->getLinkMovimientosCajaCtaCte());

		$total = $this->getCajaChica()->getSaldo() + UIServiceFactory::getUIBancoService()->getSaldoBancos() + UIServiceFactory::getUIMovimientoCajaService()->getTotalesCtasCtesDia(new Datetime());
			$xtpl->assign("saldo_total", MercatUIUtils::formatMontoToView($total) );
	}


	public function getTitle(){
		$empleado = $this->getEmpleado();
		if($empleado)
			$nombre = $this->getEmpleado()->getNombre();
		else
			$nombre ="";
		return MercatUIUtils::formatMessage( $this->localize("empleado_home.title"), array($nombre)) ;
	}

	public function getMenuGroups(){

		$menuGroup = new MenuGroup();

		//		$menuOption = new MenuOption();
		//		$menuOption->setLabel( $this->localize( "ausencia.agregar" ) );
		//		$menuOption->setPageName("AusenciaAgregar");
		//		$menuOption->setImageSource( $this->getWebPath() . "css/images/ausencias_48.png" );
		//		$menuGroup->addMenuOption( $menuOption );
		//
		//		$menuOption = new MenuOption();
		//		$menuOption->setLabel( $this->localize( "horario.definir" ) );
		//		$menuOption->setPageName("HorariosProfesional");
		//		$menuOption->setImageSource( $this->getWebPath() . "css/images/horarios_48.png" );
		//		$menuGroup->addMenuOption( $menuOption );

		return array();
	}

	public function getType(){

		return "AdminMovimientos";

	}



}
?>
