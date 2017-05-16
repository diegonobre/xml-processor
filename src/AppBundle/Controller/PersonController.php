<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Entity\PersonPhone;
use AppBundle\Form\Type\PersonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Util\XmlParser;

/**
 * @Route("/person")
 */
class PersonController extends Controller
{
    /**
     * @Route("/create", name="person_create")
     * @param Request $request
     */
    public function createAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // $file stores the uploaded XML file
            $file = $person->getXmlFileName();

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
            'errors' => $this->get('validator')->validate($person),
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
            $xmlPerson = new Person();
            $xmlPerson->setName($item->personname);

            $em->persist($xmlPerson);

            foreach ($item->phones as $phone) {
                $xmlPersonPhone = new PersonPhone();
                $xmlPersonPhone->setPerson($xmlPerson);
                $xmlPersonPhone->setPhone($phone->phone);

                $em->persist($xmlPersonPhone);
            }
        }

        $em->flush();
    }
}
