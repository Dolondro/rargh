<?php


namespace Dolondro\Rargh\Controllers\projects;


use Dolondro\Rargh\Controllers\AbstractController;
use Symfony\Component\Console\Application;
use Symfony\Component\HttpFoundation\Request;

class HumanCluedoController extends AbstractController
{
    public function index(Request $request)
    {
        return $this->render([]);
    }
}