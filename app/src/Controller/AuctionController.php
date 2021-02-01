<?php

namespace App\Controller;

use App\Entity\Auction;
use App\Form\AuctionType;
use App\Repository\AuctionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

/**
 * @Route("/auction")
 */
class AuctionController extends AbstractController
{
    /**
     * @Route("/", name="auction_index", methods={"GET"})
     */
    public function index(AuctionRepository $auctionRepository, UserRepository $userRepository): Response
    {
        if ($userRepository->getCurrentSecurity() == "admin") {
            return $this->render('auction/index.html.twig', [
                'auctions' => $auctionRepository->findAll(),
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/new", name="auction_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        if ($userRepository->getCurrentSecurity() == "admin") {
            $auction = new Auction();
            $form = $this->createForm(AuctionType::class, $auction);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($auction);
                $entityManager->flush();

                return $this->redirectToRoute('auction_index');
            }

            return $this->render('auction/new.html.twig', [
                'auction' => $auction,
                'form' => $form->createView(),
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/{id}", name="auction_show", methods={"GET"})
     */
    public function show(Auction $auction, UserRepository $userRepository): Response
    {
        if ($userRepository->getCurrentSecurity() == "admin") {
            return $this->render('auction/show.html.twig', [
                'auction' => $auction,
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/{id}/edit", name="auction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Auction $auction, UserRepository $userRepository): Response
    {
        if ($userRepository->getCurrentSecurity() == "admin") {
            $form = $this->createForm(AuctionType::class, $auction);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('auction_index');
            }

            return $this->render('auction/edit.html.twig', [
                'auction' => $auction,
                'form' => $form->createView(),
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/{id}", name="auction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Auction $auction, UserRepository $userRepository): Response
    {
        if ($userRepository->getCurrentSecurity() == "admin") {
            if ($this->isCsrfTokenValid('delete' . $auction->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($auction);
                $entityManager->flush();
            }

            return $this->redirectToRoute('auction_index');
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }
}
