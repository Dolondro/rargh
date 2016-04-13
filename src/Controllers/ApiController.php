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
        $mode = $request->get("hub.mode");

        $verifyToken = $request->get("facebook.verify.token");
        if ($verifyToken!==$this->facebookVerifyToken) {
            return $this->application->json(["ok" => false, "message" => "Verification failed"], 401);
        }

        /**
         * hub.mode - The string "subscribe" is passed in this parameter
         * hub.challenge - A random string
         * hub.verify_token - The verify_token value you specified when you created the subscription
         */
        switch ($mode) {
            case "subscribe":
                $challenge = $request->get("hub.challenge");
                // Todo: Fix potential XSS attack here, but they'd have to get the verify token correct anyway... 
                return $this->application->json(["ok" => true, "challenge" => $challenge]);

        }
        
        return $this->application->json(["ok" => false, "mode" => $mode]);
    }
}