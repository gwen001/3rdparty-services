<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ThirdParty
{
	const SERVICE_SEP = ',';
	
	const USER_AGENT = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0';

	const SERVICE_STATUS_UNKNOW    = 0;
	const SERVICE_STATUS_FOUND     = 1;
	const SERVICE_STATUS_DISABLE   = 2;
	const SERVICE_STATUS_NOT_FOUND = 3;

	const SERVICE_STATUS = [
		0 => 'Uknown status',
		1 => 'Service has been found',
		2 => 'Service seems to be disable/not allowed',
		3 => 'Service has been NOT FOUND',
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

	private $t_domain = [];

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
		return $this->t_domain;
	}
	public function setDomain( $v ) {
		if( is_file($v) ) {
			$this->t_domain = file( $v, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
		} else {
			$this->t_domain = [ trim($v) ];
		}
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
		
		$current_domain = 0;
		$current_service = 0;
		$n_domain = count( $this->t_domain );
		$n_service = count( $this->service );
		$n_safe = 0;
		$n_danger = 0;
		$n_vulnerable = 0;
		
		echo $n_domain." hosts to test on ".$n_service." services.\n\n";

		foreach( $this->t_domain as $d )
		{
			$current_domain++;
			$current_service = 0;
			
			foreach( $this->service as $s )
			{
				$current_service++;
				$class = $this->t_services[ $s ];
				
				echo "Host: ".$d." (".$current_domain."/".$n_domain."), Service: ".$class::SERVICE_NAME." (".$current_service."/".$n_service.")\n";
				
				$t_result = $class::test( $d, $n_test, $n_success );
				
				foreach( $t_result as $r ) {
					echo self::SERVICE_STATUS[ $r[1] ].' on '.$r[0].' according to '.self::TEST_METHOD[ $r[2] ]."\n";
				}
				
				echo 'Test passed ('.$n_success.'/'.$n_test.'), ';
				
				if( $n_success == $n_test ) {
					$n_vulnerable++;
					Utils::_println( 'the host seems to be VULNERABLE!', 'red' );
				} elseif( $n_success ) {
					$n_danger++;
					Utils::_println( 'the host seems to be in DANGER!', 'yellow' );
				} else {
					$n_safe++;
					Utils::_println( 'the host seems to be SAFE!', 'green' );
				}
			}
			
			echo "\n";
		}
		
		echo $current_domain." hosts tested, ".$n_safe." safe, ".$n_danger." in danger, ".$n_vulnerable." vulnerable.\n";
	}
}
