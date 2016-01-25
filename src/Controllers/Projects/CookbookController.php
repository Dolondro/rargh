<?php

namespace Dolondro\Rargh\Controllers\Projects;


use Dolondro\CookBook\RecipeCollection;
use Dolondro\Rargh\Controllers\AbstractController;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CookbookController extends AbstractController
{
    public function index(Request $request, Application $app)
    {
        $recipeCollection = new RecipeCollection();
        return $this->render([
            "recipes" => array_map(function($recipe) {
                return json_encode($recipe->get(), JSON_PRETTY_PRINT);
            }, $recipeCollection->getList())
        ]);
    }
}
