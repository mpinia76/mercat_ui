<?php

namespace Mercat\UI\components\form\empleado;

use Datetime;
use Mercat\UI\components\filter\model\UIEmpleadoCriteria;

use Mercat\UI\service\finder\EmpleadoFinder;



use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mercat\Core\model\Empleado;
use Mercat\Core\model\Sexo;

use Mercat\Core\model\TipoDocumento;
use Mercat\Core\model\TipoEmpleado;

use Rasty\utils\LinkBuilder;

/**
 * Formulario para empleado

 * @author Marcos
 * @since 11/10/2022
 */
class EmpleadoForm extends Form{



	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;


	/**
	 *
	 * @var Empleado
	 */
	private $empleado;


	public function __construct($backToOnSuccess="Empleados"){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");

		$this->addProperty("nombre");

		$this->addProperty("tipoDocumento");
		$this->addProperty("documento");
		$this->addProperty("cuil");
		$this->addProperty("nacimiento");
		$this->addProperty("sexo");
		$this->addProperty("telefono");
		$this->addProperty("celular");
		$this->addProperty("mail");
		$this->addProperty("direccion");
		$this->addProperty("observaciones");
		$this->addProperty("numero");



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

		return "EmpleadoForm";

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

		$xtpl->assign("lbl_nombre", $this->localize("empleado.nombre") );
		$xtpl->assign("lbl_tipoDocumento", $this->localize("empleado.tipoDocumento") );

		$xtpl->assign("lbl_documento", $this->localize("empleado.documento") );
		$xtpl->assign("lbl_sexo", $this->localize("empleado.sexo") );
		$xtpl->assign("lbl_nacimiento", $this->localize("empleado.nacimiento") );
		$xtpl->assign("lbl_telefono", $this->localize("empleado.telefono") );
		$xtpl->assign("lbl_celular", $this->localize("empleado.celular") );
		$xtpl->assign("lbl_mail", $this->localize("empleado.mail") );
		$xtpl->assign("lbl_direccion", $this->localize("empleado.direccion") );
		$xtpl->assign("lbl_observaciones", $this->localize("empleado.observaciones") );
		$xtpl->assign("lbl_numero", $this->localize("empleado.numero") );
		$xtpl->assign("lbl_cuil", $this->localize("empleado.cuil") );

	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}



	public function getEmpleado()
	{
	    return $this->empleado;
	}

	public function setEmpleado($empleado)
	{
	    $this->empleado = $empleado;

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

	public function getTiposEmpleado(){

		return MercatUIUtils::localizeEntities(TipoEmpleado::getItems());
	}


}
?>
