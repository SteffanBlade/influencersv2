<?php
namespace App\Controller ;




use App\Entity\Articles;
use App\Entity\Authors;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;

class ArticleController extends AbstractController{

    /**
     * @Route("/",name="index")
     * */
public function index()
{



    $articles = $this->getDoctrine()
        ->getRepository(Articles::class)
        ->findBy(array(), array('articlesDate' => 'DESC'));


    return $this->render('index.html.twig', array('articles' => $articles));

}
    /**
     * @Route("/new")
     * */
    public function new(){

        return $this->render('newArticle.html.twig');
    }

    /**
     * @Route("/ranking",name = "ranking")
     * */
    public function ranking(){

        $authors = $this->getDoctrine()
            ->getRepository(Authors::class)
            ->findBy(array(), array('authorsVotes' => 'DESC'));

        return $this->render('ranking.html.twig',array('authors'=>$authors));
    }

    /**
     * @Route("/current/{id}")
     */
    public function CurrentArticle($id)
    {
        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);
        return $this->render('singleArticle.html.twig',array('article' => $articles));
    }

    /**
     * @Route("/{id}",name="liked")
     */
    public function likeIt($id){

        $request = Request::createFromGlobals();


        if (!($request->cookies->get('test')) ){
            $cookieStorage = new Response();
            $cookie = new Cookie('test', 1, time()+3600);
            $cookieStorage->headers->setCookie($cookie);
        }
        elseif ($request->cookies->get('test') == "1"){
            echo 'hi mate';  // test it - not working
        }



        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);
        $articles->setArticlesVotes();

        $authorsVariable = $articles->articlesAuthors;
        $authors = $this->getDoctrine()->getRepository(Authors::class)->find($authorsVariable);
        $authors->setAuthorsVotes();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($articles);
        $entityManager->flush();

        return $this->redirectToRoute("index");
    }



}