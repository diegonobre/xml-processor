<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Form\Type\PersonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction($validations = null)
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);

        // list images
        $em = $this->getDoctrine()->getManager();
        $people = $em->getRepository('AppBundle:Person')->findBy(array(), array('name' => 'asc'));

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
            'people' => $people,
            'validations' => $validations,
        ));
    }
}
