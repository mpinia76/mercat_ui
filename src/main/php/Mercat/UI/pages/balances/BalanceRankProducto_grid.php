<?php
namespace Mercat\UI\pages\balances;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIProductoCriteria;

use Mercat\UI\components\grid\model\RankProductoGridModel;

use Mercat\UI\service\UIProductoService;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\Producto;
use Mercat\Core\criteria\ProductoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


use Mercat\UI\utils\MercatUIUtils;
use Mercat\UI\service\UIServiceFactory;


/**
 * Página para consultar los productos.
 *
 * @author Marcos
 * @since 22/10/2020
 *
 */
class BalanceRankProductoGrid extends MercatPage{

	private $productoCriteria;

	public function __construct(){
		/*$productoCriteria = new ProductoCriteria();

		$productoCriteria->setVendedor(UIServiceFactory::getUIVendedorService()->get(MercatUIUtils::getVendedorSession() ));
		$this->setProductoCriteria($productoCriteria);*/
	}

	public function getTitle(){
		return $this->localize( "balanceRankProducto.title" );
	}



	public function getType(){

		return "BalanceRankProducto";

	}

	public function getModelClazz(){
		return get_class( new RankProductoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIProductoCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );


	}


	public function getProductoCriteria()
	{
	    return $this->productoCriteria;
	}

	public function setProductoCriteria($productoCriteria)
	{
	    $this->productoCriteria = $productoCriteria;
	}
}
?>
