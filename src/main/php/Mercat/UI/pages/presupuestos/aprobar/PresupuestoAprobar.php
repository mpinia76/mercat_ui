<?php
namespace Mercat\UI\pages\presupuestos\aprobar;

use Mercat\UI\service\UIServiceFactory;

use Mercat\Core\utils\MercatUtils;
use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\pages\MercatPage;

use Rasty\utils\XTemplate;
use Mercat\Core\model\Presupuesto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class PresupuestoAprobar extends MercatPage{

	/**
	 * presupuesto a aprobar.
	 * @var Presupuesto
	 */
	private $presupuesto;

	private $error;
	
	public function __construct(){
		
		//inicializamos el presupuesto.
		$presupuesto = new Presupuesto();
		
		
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
		return $this->localize( "presupuesto.aprobar.title" );
	}

	public function getType(){
		
		return "PresupuestoAprobar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		$xtpl->assign( "presupuesto_legend", $this->localize( "aprobarPresupuesto.presupuesto.legend") );
		
		$xtpl->assign( "presupuestoOid", $this->getPresupuesto()->getOid() );
		
		$xtpl->assign( "linkAprobarPresupuesto", $this->getLinkActionAprobarPresupuesto($this->getPresupuesto()) );
		
		$msg = $this->getError();
		
		if( !empty($msg) ){
			
			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
		
		$xtpl->assign( "lbl_submit", $this->localize("aprobarPresupuesto.confirm") );
		$xtpl->assign( "lbl_cancel", $this->localize("aprobarPresupuesto.cancel") );
		
	}


	public function getPresupuesto()
	{
	    return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
	    $this->presupuesto = $presupuesto;
	}
	
	public function setPresupuestoOid($presupuestoOid)
	{
		if(!empty($presupuestoOid)){
			$presupuesto = UIServiceFactory::getUIPresupuestoService()->get($presupuestoOid);
			$this->setPresupuesto($presupuesto);
		}
		
	    
	}
					
	public function getMsgError(){
		return "";
	}

	public function getError()
	{
	    return $this->error;
	}

	public function setError($error)
	{
	    $this->error = $error;
	}
}
?>