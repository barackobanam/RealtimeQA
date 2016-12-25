<?php
/**
* A sample configuration file
*
* The variables below need to be filled out with environment specific data.
*
* @author Jason Lengstorf <jason@lengstorf.com>
* @author Phil Leggetter <phil@leggetter.co.uk>
*/
// Set up an array for constants
$_C = array();
//-----------------------------------------------------------------------------
// General configuration options
//-----------------------------------------------------------------------------
$_C['APP_TIMEZONE'] = 'US/Pacific';
//-----------------------------------------------------------------------------
// Database credentials
//-----------------------------------------------------------------------------
$_C['DB_HOST'] = 'localhost';
$_C['DB_NAME'] = 'real_time';
$_C['DB_USER'] = 'root';
$_C['DB_PASS'] = '';
//-----------------------------------------------------------------------------
//// Pusher credentials
//-----------------------------------------------------------------------------
$_C['PUSHER_KEY'] = '536ec15a8a294db3f7a2';
$_C['PUSHER_SECRET'] = '0570cf10acf2cf5a5ba7';
$_C['PUSHER_APPID'] = '252065';
//-----------------------------------------------------------------------------
// Enable debug mode (strict error reporting)
//-----------------------------------------------------------------------------
$_C['DEBUG'] = TRUE;
//-----------------------------------------------------------------------------// Converts the constants array into actual constants
//-----------------------------------------------------------------------------
foreach ($_C as $constant=>$value) {
define($constant, $value);
}