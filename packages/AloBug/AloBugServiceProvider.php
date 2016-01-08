<?php
namespace AloBug;

class AloBugServiceProvider implements IRegisterServiceProvider
{
  public void register()
  {
    // register the AloBug initial requirements in here.
    set_exception_handler(new ErrorNotifier()->exceptionHandler);
  }
}
