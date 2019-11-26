<?php

namespace App\Controller;

use App\Entity\Article;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ArticleController extends FOSRestController   
{
    /**
     * @Rest\Post(
     *                  path="/articles",
     *                  name="app_article_create"
     * )
     * @Rest\View(StatusCode= 201)
     * @ParamConverter("article", converter="fos_rest.request_body")
     */

     public function createAction(Article $article)
     {
       //  dump($article); die();

       $em = $this->getDoctrine()->getManager();

       $em->persist($article);
       $em->flush();

       return $this->view($article, Response::HTTP_CREATED,[
           'Location'=> $this->generateUrl('app_article_show',['id' => $article->getId(),
           UrlGeneratorInterface::ABSOLUTE_URL
           ])
       ]);

     }

      /*
     * @Rest\Post(
     *                  path="/articles",
     *                  name="app_article_create"
     * )
     * @Rest\View(StatusCode= 201)
     *
     

    public function createAction(Request $request)
    {
      //  dump($article); die();

       $data = $this->get('serializer')->deserialize($request->getContent(),'array', 'json');
       $article = new Article;
       $form = $this->get('form.factory')->create(ArticleType::class, $article);
       $form->submit($data);

       $em = $this->getDoctrine()->getManager();
       $em->persist($article);
       $em->flush();

       return $this->view($article, Response::HTTP_CREATED,['Location' => $this->generateUrl('app_article_show',['id' => $article->getId()])]);
    }
    */
}
