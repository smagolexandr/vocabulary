<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Word;
use AppBundle\Entity\User;
use AppBundle\Form\WordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("default/index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $words = $em -> getRepository('AppBundle:Word')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($words, $request->query->getInt('page', 1), 25);

        return [
            "words" => $pagination
        ];
    }

    /**
     * @Route("/word/add", name="add_word")
     * @Template("AppBundle:Word:add.html.twig")
     */
    public function addWordAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $word = new Word;
        $form = $this->createForm(WordType::class, $word)
            ->add('Добавить', SubmitType::class, array(
        'attr' => array('class' => 'btn btn-success center-btn')
    ));;
        $form->handleRequest($request);
        if ($form->isValid()) {
            //dump($form);
            $em->persist($word);

            if(!$word->getDe()){
                $word->setDe($word->getWordTranslation($word->getEn(),'de'));
            }
            if(!$word->getUk()){
                $word->setUk($word->getWordTranslation($word->getEn(),'uk'));
            }
            if(!$word->getRu()){
                $word->setRu($word->getWordTranslation($word->getEn(),'ru'));
            }
            if(!$word->getPl()){
                $word->setPl($word->getWordTranslation($word->getEn(),'pl'));
            }
            $word->setUsers($this->getUser());
            $em->persist($word);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }


        return ['form' => $form->createView()];
    }


    /**
     * @Route("/wishlist", name="wishlist")
     * @Template("default/index.html.twig")
     */
    public function wishlistAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $words = $user->getWishlist();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($words, $request->query->getInt('page', 1), 25);

        return [
            "words" => $pagination
        ];
    }

    /**
     * @Route("/wishlist/add/{id}", name="add_word_to_wishlist")
     */
    public function addWishlistWordAction(Request $request, Word $word)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var User @user
         */
        $user = $this->getUser();
        $user->addWishlist($word);
        $em->persist($user);
        $em->flush();
        return new RedirectResponse($this->generateUrl("homepage"));
    }

    /**
     * @Route("/words", name="add_words")
     */
    public function wordsAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $locale = $request->getLocale();

        $words =
            ["and","in","that","have","I","it","for","not","on","with","he","as","you","do","at","this","but","his","by","from","they","we","say","her","she","or","an","will","my","one","all","would","there","their","what","so","up","out","if","about","who","get","which","go","me","when","make","can","like","time","no","just","him","know","take","people","into","year","your","good","some","could","them","see","other","than","then","now","look","only","come","its","over","think","also","back","after","use","two","how","our","work","first","well","way","even","new","want","because","any","these","give","day","most","us"];

        $langs = ["uk","ru","de","pl"];
        foreach ($words as $word){
            $obj = new Word();
            foreach ($langs as $lang){
                $obj->setEn($word);
                $url= "https://translate.yandex.net/api/v1.5/tr/translate?key=trnsl.1.1.20170215T074352Z.bb4ccda94e0b356f.7474d864b60d776edfb3c5e32063b026816b1a02&text=$word&lang=en-$lang&format=plain";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
// Set so curl_exec returns the result instead of outputting it.
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Get the response and close the channel.
                $data = curl_exec($ch);
                $xml = simplexml_load_string($data);

                switch ($lang){
                    case "uk" :
                        $obj->setUk($xml->text);
                        break;
                    case "ru":
                        $obj->setRu($xml->text);
                        break;
                    case "de":
                        $obj->setDe($xml->text);
                        break;
                    case "pl":
                        $obj->setPl($xml->text);
                        break;
                }

                curl_close($ch);
            }
            $em->persist($obj);
        }
        $em->flush();


        return [
            'words' => $words
        ];
    }
}
