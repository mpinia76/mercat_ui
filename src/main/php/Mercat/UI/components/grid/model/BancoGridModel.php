<?php
namespace Mercat\UI\components\grid\model;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Mercat\UI\utils\MercatUIUtils;

use Mercat\UI\components\grid\formats\GridImporteFormat;



use Mercat\UI\components\filter\model\UIBancoCriteria;

use Rasty\Grid\entitygrid\EntityGrid;
use Rasty\Grid\entitygrid\model\EntityGridModel;
use Rasty\Grid\entitygrid\model\GridModelBuilder;
use Rasty\Grid\filter\model\UICriteria;
use Rasty\Grid\entitygrid\model\GridDatetimeFormat;
use Mercat\UI\service\UIServiceFactory;
use Rasty\utils\RastyUtils;
use Rasty\utils\Logger;

use Rasty\Menu\menu\model\MenuOption;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuActionOption;
use Rasty\Menu\menu\model\MenuActionAjaxOption;

/**
 * Model para la grilla de Bancos.
 *
 * @author Marcos
 * @since 06/03/2021
 */
class BancoGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();

    }

    public function getService(){

    	return UIServiceFactory::getUIBancoService();
    }

    public function getFilter(){
//
    	$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "bancosfilter" );
		$componentConfig->setType( "BancoFilter" );
//
//		//TODO esto setearlo en el .rasty
	    return ComponentFactory::buildByType($componentConfig, $this);

    	/*$filter = new UIBancoCriteria();

		return $filter;  */

    }

	protected function initModel() {

		$this->setHasCheckboxes( false );

		$column = GridModelBuilder::buildColumn( "oid", "banco.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );

        $column = GridModelBuilder::buildColumn( "nombre", "banco.nombre", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
        $this->addColumn( $column );

        $column = GridModelBuilder::buildColumn( "numero", "banco.numero", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
        $this->addColumn( $column );

        $column = GridModelBuilder::buildColumn( "saldoInicial", "banco.saldoInicial", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
        $this->addColumn( $column );

        $column = GridModelBuilder::buildColumn( "saldo", "banco.saldo", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
        $this->addColumn( $column );


	}

	public function getDefaultFilterField() {
        return "oid";
    }

	public function getDefaultOrderField(){
		return "oid";
	}

	public function getDefaultOrderType(){
		return "DESC";
	}

    /**
	 * opciones de menú dado el item
	 * @param unknown_type $item
	 */
	public function getMenuGroups( $item ){

        $group = new MenuGroup();
        $group->setLabel("grupo");
        $options = array();

        $menuOption = new MenuOption();
        $menuOption->setLabel( $this->localize( "menu.bancos.modificar") );
        $menuOption->setPageName( "BancoModificar" );
        $menuOption->addParam("oid",$item->getOid());
        $menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
        $options[] = $menuOption ;






        $menuOption = new MenuActionAjaxOption();
        $menuOption->setLabel( $this->localize( "menu.banco.eliminar") );
        $menuOption->setActionName( "EliminarBanco" );
        $menuOption->setConfirmMessage( $this->localize( "banco.eliminar.confirm.msg") );
        $menuOption->setConfirmTitle( $this->localize( "banco.eliminar.confirm.title") );
        $menuOption->setOnSuccessCallback( "eliminarCallback" );
        $menuOption->addParam("bancoOid",$item->getOid());
        $menuOption->setImageSource( $this->getWebPath() . "css/images/eliminar_32.png" );
        $options[] = $menuOption ;

        $group->setMenuOptions( $options );

        return array( $group );

	}

	public function getRowStyleClass($item){

		//return MercatUIUtils::getEstadoBancoCss($item->getEstado());

	}



}
?>
