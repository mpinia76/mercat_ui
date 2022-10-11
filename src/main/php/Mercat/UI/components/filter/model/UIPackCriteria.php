<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\PackCriteria;

/**
 * Representa un criterio de búsqueda
 * para packs.
 * 
 * @author Marcos
 * @since 27/03/2019
 *
 */
class UIPackCriteria extends UIMercatCriteria{

	
	private $codigo;
	private $codigoExacto;
	private $nombre;
	private $producto;
	private $nombreOTipoOMarca;
	
	public function __construct(){

		parent::__construct();

	}
		
	
	
	protected function newCoreCriteria(){
		return new PackCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
		$criteria->setCodigo( $this->getCodigo() );		
		$criteria->setCodigoExacto( $this->getCodigoExacto() );		
		$criteria->setNombre( $this->getNombre() );
		$criteria->setProducto( $this->getProducto() );
		$criteria->setNombreOTipoOMarca( $this->getNombreOTipoOMarca() );
		return $criteria;
	}


	

	

	public function getCodigo()
	{
	    return $this->codigo;
	}

	public function setCodigo($codigo)
	{
	    $this->codigo = $codigo;
	}

	public function getCodigoExacto()
	{
	    return $this->codigoExacto;
	}

	public function setCodigoExacto($codigoExacto)
	{
	    $this->codigoExacto = $codigoExacto;
	}

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getProducto()
	{
	    return $this->producto;
	}

	public function setProducto($producto)
	{
	    $this->producto = $producto;
	}

	public function getNombreOTipoOMarca()
	{
	    return $this->nombreOTipoOMarca;
	}

	public function setNombreOTipoOMarca($nombreOTipoOMarca)
	{
	    $this->nombreOTipoOMarca = $nombreOTipoOMarca;
	}
}