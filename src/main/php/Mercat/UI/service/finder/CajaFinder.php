<?php
namespace Mercat\UI\service\finder;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\filter\model\UICajaCriteria;

use Mercat\UI\service\UIServiceFactory;

use Rasty\Forms\finder\model\IAutocompleteFinder;

use Rasty\i18n\Locale;

/**
 * 
 * Finder para cajas.
 * 
 * @author Marcos
 * @since 13-10-2022
 */
class CajaFinder implements  IAutocompleteFinder {
	
	
	public function __construct() {}
	
	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::findEntitiesByText()
	 */
	public function findEntitiesByText( $text, $parent=null ){
		
		$uiCriteria = new UICajaCriteria();
		$uiCriteria->setNumero( $text );
		$uiCriteria->setRowPerPage( 10 );
		return UIServiceFactory::getUICajaService()->getList($uiCriteria);	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::findEntityByCode()
	 */
	function findEntityByCode( $code, $parent=null ){
		
		//$uiCriteria = new UIObraSocialCriteria();
		//$uiCriteria->setOid( $code );
		
		return UIServiceFactory::getUICajaService()->get( $code );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::getAttributes()
	 */
	public function getAttributes(){
		return array("numero", "cajero.oid", "cajero.nombre", "fecha", "horaApertura", "saldo");
	}

	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::getAttributesCallback()
	 */
	public function getAttributesCallback(){
		return array("oid", "numero", "cajero.oid", "cajero.nombre", "fecha", "horaApertura", "saldo");		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::getEntityCode()
	 */
	function getEntityCode( $entity ){
		if( !empty( $entity)  )
		
		return $entity->getOid();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::getEntityLabel()
	 */
	function getEntityLabel( $entity ){
		
		
		
		if( !empty( $entity)  ){
			$msg = Locale::localize("caja.toString");
			$params = array( $entity->getNumero(), $entity->getCajero(), MercatUIUtils::formatMontoToView($entity->getSaldo()) );
			return MercatUIUtils::formatMessage( $msg, $params);
		}
		
	}

	/**
	 * (non-PHPdoc)
	 * @see service/finder/Rasty\Forms\finder\model.IAutocompleteFinder::getEntityFieldCode()
	 */
	function getEntityFieldCode( $entity ){
		return "oid";
	}
	
	/**
	 * mensaje para cuando no hay resultados.
	 * @var string
	 */
	function getEmptyResultLabel(){
		return null;
	}
	
	/**
	 * label para agregar una nueva entity
	 * @var string
	 */
	function getAddEntityLabel(){
		return null;
	}
	
	/**
	 * función javascript a ejecutar para agregar una nueva entity.
	 * si esta property es definida se muestra el link cuando
	 * no hay resultados
	 * @var string
	 */
	function getOnclickAdd(){
		return "";
	}
}
?>