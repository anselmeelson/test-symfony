<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function index() {
        return $this->redirectToRoute('home');
    }
}