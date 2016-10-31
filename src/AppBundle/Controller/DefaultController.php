<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\Country;
use AppBundle\Entity\Product;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\DependencyInjection\ContainerBuilder;




class DefaultController extends Controller
{
    /**
     * @Route("/", name="_homepage")
     */
    public function indexAction(Request $request)
    {

        return $this->render('default/test.html.twig');

    }
    /**
     * @Route("/admin",name="admin")
     */

    public function adminAction(Request $request)
    {
        $authorizationChecker = $this->get('security.authorization_checker');

        // check for auth user access
        if (false === $authorizationChecker->isGranted('ROLE_USER')) {
            //throw new AccessDeniedException();
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'You have no permission!')
            ;
            return $this->redirectToRoute('_homepage');
        }

        //check if user login

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
           // echo $user->getId();
        }


        return $this->render('admin/admin.html.twig',array(
            'test' => 'test'
        ));

    }





    /**
     * @Route("/product/update/{productId}")
     */
    public function updateAction($productId)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($productId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$productId
            );
        }

        $product->setName('New product name!');
        $em->flush();


        return new Response(' product new name '.$product->getName());
    }

    /**
     * @Route("/product/delete/{productId}")
     */
    public function deleteAction($productId)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($productId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$productId
            );
        }


        $em->remove($product);
        $em->flush();



        return new Response('Delete product id '.$productId);
    }

}