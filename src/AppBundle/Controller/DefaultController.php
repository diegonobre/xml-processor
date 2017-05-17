<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Entity\ShipOrder;
use AppBundle\Form\Type\PersonType;
use AppBundle\Form\Type\ShipOrderType;
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
        $personForm = $this->createForm(PersonType::class, $person);

        $shipOrder = new ShipOrder();
        $shipOrderForm = $this->createForm(ShipOrderType::class, $shipOrder);

        return $this->render('default/index.html.twig', array(
            'person_form' => $personForm->createView(),
            'shiporder_form' => $shipOrderForm->createView(),
            'validations' => $validations,
        ));
    }
}
