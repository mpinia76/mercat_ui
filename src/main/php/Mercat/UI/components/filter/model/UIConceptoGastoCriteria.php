<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\ConceptoGastoCriteria;

/**
 * Representa un criterio de búsqueda
 * para conceptoGastos.
 * 
 * @author Marcos
 * @since 09/03/2018
 *
 */
class UIConceptoGastoCriteria extends UIMercatCriteria{


	private $nombre;
	
	
	public function __construct(){

		parent::__construct();

	}
		
	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	
	protected function newCoreCriteria(){
		return new ConceptoGastoCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		$criteria->setNombre( $this->getNombre() );
		
		return $criteria;
	}

}