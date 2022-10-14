<?php
namespace Mercat\UI\pages\bancos\agregar;

use Mercat\UI\pages\MercatPage;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Banco;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class BancoAgregar extends MercatPage{

	/**
	 * Banco a agregar.
	 * @var Banco
	 */
	private $Banco;


	public function __construct(){

		//inicializamos el Banco.
		$banco = new Banco();


		$this->setBanco($banco);


	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("Bancos");
		$menuGroup->addMenuOption( $menuOption );


		return array($menuGroup);
	}

	public function getTitle(){
		return $this->localize( "banco.agregar.title" );
	}

	public function getType(){

		return "BancoAgregar";

	}

	protected function parseXTemplate(XTemplate $xtpl){
		$bancoForm = $this->getComponentById("bancoForm");
		$bancoForm->fillFromSaved( $this->getBanco() );

	}


	public function getBanco()
	{
	    return $this->Banco;
	}

	public function setBanco($Banco)
	{
	    $this->Banco = $Banco;
	}



	public function getMsgError(){
		return "";
	}
}
?>
