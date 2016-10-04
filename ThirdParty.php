<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ThirdParty
{
	const SERVICE_SEP = ',';

	const SERVICE_STATUS_UNKNOW    = 0;
	const SERVICE_STATUS_FOUND     = 1;
	const SERVICE_STATUS_DISABLE   = 2;
	const SERVICE_STATUS_NOT_FOUND = 3;

	const SERVICE_STATUS = [
		0 => 'uknown status',
		1 => 'service has been found',
		2 => 'service seems to be disable/not allowed',
		3 => 'service has NOT been found',
	];

	const TEST_METHOD_HTTP_HEADER  = 1;
	const TEST_METHOD_WEB_CONTENT  = 2;
	const TEST_METHOD_API_CALL     = 3;
	const TEST_METHOD_PING         = 4;

	const TEST_METHOD = [
		1 => 'http header',
		2 => 'web content',
		3 => 'api call',
		4 => 'system command ping',
	];

	private $domain = null;

	private $service = null;

	private $t_services = [];



	private function testService( $s ) {
		/*if( !is_subclass_of($s,'ThirdParty') ) {
			return false;
		}*/
		if( !method_exists($s,'test') ) {
			return false;
		}
		if( property_exists($s,'SERVICE_NAME') ) {
			return false;
		}
		return true;
	}


	public function registerService( $v ) {
		$v = trim( $v );
		$file = dirname(__FILE__).'/'.$v.'.php';
		if( !is_file($file) || !class_exists($v) ) {
			Utils::help( $v.' class not found' );
		}
		if( !$this->testService($v) ) {
			Utils::help( $v.' class wrongly configured' );
		}
		$this->t_services[ strtolower($v::SERVICE_NAME) ] = $v;
		ksort( $this->t_services );
		return true;;
	}
	public function getAvailableServices() {
		return array_keys($this->t_services);
	}


	public function getDomain() {
		return $this->domain;
	}
	public function setDomain( $v ) {
		$this->domain = trim( $v );
		return true;
	}


	public function getService() {
		return $this->service;
	}
	public function setService( $v ) {
		$this->service = explode( self::SERVICE_SEP, trim($v) );
		$this->service = array_map( 'trim', $this->service );
		$this->service = array_map( 'strtolower', $this->service );
		foreach( $this->service as $s ) {
			if( !isset($this->t_services[$s]) ) {
				Utils::help( $s.' service not supported' );
			}
		}
		return true;
	}


	public function run()
	{
		if( !$this->service ) {
			$this->service = array_keys( $this->t_services );
		}

//		var_dump( $this->t_services );
//		var_dump( $this->service );
//		exit();

		foreach( $this->service as $s ) {
			$class = $this->t_services[ $s ];
			echo "Testing ".$class::SERVICE_NAME.":\n";
			$t_result = $class::test( $this->domain );
			foreach( $t_result as $r ) {
				echo self::SERVICE_STATUS[ $r[1] ].' on '.$r[0].' according to '.self::TEST_METHOD[ $r[2] ]."\n";
			}
			echo "\n";
		}
	}
}
