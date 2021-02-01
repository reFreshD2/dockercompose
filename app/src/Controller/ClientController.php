<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\AuctionRepository;
use App\Repository\LotRepository;
use App\Repository\BueRepository;
use App\Entity\Auction;
use App\Entity\Lot;
use App\Entity\Bue;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client")
     */
    public function index(UserRepository $userRepository)
    {
        if ($userRepository->getCurrentSecurity() == "user") {
            return $this->render('client/index.html.twig');
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/exit", name="exit")
     */
    public function exit()
    {
        setcookie("login", "", time() - 3600, '/');
        setcookie("password", "", time() - 3600, '/');
        return $this->redirectToRoute('auth');
    }

    /**
     * @Route("/auctions", name="user_auctions")
     */
    public function showAuctions(UserRepository $userRepository, AuctionRepository $auctionRepository)
    {
        if ($userRepository->getCurrentSecurity() == "user") {
            return $this->render('client/auctions.html.twig', [
                'auctions' => $auctionRepository->getCurrentAuctions(),
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/auctions/{id}", name="visit", methods={"GET"})
     */
    public function visit(Auction $auction, UserRepository $userRepository, LotRepository $lotRepository)
    {
        if ($userRepository->getCurrentSecurity() == "user") {
            return $this->render('client/lotsofauctions.html.twig', [
                'lots' => $lotRepository->getCurrentLot($auction),
                'id' => $auction->getId()
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/auctions/{id}/add", name="add_lot", methods={"GET"})
     */
    public function show_add(Auction $auction, UserRepository $userRepository)
    {
        if ($userRepository->getCurrentSecurity() == "user") {
            return $this->render('client/addlot.html.twig', [
                'id' => $auction->getId(),
                'message' => ''
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/auctions/{id}/buy", name="buy_lot", methods={"GET"})
     */
    public function buy(UserRepository $userRepository, Lot $lot)
    {
        if ($userRepository->getCurrentSecurity() == "user") {
            $entityManager = $this->getDoctrine()->getManager();
            $buy = new Bue();
            $user = $userRepository->findOneBy(['login' => $_COOKIE['login']]);
            $buy->setLot($lot);
            $buy->setBuyer($user);
            $entityManager->persist($buy);
            $entityManager->flush();
            return $this->redirectToRoute('user_auctions');
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/auctions/{id}/add/confirm", name="adding", methods={"POST"})
     */
    public function add(Auction $auction, UserRepository $userRepository, Request $request, LotRepository $lotRepository)
    {
        if ($userRepository->getCurrentSecurity() == "user") {
            if (!$request->request->has('name') || !$request->request->has('price')) {
                return $this->render('client/addlot.html.twig', [
                    'id' => $auction->getId(),
                    'message' => 'Some field was empty'
                ]);
            }

            $name = $request->request->get('name');

            $lot = $lotRepository->findOneBy(['name' => $name]);

            if ($lot != null) {
                return $this->render('client/addlot.html.twig', [
                    'id' => $auction->getId(),
                    'message' => 'Lot already was add'
                ]);
            } else {
                $entityManager = $this->getDoctrine()->getManager();
                $price = $request->request->get('price');
                $newLot = new Lot();
                $newLot->setName($name);
                $newLot->setPrice($price);
                $newLot->setAuction($auction);
                $newLot->setSeller($userRepository->findOneBy(['login' => $_COOKIE['login']]));
                $entityManager->persist($newLot);
                $entityManager->flush();
                return $this->redirectToRoute('visit', [
                    'id' => $auction->getId()]);
            }
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/home", name="home")
     */
    public function showHome(UserRepository $userRepository)
    {
        if ($userRepository->getCurrentSecurity() == "user") {
            return $this->render('client/home.html.twig', [
                'user' => $userRepository->findOneBy(['login' => $_COOKIE['login']])
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/home/lots", name="my_lot")
     */
    public function showLots(UserRepository $userRepository, LotRepository $lotRepository)
    {
        if ($userRepository->getCurrentSecurity() == "user") {
            $user = $userRepository->findOneBy(['login' => $_COOKIE['login']]);
            return $this->render('client/home.lot.html.twig', [
                'user' => $user,
                'lots' => $lotRepository->findBy(['seller' => $user])
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }

    /**
     * @Route("/home/buyes", name="my_buyes")
     */
    public function showBuyes(UserRepository $userRepository, BueRepository $bueRepository)
    {
        if ($userRepository->getCurrentSecurity() == "user") {
            $user = $userRepository->findOneBy(['login' => $_COOKIE['login']]);
            return $this->render('client/home.buyes.html.twig', [
                'user' => $user,
                'buyes' => $bueRepository->findBy(['buyer' => $user])
            ]);
        } else {
            throw $this->createNotFoundException('Not found');
        }
    }
}
