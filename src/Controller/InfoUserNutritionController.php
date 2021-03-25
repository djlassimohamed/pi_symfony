<?php

namespace App\Controller;

use App\Entity\InfoUserNutrition;
use App\Form\InfoUserNutritionType;
use App\Repository\InfoUserNutritionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/info/user/nutrition")
 */
class InfoUserNutritionController extends AbstractController
{
    /**
     * @Route("/", name="info_user_nutrition_index", methods={"GET"})
     */
    public function index(InfoUserNutritionRepository $infoUserNutritionRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT n FROM App\Entity\Nutritionist n WHERE n.user = :user");
        $user = $this->getUser();
        $query->setParameter('user', $user);
        $nutri = $query->getSingleResult();
        $query = $em->createQuery
        ("SELECT i FROM App\Entity\InfoUserNutrition i WHERE i.programmenutrition is NULL AND i.nutritionist = :nutri");
        $query->setParameter('nutri', $nutri);
        $programmenutritions = $query->getResult();
        return $this->render('info_user_nutrition/index.html.twig', [
            'info_user_nutritions' => $programmenutritions,
        ]);
    }
    /**
     * @Route("/{id}/programmer", name="info_user_nutrition_programmer", methods={"GET","POST"})
     */
    public function programmer(Request $request, InfoUserNutrition $infoUserNutrition): Response
    {
        return $this->redirect("/programmenutrition/new/".$infoUserNutrition->getId());
    }
    /**
     * @Route("/new/{id}", name="info_user_nutrition_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT a FROM App\Entity\Abonnement a WHERE a.id = :idAb");
        $query->setParameter('idAb', $request->attributes->get('id'));
        $abonnement = $query->getSingleResult();
        $infoUserNutrition = new InfoUserNutrition();
        $infoUserNutrition->setAbonnement($abonnement);
        $infoUserNutrition->setNutritionist($abonnement->getNutritionist());
        $form = $this->createForm(InfoUserNutritionType::class, $infoUserNutrition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoUserNutrition->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($infoUserNutrition);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('info_user_nutrition/new.html.twig', [
            'info_user_nutrition' => $infoUserNutrition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="info_user_nutrition_show", methods={"GET"})
     */
    public function show(InfoUserNutrition $infoUserNutrition): Response
    {
        return $this->render('info_user_nutrition/show.html.twig', [
            'info_user_nutrition' => $infoUserNutrition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="info_user_nutrition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, InfoUserNutrition $infoUserNutrition): Response
    {
        $form = $this->createForm(InfoUserNutritionType::class, $infoUserNutrition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('info_user_nutrition_index');
        }

        return $this->render('info_user_nutrition/edit.html.twig', [
            'info_user_nutrition' => $infoUserNutrition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="info_user_nutrition_delete", methods={"DELETE"})
     */
    public function delete(Request $request, InfoUserNutrition $infoUserNutrition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$infoUserNutrition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($infoUserNutrition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('info_user_nutrition_index');
    }
}
