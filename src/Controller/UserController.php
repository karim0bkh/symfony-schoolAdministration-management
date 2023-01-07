<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher,UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            if($user->getType() === 'etudiant'){
                $user->setRoles(['ROLE_ETUDIANT']);
            }elseif($user->getType() === 'prof')
            {
                $user->setRoles(['ROLE_PROF']);
            }elseif($user->getType() === 'admin')
            {
                $user->setRoles(['ROLE_ADMIN']);
            }
            
            $userRepository->save($user, true);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserPasswordHasherInterface $userPasswordHasher,  User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $oldtype = $user->getType();
       // if($user->getType()==='etudiant' or $user->getType()==='prof'){
        //    $form->remove('type');
            
       // }
        if ($form->isSubmitted() && $form->isValid()) {
            //if($form->get('type')===null){$user->setType($oldtype);}
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );


            if($user->getType() === 'etudiant'){
                $user->setRoles(['ROLE_ETUDIANT']);
            }elseif($user->getType() === 'prof')
            {
                $user->setRoles(['ROLE_PROF']);
            }elseif($user->getType() === 'admin')
            {
                $user->setRoles(['ROLE_ADMIN']);
            }
        
            $userRepository->save($user, true);
            if($user->getType()==='etudiant' or $user->getType()==='prof'){
                return $this->redirectToRoute('app_stage_index', [], Response::HTTP_SEE_OTHER);
                
            }  else {
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
    }
        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
