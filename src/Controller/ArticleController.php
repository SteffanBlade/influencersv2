<?php
namespace App\Controller ;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController{

    /**
     * @Route("/")
     * */
public function index(){
    return $this->render("index.html.twig");
}
}