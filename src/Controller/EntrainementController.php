<?php

namespace App\Controller;

use App\Entity\Entrainement;
use App\Form\EntrainementType;
use App\Repository\EntrainementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entrainement")
 */
class EntrainementController extends AbstractController
{
    /**
     * @Route("/{id}", name="entrainement_index", methods={"GET"})
     */
    public function index(Request $request, EntrainementRepository $entrainementRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery
        ("SELECT c FROM App\Entity\Coach c WHERE c.id = :id");
        $query->setParameter('id', $request->attributes->get('id'));
        $coach = $query->getSingleResult();
        $query = $em->createQuery
        ("SELECT e FROM App\Entity\Entrainement e WHERE e.coach = :coach");
        $query->setParameter('coach', $coach);
        $entrainements = $query->getResult();
        return $this->render('entrainement/index.html.twig', [
            'entrainements' => $entrainements,
        ]);
    }

    /**
     * @Route("/coach/new/{jour}/{heure}", name="entrainement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entrainement = new Entrainement();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $query = $em->createQuery("SELECT c FROM App\Entity\Coach c WHERE c.user = :user");
        $query->setParameter('user', $user);
        $coach = $query->getSingleResult();
        $entrainement->setCoach($coach);
        $entrainement->setJour($request->attributes->get('jour'));
        $entrainement->setHeure($request->attributes->get('heure'));
        $form = $this->createForm(EntrainementType::class, $entrainement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entrainement);
            $entityManager->flush();

            return $this->redirect("/entrainement/".$entrainement->getCoach()->getId());
        }

        return $this->render('entrainement/new.html.twig', [
            'entrainement' => $entrainement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/coach/{id}", name="entrainement_show", methods={"GET"})
     */
    public function show(Entrainement $entrainement): Response
    {
        return $this->render('entrainement/show.html.twig', [
            'entrainement' => $entrainement,
        ]);
    }

    /**
     * @Route("/coach/{id}/edit", name="entrainement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entrainement $entrainement): Response
    {
        $form = $this->createForm(EntrainementType::class, $entrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect("/entrainement/".$entrainement->getCoach()->getId());
        }

        return $this->render('entrainement/edit.html.twig', [
            'entrainement' => $entrainement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/coach/{id}", name="entrainement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entrainement $entrainement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrainement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entrainement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entrainement_index');
    }
}
