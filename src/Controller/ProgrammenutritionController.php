<?php

namespace App\Controller;

use App\Entity\Programmenutrition;
use App\Form\ProgrammenutritionType;
use App\Repository\ProgrammenutritionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/programmenutrition")
 */
class ProgrammenutritionController extends AbstractController
{
    /**
     * @Route("/", name="programmenutrition_index", methods={"GET"})
     */
    public function index(ProgrammenutritionRepository $programmenutritionRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT p FROM App\Entity\Programmenutrition p WHERE p.user = :user");
        $query->setParameter('user', $this->getUser());
        $programmenutritions = $query->getResult();
        return $this->render('programmenutrition/index.html.twig', [
            'programmenutritions' => $programmenutritions,
        ]);
    }

    /**
     * @Route("/new/{id}", name="programmenutrition_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT i FROM App\Entity\InfoUserNutrition i WHERE i.id = :id");
        $query->setParameter('id', $request->attributes->get('id'));
        $infoUserNutrition = $query->getSingleResult();
        $programmenutrition = new Programmenutrition();
        $programmenutrition->setInfoUserNutrition($infoUserNutrition);
        $form = $this->createForm(ProgrammenutritionType::class, $programmenutrition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programmenutrition->setUser($programmenutrition->getInfoUserNutrition()->getUser());
            $programmenutrition->setNutritionist($programmenutrition->getInfoUserNutrition()->getNutritionist());
            $infoUserNutrition->setProgrammenutrition($programmenutrition);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($programmenutrition);
            $entityManager->persist($infoUserNutrition);
            $entityManager->flush();

            return $this->redirectToRoute('info_user_nutrition_index');
        }

        return $this->render('programmenutrition/new.html.twig', [
            'programmenutrition' => $programmenutrition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="programmenutrition_show", methods={"GET"})
     */
    public function show(Programmenutrition $programmenutrition): Response
    {
        return $this->render('programmenutrition/show.html.twig', [
            'programmenutrition' => $programmenutrition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="programmenutrition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Programmenutrition $programmenutrition): Response
    {
        $form = $this->createForm(ProgrammenutritionType::class, $programmenutrition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('programmenutrition_index');
        }

        return $this->render('programmenutrition/edit.html.twig', [
            'programmenutrition' => $programmenutrition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="programmenutrition_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Programmenutrition $programmenutrition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programmenutrition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($programmenutrition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('programmenutrition_index');
    }
}
