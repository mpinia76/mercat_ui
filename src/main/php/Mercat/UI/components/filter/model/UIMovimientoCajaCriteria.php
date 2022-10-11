<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\MovimientoCajaCriteria;

/**
 * Representa un criterio de búsqueda
 * para movimientos de cuenta.
 *
 * @author Marcos
 * @since 14/03/2018
 *
 */
class UIMovimientoCajaCriteria extends UIMercatCriteria{


	private $fecha;

	private $fechaDesde;

	private $fechaHasta;

	private $cuenta;

	private $cuentas;

	public function __construct(){

		parent::__construct();

	}

	protected function newCoreCriteria(){
		return new MovimientoCajaCriteria();
	}

	public function buildCoreCriteria(){

		$criteria = parent::buildCoreCriteria();

		$criteria->setFecha( $this->getFecha() );
		$criteria->setFechaDesde( $this->getFechaDesde() );
		$criteria->setFechaHasta( $this->getFechaHasta() );
		$criteria->setCuenta( $this->getCuenta() );
		$criteria->setCuentas( $this->getCuentas() );

		return $criteria;
	}


	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getFechaDesde()
	{
	    return $this->fechaDesde;
	}

	public function setFechaDesde($fechaDesde)
	{
	    $this->fechaDesde = $fechaDesde;
	}

	public function getFechaHasta()
	{
	    return $this->fechaHasta;
	}

	public function setFechaHasta($fechaHasta)
	{
	    $this->fechaHasta = $fechaHasta;
	}



	public function getCuenta()
	{
	    return $this->cuenta;
	}

	public function setCuenta($cuenta)
	{
	    $this->cuenta = $cuenta;
	}

	public function getCuentas()
	{
	    return $this->cuentas;
	}

	public function setCuentas($cuentas)
	{
	    $this->cuentas = $cuentas;
	}
}
