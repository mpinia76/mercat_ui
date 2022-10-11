<?php
namespace Mercat\UI\components\filter\model;


use Mercat\UI\components\filter\model\UIMercatCriteria;

use Rasty\utils\RastyUtils;
use Mercat\Core\criteria\ClienteCriteria;
use Rasty\security\RastySecurityContext;
use Mercat\Core\utils\MercatUtils;

/**
 * Representa un criterio de búsqueda
 * para clientes.
 *
 * @author Marcos
 * @since 02/03/2018
 *
 */
class UIClienteCriteria extends UIMercatCriteria{


	private $nombre;
	private $documento;
	private $tieneCtaCte;
	private $tipoCliente;

	public function __construct(){

		parent::__construct();
        $user = RastySecurityContext::getUser();

        $user = MercatUtils::getUserByUsername($user->getUsername());

        /*if( MercatUtils::isAdmin($user)) {

        }
        else{
            $this->setTipoCliente(2);
        }*/

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
		return new ClienteCriteria();
	}

	public function buildCoreCriteria(){

		$criteria = parent::buildCoreCriteria();

		$criteria->setNombre( $this->getNombre() );
		$criteria->setDocumento( $this->getDocumento() );
		$criteria->setTieneCtaCte( $this->getTieneCtaCte() );
		$criteria->setTipoCliente( $this->getTipoCliente() );

		return $criteria;
	}


	public function getDocumento()
	{
	    return $this->documento;
	}

	public function setDocumento($documento)
	{
	    $this->documento = $documento;
	}

	public function getTieneCtaCte()
	{
	    return $this->tieneCtaCte;
	}

	public function setTieneCtaCte($tieneCtaCte)
	{
	    $this->tieneCtaCte = $tieneCtaCte;
	}

	public function getTipoCliente()
	{
	    return $this->tipoCliente;
	}

	public function setTipoCliente($tipoCliente)
	{
	    $this->tipoCliente = $tipoCliente;
	}
}
