<?php

namespace Mercat\UI\layouts;

use Rasty\Layout\layout\Rasty\Layout;

use Rasty\utils\XTemplate;


class MercatLoginMetroLayout extends MercatMetroLayout{

	public function getXTemplate($file_template=null){
		return parent::getXTemplate( dirname(__DIR__) . "/layouts/MercatLoginMetroLayout.htm" );
	}

	public function getType(){
		
		return "MercatLoginMetroLayout";
		
	}	

}
?>