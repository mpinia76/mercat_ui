<?php
namespace Accounts\UI\pages\bancos;

use Accounts\UI\pages\AccountsPage;




use Accounts\UI\utils\AccountsUIUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;
use Rasty\utils\LinkBuilder;



use Rasty\security\RastySecurityContext;

class MovimientosBancoXLS extends AccountsPage{



	public function __construct(){



	}

	public function getTitle(){
		return date('YmdHis').'_movimientos';
	}



	protected function parseXTemplate(XTemplate $xtpl){

		$title = $this->localize("admin_home.title");
		$subtitle = $this->localize("admin_home.subtitle");
		$xtpl->assign("app_title", $title );

	}




	public function getType(){

		return "MovimientosBancoXLS";

	}



}
?>
