<?php

namespace Dolondro\Rargh\Controllers\Projects;

use Dolondro\HotStuff\Storage\StorageInterface;
use Dolondro\Rargh\Controllers\AbstractController;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class BoilerController extends AbstractController
{
    protected $storageInterface;

    public function __construct(StorageInterface $storageInterface)
    {
        $this->storageInterface = $storageInterface;
    }

    public function index(Request $request, Application $app)
    {
        $now = new \DateTime();
        $lastMonth = new \DateTime();
        $lastMonth->sub(new \DateInterval("P1M"));

        return $this->render([
            "startdate" => $lastMonth->format("Y-m-d"),
            "enddate" => $now->format("Y-m-d")
        ]);
    }

    public function download(Request $request)
    {
        $startdate = $request->get("startdate");
        $enddate = $request->get("enddate");
        $records = $this->storageInterface->between($startdate, $enddate);

        Header("Content-Type: application/octet-stream");
        Header("Content-Disposition: attachment");
        Header("Content-Disposition: attachment; filename=\"boiler.csv\"");

        $headerSent = false;
        foreach ($records as $row) {
            if ($row["data"]=='null') {
                continue;
            }
            $data = json_decode($row["data"], true);
            ksort($data);
            $outputData = ["datetime" => $row["datetime"]];
            $outputData = array_merge($outputData, $data);

            if (!$headerSent) {
                echo "\"".implode("\",\"", array_keys($outputData))."\"\n";
                $headerSent = true;
            }

            echo "\"".implode("\",\"", array_values($outputData))."\"\n";
        }
    }
}
