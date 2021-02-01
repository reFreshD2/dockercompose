<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/auth")
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/", name="auth")
     */
    public function index(UserRepository $userRepository)
    {
        $security = $userRepository->getCurrentSecurity();
        if ($security == null)
            return $this->render('auth/index.html.twig', [
                'message' => ''
            ]);
        switch ($security) {
            case "admin": return $this->redirectToRoute('admin');
            case "user": return $this->redirectToRoute('client');
        }
    }

    /**
     * @Route("/signIn", name="signIn", methods={"POST"})
     */
    public function signIn(Request $request, UserRepository $userRepository)
    {
        if (!$request->request->has('login') || !$request->request->has('password')) {
            return $this->render('auth/index.html.twig', [
                'message' => 'Login or password was empty'
            ]);
        }

        $log = $request->request->get('login');
        $pass = $request->request->get('password');

        $user = $userRepository->findOneBy(['login' => $log, 'password' => $pass]);

        if ($user != null) {
            setcookie("login", $log,0,'/');
            setcookie("password", $pass,0,'/');
            switch ($user->getSecurity()) {
                case "admin": return $this->redirectToRoute('admin');
                case "user": return $this->redirectToRoute('client');
            }
        } else {
            return $this->render('auth/index.html.twig', [
                'message' => 'Incorrect login or password'
            ]);
        }
    }
}
