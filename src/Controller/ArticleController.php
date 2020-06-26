<?php
namespace App\Controller ;




use App\Entity\Articles;
use App\Entity\Authors;
use App\Repository\ArticlesRepository;
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
    // Manual repository
    //    $articlesTest = $this->getDoctrine()->getRepository(Articles::class)->testQuery();


    $articles = $this->getDoctrine()
        ->getRepository(Articles::class)
        ->findBy(array(), array('articlesDate' => 'DESC'));

    $articlesVotes = $this->getDoctrine()
        ->getRepository(Articles::class)
        ->findBy(array(), array('articlesVotes' => 'DESC'));


    return $this->render('indexv2.html.twig',
        array('articles' => $articles,
            'articlesVotes' => $articlesVotes)
    );


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
        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);
        $authorsVariable = $articles->articlesAuthors;
        $authors = $this->getDoctrine()->getRepository(Authors::class)->find($authorsVariable);
        $request = Request::createFromGlobals();

        $random = 1;
        $setCookie = new Cookie($articles->articlesId,$random, time()+3600);
        $cookie = $request->cookies;
        if($cookie->get($articles->articlesId) == $random){
            return $this->redirectToRoute("index");
        }
        else{
            $response = new Response();
            $response->headers->setCookie($setCookie);
            $response->sendHeaders();

            $articles->setArticlesVotes();
            $authors->setAuthorsVotes();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articles);
            $entityManager->flush();
            return  $this->redirectToRoute('index');
        }

        }






}