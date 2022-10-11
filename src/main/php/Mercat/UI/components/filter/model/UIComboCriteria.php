<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\ComboCriteria;

/**
 * Representa un criterio de búsqueda
 * para combos.
 * 
 * @author Marcos
 * @since 28/08/2019
 *
 */
class UIComboCriteria extends UIMercatCriteria{

	
	
	private $nombre;
	
	
	
	public function __construct(){

		parent::__construct();

	}
		
	
	
	protected function newCoreCriteria(){
		return new ComboCriteria();
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