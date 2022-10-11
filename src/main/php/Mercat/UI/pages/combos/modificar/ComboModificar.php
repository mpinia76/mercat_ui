<?php
namespace Mercat\UI\pages\combos\modificar;

use Mercat\UI\pages\MercatPage;
use Mercat\UI\utils\MercatUIUtils;
use Mercat\UI\service\UIServiceFactory;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Combo;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class ComboModificar extends MercatPage{

	/**
	 * combo a modificar.
	 * @var Combo
	 */
	private $combo;

	
	public function __construct(){
		
		//inicializamos el combo.
		$combo = new Combo();
		$this->setCombo($combo);
				
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		return array($menuGroup);
	}
	
	public function setComboOid($oid){
		
		//a partir del id buscamos el combo a modificar.
		$combo = UIServiceFactory::getUIComboService()->get($oid);
		
		$this->setCombo($combo);
		
	}
	
	public function getTitle(){
		return $this->localize( "combo.modificar.title" );
	}

	public function getType(){
		
		return "ComboModificar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		MercatUIUtils::setProductosComboSession(array()  );
	
		foreach ($this->getCombo()->getProductos() as $producto) {
			MercatUIUtils::agregarProductoComboSession($producto);
			
		}
		
		$comboForm = $this->getComponentById("comboForm");
		$comboForm->fillFromSaved( $this->getCombo() );
		
	}

	public function getCombo(){
		
	    return $this->combo;
	}

	public function setCombo($combo)
	{
	    $this->combo = $combo;
	}
}
?>