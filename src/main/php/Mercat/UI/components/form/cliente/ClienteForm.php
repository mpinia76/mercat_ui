<?php

namespace Mercat\UI\components\form\cliente;

use Datetime;
use Mercat\UI\components\filter\model\UIClienteCriteria;

use Mercat\UI\service\finder\ClienteFinder;



use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mercat\Core\model\Cliente;
use Mercat\Core\model\Sexo;

use Mercat\Core\model\TipoDocumento;
use Mercat\Core\model\TipoCliente;

use Rasty\utils\LinkBuilder;

/**
 * Formulario para cliente

 * @author Marcos
 * @since 02/03/2018
 */
class ClienteForm extends Form{



	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;


	/**
	 *
	 * @var Cliente
	 */
	private $cliente;


	public function __construct($backToOnSuccess="Clientes"){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");

		$this->addProperty("nombre");
		$this->addProperty("tipoCliente");
		$this->addProperty("tipoDocumento");
		$this->addProperty("documento");
		$this->addProperty("cuit");
		$this->addProperty("nacimiento");
		$this->addProperty("sexo");
		$this->addProperty("telefono");
		$this->addProperty("celular");
		$this->addProperty("mail");
		$this->addProperty("direccion");
		$this->addProperty("observaciones");
		$this->addProperty("laboral");


		$url = parse_url($_SERVER['REQUEST_URI']);
		if (isset($url['query'])) {
			$arrayParametros = explode("&",$url['query']);
			foreach ($arrayParametros as $parametro) {
				$arrayParametro = explode("=",$parametro);
				if ($arrayParametro[0]=="onSuccessCallback") {
					$backToOnSuccess = $arrayParametro[1];
				}
			}
		}


		$this->setBackToOnSuccess($backToOnSuccess);
		$this->setBackToOnCancel($backToOnSuccess);

	}

	public function getOid(){

		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}


	public function getType(){

		return "ClienteForm";

	}

	public function fillEntity($entity){

		parent::fillEntity($entity);

		//uppercase para el nombre
		//$entity->setNombre( strtoupper( $entity->getNombre() ) );
		$entity->setFecha(new Datetime() );
		$entity->setUltModificacion(new Datetime() );


	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);


		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );

		$xtpl->assign("lbl_nombre", $this->localize("cliente.nombre") );
		$xtpl->assign("lbl_tipoDocumento", $this->localize("cliente.tipoDocumento") );
		$xtpl->assign("lbl_tipoCliente", $this->localize("cliente.tipoCliente") );
		$xtpl->assign("lbl_documento", $this->localize("cliente.documento") );
		$xtpl->assign("lbl_sexo", $this->localize("cliente.sexo") );
		$xtpl->assign("lbl_nacimiento", $this->localize("cliente.nacimiento") );
		$xtpl->assign("lbl_telefono", $this->localize("cliente.telefono") );
		$xtpl->assign("lbl_celular", $this->localize("cliente.celular") );
		$xtpl->assign("lbl_mail", $this->localize("cliente.mail") );
		$xtpl->assign("lbl_direccion", $this->localize("cliente.direccion") );
		$xtpl->assign("lbl_observaciones", $this->localize("cliente.observaciones") );
		$xtpl->assign("lbl_laboral", $this->localize("cliente.laboral") );
		$xtpl->assign("lbl_cuit", $this->localize("cliente.cuit") );

	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}



	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;

	}

	public function getLinkCancel(){
		$params = array();

		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}

	public function getSexos(){

		return MercatUIUtils::localizeEntities(Sexo::getItems());
	}

	public function getTiposDocumento(){

		return MercatUIUtils::localizeEntities(TipoDocumento::getItems());
	}

	public function getTiposCliente(){

		return MercatUIUtils::localizeEntities(TipoCliente::getItems());
	}


}
?>
