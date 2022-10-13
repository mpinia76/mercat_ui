<?php

namespace Mercat\UI\components\filter\banco;

use Mercat\UI\components\filter\model\UIBancoCriteria;

use Mercat\UI\components\grid\model\BancoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar bancos
 *
 * @author Marcos
 * @since 06/03/2021
 */
class BancoFilter extends Filter{

	public function getType(){

		return "BancoFilter";
	}


	public function __construct(){

		parent::__construct();

		$this->setGridModelClazz( get_class( new BancoGridModel() ));

		$this->setUicriteriaClazz( get_class( new UIBancoCriteria()) );

		//$this->setSelectRowCallback("seleccionarBanco");

		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");

	}

	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		//$this->fillInput("nombre", $this->getInitialText() );

		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_nombre",  $this->localize("banco.nombre") );

		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "BancoModificar") );


	}
}
?>
