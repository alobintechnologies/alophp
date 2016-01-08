<?php
namespace AloBug;

class ErroNotifier
{

  public function getFileLines($start = 0, $length = null, $filePath)
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

  /**
   * This module implemented for AloBug with dummy localhost ipaddress for testing purpose.
   */
  public function exceptionHandler($exception) {

      // these are our templates
      $traceline = "#%s %s(%s): %s(%s)\r\n <pre class='code-block linenums'>%s</pre>";
      $msg = "PHP Fatal error:  Uncaught exception '%s' with message '%s' in %s:%s\r\nStack trace:\r\n%s\r\n  thrown in %s on line %s";

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
  				$range[$line-1] = "<strong>".$range[$line-1]."</strong>";
  				$source = join("\r\n", $range);
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
          implode("\r\n", $result),
          $exception->getFile(),
          $exception->getLine()
      );


  	$curl = curl_init();

  	curl_setopt_array($curl, array(
  		CURLOPT_RETURNTRANSFER => 1,
  		CURLOPT_URL => 'http://192.168.0.6:81/api/projects/8a11b55c9e7ca56ac380039cf95ebbf9/errors',
  		CURLOPT_POST => 1,
  		CURLOPT_POSTFIELDS => array(
  			'error_name' => get_class($exception),
  			'error_desc' => $exception->getMessage(),
  			'error_data' => $msg
  		)
  	));

  	if(!curl_exec($curl)){
  		die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
  	}
  	curl_close($curl);

      // log or echo as you please
      echo $msg;
  }
}
