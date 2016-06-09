<?php

namespace CarnetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CarnetBundle\Entity\Contacts;
use CarnetBundle\Form\ContactsType;

/**
 * Contacts controller.
 *
 */
class CarnetController extends Controller
{
    /**
     * Lists all Contacts entities.
     *
     */
    public function indexAction()
    {
        return $this->render('CarnetBundle:Carnet:index.html.twig');
    }

}
