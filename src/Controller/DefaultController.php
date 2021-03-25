<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
class DefaultController extends AbstractController
{
    function index(){
        return $this->render('index_front.html.twig');
    }
    function admin(){
        return $this->render('index_back.html.twig');
    }
}