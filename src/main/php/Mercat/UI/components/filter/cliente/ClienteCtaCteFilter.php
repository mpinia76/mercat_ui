<?php

namespace Mercat\UI\components\filter\cliente;

use Mercat\UI\components\filter\model\UIClienteCriteria;

use Mercat\UI\components\grid\model\ClienteGridModel;

//use Mercat\Core\model\TipoCliente;

use Mercat\UI\utils\MercatUIUtils;


use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

use Rasty\security\RastySecurityContext;
use Mercat\Core\utils\MercatUtils;

/**
 * Filtro para buscar clientes
 *
 * @author Marcos
 * @since 12/09/2019
 */
class ClienteCtaCteFilter extends Filter{

	public function getType(){

		return "ClienteCtaCteFilter";
	}


	public function __construct(){

		parent::__construct();

		$this->setGridModelClazz( get_class( new ClienteGridModel() ));

		$this->setUicriteriaClazz( get_class( new UIClienteCriteria()) );

		//$this->setSelectRowCallback("seleccionarCliente");

		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");
		$this->addProperty("documento");
		//$this->addProperty("tipoCliente");
		//print_r(RastyUtils::getParamGET("tieneCtaCte"));

	}

	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		/*$this->fillInput("nombre", $this->getInitialText() );
		$this->fillInput("documento", $this->getInitialText() );*/

		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_nombre",  $this->localize("cliente.nombre") );
		$xtpl->assign("lbl_documento",  $this->localize("cliente.documento") );
		//$xtpl->assign("lbl_tipoCliente",  $this->localize("cliente.tipoCliente") );

		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "ClienteModificar") );


        $user = RastySecurityContext::getUser();

        $user = MercatUtils::getUserByUsername($user->getUsername());

        if( MercatUtils::isAdmin($user)) {
            $xtpl->assign("isAdmin",  1 );
        }
        else{
            $xtpl->assign("isAdmin",  0 );
        }


	}

	public function fillEntity($entity){

		parent::fillEntity($entity);



			$entity->setTieneCtaCte( 1 );



	}


	/*public function getTiposClientes(){

		return MercatUIUtils::localizeEntities(TipoCliente::getItems());
	}*/
}
?>
