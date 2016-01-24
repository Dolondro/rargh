<?php

namespace Dolondro\Rargh\Controllers\Projects;

use Dolondro\HotStuff\Storage\StorageInterface;
use Dolondro\Rargh\Controllers\AbstractController;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

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
            "enddate" => $now->format("Y-m-d"),
            "temperatureData" => $this->storageInterface->recentTemperature(new \DateInterval("P2D"))
        ]);
    }

    public function download(Request $request)
    {
        $startdate = $request->get("startdate");
        $enddate = $request->get("enddate");

        if (!$startdate) {
            throw new \Exception("startdate parameter is required");
        }

        if (!$enddate) {
            throw new \Exception("enddate
             parameter is required");
        }
        $records = $this->storageInterface->between($startdate, $enddate);

        $headerSent = false;
        $output = "";
        foreach ($records as $row) {
            if ($row["data"]=='null') {
                continue;
            }
            $data = json_decode($row["data"], true);
            ksort($data);
            $outputData = ["datetime" => $row["datetime"]];
            $outputData = array_merge($outputData, $data);

            if (!$headerSent) {
                $output.="\"".implode("\",\"", array_keys($outputData))."\"\n";
                $headerSent = true;
            }

            $output.="\"".implode("\",\"", array_values($outputData))."\"\n";
        }

        return new Response($output, 200, [
            "Content-Type" =>  "application/octet-stream",
            "Content-Disposition" => "attachment; filename=\"boiler.csv\""
        ]);
    }
}
