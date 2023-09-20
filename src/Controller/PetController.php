<?php

namespace App\Controller;

use App\Form\PetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/pet', name: 'pet_')]
class PetController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $response = $this->httpClient->request('GET', 'https://petstore.swagger.io/v2/pet/findByStatus?status=available');

        $pets = $response->toArray();

        return $this->render('pet/index.html.twig', [
            'pets' => $pets,
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function add(Request $request): Response
    {
        $form = $this->createForm(PetType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            try {
                $response = $this->httpClient->request('POST', 'https://petstore.swagger.io/v2/pet', [
                    'json' => $data,
                ]);

                if ($response->getStatusCode() === 200) {
                    return $this->redirectToRoute('pet_index');
                }
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while adding a pet.');
            }
        }

        return $this->render('pet/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id): Response
    {
        $response = $this->httpClient->request('GET', 'https://petstore.swagger.io/v2/pet/'.$id);

        $pet = $response->toArray();

        $form = $this->createForm(PetType::class, [
            'name' => $pet['name'],
            'status' => $pet['status'],
        ]);
    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data['id'] = $id;
    
            try {
                $response = $this->httpClient->request('PUT', 'https://petstore.swagger.io/v2/pet', [
                    'json' => $data,
                ]);
    
                if ($response->getStatusCode() === 200) {
                    return $this->redirectToRoute('pet_index');
                }
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while editing the pet.');
            }
        }

        return $this->render('pet/edit.html.twig', [
            'form' => $form->createView(),
            'pet' => $pet,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete($id): Response
    {
        try {
            $response = $this->httpClient->request('DELETE', 'https://petstore.swagger.io/v2/pet/'.$id);

            if ($response->getStatusCode() === 200) {
                return $this->redirectToRoute('pet_index');
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'An error occurred while deleting the pet.');
        }

        return $this->redirectToRoute('pet_index');
    }

}
