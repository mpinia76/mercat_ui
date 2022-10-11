<?php
namespace Mercat\UI\components\grid\formats;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\Core\model\TipoCliente;
use Rasty\Grid\entitygrid\model\GridValueFormat;
use Rasty\i18n\Locale;

/**
 * Formato para renderizar el tipo de un cliente
 *
 * @author Marcos
 * @since 13-08-2020
 *
 */

class GridTipoClienteFormat extends  GridValueFormat{

	private $pattern;
	
	public function format( $value, $item=null ){
		
		if( !empty($value))
			return  Locale::localize( TipoCliente::getLabel( $value ) );
		else $value;	
	}		
	
	
	
	public function getPattern(){
		return $this->pattern;
	}
	
}