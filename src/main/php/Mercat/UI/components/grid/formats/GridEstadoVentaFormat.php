<?php
namespace Mercat\UI\components\grid\formats;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\Core\model\EstadoVenta;
use Rasty\Grid\entitygrid\model\GridValueFormat;
use Rasty\i18n\Locale;

/**
 * Formato para renderizar el estado de una Venta
 *
 * @author Marcos
 * @since 13-03-2018
 *
 */

class GridEstadoVentaFormat extends  GridValueFormat{

	private $pattern;

	public function format( $value, $item=null ){

		if( !empty($value))
			return  Locale::localize( EstadoVenta::getLabel( $value ) );
		else $value;
	}

	public function getColumnCssClass($value, $item=null){

		//return MercatUIUtils::getEstadoVentaCss($value,'melisa');
	}

	public function getPattern(){
		return $this->pattern;
	}

}
