<?php
namespace Mercat\UI\pages\bancos;

use Mercat\UI\service\UIServiceFactory;

use Mercat\UI\components\filter\model\UIMovimientoCajaCriteria;

use Mercat\UI\components\grid\model\MovimientoCajaGridModel;

use Mercat\UI\pages\MercatPage;

use Mercat\UI\utils\MercatUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

use Mercat\Core\criteria\MovimientoCajaCriteria;


/**
 * Página para consultar los movimientos de banco.
 *
 * @author Bernardo
 * @since 09-06-2014
 *
 */
class MovimientosBanco extends MercatPage{


    private $movimientoCuentaCriteria;

    /**
     * @return mixed
     */
    public function getMovimientoCuentaCriteria()
    {
        return $this->movimientoCuentaCriteria;
    }

    /**
     * @param mixed $movimientoCuentaCriteria
     */
    public function setMovimientoCuentaCriteria($movimientoCuentaCriteria)
    {
        $this->movimientoCuentaCriteria = $movimientoCuentaCriteria;
    }

	public function __construct(){
        $movimientoCuentaCriteria = new MovimientoCajaCriteria();


        $this->setMovimientoCuentaCriteria($movimientoCuentaCriteria);

	}

	public function getTitle(){
		return $this->localize( "banco.movimientos.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "cliente.agregar") );
//		$menuOption->setPageName("ClienteAgregar");
//		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
//		$menuGroup->addMenuOption( $menuOption );


		return array($menuGroup);
	}

	public function getType(){

		return "MovimientosBanco";

	}

	public function getModelClazz(){
		return get_class( new MovimientoCajaGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIMovimientoCajaCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );

        /*$movimientoCuentaFilter = $this->getComponentById("movimientosFilter");

        $movimientoCuentaFilter->fillFromSaved( $this->getMovimientoCuentaCriteria() );*/

       // $xtpl->assign("lbl_pdf", $this->localize("menu.productos.precios") );
        $xtpl->assign("linkPdf", $this->getLinkMovimientosPdf() );
        $xtpl->assign("linkXls", $this->getLinkMovimientosXls() );

        $xtpl->parse("main.opciones.add");
        $xtpl->parse("main.opciones");
	}

//	public function getBanco(){
//
//		//lo fijamos en la cuenta BAPRO.
//		return UIServiceFactory::getUICuentaService()->getCuentaBAPRO();
//	}
}
?>
