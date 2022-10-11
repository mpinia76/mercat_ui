<?php

namespace Cuentas\UI\Test;

use Cose\utils\Logger;
use Cuentas\UI\conf\CuentasUISetup;
use Cuentas\Core\conf\CuentasConfig;

class GenericTest extends \PHPUnit_Framework_TestCase{
	
	/**
	 * 
	 * @var \Cose\persistence\PersistenceContext
	 */
	//protected $persistenceContext;
	
	protected function setUp() {

		CuentasUISetup::initialize("cuentas_ui");		
		Logger::configure( dirname(__DIR__) . "/Test/conf/log4php.xml" );
		CuentasConfig::getInstance()->initLogger(dirname(__DIR__) . "/Test/conf/log4php.xml");
	}
	
	protected function tearDown() {

		$this->log("successful!", __CLASS__);
		
    }
    
    protected function log($msg, $clazz=__CLASS__){
    	Logger::log($msg, $clazz);
    }
    
    public static function logObject($msg, $clazz=__CLASS__){
    	Logger::logObject($msg, $clazz);
    } 
    
}
?>