<?php
namespace Frameworkless\Controllers;

use Symfony\Component\HttpFoundation\Response;

class HelloController
{
	private $twig;

	public function __construct(\Twig_Environment $twig)
	{
		$this->twig = $twig;
	}

    public function get()
    {
        //return new Response('Hello there!');
		return new Response($this->twig->render('home.html.twig', array('message' => 'Domeel')));
    }

	public function home()
	{
		for($i = 0; $i < 20; $i++)
			$a = 10/0;
		return \View::render('home', array('message' => 'Domeel'));
	}
}
