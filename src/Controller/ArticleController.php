<?php
namespace App\Controller ;


use App\Entity\Articles;
use App\Entity\Authors;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController{

    /**
     * @Route("/")
     * */
public function index(){

    $articles = $this->getDoctrine()
        ->getRepository(Articles::class)
        ->findBy(array(), array('articlesDate' => 'DESC'));


    return $this->render('index.html.twig',array('articles' => $articles));

}
}