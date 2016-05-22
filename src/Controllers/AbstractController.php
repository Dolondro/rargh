<?php

namespace Dolondro\Rargh\Controllers;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGenerator;

abstract class AbstractController
{
    /**
     * @var Application
     */
    protected $application;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var boolean
     */
    protected $debug;

    /**
     * @var UrlGenerator
     */
    protected $urlGenerator;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    public function setUrlGenerator(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function setApplication(Application $app)
    {
        $this->application = $app;
    }

    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function setTwig(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    protected function render($array = [])
    {
        $this->twig->addGlobal("request_path", $this->requestStack->getCurrentRequest()->getPathInfo());
        $calleeClass = get_called_class();
        $calleeMethod = debug_backtrace()[1]['function'];

        $exploded = explode("\\", $calleeClass);
        $calleeFinalPart = implode("/", array_merge(array_slice($exploded, 3, count($exploded)-4), [str_replace("Controller", "", end($exploded))]));
        $templateFilename = $calleeFinalPart."/".$calleeMethod.".twig";

        return $this->twig->render($templateFilename, $array);
    }

    protected function getRouteUrl($name)
    {
        if (!isset($this->urlGenerator)) {
            throw new \Exception("URLGenerator was not set");
        }

        return $this->urlGenerator->generate($name);
    }
}
