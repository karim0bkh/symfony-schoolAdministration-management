<?php
 
namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Demande;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
class PdfGeneratorController extends AbstractController
{
   
    #[IsGranted('ROLE_USER')]

    #[Route('/pdf/generator/{id}', name: 'app_pdf_generator')]
    public function index(Demande $demande): Response
    {
        // return $this->render('pdf_generator/index.html.twig', [
        //     'controller_name' => 'PdfGeneratorController',
        // ]);


        $writer = new PngWriter();
        $qrCode = QrCode::create('polytechnique sousse')
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(120)
            ->setMargin(0)
            ->setForegroundColor(new Color(255,69,0))
            ->setBackgroundColor(new Color(0, 0, 255));


            $qrCodes = [];
            $label = Label::create('')->setFont(new NotoSans(8));
            $qrCodes['simple'] = $writer->write(
                                    $qrCode,
                                    null,
                                    $label->setText('Ecole Polytechnique')
                                )->getDataUri();





        if($demande->getType() === 'type2'){
        $html =  $this->renderView('pdf_generator/type2.html.twig', [
            'demande' => $demande,'qrcode'=>$qrCodes]);
        }
        elseif($demande->getType() === 'type1'){
            $html =  $this->renderView('pdf_generator/type1.html.twig', [
                'demande' => $demande,'qrcode'=>$qrCodes]);
            }
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
         
        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
 
   
}