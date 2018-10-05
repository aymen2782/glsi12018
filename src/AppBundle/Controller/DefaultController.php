<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/test/{name}", name="homepage")
     */
    public function indexAction(Request $request, $name)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/users/list",name="usersList")
     */
    public function listUserAction(Request $request) {
        $session =  $request->getSession();
        // je teste si la session existe
         // si non je crée la sessio vide
        if (!$session->has("users")) {
               $users= array();
               $session->set("users",$users);
               $session->getFlashBag()->add("init","Session initialisée avec succées");
           }
        return $this->render("@App/Users/index.html.twig");
    }

    /**
     * @param Request $request
     * @param $username
     * @param $name
     * @Route("/users/add/{username}/{name}",
     *          name="add-user",
     *          defaults={"name":"fakename"})
     */
  public function addUserAction(Request $request, $username, $name) {
        $session =  $request->getSession();
        // si j'ai ma variable de session
        if ($session->has("users")) {
            $users = $session->get('users');
            // tester si le username existe
            if (isset($users[$username])) {
                // si oui message erreur
                $session->getFlashBag()->add("error","User $username existe déjà :(");
            } else {
                $users[$username]=$name;
                $session->getFlashBag()->add("success","User $username ajouté avec succés");
                $session->set('users',$users);
            }
        }
        return $this->forward('AppBundle:Default:listUser');
    }

    /**
     * @param Request $request
     * @param $username
     * @param $name
     * @Route("/users/update/{username}/{name}", name="update-user")
     */
    public function updateUserAction(Request $request, $username, $name) {
        // je récupére ma session
        $session = $request->getSession();

        // je teste si ma session contient la liste des users
        if(!$session->has("users")){
            // si non
            // message erreur
            $session->getFlashBag()->add('error','session innexistante on va la créer');
        } else {
            //  si oui
            // je vérifie si le user existe
            $users = $session->get('users');
            if (!isset($users[$username])){
                // si non
                // message erreur user innexistant
                $session->getFlashBag()->add('error',"User $username innexistant");
            } else {
                // si oui je modifie et message de succés
                $users[$username]=$name;
                $session->set('users',$users);
                $session->getFlashBag()->add('success',"User $username modifié avec succés");
            }
        }
        return $this->redirectToRoute('usersList');
        // jE FORWARD AU CONTROLLEJUR QUI VA AFFFICHER
    }

    /**
     * @param Request $request
     * @param $usename
     * @Route("/users/delete/{username}")
     */
    public function deleteUserAction(Request $request, $username) {
        // je récupére ma session
        $session = $request->getSession();

        // je teste si ma session contient la liste des users
        if(!$session->has("users")){
            // si non
            // message erreur
            $session->getFlashBag()->add('error','session innexistante on va la créer');
        } else {
            //  si oui
            // je vérifie si le user existe
            $users = $session->get('users');
            if (!isset($users[$username])){
                // si non
                // message erreur user innexistant
                $session->getFlashBag()->add('error',"User $username innexistant");
            } else {
                // si oui je modifie et message de succés
                unset($users[$username]);
                $session->set('users',$users);
                $session->getFlashBag()->add('success',"User $username supprimé avec succés");
            }
        }
        return $this->redirectToRoute('usersList');
        // jE FORWARD AU CONTROLLEJUR QUI VA AFFFICHER
    }

    /**
     * @Route("/users/reset", name="rest-user")
     */
    public function resetUsersAction(Request $request){
        $session = $request->getSession();

        // je teste si ma session contient la liste des users
        if(!$session->has("users")){
            // si non
            // message erreur
            $session->getFlashBag()->add('error','session innexistante on va la créer');
        } else {
            //  si oui
            // je vide la session
            $session->clear();
            $session->getFlashBag()->add('success',"Session réinitialisé avec succès");
        }
        return $this->redirectToRoute('usersList');
        // jE FORWARD AU CONTROLLEJUR QUI VA AFFFICHER
    }

}
