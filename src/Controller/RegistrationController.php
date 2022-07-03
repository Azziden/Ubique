<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\JWTService;
use App\Service\SendMailService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, ManagerRegistry $doctrine, SendMailService $mail, JWTService $jwt): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            // Generate user JWT
            // Header creation
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            //Payload Creation
            $payload = ['user_id' => $user->getId()];

            // Generate tokens
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            


            // On envoie un mail
            $mail->send(
                'no-reply@ubique.fr',
                $user->getEmail(),
                'Activation de votre compte sur le site Ubique',
                'register',
                compact('user', 'token')// It creates an array with user's content
            );


            return $this->redirectToRoute('app_accueil');
        }
        

        return $this->render('registration/registration.html.twig', [
            'form' => $form->createView(),
        ]);

        
    }

    #[Route('/verif', name : 'verify_user')]
    public function verifyUser(JWTService $jwt, UserRepository $userRepository, EntityManagerInterface $em, Request $request): Response
    {
        $token = $request->get('token');

        //verify if token is valid, is not expired and modified
        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret')))
        {
            //retrieve payload 
            $payload = $jwt->getPayload($token);

            //retrieve token's user
            $user = $userRepository->find($payload['user_id']);

            //verify that the user exist and did not activate his account
            if($user && !$user->getIsVerified())
            {
                $user->setIsVerified(true);
                $em->flush($user);
                $this->addFlash('success','Utilisateur activé');
                return $this->redirectToRoute('app_accueil');
            }

        }

        //If we have a problem with the tokens
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('app_login');

    }

    #[Route('renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        if(!$user)
        {
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');

        }

        if($user->getIsVerified()){
            $this->addflash('warning','Cet utilisateur est déjà activé');
            return $this->redirectToRoute('app_accueil');
        }
            // Generate user JWT
            // Header creation
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        //Payload Creation
        $payload = ['user_id' => $user->getId()];

        // Generate tokens
        $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

        


        // On envoie un mail
        $mail->send(
            'no-reply@ubique.fr',
            $user->getEmail(),
            'Activation de votre compte sur le site Ubique',
            'register',
            compact('user', 'token')// It creates an array with user's content
        );
        $this->addflash('success','Email de vérification envoyé');
        return $this->redirectToRoute('app_accueil');

    }

        
}
