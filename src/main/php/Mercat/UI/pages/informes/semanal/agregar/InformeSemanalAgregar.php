<?php
namespace Mercat\UI\pages\informes\semanal\agregar;

use Mercat\Core\utils\MercatUtils;
use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\pages\MercatPage;

use Rasty\utils\XTemplate;
use Mercat\Core\model\InformeSemanal;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class InformeSemanalAgregar extends MercatPage{

	/**
	 * informeSemanal a agregar.
	 * @var InformeSemanal
	 */
	private $informeSemanal;

	
	public function __construct(){
		
		//inicializamos el informeSemanal.
		$informeSemanal = new InformeSemanal();
		
		//$informeSemanal->setSucursal( MercatUIUtils::getSucursal() );
		
		$this->setInformeSemanal($informeSemanal);

		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("InformeSemanals");
//		$menuGroup->addMenuOption( $menuOption );
//		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "informeSemanal.agregar.title" );
	}

	public function getType(){
		
		return "InformeSemanalAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		
	}


	public function getInformeSemanal()
	{
	    return $this->informeSemanal;
	}

	public function setInformeSemanal($informeSemanal)
	{
	    $this->informeSemanal = $informeSemanal;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>