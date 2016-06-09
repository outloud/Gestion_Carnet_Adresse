<?php

namespace CarnetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CarnetBundle\Entity\Contacts;
use UserBundle\Entity\Utilisateurs;
use CarnetBundle\Form\ContactsType;

/**
 * Contacts controller.
 *
 */
class ContactsController extends Controller
{
    /**
     * Lists all Contacts entities.
     *
     */
    public function indexAction()
    {
       // $user = $this->container->get('security.context')->getToken()->getUser();
        $user = $this->getUser();

        $contacts = $user->getContacts();

        return $this->render('CarnetBundle:Contact:index.html.twig', array(
            'contacts' => $contacts, 'user' => $user,
        ));
    }

    /**
     * Creates a new Contacts entity.
     *
     */
    public function newAction(Request $request)
    {
        $contact = new Contacts();
        $form = $this->createForm('CarnetBundle\Form\ContactsType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('contacts_show', array('id' => $contact->getId()));
        }

        return $this->render('CarnetBundle:Contact:new.html.twig', array(
            'contact' => $contact,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Contacts entity.
     *
     */
    public function showAction(Contacts $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);
        return $this->render('CarnetBundle:Contact:show.html.twig', array(
            'contact' => $contact,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Contacts entity.
     *
     */
    public function editAction(Request $request, Contacts $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);
        $editForm = $this->createForm('CarnetBundle\Form\ContactsType', $contact);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('contacts_index');
        }

        return $this->render('CarnetBundle:Contact:edit.html.twig', array(
            'contact' => $contact,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Contacts entity.
     *
     */
    public function deleteAction(Request $request, Contacts $contact)
    {
        $form = $this->createDeleteForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush();
        }

        return $this->redirectToRoute('contacts_index');
    }

    /**
     * Creates a form to delete a Contacts entity.
     *
     * @param Contacts $contact The Contacts entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contacts $contact)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contacts_delete', array('id' => $contact->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function createUserAction(Contacts $contact)
    {
        $user = new Utilisateurs();
        $em = $this->getDoctrine()->getManager();

        $user->setUsername($contact->getEmail());
        $user->setUsernameCanonical($contact->getEmail());
        $user->setEmail($contact->getEmail());
        $user->setEmailCanonical($contact->getEmail());
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $contact->getEmail());
        $user->setPassword($password);
        $user->setEnabled(true);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('contacts_index');
    }
}
