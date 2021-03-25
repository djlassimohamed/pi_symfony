<?php

namespace App\Controller;

use App\Entity\PanierProduit;
use App\Form\PanierProduitType;
use App\Repository\PanierProduitRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\Json;

/**
 * @Route("/")
 */
class PanierProduitController extends AbstractController
{
    /**
     * @Route("/panier/produit/commander", name="panier_produit_commander", methods={"GET"})
     */
    public function commander(PanierProduitRepository $panierProduitRepository, \Swift_Mailer $mailer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT pp FROM App\Entity\PanierProduit pp WHERE pp.user = :user");
        $query->setParameter('user', $this->getUser());
        $panier = $query->getResult();
        $prixTotal = 0;
        foreach ($panier as $p){
            $prixTotal = $prixTotal + ($p->getQuantite()*$p->getProduit()->getPrix());
        }

        $message = (new \Swift_Message('Activation de votre compte'))
            ->setFrom('COACHINIesprit@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($this->renderView('panier_produit/facture.html.twig', ['panier'=>$panier, 'prixtotal'=>$prixTotal]), 'text/html');
        $mailer->send($message);

        /*return new Response(
            '<html><body>'.$prixTotal.'</body></html>'
        );*/

        return $this->render('payement.html.twig', [
            'panier' => $panier,
            'prixtotal' => $prixTotal
        ]);
    }
    /**
     * @Route("/panier/produit/", name="panier_produit_index", methods={"GET"})
     */
    public function index(PanierProduitRepository $panierProduitRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT pp FROM App\Entity\PanierProduit pp WHERE pp.user = :user");
        $query->setParameter('user', $this->getUser());
        $panier = $query->getResult();
        return $this->render('panier_produit/index.html.twig', [
            'panier' => $panier,
        ]);
    }

    /**
     * @Route("/panier/produit/new/{id}", name="panier_produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $panierProduit = new PanierProduit();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT p FROM App\Entity\Produit p WHERE p.id = :id");
        $query->setParameter('id', $request->attributes->get('id'));
        $produit = $query->getSingleResult();
        $panierProduit->setProduit($produit);
        $panierProduit->setQuantite(1);
        $panierProduit->setUser($this->getUser());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($panierProduit);
        $entityManager->flush();

        return $this->redirectToRoute('produit_index_front');
    }

    /**
     * @Route("/panier/produit/{id}", name="panier_produit_show", methods={"GET"})
     */
    public function show(PanierProduit $panierProduit): Response
    {
        return $this->render('panier_produit/show.html.twig', [
            'panier_produit' => $panierProduit,
        ]);
    }

    /**
     * @Route("/panier/produit/{id}/edit", name="panier_produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PanierProduit $panierProduit): Response
    {
        $form = $this->createForm(PanierProduitType::class, $panierProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($panierProduit->getQuantite()<=$panierProduit->getProduit()->getQuantite()){
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('panier_produit_index');
            }
            return $this->render('panier_produit/edit.html.twig', [
                'panier_produit' => $panierProduit,
                'form' => $form->createView(),
                'error' => 'Stock insuffisant'
            ]);
        }

        return $this->render('panier_produit/edit.html.twig', [
            'panier_produit' => $panierProduit,
            'form' => $form->createView(),
            'error' => ''
        ]);
    }

    /**
     * @Route("/panier/produit/{id}", name="panier_produit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PanierProduit $panierProduit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panierProduit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($panierProduit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('panier_produit_index');
    }
    /**
     * @Route("/panier/produit/facture/pdf", name="panier_produit_pdf", methods={"GET"})
     */
    public function listp(PanierProduitRepository $panierProduitRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT pp FROM App\Entity\PanierProduit pp WHERE pp.user = :user");
        $query->setParameter('user', $this->getUser());
        $panier = $query->getResult();
        $prixTotal = 0;
        foreach ($panier as $p){
            $prixTotal = $prixTotal + ($p->getQuantite()*$p->getProduit()->getPrix());
        }
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $panier = $panierProduitRepository->findAll();
        $html = $this->renderView('panier_produit/facture.html.twig', [
            'panier' => $panier,
            'prixtotal' => $prixTotal

        ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
    /**
     * @Route("/success", name="success", methods={"GET"})
     */
    public function paymentSuccess(PanierProduitRepository $panierProduitRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT pp FROM App\Entity\PanierProduit pp WHERE pp.user = :user");
        $query->setParameter('user', $this->getUser());
        $panier = $query->getResult();
        foreach ($panier as $p){
            $query = $em->createQuery("SELECT p FROM App\Entity\Produit p WHERE p.id = :id");
            $query->setParameter('id', $p->getProduit()->getId());
            $produit = $query->getSingleResult();
            $produit->setQuantite($produit->getQuantite()-$p->getQuantite());
            $em->persist($produit);
            $em->flush();
        }
        $query = $em->createQuery("DELETE App\Entity\PanierProduit pp WHERE pp.user = :user");
        $query->setParameter('user', $this->getUser());
        $query->execute();
        return $this->redirectToRoute('index');
    }
    /**
     * @Route("/error", name="error", methods={"GET"})
     */
    public function paymentError(PanierProduitRepository $panierProduitRepository): Response
    {
        return new Response(
            '<html><body>ERROR</body></html>'
        );
    }
    /**
     * @Route("/create-checkout-session", name="create-checkout-session")
     */
    public function payment(Request $request,PanierProduitRepository $panierProduitRepository): Response
    {
        \Stripe\Stripe::setApiKey('sk_test_51ITGcAJXa5XqKKTCI9GADmye8OO7PBFoTBsrmn9GUwYlRV6850PdvGAABqz7ZggyBvTyrOZuzZSTVRSIvjP8FqAu00JttYAow7');

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT pp FROM App\Entity\PanierProduit pp WHERE pp.user = :user");
        $query->setParameter('user', $this->getUser());
        $panier = $query->getResult();
        $prixTotal = 0;
        foreach ($panier as $p){
            $prixTotal = $prixTotal + ($p->getQuantite()*$p->getProduit()->getPrix());
        }
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => $prixTotal.'00',
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('error', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return new JsonResponse([ 'id' => $session->id ]);
    }
    /**
     * @Route("/paiement", name="test")
     */
    public function test(): Response
    {
        return $this->render('payement.html.twig');
    }
}
