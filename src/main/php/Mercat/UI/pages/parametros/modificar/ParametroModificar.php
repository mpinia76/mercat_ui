<?php
namespace Mercat\UI\pages\parametros\modificar;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\service\UIServiceFactory;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Parametro;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class ParametroModificar extends MercatPage{

	/**
	 * parametro a modificar.
	 * @var Parametro
	 */
	private $parametro;

	
	public function __construct(){
		
		//inicializamos el parametro.
		$parametro = new Parametro();
		$this->setParametro($parametro);
				
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		return array($menuGroup);
	}
	
	public function setParametroOid($oid){
		
		//a partir del id buscamos el parametro a modificar.
		$parametro = UIServiceFactory::getUIParametroService()->get($oid);
		
		$this->setParametro($parametro);
		
	}
	
	public function getTitle(){
		return $this->localize( "parametro.modificar.title" );
	}

	public function getType(){
		
		return "ParametroModificar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
	}

	public function getParametro(){
		
	    return $this->parametro;
	}

	public function setParametro($parametro)
	{
	    $this->parametro = $parametro;
	}
}
?>