<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/othman", name="othman")
     */
  public function othmanAction(Request $request)
    {
        $number = random_int(0, 100);

         return $this->render('othman/number.html.twig', [
            'number' => $number,
        ]);


    }
        /**
     * @Route(
     *     "/articles/{_locale}/{year}/{slug}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_locale": "ar|en|fr",
     *         "_format": "html|rss|json",
     *         "year": "\d+"
     *     }
     * )
     */
    public function showAction($_locale, $year, $slug)
    {
        
        $number = random_int(0, 10000000000);
         return $this->render('othman/number.html.twig', [
            'number' => $number,
            'year' => $year,
            'slug' => $slug,
        ]);
        
    }
}
