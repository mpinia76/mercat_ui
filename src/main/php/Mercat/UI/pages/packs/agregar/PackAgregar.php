<?php
namespace Mercat\UI\pages\packs\agregar;

use Mercat\UI\pages\MercatPage;



use Rasty\utils\XTemplate;
use Mercat\Core\model\Pack;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;
use Rasty\utils\RastyUtils;

class PackAgregar extends MercatPage{

	/**
	 * pack a agregar.
	 * @var Pack
	 */
	private $pack;

	private $producto;
	
	public function __construct(){
		
		//inicializamos el pack.
		$pack = new Pack();
		/*$producto = UIServiceFactory::getUIProductoService()->get( RastyUtils::getParamGET("productoOid") );
		$pack->setProducto($producto);*/
		//$pack->setEmail("ber@mail.com");
		$this->setPack($pack);
		
		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("Packs");
		$menuOption->addParam("productoOid",RastyUtils::getParamGET("productoOid"));
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "pack.agregar.title" );
	}

	public function getType(){
		
		return "PackAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		$packForm = $this->getComponentById("packForm");
		$packForm->fillFromSaved( $this->getPack() );
		
	}


	public function getPack()
	{
	    return $this->pack;
	}

	public function setPack($pack)
	{
	    $this->pack = $pack;
	}
	
	
					
	public function getMsgError(){
		return "";
	}

	public function getProducto()
	{
	    return $this->producto;
	}

	public function setProducto($producto)
	{
	    $this->producto = $producto;
	}
}
?>