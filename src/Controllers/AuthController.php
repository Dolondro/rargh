<?php

namespace Dolondro\Rargh\Controllers;

use Dolondro\Rargh\Services\Authentication;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;

class AuthController extends AbstractController
{
    protected $authentication;

    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }


    public function login(Application $application, Request $request)
    {
        if ($this->authentication->isLoggedIn()) {
            return $application->redirect($this->getRouteUrl("index"));
        } else {
            return $this->render([
                "error" => $application['security.last_error']($request)
            ]);
        }
    }

    public function loginAttempt(Application $application, Request $request)
    {

        $password = $request->get("password");
        //$loggedIn = ($password == $this->password);

        $this->session->set("logged_in", false);

        return $application->redirect("/login");
    }
}