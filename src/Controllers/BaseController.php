<?php
namespace AloPHP/Controllers;

class Controller
{
	private $view;

	public function __construct(Twig_Environment $twig)
	{
		$this->view = $twig;
	}

}