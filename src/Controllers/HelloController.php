<?php
namespace App\Controllers;

class HelloController extends BaseController
{

    public function get()
    {
        return $this->view('home', array('message' => 'Domeel'));
    }

    public function home()
    {
        return $this->view('home', array('message' => 'Domeel'));
    }
}
