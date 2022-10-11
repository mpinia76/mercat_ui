<?php
namespace Mercat\UI\pages\vendedores\modificar;

use Mercat\UI\pages\MercatPage;
use Mercat\UI\utils\MercatUIUtils;
use Mercat\UI\service\UIServiceFactory;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Vendedor;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class VendedorModificar extends MercatPage{

	/**
	 * vendedor a modificar.
	 * @var Vendedor
	 */
	private $vendedor;

	
	public function __construct(){
		
		//inicializamos el vendedor.
		$vendedor = new Vendedor();
		$this->setVendedor($vendedor);
				
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		return array($menuGroup);
	}
	
	public function setVendedorOid($oid){
		
		//a partir del id buscamos el vendedor a modificar.
		$vendedor = UIServiceFactory::getUIVendedorService()->get($oid);
		
		$this->setVendedor($vendedor);
		
	}
	
	public function getTitle(){
		return $this->localize( "vendedor.modificar.title" );
	}

	public function getType(){
		
		return "VendedorModificar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		
		$vendedorForm = $this->getComponentById("vendedorForm");
		$vendedorForm->fillFromSaved( $this->getVendedor() );
		
	}

	public function getVendedor(){
		
	    return $this->vendedor;
	}

	public function setVendedor($vendedor)
	{
	    $this->vendedor = $vendedor;
	}
}
?>