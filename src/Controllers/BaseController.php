<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController
{
		private $view;

		public function __construct(\Twig_Environment $twig)
		{
				$this->view = $twig;
		}

		public function view($viewName, $attr = [])
		{
				return new Response($this->view->render($viewName . '.html.twig', $attr));
		}

		public function response($value)
		{
				return new Response($value);
		}

		public function jsonResult($value)
		{
				return new JsonResponse($value);
		}

}
