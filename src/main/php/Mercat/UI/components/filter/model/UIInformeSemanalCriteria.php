<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\InformeSemanalCriteria;

/**
 * Representa un criterio de búsqueda
 * para informes semanales.
 * 
 * @author Marcos
 * @since 14/10/2022
 *
 */
class UIInformeSemanalCriteria extends UIMercatCriteria{

	private $mes;
		
	public function __construct(){

		parent::__construct();

	}
		
	protected function newCoreCriteria(){
		return new InformeSemanalCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		$criteria->setMes( $this->getMes() );
		
		return $criteria;
	}



	public function getMes()
	{
	    return $this->mes;
	}

	public function setMes($mes)
	{
	    $this->mes = $mes;
	}
}