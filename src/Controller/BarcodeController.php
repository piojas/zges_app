<?php

namespace App\Controller;

use App\Form\BarcodeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Picqer\Barcode\BarcodeGenerator;
use Picqer\Barcode\BarcodeGeneratorPNG;

#[Route('/barcode', name: 'barcode_')]
class BarcodeController extends AbstractController
{    
    private $pathImage = 'images/barcode';

    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(BarcodeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $text = $data['text'];

            $this->_barcodeGenerate(new BarcodeGeneratorPNG(), $text);
            $this->_convertPng2Webp();
            
            return $this->render('barcode/generate.html.twig', [
                'barCode' => $text,
            ]);
        }

        return $this->render('barcode/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function _barcodeGenerate(
        BarcodeGeneratorPNG $generator, 
        $text, 
        $type = BarcodeGenerator::TYPE_CODE_128, 
        $factor = 2, 
        $height = 50
    ): void {        
        file_put_contents($this->pathImage.'.png', $generator->getBarcode($text, $type, $factor, $height));
    }

    private function _convertPng2Webp(): void
    {
        $img = imagecreatefrompng($this->pathImage.'.png');
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        imagewebp($img, $this->pathImage.'.webp', 100);
        imagedestroy($img);
    }
}
