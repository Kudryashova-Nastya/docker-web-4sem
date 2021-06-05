<?php


namespace App\Api\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test")
 */
class TestController
{
    /**
     * @Route(path="/", methods={"GET"})
     */
    public function index()
    {
        return new Response(
            '<h1>Где это я?</h1><img src="https://image.flaticon.com/icons/png/512/1864/1864514.png">',
            Response::HTTP_OK,
            [
                'Content-type' => 'text/html'
            ]
        );
    }



    /**
     * @Route(path="/users", methods={"GET"})
     */
    public function users()
    {
        return new Response(
            '<h1>Кто это я?</h1><img src="https://image.flaticon.com/icons/png/512/1864/1864474.png">',
            Response::HTTP_OK,
            [
                'Content-type' => 'text/html'
            ]
        );
    }
}
