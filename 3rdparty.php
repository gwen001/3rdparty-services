#!/usr/bin/php
<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

function __autoload( $c ) {
	include( $c.'.php' );
}


set_time_limit( 0 );


// parse command line
{
	$tparty = new ThirdParty();
	$tparty->registerService( 'ServiceZendesk' );
	$tparty->registerService( 'ServiceStatusPage' );
	$tparty->registerService( 'ServiceSquarespace' );
	$tparty->registerService( 'ServiceHeroku' );
	$tparty->registerService( 'ServiceGitHub' );
	$tparty->registerService( 'ServiceFastly' );
	$tparty->registerService( 'ServiceHelpScout' );
	$tparty->registerService( 'ServiceWordpress' );
//	$tparty->registerService( 'ServiceThisMoment' );
//	$tparty->registerService( 'ServiceAmazon' );

	$argc = $_SERVER['argc'] - 1;

	for( $i=1 ; $i<=$argc ; $i++ ) {
		switch( $_SERVER['argv'][$i] ) {
			case '-d':
				$tparty->setDomain( $_SERVER['argv'][$i+1] );
				$i++;
				break;

			case '-l':
				Utils::help( implode(',',$tparty->getAvailableServices()) );

			case '-s':
				$tparty->setService( $_SERVER['argv'][$i+1] );
				$i++;
				break;

			case '-h':
				Utils::help();
				break;

			default:
				Utils::help( 'Unknown option: '.$_SERVER['argv'][$i] );
		}
	}

	if( !$tparty->getDomain() ) {
		Utils::help( 'Domain not found' );
	}
}
// ---


// main loop
{
	$tparty->run();
}
// ---


exit();
