<?php defined('SYSPATH') or die('No direct script access.');

include Kohana::find_file('vendor', 'rollbar');

// Attach the log writer
Kohana::$log->attach(new Log_Rollbar);