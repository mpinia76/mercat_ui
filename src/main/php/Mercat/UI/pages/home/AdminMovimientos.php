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

class AdminMovimientos extends MercatPage{

	private $caja;
	private $cajaChica;

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


		if( MercatUIUtils::isCajaSelected() ){
			$caja = UIServiceFactory::getUICajaService()->get(MercatUIUtils::getCaja()->getOid());
			$this->setCaja( $caja );
		}

		$this->setCajaChica( UIServiceFactory::getUICuentaService()->getCajaChica() );
	}

	public function getTitle(){
		return $this->localize( "admin_home.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

		return array($menuGroup);
	}

	protected function parseMenuUser(XTemplate $xtpl){

		$user = RastySecurityContext::getUser();
		$xtpl->assign("user", $user->getName() );

		$this->parseMenuExit($xtpl);

	}

	protected function parseXTemplate(XTemplate $xtpl){

		$title = $this->localize("admin_home.title");
		$subtitle = $this->localize("admin_home.subtitle");
		$xtpl->assign("app_title", $title );
		//$xtpl->assign("app_subtitle", $subtitle );

		$this->parseMenuUser($xtpl);



		$this->parseLinks($xtpl);

		$this->parseSaldos($xtpl);


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

		$xtpl->assign("saldo_ctasctes", MercatUIUtils::formatMontoToView( UIServiceFactory::getUICuentaCorrienteService()->getSaldoCtasCtes() ) );



	}


	public function parseMenuExit( XTemplate $xtpl){

		$menuOption = new MenuActionOption();
		$menuOption->setLabel( $this->localize( "menu.logout") );
		$menuOption->setIconClass( "icon-exit" );
		$menuOption->setActionName( "Logout");
		$menuOption->setImageSource( $this->getWebPath() . "css/images/logout.png" );

		$this->parseMenuOption($xtpl, $menuOption, "main.menuOptionExit");

	}

	public function parseMenuAdmin( XTemplate $xtpl){

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.admin_home") );
		//$menuOption->setIconClass( "icon-exit" );
		$menuOption->setPageName( "AdminHome");
		$menuOption->setImageSource( $this->getWebPath() . "css/images/empleado_home_48.png" );

		$this->parseMenuOption($xtpl, $menuOption, "main.menuOptionAdmin");

	}
	public function parseMenuProfile( XTemplate $xtpl, $user){

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.profile") );
		$menuOption->setIconClass( "icon-cog" );
		$menuOption->setPageName( "UserProfile");
		$menuOption->addParam("oid",$user->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/profile.png" );
		$this->parseMenuOption($xtpl, $menuOption, "main.menuOptionProfile");

	}

	public function parseMenuOption( XTemplate $xtpl, MenuOption $menuOption, $blockName){
		$xtpl->assign("label", $menuOption->getLabel() );
		$xtpl->assign("onclick", $menuOption->getOnclick());
		$img = $menuOption->getImageSource();
		if(!empty($img)){
			$xtpl->assign("src", $img );
			$xtpl->parse("$blockName.image");
		}
		$xtpl->assign("iconClass", $menuOption->getIconClass());

		$xtpl->parse("$blockName");
	}




	public function getType(){

		return "AdminMovimientos";

	}



}
?>
