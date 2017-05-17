<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ShipOrder;
use AppBundle\Entity\ShipOrderItem;
use AppBundle\Entity\ShipOrderTo;
use AppBundle\Form\Type\ShipOrderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Util\XmlParser;

/**
 * @Route("/ship-order")
 */
class ShipOrderController extends Controller
{
    /**
     * @Route("/create", name="shiporder_create")
     * @param Request $request
     */
    public function createAction(Request $request)
    {
        $shiporder = new ShipOrder();
        $form = $this->createForm(ShipOrderType::class, $shiporder);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // $file stores the uploaded XML file
            $file = $shiporder->getXmlFileName();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $filesDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/files/';
            $file->move($filesDir, $fileName);

            $xmlString = file_get_contents($filesDir.$fileName);
            $xmlParser = new XmlParser();

            $this->processXml($xmlParser->parse($xmlString));

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('default/validation.html.twig', array(
            'errors' => $this->get('validator')->validate($shiporder),
        ));
    }

    /**
     * Save processed XML in database
     *
     * @param $xml
     */
    public function processXml($xml)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($xml as $item) {
            $shipOrder = new ShipOrder();

            $person = $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Person')
                ->findOneBy(array('id' => (int) $item->orderperson));

            if (!$person) {
                $errors[] = array('message' => 'Please upload people XML first!');

                return $this->render('default/validation.html.twig', array(
                    'errors' => $errors,
                ));
            }
            // order details
            $shipOrder->setPerson($person->getId());

            // ship order TO...
            foreach ($item->shipto as $shipToItem) {
                $shipOrderTo = new ShipOrderTo();

                $shipOrderTo->setName($shipToItem->name);
                $shipOrderTo->setAddress($shipToItem->address);
                $shipOrderTo->setCity($shipToItem->city);
                $shipOrderTo->setCountry($shipToItem->country);

                $em->persist($shipOrderTo);
            }

            // ship order ITEM...
            foreach ($item->items as $shipItem) {
                $shipOrderItem = new ShipOrderItem();

                $shipOrderItem->setTitle($shipItem->item->title);
                $shipOrderItem->setNote($shipItem->item->note);
                $shipOrderItem->setQuantity($shipItem->item->quantity);
                $shipOrderItem->setPrice($shipItem->item->price);

                $em->persist($shipOrderItem);
            }

            $em->persist($shipOrder);
        }

        $em->persist($shipOrder);
        $em->flush();
    }
}
