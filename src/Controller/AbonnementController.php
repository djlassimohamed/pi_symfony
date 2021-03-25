<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Users;
use App\Form\AbonnementType;
use App\Repository\AbonnementRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class AbonnementController extends AbstractController
{
    /**
     * @Route("/admin/abonnement", name="abonnement_index", methods={"GET"})
     */
    public function index(AbonnementRepository $abonnementRepository): Response
    {
        return $this->render('abonnement/index.html.twig', [
            'abonnements' => $abonnementRepository->findAll(),
        ]);
    }
    /**
     * @Route("/abonnement/entrainement", name="abonnement_entrainement", methods={"GET"})
     */
    public function indexEntrainement(): Response
    {
        return $this->render('abonnement/indexAbonnementEntrainement.html.twig', []);
    }
    /**
     * @Route("/abonnement/entrainement/{nbr}/{specialte}/new", name="abonnement_entrainement_new", methods={"GET","POST"})
     */
    public function newAbonnementEntrainement(Request $request): Response
    {
        $abonnement = new Abonnement();
        $abonnement->setUser($this->getUser());
        $abonnement->setDateDebut(new \DateTime());
        $abonnement->setDuree($request->attributes->get('nbr'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($abonnement);
        $entityManager->flush();

        return $this->redirect("/coachs/".$abonnement->getId()."/".$request->attributes->get('specialte'));
    }
    /**
     * @Route("/abonnement/entrainement/affectation/{idA}/{idUserCoach}", name="abonnement_coach_affectation", methods={"GET","POST"})
     */
    public function newAbonnementCoachAffectation(Request $request, AbonnementRepository $abonnementRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT a FROM App\Entity\Abonnement a WHERE a.id = :idAb");
        $query->setParameter('idAb', $request->attributes->get('idA'));
        $abonnement = $query->getSingleResult();
        $query = $em->createQuery("SELECT u FROM App\Entity\Users u WHERE u.id = :idU");
        $query->setParameter('idU', $request->attributes->get('idUserCoach'));
        $user = $query->getSingleResult();
        $query = $em->createQuery("SELECT c FROM App\Entity\Coach c WHERE c.user = :user");
        $query->setParameter('user', $user);
        $coach = $query->getSingleResult();
        $abonnement->setCoach($coach);
        $em->persist($abonnement);
        $em->flush();

        return $this->redirectToRoute('index');
    }
    /**
     * @Route("/abonnement/nutritionniste", name="abonnement_nutri", methods={"GET"})
     */
    public function indexNutri(): Response
    {
        return $this->render('abonnement/indexAbonnementNutri.html.twig', []);
    }
    /**
     * @Route("/abonnement/nutritionniste/{nbr}/new", name="abonnement_nutri_new", methods={"GET","POST"})
     */
    public function newAbonnementNutri(Request $request): Response
    {
        $abonnement = new Abonnement();
        $abonnement->setUser($this->getUser());
        $abonnement->setDateDebut(new \DateTime());
        $abonnement->setDuree($request->attributes->get('nbr'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($abonnement);
        $entityManager->flush();

        return $this->redirect("/nutritionnistes/".$abonnement->getId());
    }
    /**
     * @Route("/abonnement/nutritionniste/affectation/{idA}/{idUserNutri}", name="abonnement_nutri_affectation", methods={"GET","POST"})
     */
    public function newAbonnementNutriAffectation(Request $request, AbonnementRepository $abonnementRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT a FROM App\Entity\Abonnement a WHERE a.id = :idAb");
        $query->setParameter('idAb', $request->attributes->get('idA'));
        $abonnement = $query->getSingleResult();
        $query = $em->createQuery("SELECT u FROM App\Entity\Users u WHERE u.id = :idU");
        $query->setParameter('idU', $request->attributes->get('idUserNutri'));
        $user = $query->getSingleResult();
        $query = $em->createQuery("SELECT n FROM App\Entity\Nutritionist n WHERE n.user = :user");
        $query->setParameter('user', $user);
        $nutritionist = $query->getSingleResult();
        $abonnement->setNutritionist($nutritionist);
        $em->persist($abonnement);
        $em->flush();

        return $this->redirect("/info/user/nutrition/new/".$abonnement->getId());
        //return $this->redirectToRoute('info_user_nutrition_new');
    }

    /**
     * @Route("/admin/abonnement/{id}/new", name="abonnement_new", methods={"GET","POST"})
     */
    public function new(Request $request, Users $user, UsersRepository $usersRepository): Response
    {
        $abonnement = new Abonnement();
        $abonnement->setUser($user);
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($abonnement->getDuree() > 0){
                $abonnement->setDateDebut(new \DateTime());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($abonnement);
                $entityManager->flush();

                return $this->redirectToRoute('abonnement_index');
            }
        }

        return $this->render('abonnement/new.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/abonnement", name="abonnement_new1", methods={"GET","POST"})
     */
    public function new1(Request $request): Response
    {
        $abonnement = new Abonnement();
        $abonnement->setUser($this->getUser());
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($abonnement->getDuree() > 0){  // Besoin ajout verification sur la date de début
                $abonnement->setDateDebut(new \DateTime());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($abonnement);
                $entityManager->flush();

                return $this->redirectToRoute('index');
            }
        }

        return $this->render('abonnement/new1.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ]);
    }
//    /**
//     * @Route("/admin/abonnement/new", name="abonnement_new", methods={"GET","POST"})
//     */
//    public function new(Request $request): Response
//    {
//        $abonnement = new Abonnement();
//        $form = $this->createForm(AbonnementType::class, $abonnement);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($abonnement);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('abonnement_index');
//        }
//
//        return $this->render('abonnement/new.html.twig', [
//            'abonnement' => $abonnement,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/admin/abonnement/{id}", name="abonnement_show", methods={"GET"})
     */
    public function show(Abonnement $abonnement): Response
    {
        return $this->render('abonnement/show.html.twig', [
            'abonnement' => $abonnement,
        ]);
    }

    /**
     * @Route("/admin/abonnement/{id}/edit", name="abonnement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Abonnement $abonnement): Response
    {
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($abonnement->getDuree() > 0) {  // Besoin ajout verification sur la date de début
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('abonnement_index');
            }
        }

        return $this->render('abonnement/edit.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/abonnement/{id}", name="abonnement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Abonnement $abonnement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonnement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($abonnement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('abonnement_index');
    }
}
