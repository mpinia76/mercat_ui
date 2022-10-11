<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\VendedorCriteria;

/**
 * Representa un criterio de búsqueda
 * para vendedores.
 * 
 * @author Marcos
 * @since 21/07/2020
 *
 */
class UIVendedorCriteria extends UIMercatCriteria{

	
	
	private $nombre;
	
	
	
	public function __construct(){

		parent::__construct();

	}
		
	
	
	protected function newCoreCriteria(){
		return new VendedorCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		$criteria->setNombre( $this->getNombre() );
		
		
		return $criteria;
	}


	

	

	

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}
}