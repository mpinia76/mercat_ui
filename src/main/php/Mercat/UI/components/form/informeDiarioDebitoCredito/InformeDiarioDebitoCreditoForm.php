<?php

namespace Mercat\UI\components\form\informeDiarioDebitoCredito;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\service\finder\SucursalFinder;
use Mercat\UI\components\filter\model\UISucursalCriteria;

use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;

use Mercat\Core\model\Sucursal;
use Mercat\Core\model\Empleado;
use Mercat\Core\model\InformeDiarioDebitoCredito;

use Mercat\UI\service\finder\BancoFinder;
use Mercat\UI\components\filter\model\UIBancoCriteria;

use Rasty\utils\LinkBuilder;

/**
 * Formulario para informeDiarioDebitoCredito

 * @author Marcos
 * @since 12/10/2022
 */
class InformeDiarioDebitoCreditoForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var InformeDiarioDebitoCredito
	 */
	private $informeDiarioDebitoCredito;
	
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("fecha");
		$this->addProperty("fechaVencimiento");
		$this->addProperty("debito");
		$this->addProperty("credito");
		//$this->addProperty("sucursal");
		$this->addProperty("banco");
		
		$this->setBackToOnSuccess("InformesDiariosDebitoCredito");
		$this->setBackToOnCancel("InformesDiariosDebitoCredito");
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "InformeDiarioDebitoCreditoForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
	
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_fecha", $this->localize("informeDiarioDebitoCredito.fecha") );
		$xtpl->assign("lbl_fechaVencimiento", $this->localize("informeDiarioDebitoCredito.fechaVencimiento") );
		$xtpl->assign("lbl_debito", $this->localize("informeDiarioDebitoCredito.debito") );
		$xtpl->assign("lbl_credito", $this->localize("informeDiarioDebitoCredito.credito") );
		//$xtpl->assign("lbl_sucursal", $this->localize("informeDiarioDebitoCredito.sucursal") );
		$xtpl->assign("lbl_banco", $this->localize("informeDiarioDebitoCredito.banco") );
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}

	
	public function getSucursales(){
		
		$sucursales = UIServiceFactory::getUISucursalService()->getList( new UISucursalCriteria() );
		
		return $sucursales;
		
	}
	
	public function getSucursalFinderClazz(){
		
		return get_class( new SucursalFinder() );
		
	}	
	
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}
	
	

	public function getInformeDiarioDebitoCredito()
	{
	    return $this->informeDiarioDebitoCredito;
	}

	public function setInformeDiarioDebitoCredito($informeDiarioDebitoCredito)
	{
	    $this->informeDiarioDebitoCredito = $informeDiarioDebitoCredito;
	}
	

	public function getEstados(){
		
		$items = array();
		
		foreach (MercatUIUtils::getEstadosInformeDiarioDebitoCredito() as $key => $value) {
			$items[ $key ] = MercatUIUtils::localize($value);
		}
		
		return $items;
		
		
	}
	
	public function getBancos(){
		
		$bancos = UIServiceFactory::getUIBancoService()->getList( new UIBancoCriteria() );
		
		return $bancos;
		
	}
	
	public function getBancoFinderClazz(){
		
		return get_class( new BancoFinder() );
		
	}	
	
		
}
?>