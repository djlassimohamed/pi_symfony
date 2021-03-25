<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="reclamation_index", methods={"GET"})
     */
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $query = $em->createQuery("SELECT r FROM App\Entity\Reclamation r WHERE r.user = :user");
        $query->setParameter('user', $user);
        $reclamations = $query->getResult();
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    /**
     * @Route("/admin/reclamation/display", name="reclamation_indexadmin", methods={"GET"})
     */
    public function indexadmin(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/indexadmin.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/reclamation/new", name="reclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reclamation = new Reclamation();
        $reclamation->setUser($this->getUser());
        $reclamation->setStatus("");
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setStatus("");
            $reclamation->setDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reclamation/{id}", name="reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/admin/reclamation/show/{id}", name="reclamation_show_admin", methods={"GET"})
     */
    public function showadmin(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show_admin.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/reclamation/{id}/edit", name="reclamation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reclamation $reclamation): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reclamation/{id}", name="reclamation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reclamation $reclamation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reclamation_index');
    }


    /**
     * @Route("/admin/reclamation/traiter/{id}", name="reclamation_traiter", methods={"GET","POST"})
     */
    public function TraiterAction(Request $request, $id)
    {
        $ef = $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()->getmanager()->getRepository(Reclamation::class)->find($id);
        $reclamation->setStatus("accepté") ;
        $ef->persist($reclamation);
        $ef->flush();
        return $this->redirectToRoute("reclamation_indexadmin");
    }

    /**
     * @Route("/admin/nontraiter/{id}", name="reclamation_nontraiter", methods={"GET","POST"})
     */
    public function NonTraiterAction(Request $request, $id)
    {
        $ef = $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()->getmanager()->getRepository(Reclamation::class)->find($id);
        $reclamation->setStatus("refusé") ;
        $ef->persist($reclamation);
        $ef->flush();
        return $this->redirectToRoute("reclamation_indexadmin");
    }
}
