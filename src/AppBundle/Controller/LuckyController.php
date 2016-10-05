<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number",name="_number")
     */
    public function numberAction()
    {
        $number = mt_rand(0, 100);

        return $this->render('lucky_number/number.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'number' => $number
        ));

        /******* redirect
        // do a permanent - 301 redirect
        return $this->redirectToRoute('homepage', array(), 301);

        // redirect to a route with parameters
        return $this->redirectToRoute('blog_show', array('slug' => 'my-page'));
        */
    }



}