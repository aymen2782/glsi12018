<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends Controller
{
    /**
     * @Route("/list")
     */
    public function listAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('todos')){
            $session->getFlashBag()->add('info','Session initialisée avec succès :D');
            $todos = array(
                'Lundi '=>"reprise Boulot",
                'Mercreddi'=>"Champions league"
            );
            $session->set('todos',$todos);
        }

        return $this->render('@App/Todo/list.html.twig');
    }

    /**
     * @Route("/test",name="test-req")
     */
    public function testAction(){
        return $this->render('@App/ToDo/fils.html.twig',
            array(
                'var1'=>'ma var 1',
                'var2'=>'ma var 2'
            ));
    }

}
