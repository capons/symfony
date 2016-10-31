<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\Category;
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


class SaleController extends  Controller
{
    /**
     * @Route("/product", name="_sale")
     */
    public function indexAction (Request $request)
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
        $category = new Category();
        $product = new Product();

        $form = $this->createFormBuilder($product)

            ->add('name', TextType::class,array(
                'required' => true,
                'label' => 'Add product',
                'attr' => array(
                    'maxlength' => 20,
                    'value' => 'new product',
                    'class' => 'form-control'
                )
            ))
            ->add('cat', TextType::class,array(
                'required' => true,
                'label' => 'Add category',
                'attr' => array(
                    'maxlength' => 20,
                    'value' => 'new category',
                    'class' => 'form-control'
                )
            ))



            ->add('save', SubmitType::class, array('label' => 'Create Category'))
            ->getForm();
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($product);
        //create category
        if ($form->isSubmitted() && $form->isValid()) {

            $category -> setName($form["cat"]->getData());

            $product->setName($form["name"]->getData());


            //$product->setName('test');


            // relate this product to the category
            $product->setCategory($category);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->persist($product);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'You have successfully add product!');

            return $this->redirectToRoute('_sale');
        } else {
            //display all product
            $product = $this->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->createQueryBuilder('e')
                ->select('e.id,e.name, co.name as cat_name')
                ->leftJoin('AppBundle:Category', 'co', 'WITH', 'co.id = e.category')
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

            return $this->render('sale/index.html.twig', array(
                'category_form' => $form->createView(),
                'errors' => '',
                'product' => $product
            ));
        }
    }

    /**
     * @Route("/product/{productId}",  requirements={"productId" = "\d+"}, defaults={"productId" = null}, name="_product_detailes")
     */
    public function detaileAction($productId)
    {

        $product = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            //->find($productId);
            ->createQueryBuilder('e')
            ->select('e.id,e.name, co.name as cat_name')
            ->leftJoin('AppBundle:Category', 'co', 'WITH', 'co.id = e.category')
            ->where('e.id = :id')
            ->setParameter('id', $productId)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return $this->render('sale/details.html.twig', array(
            'product' => $product
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