<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\AddContactType;
use App\Form\UpdateContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    #[Route('/contact/add', name: 'app_add_contact')]
    public function add(Request $request, entityManagerInterface $entityManager): Response
    {
        $contact = new Contact();

        $form = $this->createForm(AddContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            // Utilisez l'EntityManager pour persister l'utilisateur
            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash('success',"L'annonce à bien été ajoutée");

            // Faites tout ce que vous devez faire après l'ajout

            return $this->redirectToRoute('app_all_contact');
        }

        return $this->render('contact/addContact.html.twig', [
            'NewContactForm' => $form->createView(),
        ]);
    }

    #[Route('/contact/remove/{id_contact}', name: 'app_remove_contact')]
    public function remove(int $id_contact, EntityManagerInterface $entityManager): Response
    {

        $contact = $entityManager->getRepository(Contact::class)->find($id_contact);

        if (!$contact) {
            throw $this->createNotFoundException(
                'No user found for id ' . $id_contact
            );
        }

        $entityManager->remove($contact);
        $entityManager->flush();

        return $this->redirectToRoute('app_all_contact');
    }

    #[Route('contact/update/{id_contact}', name: 'app_update_contact')]
    public function update(int $id_contact, Request $request, EntityManagerInterface $entityManager): Response
    {

        $contact = $entityManager->getRepository(Contact::class)->find($id_contact);

        $form = $this->createForm(UpdateContactType::class, $contact);
        $form->handleRequest($request);

        if (!$contact) {
            return $this->redirectToRoute('contact/contact_not_found.html.twig');
        }

        if ($form->isSubmitted() && $form->isValid()) {

            // Utilisez l'EntityManager pour persister l'utilisateur
            $entityManager->flush();

            // Faites tout ce que vous devez faire après l'ajout

            return $this->redirectToRoute('app_all_contact', ['id_contact' => $contact]);
        }
        return $this->render('contact/updateContactForm.html.twig', [
            'UpdateContactForm' => $form->createView(),
            'SelectedContact' => $contact,
        ]);

    }
}
