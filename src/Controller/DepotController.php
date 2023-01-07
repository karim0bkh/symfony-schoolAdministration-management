<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Form\DepotType;
use App\Repository\DepotRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
#[IsGranted('ROLE_USER')]
#[Route('/depot')]
class DepotController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_depot_index', methods: ['POST','GET'])]
    public function index(Request $request ,DepotRepository $depotRepository): Response
    {

        if($this->getUser()->getRoles()[0] === 'ROLE_ETUDIANT'){
            return $this->render('depot/index.html.twig', [
                'depots' => $depotRepository->findBy(['user'=>$this->getUser()]),
            ]);
        }


        if($request->isMethod('POST')){
            //dd($request->get('key_word'));
            $key_word = $request->get('key_word');
            $depots = $depotRepository->findBy(['matricule'=>$key_word]);
            return $this->render('depot/index.html.twig', [
                'depots' => $depots,
            ]);
        }else {
        return $this->render('depot/index.html.twig', [
            'depots' => $depotRepository->findAll(),
        ]);
            }

    }
    #[IsGranted('ROLE_USER')]

    #[Route('/new', name: 'app_depot_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, DepotRepository $depotRepository): Response
    {
        $depot = new Depot();
        $form = $this->createForm(DepotType::class, $depot);
        $form->handleRequest($request);
        $docFile = $form->get('file')->getData();

        if ($docFile) {
            $originalFilename = pathinfo($docFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$docFile->guessExtension();
            try {
                $docFile->move(
                    $this->getParameter('upload_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
            }
            $depot->setFile($newFilename);
            $depot->setUser($this->getUser());
            $depotRepository->save($depot, true);
            return $this->redirectToRoute('app_depot_index', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->renderForm('depot/new.html.twig', [
            'depot' => $depot,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: 'app_depot_show', methods: ['GET'])]
    public function show(Depot $depot): Response
    {
        return $this->render('depot/show.html.twig', [
            'depot' => $depot,
        ]);
    }
    #[IsGranted('ROLE_USER')]

    #[Route('/{id}/edit', name: 'app_depot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SluggerInterface $slugger ,Depot $depot, DepotRepository $depotRepository): Response
    {
        $oldName = $depot->getFile();
        $form = $this->createForm(DepotType::class, $depot); 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData()->getFile() === null);

            if($form->getData()->getFile() === null){
                $form->getData()->setFile($oldName);
            }else {
                $docFile = $form->get('file')->getData();

                if ($docFile) {
                    $originalFilename = pathinfo($docFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$docFile->guessExtension();
                    try {
                        $docFile->move(
                            $this->getParameter('upload_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                    }
                    $depot->setFile($newFilename);
                    
                }

                }
                $depotRepository->save($depot, true);
                    return $this->redirectToRoute('app_depot_index', [], Response::HTTP_SEE_OTHER);
            
        }

        return $this->renderForm('depot/edit.html.twig', [
            'depot' => $depot,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_PROF')]
    #[Route('/{id}', name: 'app_depot_delete', methods: ['POST'])]
    public function delete(Request $request, Depot $depot, DepotRepository $depotRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$depot->getId(), $request->request->get('_token'))) {
            $depotRepository->remove($depot, true);
        }

        return $this->redirectToRoute('app_depot_index', [], Response::HTTP_SEE_OTHER);
    }
}
