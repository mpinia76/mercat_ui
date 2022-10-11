<?php
namespace Mercat\UI\components\grid\formats;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\Core\model\Sucursal;
use Mercat\Core\model\Producto;
use Rasty\i18n\Locale;
use Rasty\Grid\entitygrid\model\GridValueFormat;

/**
 * Formato para porcentaje
 *
 * @author Bernardo
 * @since 10-06-2014
 *
 */

class GridPorcentajeFormat extends  GridValueFormat{

	public function __construct(){
	
	}
	
	public function format( $value, $item=null ){
		
		if( $value !=null )
			return  MercatUIUtils::formatPorcentajeToView($value);
		else $value;	
	}		
	

}