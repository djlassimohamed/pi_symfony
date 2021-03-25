<?php

namespace App\Controller;

use App\Entity\Nutritionist;
use App\Entity\Users;
use App\Form\NutritionistType;
use App\Repository\NutritionistRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/nutritionist")
 */
class NutritionistController extends AbstractController
{
    /**
     * @Route("/", name="nutritionist_index", methods={"GET"})
     */
    public function index(NutritionistRepository $nutritionistRepository): Response
    {
        return $this->render('nutritionist/index.html.twig', [
            'nutritionists' => $nutritionistRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="nutritionist_new", methods={"GET","POST"})
     */
    public function new(Request $request, Users $user, UsersRepository $usersRepository): Response
    {
        $nutritionist = new Nutritionist();
        $nutritionist->setUser($user);
        $form = $this->createForm(NutritionistType::class, $nutritionist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($nutritionist->getSalary()>0) {
                $u = $usersRepository->find($user);
                $u->setRoles(["ROLE_NUTRITIONIST"]);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($u);
                $entityManager->flush();
                $entityManager->persist($nutritionist);
                $entityManager->flush();

                return $this->redirectToRoute('nutritionist_index');
            }
        }

        return $this->render('nutritionist/new.html.twig', [
            'nutritionist' => $nutritionist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nutritionist_show", methods={"GET"})
     */
    public function show(Nutritionist $nutritionist): Response
    {
        return $this->render('nutritionist/show.html.twig', [
            'nutritionist' => $nutritionist,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nutritionist_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Nutritionist $nutritionist): Response
    {
        $form = $this->createForm(NutritionistType::class, $nutritionist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($nutritionist->getSalary()>0) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('nutritionist_index');
            }
        }

        return $this->render('nutritionist/edit.html.twig', [
            'nutritionist' => $nutritionist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nutritionist_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Nutritionist $nutritionist, UsersRepository $usersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nutritionist->getId(), $request->request->get('_token'))) {
            $user = $nutritionist->getUser();
            $user->setRoles([]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $entityManager->remove($nutritionist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nutritionist_index');
    }
}
