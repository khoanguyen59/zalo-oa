<?php
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Routing\AnnotatedRouteControllerLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Composer\Autoload\ClassLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;

/** @var ClassLoader $loader */
$loader = require __DIR__ . '/vendor/autoload.php';
// AnnotationRegistry::registerLoader([$loader, 'loadClass']);
$loader = new AnnotationDirectoryLoader(
    new FileLocator(__DIR__ . '/src/Controller/'),
    new AnnotatedRouteControllerLoader(
        new AnnotationReader()
    )
);

$routes = $loader->load(__DIR__ . '/src/Controller/');
$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());
$matcher = new UrlMatcher($routes, $context);
$parameters = $matcher->match($context->getPathInfo());
$controllerInfo = explode('::',$parameters['_controller']);
var_dump($parameters);
$controller = new $controllerInfo[0];
$action = $controllerInfo[1];
$controller->$action();