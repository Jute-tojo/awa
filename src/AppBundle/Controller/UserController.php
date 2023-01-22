<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $errors = $authenticationUtils->getLastAuthenticationError();
        $email = $authenticationUtils->getLastUsername();
        return $this->render('AppBundle:User:login.html.twig', array(
            'errors' => $errors
        ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $userPasswordEncoderInterface){
        if($request->isMethod('POST')){
            $user = new User();
            $user->setUsername($request->request->get('username'));
            $user->setEmail($request->request->get('email'));
            $user->setPassword($request->request->get('password'));
            $user->setNom($request->request->get('nom'));
            $user->setPrenom($request->request->get('prenom'));
            $user->setAdresse($request->request->get('adresse'));
            $user->setTelephone($request->request->get('telephone'));
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword($userPasswordEncoderInterface->encodePassword($user, $user->getPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('AppBundle:User:register.html.twig');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }

    /**
     * @Route("/api/users")
     */
    public function userApiAction(){
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return new Response(json_encode($users), 200);
    }
    
    /**
     * @Route("/utilisateur", name="user.index")
     */
    public function userAction(){
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render("default/user/index.html.twig",[
           'users'  => $users
        ]);
    }

    /**
     * @Route("/utilisateur/create", name="user.create")
     */
    public function userCreate(Request $request, UserPasswordEncoderInterface $userpass){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $password = $userpass->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user.index');
        }
        return $this->render("default/user/create.html.twig", [
            'formUser' => $form->createView()
        ]);
    }
}
