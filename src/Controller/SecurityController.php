<?php

namespace App\Controller;

use App\Service\SendMailService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ResetPasswordRequestFormType;
use App\Form\ResetPasswordFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/oubli-pass', name: 'forgotten_password')]
    public function forgottenPassword(Request $request, UserRepository $userRepository, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $entityManager, SendMailService $mail): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //search an user by his email
            $user = $userRepository->findOneByEmail($form->get('email')
            ->getData());

            //Verify if we have an user 
            if($user)
            {
                //Generate a reset token
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                //Generate a link to reset the password
                $url = $this->generateUrl('reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                //Create mail data for the user
                $context = compact('url', 'user');

                //Send Mail
                $mail->send(
                    'ubiquecp@gmail.com',
                    $user->getEmail(),
                    'Réinitialisation de mot de passe',
                    'password_reset',
                    $context
                );

                $this->addFlash('success', 'Email envoyé avec succès');
                return $this->redirectToRoute('app_login');

                

            }
            //if $user is null
            $this->addFlash('danger', 'Un problème est survenu');
            return $this->redirectToRoute('app_login');

        }

        return $this->render('security/reset_password_request.html.twig',
        [
            'requestPassForm' => $form->createView()

        ]);
    }

    #[Route('/oubli-pass/{token}', name:'reset_pass')]
    public function resetPass(string $token,
      Request $request,
      UserRepository $userRepository,
      EntityManagerInterface $entityManager,
      UserPasswordHasherInterface $passwordHasher
    ): Response
    {
        //Verify if we have the token on our db
        $user = $userRepository->findOneByResetToken($token);

        if($user)
        {
            $form = $this->createForm(ResetPasswordFormType::class);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                //Delete token
                $user->setResetToken('');
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Mot de passe changé avec succès');
                return $this->redirectToRoute('app_login');


            }

            return $this->render('security/reset_password.html.twig',
            [
                'passForm' => $form->createView()
            ]);
        }
        $this->addFlash('danger', 'Jeton invalide');
        return $this->redirectToRoute('app_login');

    }

}
