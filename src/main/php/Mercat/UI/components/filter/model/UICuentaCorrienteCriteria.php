<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\CuentaCorrienteCriteria;

/**
 * Representa un criterio de búsqueda
 * para tiposProducto.
 * 
 * @author Marcos
 * @since 07/04/2018
 *
 */
class UICuentaCorrienteCriteria extends UIMercatCriteria{


	private $cliente;
	
	
	
	public function __construct(){

		parent::__construct();

	}
		
	

	
	protected function newCoreCriteria(){
		return new CuentaCorrienteCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		$criteria->setCliente( $this->getCliente() );
		
		return $criteria;
	}


	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}

	
}