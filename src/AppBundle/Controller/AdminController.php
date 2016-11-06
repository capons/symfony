<?php
namespace AppBundle\Controller;


use AppBundle\Entity\Group;
use AppBundle\Form\Type\Admin\UserUpdatePermissionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;



class AdminController extends Controller {

    /**
     * @Route("/admin",name="admin")
     */
    public function indexAction(Request $request)
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

        $em = $this->getDoctrine()->getManager();
        //send entity with all users
        $users = $em->getRepository('AppBundle:User')
            ->findAll();

        $form_edit_array = array();  // need to have multiple form in edit product
        //forming product update forms
        foreach ($users as $key=>$val){
            $form_edit_array[] =  $this->userUpdatePermission()->createView();
        }

        return $this->render('admin/admin.html.twig',array(
            'users' => $users,
            'update_user_permission' => $form_edit_array
        ));
    }

    /**
     * @Route("/admin/update/permission",name="_user_update_permission")
     */
    public function updatePermissionAction(Request $request){

    }

    public function userUpdatePermission()
    {
        $user = new Group();
        $product_edit_form = $this->createForm(UserUpdatePermissionType::class, $user, array(
            'action' => $this->generateUrl('_user_update_permission'),
            'method' => 'POST'
        )); // ProductType form builder class
        return $product_edit_form;
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