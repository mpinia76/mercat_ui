<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\InformeDiarioDebitoCreditoCriteria;

/**
 * Representa un criterio de búsqueda
 * para informes diarios de débito y crédito.
 * 
 * @author Marcos
 * @since 14/10/2022
 *
 */
class UIInformeDiarioDebitoCreditoCriteria extends UIMercatCriteria{

	private $mes;
	
	private $estado;
		
	public function __construct(){

		parent::__construct();

	}
		
	protected function newCoreCriteria(){
		return new InformeDiarioDebitoCreditoCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		$criteria->setMes( $this->getMes() );
		$criteria->setEstado( $this->getEstado() );
		
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

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}
}