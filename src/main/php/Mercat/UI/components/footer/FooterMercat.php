<?php

namespace Mercat\UI\components\footer;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;


class FooterMercat extends RastyComponent{


	public function __construct(){
	}

	public function getType(){

		return "FooterMercat";

	}

	protected function parseXTemplate(XTemplate $xtpl){

        $xtpl->assign('year', date('Y'));
	}

}
?>
