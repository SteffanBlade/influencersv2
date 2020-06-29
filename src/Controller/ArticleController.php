<?php

namespace App\Controller;


use App\Entity\Articles;
use App\Entity\Authors;
use App\Controller\UploadController;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;

use App\Repository\AuthorsRepository;

class ArticleController extends AbstractController
{

    /**
     * @Route("/",name="index")
     * */
    public function index()
    {


        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->findBy(array(), array('date' => 'DESC'));


        return $this->render('indexv3.html.twig',
            array('articles' => $articles)
        );

    }


    /**
     * @Route("/new", name="create")
     */
    public function new(Request $request,AuthorsRepository $repository)
    {

        $article = new Articles();
        $author = new Authors();


        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            /**@var UploadedFile $uploadedImage */
            $uploadedImage = $request->files->get('image');
            // testing if image was uploaded
            if ($uploadedImage != null) {
                $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/images';
                $originalImageName = pathinfo($uploadedImage->getClientOriginalName(), PATHINFO_FILENAME);
                $newImageName = $originalImageName . '-' . uniqid() . '.' . $uploadedImage->guessExtension();

                $uploadedImage->move($uploadDirectory,
                    $newImageName);
                $article->setImage($newImageName);
            }
            // if it's not uploaded we dont set it


            $author->setName($request->request->get('name'));
            $author->setEmail($request->request->get('email'));
            $author->setVotesTo0();

//            /** @var AuthorsRepository $repository */
//            $repository = $this->getDoctrine()->getRepository(Authors::class);
//
//            $AuthorId = $repository->findAuthorByNameAndEmail($request->request->get('name'),$request->request->get('email'));
//
//            dd($AuthorId);

            $authorID = $repository->findAuthorByNameAndEmail(($request->request->get('name')),$request->request->get('email'));
            dd($authorID);

            $article->setTitle($request->request->get('title'));
            $article->setContent($request->request->get('content'));
            $article->setDate(new \datetime());
            $article->setVotesTo0();
            $article->setTags($request->request->get('tags'));
            $article->setAuthor($author);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($author);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->render('newArticle.html.twig');
        }


        return $this->render('newArticle.html.twig');
    }

//    /**
//     * @Route("/edit/{id}", name="edit")
//     */
//    public function edit(){
//
//        return $this->render('indexv3.html.twig');
//}


    /**
     * @Route("/ranking",name = "ranking")
     * */
    public function ranking()
    {

        $authors = $this->getDoctrine()
            ->getRepository(Authors::class)
            ->findBy(array(), array('votes' => 'DESC'));

        return $this->render('ranking.html.twig', array('authors' => $authors),
            );
    }

    /**
     * @Route("/current/{id}")
     */
    public function CurrentArticle($id)
    {
        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);
        return $this->render('singleArticle.html.twig', array('article' => $articles));
    }

    /**
     * @Route("/{id}",name="liked")
     */
    public function likeIt($id)
    {
        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);
        $authorsVariable = $articles->author;
        $authors = $this->getDoctrine()->getRepository(Authors::class)->find($authorsVariable);
        $request = Request::createFromGlobals();

        $setCookie = new Cookie($articles->getId(), 1, time() + 3600);

        $cookie = $request->cookies;


        if ($cookie->get($articles->getId()) == 1) {
            return $this->redirectToRoute("index");
        } else {
            $response = new Response();
            $response->headers->setCookie($setCookie);

            $response->sendHeaders();

            $articles->setVotes();
            $authors->setVotes();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articles);
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }

    }


}