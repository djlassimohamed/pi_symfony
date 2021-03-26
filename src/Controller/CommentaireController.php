<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/{id}/", name="commentaire_index", methods={"GET","POST"})
     */
    public function index(Request $request, CommentaireRepository $commentaireRepository, Post $post, PostRepository $postRepository, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT c FROM App\Entity\Commentaire c WHERE c.post = :post");
        $query->setParameter('post', $post);
        $commentaires = $query->getResult();

        $commentaire = new Commentaire();
        $commentaire->setUser($this->getUser());
        $commentaire->setPost($post);
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirect("/commentaire/".$commentaire->getPost()->getId());
        }
        $commentaires=$paginator->paginate($commentaires,$request->query->getInt('page',1),3);

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaires,
            'post' => $post,
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="commentaire_new", methods={"GET","POST"})
     */
    public function new(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $commentaire = new Commentaire();
        $commentaire->setUser($this->getUser());
        $commentaire->setPost($post);
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirect("/commentaire/".$commentaire->getPost()->getId());
        }

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commentaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commentaire $commentaire): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect("/commentaire/".$commentaire->getPost()->getId());
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commentaire $commentaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirect("/commentaire/".$commentaire->getPost()->getId());
    }

}
