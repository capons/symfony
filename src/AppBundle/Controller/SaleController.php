<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\Category;
use AppBundle\Entity\Country;
use AppBundle\Entity\Product;
use AppBundle\Repository\ProductRepository;

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

use AppBundle\Form\Type\ProductType;
use AppBundle\Form\Type\ProductEditType;
use AppBundle\Form\Type\ProductDeleteType;



class SaleController extends  Controller
{

    /**
     * @Route("/product", name="_sale")
     */
    public function indexAction (Request $request)
    {
        //check user access; (only 'ROLE_USER' can access)

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
        //get login user data if need
        if ($authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            //user data
            //all user data
            //$user = $this->getUser();
            //relation field user data
            //var_dump($user->getAddress()->getAddress());
           //  echo $user->getId();
           // var_dump($user);
        }
        $category = new Category();
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product); // ProductType form builder class
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($product);
        //create category if form validate


        if ($form->isSubmitted() && $form->isValid()) {

            $category -> setName($form["cat"]->getData());
            $product->setName($form["name"]->getData());
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
            $em = $this->getDoctrine()->getManager();
            $products = $em->getRepository('AppBundle:Product')
                ->findAllProduct(); //my custom repository
            $form_edit_array = array();  // need to have multiple form in edit product
            $form_delete_array = array();// need to have multiple form in delete product
            //forming product update forms
            foreach ($products as $key=>$val){
                $form_edit_array[] =  $this->productUpdate()->createView();
                $form_delete_array[] =  $this->productDelete()->createView();
            }
            return $this->render('sale/index.html.twig', array(
                'category_form' => $form->createView(),
                'produt_edit_form' =>$form_edit_array,
                'product_delete_form' =>$form_delete_array,
                'errors' => $errors,
                'product' => $products
            ));
        }
    }

    /**
     * @Route("/product/{productId}",  requirements={"productId" = "\d+"}, defaults={"productId" = null}, name="_product_detailes")
     */
    public function detaileAction($productId)
    {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Product')
            ->findByProductId($productId); //my custom repository
        return $this->render('sale/details.html.twig', array(
            'product' => $products
        ));
    }

    /**
     * @Route("/product/update", name="_product_update")
     */
    public function updateAction(Request $request)
    {
        //$product = new Product();
        $form = $this->productUpdate();
        $form->handleRequest($request);
        //$validator = $this->get('validator');

        $errors = $this->getErrorMessages($form);

        if($form->isValid()){
            //get form data
            $productId = $form["id"]->getData();
            $new_name = $form["name"]->getData();
            $em = $this->getDoctrine()->getManager();
            //find product
            $product = $em->getRepository('AppBundle:Product')->find($productId);
            if (!$product) {
                $this->addFlash(
                    'product_error',
                    'Product not found!'
                );
                return $this->redirectToRoute('_sale');
            }
            //update product name
            $product->setName($new_name);
            $em->persist($product);
            $em->flush();
            $this->addFlash(
                'product_notice',
                'Product successfully update!'
            );

            return $this->redirectToRoute('_sale');
        } else {

            $request->getSession()
                ->getFlashBag()
                ->add('error', $errors);
            return $this->redirectToRoute('_sale');
        }
    }

    /**
     * @Route("/product/delete", name="_product_delete")
     */
    public function deleteAction(Request $request)
    {
        if($request->isMethod('POST')) {
            $form = $this->productDelete();
            $form->handleRequest($request);
            //get form data
            $productId = $form["id"]->getData();
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('AppBundle:Product')->find($productId);

            if (!$product) {
                $this->addFlash(
                    'product_error',
                    'Product not found!'
                );
                return $this->redirectToRoute('_sale');

            }
            $this->addFlash(
                'product_notice',
                'Product successfully deleted!'
            );
            $em->remove($product);
            $em->flush();
            return $this->redirectToRoute('_sale');
        } else {
            return $this->redirectToRoute('_sale');
        }

    }
    //need to create form for update product
    public function productUpdate()
    {
        $product = new Product();
        $product_edit_form = $this->createForm(ProductEditType::class, $product, array(
            'action' => $this->generateUrl('_product_update'),
            'method' => 'POST'
        )); // ProductType form builder class
        return $product_edit_form;
    }

    public function productDelete()
    {
        $product = new Product();
        $product_delete_form = $this->createForm(ProductDeleteType::class, $product, array(
            'action' => $this->generateUrl('_product_delete'),
            'method' => 'POST'
        )); // ProductType form builder class
        return $product_delete_form;
    }

    //get all form message if another action of form use
    private function getErrorMessages(\Symfony\Component\Form\Form $form) {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }
}