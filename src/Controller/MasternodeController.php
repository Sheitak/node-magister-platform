<?php

namespace App\Controller;

use App\Entity\Masternode;
use App\Entity\Cryptocurrency;
use App\Form\MasternodeType;
use App\Repository\MasternodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/masternode")
 */
class MasternodeController extends AbstractController
{
    /**
     * @Route("/", name="masternode_index", methods={"GET"})
     */
    public function index(MasternodeRepository $masternodeRepository): Response
    {

        return $this->render('masternode/index.html.twig', [
            'masternodes' => $masternodeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{name}/new", name="masternode_new", requirements={"slug": "[a-z0-9\-]*"}, methods={"GET","POST"})
     * @IsGranted("ROLE_SUBSCRIBER")
     */
    public function new(Request $request, Cryptocurrency $cryptocurrency): Response
    {

        $masternode = new Masternode();
        $masternode->setUser($this->getUser());
        $masternode->setCryptocurrency($cryptocurrency);
        $form = $this->createForm(MasternodeType::class, $masternode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($masternode);
            $entityManager->flush();

            return $this->redirectToRoute('masternode_index');
        }

        return $this->render('masternode/new.html.twig', [
            'masternode' => $masternode,
            'cryptocurrency' => $cryptocurrency,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="masternode_show", methods={"GET"})
     */
    public function show(Masternode $masternode): Response
    {
        return $this->render('masternode/show.html.twig', [
            'masternode' => $masternode,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="masternode_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Masternode $masternode): Response
    {
        $form = $this->createForm(MasternodeType::class, $masternode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('masternode_index');
        }

        return $this->render('masternode/edit.html.twig', [
            'masternode' => $masternode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="masternode_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Masternode $masternode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$masternode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($masternode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('masternode_index');
    }
}
