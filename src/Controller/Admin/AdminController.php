<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * Class AdminController
 * @package App\Controller\Admin
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index() {
        die("Bon");
    }
}