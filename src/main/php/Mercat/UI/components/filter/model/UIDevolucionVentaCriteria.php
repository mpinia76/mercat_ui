<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\components\filter\model\UIMercatCriteria;
use Mercat\Core\utils\MercatUtils;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\DevolucionVentaCriteria;


/**
 * Representa un criterio de búsqueda
 * para gastos.
 * 
 * @author Marcos
 * @since 12/03/2018
 *
 */
class UIDevolucionVentaCriteria extends UIMercatCriteria{

	
	
	private $ventas;

	private $productos;
	
	
	
	public function __construct(){

		parent::__construct();
		
		

	}
		
	protected function newCoreCriteria(){
		return new DevolucionVentaCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		
		$criteria->setVentas( $this->getVentas() );
		$criteria->setProductos( $this->getProductos() );
		
		return $criteria;
	}

	

	public function getVentas()
	{
	    return $this->ventas;
	}

	public function setVentas($ventas)
	{
	    $this->ventas = $ventas;
	}

	public function getProductos()
	{
	    return $this->productos;
	}

	public function setProductos($productos)
	{
	    $this->productos = $productos;
	}
}