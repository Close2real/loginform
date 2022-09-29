<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route(path: '/', name: 'app.home', methods: 'GET')]
    #[Route(path: '/login', name: 'app.login_form', methods: 'GET')]
    public function entryPoint(): Response
    {
        return $this->render("index.html.twig");
    }
}