<?php

namespace Dolondro\Rargh\Controllers\Projects;


use Dolondro\Cooking\RecipeCollection;
use Dolondro\Rargh\Controllers\AbstractController;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class BoilerController extends AbstractController
{
    public function index(Request $request, Application $app)
    {
        return $this->render([]);
    }
}
