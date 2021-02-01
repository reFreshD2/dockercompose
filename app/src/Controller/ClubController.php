<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

/**
 * @Route("client/club")
 */
class ClubController extends AbstractController
{
    /**
     * @Route("/", name="club_index", methods={"GET"})
     */
    public function index(ClubRepository $clubRepository,UserRepository $userRepository): Response
    {
        if ($userRepository->getCurrentSecurity() == "user") {
            return $this->render('club/index.html.twig', [
                'clubs' => $clubRepository->findAll(),
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/new", name="club_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        if ($userRepository->getCurrentSecurity() == "user") {$club = new Club();
            $form = $this->createForm(ClubType::class, $club);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $user = $userRepository->findOneBy(['login'=>$_COOKIE['login']]);
                $club->addMember($user);
                $entityManager->persist($club);
                $entityManager->flush();
                return $this->redirectToRoute('club_index');
            }

            return $this->render('club/new.html.twig', [
                'club' => $club,
                'form' => $form->createView(),
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/join/{id}", name="join_club", methods={"GET"})
     */
    public function joinClub(UserRepository $userRepository, Club $club){
        if ($userRepository->getCurrentSecurity() == "user") {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $userRepository->findOneBy(['login'=>$_COOKIE['login']]);
            $club->addMember($user);
            $entityManager->persist($club);
            $entityManager->flush();
            return $this->redirectToRoute('club_index');
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }
}
