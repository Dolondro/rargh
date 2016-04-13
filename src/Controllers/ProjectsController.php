<?php

namespace Dolondro\Rargh\Controllers;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ProjectsController extends AbstractController
{
    public function index(Request $request, Application $app)
    {
        // This should almost certainly be abstracted to Yaml
        $projects = [
            "public_projects" => [
                [
                    "name" => "Cookbook",
                    "url" => $this->getRouteUrl("projects.cookbook.index"),
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
                ],
                [
                    "name" => "Helius",
                    "url" => $this->getRouteUrl("projects.helius.index"),
                    "description" =>
                        [
                            "The same person who owns the magical boiler also owns... some solar panels! The web interface for that is better ".
                            "that that for the boiler, but as with all things, it could be better",
                            "This scraping script just logs on using the appropriate credentials and then makes an AJAX request to the server to ".
                            "get the information back (which we can then put into a database, huzzah!)"
                        ]
                ],
                [
                    "name" => "Human Cluedo",
                    "url" => $this->getRouteUrl("projects.humancluedo.index"),
                    "description" => [
                        "Ever heard of human cluedo? I suspected not.",
                        "\"n\" people put their names, a location and a \"weapon\" into 3 hats.",
                        "You then draw an item from each and then attempt to kill the person by giving them the \"weapon\" in the location",
                        "This is a more randomised system that ensures you can't pick your name out of a hat."
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
