<?php

namespace App\Controller;


use App\Entity\Articles;
use App\Entity\Authors;
use App\Controller\UploadController;
use App\Controller\MailerController;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use http\Message;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
     * @Route("/authorsView/{id}",name="authorArticles")
     * */
    public function authorsView($id, ArticlesRepository $repository)
    {

        $articles = $repository->findArticleByAuthorId($id);

        return $this->render('indexv3.html.twig',
            array('articles' => $articles)
        );
    }


    /**
     * @Route("/tags/{tag}", name = "author")
     */
    public function tagsView($tag, ArticlesRepository $repository)
    {
        $articles = $repository->findArticleByTag($tag);

        return $this->render('indexv3.html.twig',
            array('articles' => $articles)
        );
    }


    /**
     * @Route("/new", name="create")
     */
    public function new(Request $request, AuthorsRepository $repository)
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

            // Search if an author already exists
            // if it exist -> set article author to him
            // if it not exist -> create a new author
            try{
                if ($repository->findAuthorByNameAndEmail($request->request->get('name'), $request->request->get('email')) != null) {
                    $author = $repository->findAuthorByNameAndEmail($request->request->get('name'), $request->request->get('email'));
                    $article->setAuthor($author[0]);


                } else {
                    $author->setName($request->request->get('name'));
                    $author->setEmail($request->request->get('email'));
                    $author->setVotesTo0();

                    $setCookie = new Cookie($author->getEmail(),1, time() + 3600);
                    $response = new Response();
                    $response->headers->setCookie($setCookie);
                    $response->sendHeaders();


                    $article->setAuthor($author);
                    $entityManager->persist($author);


                }

            $article->setTitle($request->request->get('title'));
            $article->setContent($request->request->get('content'));
            $article->setDate(new \datetime());
            $article->setVotesTo0();
            $article->setTags($request->request->get('tags'));



            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->persist($article);
            $entityManager->flush();

                $this->addFlash('success','Article created ! ');

            }catch(UniqueConstraintViolationException $e){
                $errorMessage = $e->getMessage();
                $this->addFlash('error','The name and email does not match ! 
                 Please enter a valid combination !');
            }

        }


        return $this->render('newArticle.html.twig');
    }


    /**
     * @Route("/edit/{id}", name="edit", methods={"PUT","GET"})
     *
     */
    public function edit(MailerInterface $mailer, Request $request, $id)
    {


        $article = new Articles();
        $article = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);

//        $random = random_int(1, 100);
        $random = 1 ;
        $email = (new Email())
            ->from('alienmailer@example.com')
            ->to($article->author->getEmail())
            ->subject('Test')
            ->text("Salutare ! Facem o proba, asta e numaru : $random ");
        $mailer->send($email);


        $form = $this->createFormBuilder($article, array('method' => 'GET'))  // De ce ma lasa sa fac update with GET si cu PUT nu?
        ->add('title', TextareaType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add('content', TextareaType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add('code',\Symfony\Component\Form\Extension\Core\Type\IntegerType::class, array('mapped' => false))
            ->add('save', SubmitType::class, array('label' => 'Edit', 'attr' => array('class' => 'btn btn-primary mt-3')))

            ->getForm();
        $form->handleRequest($request);

        $checker = $form->get('code')->getData();


        if ($form->isSubmitted() && $form->isValid() && $random == $checker) {
//            dd($random == $checker);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            $this->addFlash('success', 'Article Created!');
            return $this->redirectToRoute('index');
        }


        return $this->render('edit.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/ranking",name = "ranking")
     * */
    public function ranking(ArticlesRepository $articlesRepository)
    {

        $authors = $this->getDoctrine()
            ->getRepository(Authors::class)
            ->findBy(array(), array('votes' => 'DESC'));



        return $this->render('ranking.html.twig', array('authors' => $authors));


    }

    /**
     * @Route("/current/{id}/{tag}/{authorId}")
     */
    public function CurrentArticle($id, $tag, $authorId, ArticlesRepository $articlesRepository)
    {
        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);
        $sameTagsArticles = $articlesRepository->findArticleByTag($tag);
        $sameAuthorArticles = $articlesRepository->findArticleByAuthorId($authorId);

        return $this->render('singleArticle.html.twig', array('article' => $articles,
            'articlesTags' => $sameTagsArticles,
            'articlesAuthor' => $sameAuthorArticles));
    }

    /**
     * @Route("/likeIt",name="liked")
     */
    public function likeIt(Request $request, ArticlesRepository $articlesRepository)
    {
        $id = $request->request->get('id');
        $value = $request->request->get('value');

        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);


        $authorsVariable = $articles->author;
        $authors = $this->getDoctrine()->getRepository(Authors::class)->find($authorsVariable);





        $request = Request::createFromGlobals();

        $setCookie = new Cookie($articles->getId(), 1, time() + 3600);

        $cookie = $request->cookies;


        if ($cookie->get($articles->getId()) == 1) {
            $likes = ["likes" => $articles->getVotes()];
            return new JsonResponse($likes);
        } else {

            $response = new Response();
            $response->headers->setCookie($setCookie);

            $response->sendHeaders();
            $articles->setVotes($value);
            $allArticles = $articlesRepository->findArticleByAuthorId($id);

            // ranking algorithm

            $count0 = 0;
            foreach ($allArticles as $article) {
                if ($article->getVotes() == 0)
                {
                    $count0 = $count0 + 1;
                }
            }
            $authorVotesValue = $value - $count0 * 0.25 * $value;
            $authors->setVotes($authorVotesValue);

            //push to db
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articles);
            $entityManager->flush();

            $likes = ["likes" => $articles->getVotes()];
            return new JsonResponse($likes);
        }

    }


    /**
     * @Route("/search/{value}",name="search")
     * */
    public function Value($value,ArticlesRepository $articlesRepository)
    {

        $articles = $articlesRepository->findArticleByContent($value);

        return $this->render('indexv3.html.twig',
            array('articles' => $articles)
        );

    }

}