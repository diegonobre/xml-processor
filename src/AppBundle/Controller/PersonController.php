<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Form\Type\PersonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $form = $this->createForm(PostType::class, $person);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // $file stores the uploaded XML file
            $file = $person->getXmlFileName();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $imagesDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/files';
            $file->move($imagesDir, $fileName);

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $person->setXmlFileName($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('default/validation.html.twig', array(
            'errors' => $this->get('validator')->validate($person),
        ));
    }
}
