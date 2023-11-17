<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_all_contact')]
    public function show(ContactRepository $repo): Response
    {

        $liste = $repo->findAll();

        return $this->render('default/index.html.twig', [
            'contacts' => $liste,
        ]);
    }

    #[Route('/contact/detail/{id_contact}', name: 'contact_detail')]
    public function detail(int $id_contact, ContactRepository $repo): Response
    {
        $contactSelected = $repo->find($id_contact);
        return $this->render('default/detailContact.html.twig', [
            'contactSelected' => $contactSelected,
        ]);
    }
}
