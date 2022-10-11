<?php
namespace Mercat\UI\pages\ventas;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIVentaCriteria;

use Mercat\UI\components\grid\model\VentaGridModel;

use Mercat\UI\service\UIVentaService;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\Venta;
use Mercat\Core\criteria\VentaCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los ventas.
 *
 * @author Marcos
 * @since 13-03-2018
 *
 */
class Ventas extends MercatPage{


	private $ventaCriteria;

	public function __construct(){
		$ventaCriteria = new VentaCriteria();


		$this->setVentaCriteria($ventaCriteria);
	}

	public function getTitle(){
		return $this->localize( "ventas.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.ventas.agregar") );
		$menuOption->setPageName("VentaAgregar");
		$menuOption->setIconClass( "icon-ventas");
		$menuGroup->addMenuOption( $menuOption );


		return array($menuGroup);
	}

	public function getType(){

		return "Ventas";

	}

	public function getModelClazz(){
		return get_class( new VentaGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIVentaCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );

		$xtpl->assign("agregar_label", $this->localize("venta.agregar") );

		$ventaFilter = $this->getComponentById("ventasFilter");

		$ventaFilter->fillFromSaved( $this->getVentaCriteria() );
	}

	public function getVentaCriteria()
	{
	    return $this->ventaCriteria;
	}

	public function setVentaCriteria($ventaCriteria)
	{
	    $this->ventaCriteria = $ventaCriteria;
	}

}
?>
