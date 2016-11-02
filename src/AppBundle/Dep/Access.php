<?php
namespace AppBundle\Dep;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Access extends Controller
{

    public function checkPermission($authCheck, $role)
    {
        if ($authCheck->isGranted($role)) {
            //throw new AccessDeniedException();
           return true;
        } else {
            return false;
        }
    }
}