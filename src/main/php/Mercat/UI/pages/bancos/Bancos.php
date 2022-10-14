<?php
namespace Mercat\UI\pages\bancos;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIBancoCriteria;

use Mercat\UI\components\grid\model\BancoGridModel;

use Mercat\UI\service\UIBancoService;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\Banco;
use Mercat\Core\criteria\BancoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los bancos.
 *
 * @author Marcos
 * @since 06/03/2021
 *
 */
class Bancos extends MercatPage{


	public function __construct(){

	}

	public function getTitle(){
		return $this->localize( "bancos.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.bancos.agregar") );
		$menuOption->setPageName("BancoAgregar");
		$menuOption->setIconClass( "icon-agregar fg-green" );
		$menuGroup->addMenuOption( $menuOption );


		return array($menuGroup);
	}

	public function getType(){

		return "Bancos";

	}

	public function getModelClazz(){
		return get_class( new BancoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIBancoCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );

		$xtpl->assign("agregar_label", $this->localize("banco.agregar") );
	}

}
?>
