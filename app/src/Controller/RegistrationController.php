<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index(UserRepository $userRepository)
    {
        $security = $userRepository->getCurrentSecurity();
        if ($security == null) {
            return $this->render('registration/index.html.twig', [
                'message' => '',
            ]);
        }
        switch ($security) {
            case "admin": return $this->redirectToRoute('admin');
            case "user": return $this->redirectToRoute('client');
        }
    }

    /**
     * @Route("/signUp", name="signUp", methods={"POST"})
     */
    public function signUp(Request $request, UserRepository $userRepository)
    {
        if (!$request->request->has('login') || !$request->request->has('password') || !$request->request->has('phone')) {
            return $this->render('registration/index.html.twig', [
                'message' => 'Some field was empty'
            ]);
        }

        $log = $request->request->get('login');

        $user = $userRepository->findOneBy(['login' => $log]);

        if ($user != null) {
           return $this->render('registration/index.html.twig', [
               'message' => 'Login in use by another user'
           ]);
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $pass = $request->request->get('password');
            $phone = $request->request->get('phone');
            $newUser = new User();
            $newUser->setLogin($log);
            $newUser->setPassword($pass);
            $newUser->setPhone($phone);
            $newUser->setSecurity("user");
            $entityManager->persist($newUser);
            $entityManager->flush();
            setcookie("login", $log,0,'/');
            setcookie("password", $pass,0,'/');
            return $this->redirectToRoute('client');
        }
    }
}
