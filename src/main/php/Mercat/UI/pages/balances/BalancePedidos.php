<?php
namespace Mercat\UI\pages\balances;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIPedidoCriteria;

use Mercat\UI\components\grid\model\BalancePedidoGridModel;

use Mercat\UI\service\UIPedidoService;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\Pedido;
use Mercat\Core\criteria\PedidoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los pedidos.
 *
 * @author Marcos
 * @since 23-10-2020
 *
 */
class BalancePedidos extends MercatPage{


	public function __construct(){

	}

	public function getTitle(){
		return $this->localize( "pedidos.title" );
	}



	public function getType(){

		return "BalancePedidos";

	}

	public function getModelClazz(){
		return get_class( new BalancePedidoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIPedidoCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );


	}

}
?>
