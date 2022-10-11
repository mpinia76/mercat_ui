<?php

namespace Mercat\UI\components\filter\balance;

use Mercat\UI\components\filter\model\UIVentaCriteria;

use Mercat\UI\components\filter\model\UIVendedorCriteria;
use Mercat\UI\service\finder\VendedorFinder;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

use Mercat\UI\service\UIServiceFactory;

/**
 * Filtro para buscar balances
 *
 * @author Marcos
 * @since 22/10/2020
 */
class BalanceRankClienteFilter extends Filter{



	public function getType(){

		return "BalanceRankClienteFilter";
	}


	public function __construct(){

		parent::__construct();


		$this->setUicriteriaClazz( get_class( new UIVentaCriteria()) );



        $this->addProperty("fechaDesde");
        $this->addProperty("fechaHasta");


		$this->addProperty("vendedor");

	}

	protected function parseXTemplate(XTemplate $xtpl){



		parent::parseXTemplate($xtpl);




        $xtpl->assign("lbl_fechaDesde",  $this->localize("criteria.fechaDesde") );
        $xtpl->assign("lbl_fechaHasta",  $this->localize("criteria.fechaHasta") );



		$xtpl->assign("lbl_vendedor",  $this->localize("venta.vendedor") );





	}

	public function getVendedorFinderClazz(){

		return get_class( new VendedorFinder() );

	}


	public function getVendedores(){

		$vendedores = UIServiceFactory::getUIVendedorService()->getList( new UIVendedorCriteria());

		return $vendedores;
	}
}
?>
