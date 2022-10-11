<?php
namespace Mercat\UI\components\filter\model;


use Datetime;
use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\ProductoCriteria;

/**
 * Representa un criterio de búsqueda
 * para productos.
 *
 * @author Marcos
 * @since 06/03/2018
 *
 */
class UIProductoCriteria extends UIMercatCriteria{

	const POR_VENCER = "productosPorVencer";
	const STOCK_MINIMO = "productosDebajoStockMinimo";
	private $codigo;
	private $codigoExacto;
	private $nombre;
	private $tipoProducto;
	private $marcaProducto;
	private $nombreOTipoOMarca;
	private $vencimientoHasta;
	private $stockMinimo;
	private $fecha;
	private $cliente;
	private $vendedor;
	private $porcentajeGanancia2;
    private $fechaDesde;


    private $fechaHasta;
	public function __construct(){

	    parent::__construct();
		$fecha = new DateTime();
		$this->setFecha($fecha);
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
		return new ProductoCriteria();
	}

	public function buildCoreCriteria(){

		$criteria = parent::buildCoreCriteria();
		$criteria->setCodigo( $this->getCodigo() );
		$criteria->setCodigoExacto( $this->getCodigoExacto() );
		$criteria->setNombre( $this->getNombre() );
		$criteria->setTipoProducto( $this->getTipoProducto() );
		$criteria->setMarcaProducto( $this->getMarcaProducto() );
		$criteria->setNombreOTipoOMarca( $this->getNombreOTipoOMarca() );
		$criteria->setVencimientoHasta( $this->getVencimientoHasta() );
		$criteria->setStockMinimo( $this->getStockMinimo() );
		$criteria->setVendedor( $this->getVendedor() );
		$criteria->setPorcentajeGanancia2( $this->getPorcentajeGanancia2() );
		return $criteria;
	}




	public function getTipoProducto()
	{
	    return $this->tipoProducto;
	}

	public function setTipoProducto($tipoProducto)
	{
	    $this->tipoProducto = $tipoProducto;
	}

	public function getMarcaProducto()
	{
	    return $this->marcaProducto;
	}

	public function setMarcaProducto($marcaProducto)
	{
	    $this->marcaProducto = $marcaProducto;
	}

	public function getNombreOTipoOMarca()
	{
	    return $this->nombreOTipoOMarca;
	}

	public function setNombreOTipoOMarca($nombreOTipoOMarca)
	{
	    $this->nombreOTipoOMarca = $nombreOTipoOMarca;
	}

	public function productosPorVencer(){

		$vencimientoHasta = new Datetime();
		$vencimientoHasta->modify("+30 day");

		$this->setVencimientoHasta($vencimientoHasta);

		$this->addOrder("vencimiento", "ASC");


	}

	public function productosDebajoStockMinimo(){
		$this->setStockMinimo(1);
	}

	public function getCodigo()
	{
	    return $this->codigo;
	}

	public function setCodigo($codigo)
	{
	    $this->codigo = $codigo;
	}

	public function getVencimientoHasta()
	{
	    return $this->vencimientoHasta;
	}

	public function setVencimientoHasta($vencimientoHasta)
	{
	    $this->vencimientoHasta = $vencimientoHasta;
	}

	public function getStockMinimo()
	{
	    return $this->stockMinimo;
	}

	public function setStockMinimo($stockMinimo)
	{
	    $this->stockMinimo = $stockMinimo;
	}

	public function getCodigoExacto()
	{
	    return $this->codigoExacto;
	}

	public function setCodigoExacto($codigoExacto)
	{
	    $this->codigoExacto = $codigoExacto;
	}

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}

	public function getVendedor()
	{
	    return $this->vendedor;
	}

	public function setVendedor($vendedor)
	{
	    $this->vendedor = $vendedor;
	}

	public function getPorcentajeGanancia2()
	{
	    return $this->porcentajeGanancia2;
	}

	public function setPorcentajeGanancia2($porcentajeGanancia2)
	{
	    $this->porcentajeGanancia2 = $porcentajeGanancia2;
	}


    /**
     * @return mixed
     */
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * @param mixed $fechaDesde
     */
    public function setFechaDesde($fechaDesde)
    {
        $this->fechaDesde = $fechaDesde;
    }

    /**
     * @return mixed
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * @param mixed $fechaHasta
     */
    public function setFechaHasta($fechaHasta)
    {
        $this->fechaHasta = $fechaHasta;
    }

}
