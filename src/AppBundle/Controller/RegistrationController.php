<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\Country;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use AppBundle\Entity\Group;
use AppBundle\Entity\Role;

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
        $user_permission = new Group();


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
                    ->add('reg_error', 'Email already exist!')
                ;
                $url = $this->generateUrl('_homepage');
                return $this->redirect($url);
            }

            //find user permission by name
            $role_name = $user_permission->getRole();
            $em = $this->getDoctrine()->getManager();
            $user_role = $em->getRepository('AppBundle:Role')
                ->loadRoleByRolename($role_name); //my custom repository

            //*/


            //save form data to database
            $address->setAddress($form["addre"]->getData());
            $pwd=$user->getPassword();
            $encoder=$this->container->get('security.password_encoder');
            $pwd=$encoder->encodePassword($user, $pwd);
            $user->setPassword($pwd);
            $user->setAddress($address);
            //add user permission
            $user_permission->setName($form["username"]->getData());
            $user_permission->setUserRole($user_role);


            $user->addGroup($user_permission);
            $em = $this->getDoctrine()->getManager();

            $em->persist($address);
            $em->persist($user);
            $em->persist($user_permission);

            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('reg_success', 'You have successfully registered!')
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