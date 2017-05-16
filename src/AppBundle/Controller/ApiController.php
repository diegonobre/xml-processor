<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/api")
 */
class ApiController extends FOSRestController
{
    /**
     * Returns ONE Person from XMLProcessor by ID
     *
     * @ApiDoc(
     *   resource=true,
     *   description="Returns JSON formatted person details"
     * )
     *
     * @Get("/person/{id}")
     */
    public function personAction($id)
    {
        $person = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->find($id);

        $data = array("person" => $person);
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * Returns list of all persons from XMLProcessor
     *
     * @ApiDoc(
     *   resource=true,
     *   description="Returns JSON formatted list of persons"
     * )
     *
     * @Get("/people")
     */
    public function peopleAction()
    {
        $people = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->findBy(array(), array('personname' => 'asc'));

        $data = array("people" => $people);
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * Returns ONE ship order from XMLProcessor by ID
     *
     * @ApiDoc(
     *   resource=true,
     *   description="Returns JSON formatted ship order details"
     * )
     *
     * @Get("/shiporder/{id}")
     */
    public function shiporderAction($id)
    {
        $shiporder = $this->getDoctrine()
            ->getRepository('AppBundle:ShipOrder')
            ->find($id);

        $data = array("shiporder" => $shiporder);
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * Returns list of all ship orders from XMLProcessor
     *
     * @ApiDoc(
     *   resource=true,
     *   description="Returns JSON formatted list of ship orders"
     * )
     *
     * @Get("/shiporders")
     */
    public function shipordersAction()
    {
        $shiporders = $this->getDoctrine()
            ->getRepository('AppBundle:ShipOrder')
            ->findBy(array(), array('orderid' => 'desc'));

        $data = array("shiporders" => $shiporders);
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * @Route("/doc", name="api_doc")
     */
    public function docAction()
    {
        return $this->redirect('api/doc');
    }
}
