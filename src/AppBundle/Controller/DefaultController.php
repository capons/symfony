<?php

namespace AppBundle\Controller;

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

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_homepage")
     */
    public function indexAction(Request $request)
    {

        //$this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!'); //redirect if ROLE not admin
        /*
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }
        */
        // create a task and give it some dummy data for this example
        $user = new User();




        $form = $this->createFormBuilder($user)

            ->add('username', TextType::class,array(
                'required' => true,
                'attr' => array(
                    'maxlength' => 4,
                    'class' => 'form-control'
                )
            ))
            // If you use PHP 5.3 or 5.4 you must use
            // ->add('task', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            /*
        ->add('email', TextType::class,array(
            'required' => true,
            'attr' => array(
                'maxlength' => 20,
                'class' => 'form-control'
            )
        ))*/
            ->add('password', TextType::class,array(
                'required' => true,
                'attr' => array(
                    'maxlength' => 20,
                    'class' => 'form-control'
                )
            ))
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return $this->render('default/test.html.twig', array(
                'reg_form' =>  $form->createView(),
                'errors' => $errors,
            ));

        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository = $this->getDoctrine()->getRepository('AppBundle:User');
            $check_duplicat = $repository->findOneByUsername($form["username"]->getData());

            if($check_duplicat){
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Email already exist!')
                ;

                $url = $this->generateUrl('_homepage');

                return $this->redirect($url);
            } else {
                //save form data to database

                $user = $form->getData();
                $em = $this->getDoctrine()->getManager();

                $pwd=$user->getPassword();

                $encoder=$this->container->get('security.password_encoder');
                $pwd=$encoder->encodePassword($user, $pwd);
                $user->setPassword($pwd);
                $user->setRoles('ROLE_USER'); //default role
                $em->persist($user);
                $em->flush();
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'You have successfully registered!')
                ;
                return $this->redirectToRoute('_homepage');

            }

        }



        //load view with parameter
        return $this->render('default/test.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'reg_form' =>  $form->createView()
        ));

    }
    /**
     * @Route("/admin",name="admin")
     */

    public function adminAction()
    {
        $authorizationChecker = $this->get('security.authorization_checker');

        // check for edit access
        if (false === $authorizationChecker->isGranted('ROLE_USER')) {
            //throw new AccessDeniedException();
            return $this->redirectToRoute('_homepage');
        }
        return $this->render('admin/admin.html.twig');
        //return new Response('<html><body>Admin page!</body></html>');
    }

}