<?php

namespace App\Controller;

use App\Entity\Cryptocurrency;
use App\Entity\CryptocurrencySearch;
use App\Form\CryptocurrencySearchType as FormCryptocurrencySearchType;
use App\Form\CryptocurrencyType;
use App\Repository\CryptocurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CoinGeckoService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/cryptocurrency")
 */
class CryptocurrencyController extends AbstractController
{
    /**
     * @Route("/listing", name="cryptocurrency_index", methods={"GET"})
     */
    public function index(
        CryptocurrencyRepository $cryptocurrencyRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $search = new CryptocurrencySearch();
        $form = $this->createForm(FormCryptocurrencySearchType::class, $search);
        $form->handleRequest($request);

        $cryptocurrencies = $paginator->paginate(
            $cryptocurrencyRepository->findCryptoQuery($search),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );

        return $this->render('cryptocurrency/index.html.twig', [
            'cryptocurrencies' => $cryptocurrencies,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="cryptocurrency_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $cryptocurrency = new Cryptocurrency();
        $form = $this->createForm(CryptocurrencyType::class, $cryptocurrency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cryptocurrency);
            $entityManager->flush();
            $this->addFlash('success', 'Create with success !');

            return $this->redirectToRoute('cryptocurrency_index');
        }

        return $this->render('cryptocurrency/new.html.twig', [
            'cryptocurrency' => $cryptocurrency,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}-{ticker}", name="cryptocurrency_show", requirements={"slug": "[a-z0-9\-]*"}, methods={"GET"})
     * @IsGranted("ROLE_SUBSCRIBER")
     */
    public function show(string $slug, Cryptocurrency $cryptocurrency, CoinGeckoService $coinGeckoClient): Response
    {
        $slugify = $cryptocurrency->getSlug();

        if ($slugify !== $slug) {
            return $this->redirectToRoute('cryptocurrency_show', [
                'ticker' => $cryptocurrency->getTicker(),
                'slug' => $slugify,
            ], 301);
        }

        // Récupération des données API CoinGecko
        $crypto = $coinGeckoClient->CoinGeckoClient();
        $chart = $coinGeckoClient->CoinGeckoChart();

        return $this->render('cryptocurrency/show.html.twig', [
            'cryptocurrency' => $cryptocurrency,
            'crypto' => $crypto,
            'chart' => $chart,
        ]);
    }

    /**
     * @Route("/{name}/edit", name="cryptocurrency_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Cryptocurrency $cryptocurrency): Response
    {
        $form = $this->createForm(CryptocurrencyType::class, $cryptocurrency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Edit with success !');

            return $this->redirectToRoute('cryptocurrency_index');
        }

        return $this->render('cryptocurrency/edit.html.twig', [
            'cryptocurrency' => $cryptocurrency,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cryptocurrency_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Cryptocurrency $cryptocurrency): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cryptocurrency->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cryptocurrency);
            $entityManager->flush();
            $this->addFlash('success', 'Delete with success !');
        }

        return $this->redirectToRoute('cryptocurrency_index');
    }
}
