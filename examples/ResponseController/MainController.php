<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        /*
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'message' => 'Welcome freeCodeCamp!'
        ]);
        */

        return new Response('<h1>Welcome freeCodeCamp!</h1>');
    }


    /**
     * @Route("/custom/{name?}", name="custom")
     *
     * {home?} does mean parameter is optional
     * @param Request $request
     * @return Response
     */
    public function custom(Request $request)
    {
        $name = $request->get('name');

        return new Response('<h1>Welcome '. $name .'</h1>');
    }
}
