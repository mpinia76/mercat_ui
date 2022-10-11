<?php
namespace Mercat\UI\actions\clientes;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\service\UIServiceFactory;
use Mercat\Core\model\Cliente;
use Mercat\Core\utils\MercatUtils;

use Rasty\actions\JsonAction;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se eliminar un tipo de documento
 * 
 * @author Marcos
 * @since 02/03/2018
 */
class EliminarCliente extends JsonAction{

	
	public function execute(){

		try {

			$clienteOid = RastyUtils::getParamGET("clienteOid");
			
			//obtenemos la cliente
			$cliente = UIServiceFactory::getUIClienteService()->get($clienteOid);

			UIServiceFactory::getUIClienteService()->delete($cliente);
			
			$result["info"] = Locale::localize("cliente.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>