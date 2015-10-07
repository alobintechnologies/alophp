<?php

use Symfony\Component\HttpFoundation\Response;

class View
{
	
	public static function render($viewName, $attributes = [])
	{
		$twig = new Twig_Environment(new Twig_Loader_Filesystem(GLOABAL_VIEWS_PATH));

		return new Response($twig->render($viewName.'.html.twig', $attributes));
	}
}