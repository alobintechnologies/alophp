<<<<<<< HEAD
# Frameworkless
Blog post: https://medium.com/@mmeyer/frameworkless-or-how-i-use-php-bf0b119536ad

Frameworkless is a simple example of how you can use just a few composer packages to create an awesomely-simple diy micro-framework. Check out the code for usage examples, everything is extremely simple and easy to understand.

## Using Twig
If you're not just serving up JSON and raw responses, you might want to check out Twig. To use it, run: "composer require twig/twig". Then, inside of app.php, add:
````
$container->add('Twig_Environment')
    ->withArgument(new Twig_Loader_Filesystem(__DIR__ . '/../views/'));
````
Create a "views" directory inside of your project, and start adding *.html.twig files. To return a response with twig, inside of your controller, first add:
````
private $twig;

public function __construct(Twig_Environment $twig)
{
    $this->twig = $twig;
}
````
This will tell the container to inject a Twig_Environment instance to your controller. From there, inside a method add:
````
return new Response($this->twig->render('page.html.twig', $data));
````
## Spot (ORM)
If you'd like to use an ORM with frameworkless instead PDO, it's easy to add Spot:

```
composer require vlucas/spot2
```

from here, edit ``bootstrap/app.php`` and add spot to the container:

```php
$db = new \Spot\Config();
$db->addConnection('mysql', [
    'dbname' => getenv('DB_NAME'),
    'user' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'host' => getenv('DB_HOST')
]);

$container->add('\Spot\Locator')
    ->withArgument($db);
```
From here you can add models to any directory under src/, which will be autoloaded by composer. For example ( ``src/Models/Posts.php``): 

```php
namespace Frameworkless\Models;

class Posts extends \Spot\Entity
{
    protected static $table = 'posts';
}

```

And finally from your controller:

```php
private $spot;

public function __construct(\Spot\Locator $spot)
{
    $this->spot = $spot;
}

public function get()
{
    $posts = $this->spot->mapper('Frameworkless\Models\Posts')->all();
    return new Response('Here are your posts' . print_r($posts, true));
}
```

## Contributing
File an issue, or even better, submit a pull request. I'll review it asap. You can also email me at: mcm1792 at rit.edu
=======
# alophp
This is a framework for php with composer packages 
>>>>>>> 2c4511d0f5a665245cc7f6c1cc88f76fe2650a2a
