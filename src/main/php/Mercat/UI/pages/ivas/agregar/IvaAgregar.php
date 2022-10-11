<?php
namespace Mercat\UI\pages\ivas\agregar;

use Mercat\UI\pages\MercatPage;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Iva;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class IvaAgregar extends MercatPage{

	/**
	 * Iva a agregar.
	 * @var Iva
	 */
	private $Iva;

	
	public function __construct(){
		
		//inicializamos el Iva.
		$Iva = new Iva();
		
		//$Iva->setNombre("Bernardo");
		//$Iva->setEmail("ber@mail.com");
		$this->setIva($Iva);
		
		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("Ivas");
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "iva.agregar.title" );
	}

	public function getType(){
		
		return "IvaAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		$ivaForm = $this->getComponentById("ivaForm");
		$ivaForm->fillFromSaved( $this->getIva() );
		
	}


	public function getIva()
	{
	    return $this->Iva;
	}

	public function setIva($Iva)
	{
	    $this->Iva = $Iva;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>