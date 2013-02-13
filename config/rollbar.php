<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
	// Disable Rollbar logging (e.g. set this to false in development environments to disable logging).
	'disabled'                  => TRUE,
	// Environment to include with log message.
	'environment'               => 'production',
	// Rollbar access token (needs post_server_item permission).
	'access_token'              => '',
	// Batched needs to be turned off because we are using the Kohana log system to batch send the messages.
	'batched'                   => FALSE,
);