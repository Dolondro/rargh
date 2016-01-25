<?php


namespace Dolondro\Rargh\Controllers;


use Symfony\Component\HttpFoundation\Request;

class ErrorController extends AbstractController
{
    public function index(\Exception $e, Request $request, $code)
    {
        return $this->render(["code" => $code, "message" => $this->getMessage($code)]);
    }

    protected function getMessage($code)
    {
        switch ($code) {
            case 404:
                // This is a bit of a hacky way of doing it, but I think I'll manage to sleep at night
                return '<iframe width="1080" height="700" src="https://www.youtube.com/embed/84RxK4N1wfE?autoplay=1" frameborder="0" allowfullscreen></iframe>';

            case 500:
                return "Hmm, probably my bad. I'd say I've logged the error and I'll look into it, but I'd be lying";

            default:
                return "Yup. No clue what you've done. Definitely you though. Not me. My code is perfect.";
        }
    }
}