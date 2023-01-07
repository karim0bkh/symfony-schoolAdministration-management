<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
#[IsGranted('ROLE_USER')]

#[Route('/document')]
class DocumentController extends AbstractController
{
    #[IsGranted('ROLE_USER')]

    #[Route('/', name: 'app_document_index', methods: ['POST','GET'])]
    public function index(Request $request ,DocumentRepository $documentRepository): Response
    {


        if($request->isMethod('POST')){
            //dd($request->get('key_word'));
            $key_word = $request->get('key_word');
            $documents =$documentRepository->findBy(
                ['keyword1'=>$key_word , 'valide'=>'1' ] , ['name'=>'ASC']
            );
            $documents += $documentRepository->findBy(
                ['keyword2'=>$key_word  , 'valide'=>'1' ] , ['name'=>'ASC']
            );
            $documents += $documentRepository->findBy(
                ['keyword3'=>$key_word  , 'valide'=>'1' ] , ['name'=>'ASC']
            );
            $documents += $documentRepository->findBy(
                ['keyword4'=>$key_word  , 'valide'=>'1' ] , ['name'=>'ASC']
            );
            $documents += $documentRepository->findBy(
                ['keyword5'=>$key_word  , 'valide'=>'1' ] , ['name'=>'ASC']
            );
            


            return $this->render('document/index.html.twig', [

                'documents' => $documents,
            ]);
        }else {
                return $this->render('document/index.html.twig', [
                    'documents' => $documentRepository->findBy(['valide'=>'1']),
                ]);
            }

    }
    #[IsGranted('ROLE_USER')]

    #[Route('/new', name: 'app_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, DocumentRepository $documentRepository): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);
        $docFile = $form->get('file')->getData();

        if ($docFile) {
            $originalFilename = pathinfo($docFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$docFile->guessExtension();
            try {
                $docFile->move(
                    $this->getParameter('upload_directory2'),
                    $newFilename
                );
            } catch (FileException $e) {
            }
            $document->setFile($newFilename);
            if ($document->getKeyword3()===null)
            {
                $document->setKeyword3('Non-renseigné');
            }
            if ($document->getKeyword4()===null)
            {
                $document->setKeyword4('Non-renseigné');
            }
            if ($document->getKeyword5()===null)
            {
                $document->setKeyword5('Non-renseigné');
            }
            $document->setValide('0');

            $document->setUser($this->getUser());
            $documentRepository->save($document, true);
            return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('document/new.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_USER')]

    #[Route('/{id}', name: 'app_document_show', methods: ['GET'])]
    public function show(Document $document): Response
    {
        return $this->render('document/show.html.twig', [
            'document' => $document,
        ]);
    }

    #[IsGranted('ROLE_USER')]

    #[Route('/doc/personnelle', name: 'app_document_perso', methods: ['GET'])]
    public function perso(DocumentRepository $documentRepository): Response
    {
        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findBy(['user'=>$this->getUser()]),
        ]);
    }




    #[IsGranted('ROLE_USER')]

    #[Route('/{id}/edit', name: 'app_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SluggerInterface $slugger , Document $document, DocumentRepository $documentRepository): Response
    {
        $oldName = $document->getFile();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);
          //  dd($oldName);
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData()->getFile());
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
                                $this->getParameter('upload_directory2'),
                                $newFilename
                            );
                        } catch (FileException $e) {
                        }
                        $document->setFile($newFilename);
                       
                    }
    
                }
                $documentRepository->save($document, true);
                return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
                
            }
        return $this->renderForm('document/edit.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_USER')]

    #[Route('/{id}', name: 'app_document_delete', methods: ['POST'])]
    public function delete(Request $request, Document $document, DocumentRepository $documentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->request->get('_token'))) {
            $documentRepository->remove($document, true);
        }

        return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/show/nonvalide', name: 'app_document_valide', methods: ['POST','GET'])]
    public function doc_valide( DocumentRepository $documentRepository): Response
    {

        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findBy(['valide'=>'0']),
        ]);
    
    
    }
    #[Route('/show/nonvalide/{id}', name: 'app_document_validate', methods: ['POST','GET'])]
    public function validatee( Document $document , DocumentRepository $documentRepository): Response
    {

        $document->setValide('1');
        $documentRepository->save($document, true);
        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findBy(['valide'=>'0']),
        ]);
    
    
    }
  


}
