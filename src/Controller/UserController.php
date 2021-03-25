<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UsersRepository;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="users", methods={"GET"})
     */
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }
    /**
     * @Route("/admin/users/{id}", name="user_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/users/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Users $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('users');
    }


    /**
     * @Route("/admin/users1", name="user1", methods={"GET"})
     */
    public function index1(UsersRepository $usersRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT u FROM App\Entity\Users u WHERE u.roles LIKE '[]'");
        $users = $query->getResult();
        return $this->render('user/index1.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/admin/users2", name="user2", methods={"GET"})
     */
    public function index2(UsersRepository $usersRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT u FROM App\Entity\Users u WHERE u.roles LIKE '[]'");
        $users = $query->getResult();
        return $this->render('user/index2.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/admin/users3", name="user3", methods={"GET"})
     */
    public function index3(UsersRepository $usersRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT u FROM App\Entity\Users u WHERE u.roles LIKE '[]'");
        $users = $query->getResult();
        return $this->render('user/index3.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/coachs/{id}/{specialte}", name="coachs", methods={"GET"})
     */
    public function indexCoachs(Request $request, UsersRepository $usersRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT u FROM App\Entity\Users u WHERE u.roles LIKE '[\"ROLE_COACH\"]'");
        $users = $query->getResult();
        return $this->render('user/indexCoach.html.twig', [
            'users' => $users,
            'id' => $request->attributes->get('id'),
            'specialte' => $request->attributes->get('specialte')
        ]);
    }
    /**
     * @Route("/nutritionnistes/{id}", name="nutritionnistes", methods={"GET"})
     */
    public function indexNutritionnistes(Request $request, UsersRepository $usersRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT u FROM App\Entity\Users u WHERE u.roles LIKE '[\"ROLE_NUTRITIONIST\"]'");
        $users = $query->getResult();
        return $this->render('user/indexNutri.html.twig', [
            'users' => $users,
            'id' => $request->attributes->get('id')
        ]);
    }
    /**
     * @Route("/entrainement/list/coachs/", name="entrainement_coachs", methods={"GET"})
     */
    public function entrainementCoachs(Request $request, UsersRepository $usersRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery
        ("SELECT a FROM App\Entity\Abonnement a WHERE a.coach IS NOT NULL AND a.user = :user GROUP BY a.coach");
        $query->setParameter('user', $this->getUser());
        $abonnements = $query->getResult();
        return $this->render('user/entrainementCoachs.html.twig', [
            'abonnements' => $abonnements,
        ]);
    }
}
