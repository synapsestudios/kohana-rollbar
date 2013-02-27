<?php defined('SYSPATH') OR die('No direct script access.');

class Log_Rollbar extends Log_Writer {

	public function write( array $messages)
	{
		// Load the Rollbar config
		$config = Kohana::$config->load('rollbar')
			->as_array();

		// If logging is disabled do nothing.
		if (isset($config['disabled']) AND $config['disabled'])
			return;

		// Create a new Rollbar notifier instance.
		$rollbar = new RollbarNotifier($config);

		try
		{
			// Try to get information about the active user.
			$user = Auth::instance()->get_user() ?: new Model_User;

			if ($user->loaded())
			{
				$rollbar->person = array(
					'id'     => $user->id,
					'email'  => $user->email,
				);
			}
		}
		catch(Exception $e)
		{
			// Log writers can't throw exceptions.
		}

		// Send the log messages to Rollbar.
		foreach ($messages as $message)
		{
			if (isset($message['additional']['exception']))
			{
				// If we have an exception log that.
				$rollbar->report_exception($message['additional']['exception']);
			}
			else
			{
				// Otherwise log the message with additional data.
				$rollbar->report_message($message['body'], $this->_log_levels[$message['level']], $message['additional']);
			}
		}

		unset($rollbar, $user);
	}
}