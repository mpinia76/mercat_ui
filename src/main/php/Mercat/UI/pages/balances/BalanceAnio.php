<?php
namespace Mercat\UI\pages\balances;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\components\filter\model\UIProductoCriteria;



use Mercat\UI\service\UIVentaService;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mercat\Core\model\Caja;
use Mercat\Core\criteria\VentaCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar las balances.
 * 
 * @author Marcos
 * @since 09/10/2019
 * 
 */
class BalanceAnio extends MercatPage{

	
	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize("balanceAnio.title") ;
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "BalanceAnio";
		
	}	

	
	public function getUicriteriaClazz(){
		return get_class( new UIProductoCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		
	}
	
	

}
?>