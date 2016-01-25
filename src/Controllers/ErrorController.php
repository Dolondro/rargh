<?php


namespace Dolondro\Rargh\Controllers;


use Symfony\Component\HttpFoundation\Request;

class ErrorController extends AbstractController
{
    public function index(\Exception $e, Request $request, $code)
    {
        return $this->render([
            "code" => $code,
            "message" => $this->getMessage($code),
            "video" => $this->getVideo($code)
        ]);
    }

    protected function getMessage($code)
    {
        switch ($code) {
            case 404:
                return "Sorry, I can't help you. I don't know what you're looking for. Although...";

            case 500:
                return "Hmm, probably my bad. I'd say I've logged the error and I'll look into it, but I'd be lying";

            default:
                return "Yup. No clue what you've done. Definitely you though. Not me. My code is perfect.";
        }
    }

    protected function getVideo($code)
    {
        switch ($code) {
            case 404:
                return "https://www.youtube.com/embed/84RxK4N1wfE?autoplay=1";

            default:
                return false;
        }
    }
}