<?php

namespace Mercat\UI\components\form\banco;









use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;



use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mercat\Core\model\Banco;

use Rasty\utils\LinkBuilder;

/**
 * Formulario para banco

 * @author Marcos
 * @since 06/03/2021
 */
class BancoForm extends Form{



	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;


	/**
	 *
	 * @var Banco
	 */
	private $banco;


	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");


		$this->addProperty("saldoInicial");
        //$this->addProperty("saldo");
		$this->addProperty("nombre");
        $this->addProperty("titular");
        $this->addProperty("cuit");
        $this->addProperty("cbu");
        $this->addProperty("numero");


		$this->setBackToOnSuccess("Bancos");
		$this->setBackToOnCancel("Bancos");

	}

	public function getOid(){

		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}


	public function getType(){

		return "BancoForm";

	}

	public function fillEntity($entity){

		parent::fillEntity($entity);


	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);


		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );

        //$xtpl->assign("lbl_saldo", $this->localize("banco.saldo") );
		$xtpl->assign("lbl_saldoInicial", $this->localize("banco.saldoInicial") );
		$xtpl->assign("lbl_nombre", $this->localize("banco.nombre") );
        $xtpl->assign("lbl_titular", $this->localize("banco.titular") );
        $xtpl->assign("lbl_cuit", $this->localize("banco.cuit") );
        $xtpl->assign("lbl_cbu", $this->localize("banco.cbu") );
        $xtpl->assign("lbl_numero", $this->localize("banco.numero") );


	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}







	public function getLinkCancel(){
		$params = array();

		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}



	public function getBanco()
	{
	    return $this->banco;
	}

	public function setBanco($banco)
	{
	    $this->banco = $banco;
	}
}
?>
