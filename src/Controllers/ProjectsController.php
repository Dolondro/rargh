<?php

namespace Dolondro\Rargh\Controllers;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ProjectsController extends AbstractController
{
    public function index(Request $request, Application $app)
    {
        return $this->render([
            "public_projects" => [
                [
                    "name" => "Cooking",
                    "url" => $this->getRouteUrl("projects.cooking.index")
                ]
            ],
            "private_projects" => [
                [
                    "name" => "Boiler",
                    "url" => $this->getRouteUrl("projects.boiler.index")
                ]
            ]
        ]);
    }
}
