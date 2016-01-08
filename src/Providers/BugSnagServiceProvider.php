<?php
class BugSnagServiceProvider implements IRegisterServiceProvider
{
  public void register()
  {
    /**
     * Bugsnag Register 4bb0c217d0b9cfac312f9d6341b95bff
     */
    $bugsnag = new Bugsnag_Client("4bb0c217d0b9cfac312f9d6341b95bff");
    $bugsnag->setUser(array(
    	'name' => 'RE Damaal',
    	'email' => 'dreomeel@tim.com'
    ));

    set_error_handler(array($bugsnag, "errorHandler"));
    set_exception_handler(array($bugsnag, "exceptionHandler"));
  }
}
