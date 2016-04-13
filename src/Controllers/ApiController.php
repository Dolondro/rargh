<?php


namespace Dolondro\Rargh\Controllers;


use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    protected $facebookVerifyToken;

    public function __construct($facebookVerifyToken)
    {
        $this->facebookVerifyToken = $facebookVerifyToken;
    }

    public function facebook(Request $request)
    {
        if ($request->get("hub_verify_token")!==$this->facebookVerifyToken) {
            return $this->application->json(["ok" => false, "message" => "Verification failed"], 401);
        }

        /**
         * hub.mode - The string "subscribe" is passed in this parameter
         * hub.challenge - A random string
         * hub.verify_token - The verify_token value you specified when you created the subscription
         */
        switch ($request->get("hub_mode")) {
            case "subscribe":
                return $request->get("hub_challenge");

        }

        return $this->application->json(["ok" => false, "mode" => $request->get("hub_mode")]);
    }
}