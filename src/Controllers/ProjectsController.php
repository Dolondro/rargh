<?php

namespace Dolondro\Rargh\Controllers;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ProjectsController extends AbstractController
{
    public function index(Request $request, Application $app)
    {
        $projects = [
            "public_projects" => [
                [
                    "name" => "Cooking",
                    "url" => $this->getRouteUrl("projects.cooking.index"),
                    "description" => [
                        "Assorted recipes that I'm slowly assembling! I'll probably create some kind of shopping list generator at some point",
                        "The real nice thing about this particular project is simply that it outputs it in JSON, which I maintain is actually the ".
                        "easiest way to read this sort of thing"
                    ]
                ]
            ],
            "private_projects" => [
                [
                    "name" => "Boiler",
                    "url" => $this->getRouteUrl("projects.boiler.index"),
                    "description" =>
                        [
                            "I know someone who has a magical boiler with a web interface. The people who created the software for the boiler ".
                            "did not do what I would describe as... an exemplary job.",
                            "This project is to allow us to get an idea of what the boiler is doing over an extended period of time by polling ".
                            "it frequently"
                        ]
                ]
            ]
        ];

        foreach ($projects as $type => $projectList) {
            foreach ($projectList as &$project) {
                if (!isset($project["description"])) {
                    $project["description"]=[];
                } elseif (!is_array($project["description"])) {
                    $project["description"]=[$project["description"]];
                }
            }
            unset($project);
        }

        return $this->render($projects);
    }
}
