<?php
namespace Mercat\UI\pages\presupuestos\agregar;

use Datetime;
use Mercat\Core\utils\MercatUtils;
use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\pages\MercatPage;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Presupuesto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

use Mercat\UI\service\UIServiceFactory;


use Rasty\utils\RastyUtils;

class PresupuestoAgregar extends MercatPage{

	/**
	 * presupuesto a agregar.
	 * @var Presupuesto
	 */
	private $presupuesto;


	public function __construct(){

		//inicializamos el presupuesto.
		$presupuesto = new Presupuesto();

		$presupuesto->setFecha( new Datetime() );

		if(RastyUtils::getParamGET("clienteOid") ){
			$cliente = UIServiceFactory::getUIClienteService()->get( RastyUtils::getParamGET("clienteOid") );
			$presupuesto->setCliente($cliente );
		}
		else{
			$presupuesto->setCliente( MercatUtils::getClienteDefault() );
		}

        $presupuesto->setVendedor(UIServiceFactory::getUIVendedorService()->get(MercatUIUtils::getVendedorSession() ));

		$this->setPresupuesto($presupuesto);


	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Presupuestos");
//		$menuGroup->addMenuOption( $menuOption );
//

		return array($menuGroup);
	}

	public function getTitle(){
		return $this->localize( "presupuesto.agregar.title" );
	}

	public function getType(){

		return "PresupuestoAgregar";

	}

	protected function parseXTemplate(XTemplate $xtpl){

		MercatUIUtils::setDetallesPresupuestoSession( array() );
	}


	public function getPresupuesto()
	{
	    return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
	    $this->presupuesto = $presupuesto;
	}



	public function getMsgError(){
		return "";
	}
}
?>
