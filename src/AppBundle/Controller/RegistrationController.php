<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\Country;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;

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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RegistrationController extends Controller{

    /**
     * @Route("/registr", name="_registration")
     */
    public function indexAction(Request $request)
    {

        //$request->query->get('id'); retrive post get data example
        $user = new User();
        $address = new Address();


        //create form

        $form = $this->createForm(UserType::class, $user); // UserType form builder class


        $form->handleRequest($request);
        //validate form

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        //if form submit
        if ($form->isSubmitted() && $form->isValid()) {


            $repository = $this->getDoctrine()->getRepository('AppBundle:User');

            $check_duplicat_name = $repository->findOneByUsername($form["username"]->getData());

            //check duplicat
            if($check_duplicat_name){
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', 'Username already exist!')
                ;
                $url = $this->generateUrl('_registration');
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
            //save address

            $em = $this->getDoctrine()->getManager();
            $address->setAddress($form["address"]->getData());
            $em->persist($address);
            $em->flush();
            $address_id = $address->getId(); //return save address id

            //user object
            $user = $form->getData();
            $pwd=$user->getPassword();
            $encoder=$this->container->get('security.password_encoder');
            $pwd=$encoder->encodePassword($user, $pwd);
            $user->setPassword($pwd);

            $user->setAddress($address_id);

            $em->persist($user);

            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'You have successfully registered!')
            ;
            return $this->redirectToRoute('_registration');

        } else {





            //load view with parameter
            return $this->render('registration/index.html.twig', array(
                'reg_form' => $form->createView(),
                'errors' => $errors
            ));

        }
    }
}