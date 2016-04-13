<?php

namespace Dolondro\Rargh\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;

class AuthController extends AbstractController
{
    public function login(Application $application, Request $request)
    {
        return $this->render([
            "error" => $application['security.last_error']($request)
        ]);
    }
}