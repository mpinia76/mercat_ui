<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\utils\MercatUIUtils;
use Mercat\Core\utils\MercatUtils;
use Mercat\Core\model\EstadoPresupuesto;

use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\PresupuestoCriteria;

/**
 * Representa un criterio de búsqueda
 * para Presupuestos.
 * 
 * @author Marcos
 * @since 29-03-2019
 *
 */
class UIPresupuestoCriteria extends UIMercatCriteria{

	/* constantes para los filtros predefinidos */
	const HOY = "presupuestosHoy";
	const SEMANA_ACTUAL = "presupuestosSemanaActual";
	const MES_ACTUAL = "presupuestosMesActual";
	const ANIO_ACTUAL = "presupuestosAnioActual";
	const PENDIENTES = "presupuestosPendientes";
	const ANULADOS = "presupuestosAnulados";
	
	private $fechaDesde;
	
	private $fechaHasta;
	
	private $fecha;
				
	private $estados;
	
	private $estadoNotEqual;
	
	private $estado;
	
	public function __construct(){

		parent::__construct();
		
		//$this->setFiltroPredefinido( self::HOY );

	}
		
	protected function newCoreCriteria(){
		return new PresupuestoCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
		
		$criteria->setFechaDesde( $this->getFechaDesde() );
		$criteria->setFechaHasta( $this->getFechaHasta() );
		$criteria->setFecha( $this->getFecha() );
		$criteria->setEstados( $this->getEstados() );
		$criteria->setEstado( $this->getEstado() );
		
		
		return $criteria;
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

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getEstados()
	{
	    return $this->estados;
	}

	public function setEstados($estados)
	{
	    $this->estados = $estados;
	}

	public function getEstadoNotEqual()
	{
	    return $this->estadoNotEqual;
	}

	public function setEstadoNotEqual($estadoNotEqual)
	{
	    $this->estadoNotEqual = $estadoNotEqual;
	}

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}
	
	
	public function presupuestosHoy(){
	
		$this->setFecha( new \Datetime() );

	}
	
	
	public function presupuestosSemanaActual(){

		$fechaDesde = MercatUtils::getFirstDayOfWeek( new \Datetime() );
		$fechaHasta = MercatUtils::getLastDayOfWeek( new \Datetime());
	
		$this->setFechaDesde( $fechaDesde );
		$this->setFechaHasta( $fechaHasta );
	}
			
	public function presupuestosMesActual(){

		$fechaDesde = MercatUtils::getFirstDayOfMonth( new \Datetime() );
		$fechaHasta = MercatUtils::getLastDayOfMonth( new \Datetime());
	
		$this->setFechaDesde( $fechaDesde );
		$this->setFechaHasta( $fechaHasta );
			
	}
	
	public function presupuestosAnioActual(){

		$fechaDesde = MercatUtils::getFirstDayOfYear( new \Datetime() );
		$fechaHasta = MercatUtils::getLastDayOfYear( new \Datetime());
	
		$this->setFechaDesde( $fechaDesde );
		$this->setFechaHasta( $fechaHasta );
	}						
				
	public function presupuestosPendientes(){

		$this->setEstados( array(EstadoPresupuesto::Pendiente) );
			
	}				

	public function presupuestosAnulados(){

		$this->setEstado( EstadoPresupuesto::Anulado );
	}
	
}