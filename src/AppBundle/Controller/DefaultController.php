<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\Country;

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
        //$request->query->get('id'); retrive post get data example
        $user = new User();
        $address = new Address();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT p.id,p.code,p.name
                 FROM AppBundle:Country p'
                    );
        $all_country = $query->getResult();
        $sort_country = array();
        foreach ($all_country as $val){
            $sort_country[$val['name']] = $val['id'];
        }
        //create form
        $form = $this->createFormBuilder($user)

            ->add('username', TextType::class,array(
                'required' => true,
                'attr' => array(
                    'maxlength' => 4,
                    'value' => 'bog',
                    'class' => 'form-control'
                )
            ))

            ->add('address', TextType::class,array(
                'required' => true,
                'attr' => array(
                    'maxlength' => 40,
                    'value' => 'some address',
                    'class' => 'form-control'
                )
            ))

            ->add('email', EmailType::class,array(
                'required' => true,
                'attr' => array(
                    'maxlength' => 30,
                    'value' => 'someemail@ram.ru',
                    'class' => 'form-control'
                )
            ))
            ->add('country', ChoiceType::class, array(
                'choices' => $sort_country//$country

            ))
            ->add('password', PasswordType::class,array(
                'required' => true,
                'attr' => array(
                    'maxlength' => 20,
                    'value' => '111111',
                    'class' => 'form-control'
                )
            ))
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($user);


        if ($form->isSubmitted() && $form->isValid()) {

            $repository = $this->getDoctrine()->getRepository('AppBundle:User');

            $check_duplicat_name = $repository->findOneByUsername($form["username"]->getData());

            //check duplicat
            if($check_duplicat_name){
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', 'Username already exist!')
                ;
                $url = $this->generateUrl('_homepage');
                return $this->redirect($url);
            }
            $check_duplicat_email = $repository->findOneByEmail($form["email"]->getData());
            //check duplicat
            if($check_duplicat_email){
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', 'Email already exist!')
                ;
                $url = $this->generateUrl('_homepage');
                return $this->redirect($url);
            }
            //save form data to database
                $em = $this->getDoctrine()->getManager();
                $address->setAddress($form["address"]->getData());
                $em->persist($address);
                $em->flush();
                $address_id = $address->getId(); //return save address id

                $user = $form->getData();

                $pwd=$user->getPassword();
                $encoder=$this->container->get('security.password_encoder');
                $pwd=$encoder->encodePassword($user, $pwd);
                $user->setPassword($pwd);
                $user->setRoles('ROLE_USER'); //default role
                $user->setAddress($address_id);

                $em->persist($user);
                $em->flush();
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'You have successfully registered!')
                ;
                return $this->redirectToRoute('_homepage');

        } else {

            //load view with parameter

            return $this->render('default/test.html.twig', array(
                'reg_form' => $form->createView(),
                'errors' => $errors
            ));

        }



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


        /*
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->createQueryBuilder('e')
            ->select('e.id,e.username,co.name')
            ->leftJoin('AppBundle:Country', 'co', 'WITH', 'co.id = e.country')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        echo '<pre>';
        print_r($repository);
        echo '</pre>';
        */







        return $this->render('admin/admin.html.twig',array(
            'test' => 'test'
        ));
        //return new Response('<html><body>Admin page!</body></html>');
    }

    /**
     * @Route("/product",name="product")
     */
    public function productAction()
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @Route("/product/{product}")
     */
    public function showAction($product)
    {
        $productt = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->find($product);

        if (!$productt) {
            throw $this->createNotFoundException(
                'No product found for id '.$product
            );
        }
        return new Response(' product name '.$productt->getName());


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