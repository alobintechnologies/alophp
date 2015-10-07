<?php

use League\Container\Container;

define('GLOABAL_VIEWS_PATH', __DIR__.'/../views');


/**
 * Dotenv setup
 */
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();


/**
 * Error handler
 */
$whoops = new \Whoops\Run;
if (getenv('MODE') === 'dev') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);	
} else {
    $whoops->pushHandler(function () {
        Response::create('Something broke', Response::HTTP_INTERNAL_SERVER_ERROR)->send();
    });
}
$whoops->register();

/**
 * Bugsnag Register 4bb0c217d0b9cfac312f9d6341b95bff
 */
$bugsnag = new Bugsnag_Client("4bb0c217d0b9cfac312f9d6341b95bff");
$bugsnag->setUser(array(
	'name' => 'RE Damaal',
	'email' => 'dreomeel@tim.com'
));

/**
 * Custom exception handler
 */
 function exception_handler($exception) {
	echo '<div class="alert alert-danger">';
	echo '<b>Fatal error</b>:  Uncaught exception \'' . get_class($exception) . '\' with message ';
	echo $exception->getMessage() . '<br>';
	echo 'Stack trace:<pre>' . $exception->getTraceAsString() . '</pre>';
	echo 'thrown in <b>' . $exception->getFile() . '</b> on line <b>' . $exception->getLine() . '</b><br>';
	echo '</div>';
}

function getFileLines($start = 0, $length = null, $filePath)
{
	$fileContents = file_get_contents($filePath);

	if (null !== ($contents = $fileContents)) {
		$lines = explode("\n", $contents);
		// Get a subset of lines from $start to $end
		if ($length !== null) {
			$start  = (int) $start;
			$length = (int) $length;
			if ($start < 0) {
				$start = 0;
			}
			if ($length <= 0) {
				throw new InvalidArgumentException(
					"\$length($length) cannot be lower or equal to 0"
				);
			}
			$lines = array_slice($lines, $start, $length, true);
		}
		return $lines;
	}
}

function exceptionHandler($exception) {

    // these are our templates
    $traceline = "#%s %s(%s): %s(%s)<br/> <pre class='code-block linenums'>%s</pre>";
    $msg = "PHP Fatal error:  Uncaught exception '%s' with message '%s' in %s:%s<br/>Stack trace:<br/>%s<br/>  thrown in %s on line %s";

    // alter your trace as you please, here
    $trace = $exception->getTrace();
    foreach ($trace as $key => $stackPoint) {
        // I'm converting arguments to their type
        // (prevents passwords from ever getting logged as anything other than 'string')
        $trace[$key]['args'] = array_map('gettype', $trace[$key]['args']);
    }

    // build your tracelines
    $result = array();
    foreach ($trace as $key => $stackPoint) {
		$line = $stackPoint['line'];
		$source = "";
		if($line !== null) {			
			$range = getFileLines($line - 8, 10, $stackPoint['file']);

			if($range) {
				$range = array_map(function($line) { return empty($line) ? ' ' : $line; }, $range);
				$start = key($range) + 1;
				$source = join("\n", $range);
			}
		}
        $result[] = sprintf(
            $traceline,
            $key,
            $stackPoint['file'],
            $stackPoint['line'],
            $stackPoint['function'],
            implode(', ', $stackPoint['args']),			
			$source
        );
    }
    // trace always ends with {main}
    $result[] = '#' . ++$key . ' {main}';

    // write tracelines into main template
    $msg = sprintf(
        $msg,
        get_class($exception),
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine(),
        implode("<br/>", $result),
        $exception->getFile(),
        $exception->getLine()
    );

    // log or echo as you please
    echo $msg;
}

/**
 * setting error handler and exception handler
 */
//set_error_handler(array($bugsnag, "errorHandler"));
//set_exception_handler(array($bugsnag, "exceptionHandler"));
//set_error_handler();
set_exception_handler('exceptionHandler');


/**
 * Container setup
 */
$container = new Container();
$container->add('PDO')
    ->withArgument(getenv('DB_CONN'))
    ->withArgument(getenv('DB_USER'))
    ->withArgument(getenv('DB_PASS'));

$container->add('Twig_Environment')
    ->withArgument(new Twig_Loader_Filesystem(__DIR__ . '/../views/'));

/**
 * Routes
 */
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $routes = require __DIR__ . '/routes.php';
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
});
