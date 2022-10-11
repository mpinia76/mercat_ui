<?php
namespace Mercat\UI\pages\clientes\agregar;

use Mercat\UI\pages\MercatPage;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Cliente;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class ClienteAgregar extends MercatPage{

	/**
	 * cliente a agregar.
	 * @var Cliente
	 */
	private $cliente;

	
	public function __construct(){
		
		//inicializamos el cliente.
		$cliente = new Cliente();
		
		//$cliente->setNombre("Bernardo");
		//$cliente->setEmail("ber@mail.com");
		$this->setCliente($cliente);
		
		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("Clientes");
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "cliente.agregar.title" );
	}

	public function getType(){
		
		return "ClienteAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		$clienteForm = $this->getComponentById("clienteForm");
		$clienteForm->fillFromSaved( $this->getCliente() );
		
	}


	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>