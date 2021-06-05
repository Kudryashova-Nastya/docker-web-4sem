<?php


namespace App\Core\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route(path="/")
     */
    public function indexAction()
    {
        return new Response(
            "<h1>Главная страница без защиты</h1>",
            Response::HTTP_OK,
            [
                'Content-type' => 'text/html'
            ]
        );
    }
}
