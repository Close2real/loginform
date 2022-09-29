<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/unauthorized', name: 'app.unauthorized', methods: 'GET')]
    public function entryPoint(): Response
    {
        return $this->render("index.html.twig");
    }

    #[Route(path: '/login', name: 'app.login', options: ['expose' => true], methods: 'POST')]
    public function login()
    {
    }

    #[Route(path: '/logout', name: 'app.logout', options: ['expose' => true])]
    public function logout()
    {
    }
}
