<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $userRepository)
    {
        if ($userRepository->getCurrentSecurity() == "admin") {
            return $this->render('admin/index.html.twig');
        }  else {throw $this->createNotFoundException('Not found');}
    }

    /**
     * @Route("/exit", name="exit")
     */
    public function exit(){
        setcookie("login", "",time() - 3600,'/');
        setcookie("password", "",time() - 3600,'/');
        return $this->redirectToRoute('auth');
    }
}
