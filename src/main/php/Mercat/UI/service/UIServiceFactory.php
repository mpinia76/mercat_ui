<?php

namespace Mercat\UI\service;


/**
 * Factory de servicios de UI
 *  
 * @author Marcos
 * @since 01/03/2018
 *
 */
class UIServiceFactory {

	/*************** SEGURIDAD **/
	/**
	 * @return UIUsuarioService
	 */
	public static function getUIUsuarioService(){
	
		return \Rasty\Security\service\UIServiceFactory::getUIUsuarioService();	
	}

	/**
	 * @return UIUserService
	 */
	public static function getUIUserService(){
	
		return UIUserService::getInstance();	
	}
	
	/**
	 * @return UIClienteService
	 */
	public static function getUIClienteService(){
	
		return UIClienteService::getInstance();	
	}

    /**
     * @return UIEmpleadoService
     */
    public static function getUIEmpleadoService(){

        return UIEmpleadoService::getInstance();
    }
	

	
	/**
	 * @return UITipoProductoService
	 */
	public static function getUITipoProductoService(){
	
		return UITipoProductoService::getInstance();	
	}
	
	/**
	 * @return UIMarcaProductoService
	 */
	public static function getUIMarcaProductoService(){
	
		return UIMarcaProductoService::getInstance();	
	}
	
	/**
	 * @return UIIvaService
	 */
	public static function getUIIvaService(){
	
		return UIIvaService::getInstance();	
	}
	
	/**
	 * @return UIProductoService
	 */
	public static function getUIProductoService(){
	
		return UIProductoService::getInstance();	
	}
	
	/**
	 * @return UIPackService
	 */
	public static function getUIPackService(){
	
		return UIPackService::getInstance();	
	}	
	
	
	/**
	 * @return UIConceptoGastoService
	 */
	public static function getUIConceptoGastoService(){
	
		return UIConceptoGastoService::getInstance();	
	}
	
	/**
	 * @return UIConceptoMovimientoService
	 */
	public static function getUIConceptoMovimientoService(){
	
		return UIConceptoMovimientoService::getInstance();	
	}
	
	/**
	 * @return UIGastoService
	 */
	public static function getUIGastoService(){
	
		return UIGastoService::getInstance();	
	}
	
	/**
	 * @return UICuentaService
	 */
	public static function getUICuentaService(){
	
		return UICuentaService::getInstance();	
	}
	
	/**
	 * @return UIVentaService
	 */
	public static function getUIVentaService(){
	
		return UIVentaService::getInstance();	
	}
	
	/**
	 * @return UIMovimientoCajaService
	 */
	public static function getUIMovimientoCajaService(){
	
		return UIMovimientoCajaService::getInstance();	
	}
	
	/**
	 * @return UIMovimientoPedidoService
	 */
	public static function getUIMovimientoPedidoService(){
	
		return UIMovimientoPedidoService::getInstance();	
	}

	/**
	 * @return UICuentaCorrienteService
	 */
	public static function getUICuentaCorrienteService(){
	
		return UICuentaCorrienteService::getInstance();	
	}
	
	/**
	 * @return UITarjetaService
	 */
	public static function getUITarjetaService(){
	
		return UITarjetaService::getInstance();	
	}
	
	
	/**
	 * @return UIMovimientoVentaService
	 */
	public static function getUIMovimientoVentaService(){
	
		return UIMovimientoVentaService::getInstance();	
	}
	
	/**
	 * @return UIMovimientoGastoService
	 */
	public static function getUIMovimientoGastoService(){
	
		return UIMovimientoGastoService::getInstance();	
	}
	
	
	
	/**
	 * @return UIParametroService
	 */
	public static function getUIParametroService(){
	
		return UIParametroService::getInstance();	
	}
	
	/**
	 * @return UIPresupuestoService
	 */
	public static function getUIPresupuestoService(){
	
		return UIPresupuestoService::getInstance();	
	}
	
	/**
	 * @return UIComboService
	 */
	public static function getUIComboService(){
	
		return UIComboService::getInstance();	
	}
	
	/**
	 * @return UIBalanceService
	 */
	public static function getUIBalanceService(){
	
		return UIBalanceService::getInstance();	
	}
	
	/**
	 * @return UIVendedorService
	 */
	public static function getUIVendedorService(){
	
		return UIVendedorService::getInstance();	
	}
	
	/**
	 * @return UIDetalleVentaService
	 */
	public static function getUIDetalleVentaService(){
	
		return UIDetalleVentaService::getInstance();	
	}
	
	/**
	 * @return UIDevolucionVentaService
	 */
	public static function getUIDevolucionVentaService(){
	
		return UIDevolucionVentaService::getInstance();	
	}
	
	/**
	 * @return UIPedidoService
	 */
	public static function getUIPedidoService(){
	
		return UIPedidoService::getInstance();	
	}
	
	/**
	 * @return UIProveedorService
	 */
	public static function getUIProveedorService(){
	
		return UIProveedorService::getInstance();	
	}

    /**
     * @return UICajaService
     */
    public static function getUICajaService(){

        return UICajaService::getInstance();
    }

    /**
     * @return UIInformeDiarioDebitoCreditoService
     */
    public static function getUIInformeDiarioDebitoCreditoService(){

        return UIInformeDiarioDebitoCreditoService::getInstance();
    }

    /**
     * @return UIInformeSemanalService
     */
    public static function getUIInformeSemanalService(){

        return UIInformeSemanalService::getInstance();
    }
}