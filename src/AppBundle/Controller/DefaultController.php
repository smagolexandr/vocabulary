<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Word;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Faker;

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
     * @Route("/wishlist", name="wishlist")
     * @Template("default/index.html.twig")
     */
    public function wishlistAction(Request $request)
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
                $tmp = $xml->text;

                echo $tmp;
                switch ($lang){
                    case "uk" :
                        $obj->setUk($tmp);
                        break;
                    case "ru":
                        $obj->setRu($tmp);
                        break;
                    case "de":
                        $obj->setDe($tmp);
                        break;
                    case "pl":
                        $obj->setPl($tmp);
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
