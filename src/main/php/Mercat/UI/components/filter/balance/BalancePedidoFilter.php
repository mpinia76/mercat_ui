<?php

namespace Mercat\UI\components\filter\balance;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\filter\model\UIPedidoCriteria;

use Mercat\UI\components\grid\model\BalancePedidoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar pedidos
 *
 * @author Marcos
 * @since 23-10-2020
 */
class BalancePedidoFilter extends Filter{

	private $recibido;

	public function getType(){

		return "BalancePedidoFilter";
	}



	public function __construct(){

		parent::__construct();

		$this->setGridModelClazz( get_class( new BalancePedidoGridModel() ));

		$this->setUicriteriaClazz( get_class( new UIPedidoCriteria()) );

		//$this->setSelectRowCallback("seleccionarPedido");

		//agregamos las propiedades a popular en el submit.
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");

		$this->addProperty("proveedor");
	}

	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos para ver pendientes o todos.
		//$this->fillInput("recibido", ($this->getRecibido())?1:2 );

		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_fechaDesde",  $this->localize("criteria.fechaDesde") );
		$xtpl->assign("lbl_fechaHasta",  $this->localize("criteria.fechaHasta") );


		$xtpl->assign("lbl_proveedor",  $this->localize("criteria.proveedor") );

	}







}
?>
