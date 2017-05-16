<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction('/person/create')
            ->setMethod('POST')
            ->add('xmlFileName', FileType::class, array(
                    'label' => false,
                    'attr'   =>  array(
                        'class'   => 'file',
                        'data-min-file-count' => '1'
                    )
                )
            )
            ->add('save', SubmitType::class, array('label' => 'Process'))
            ->getForm();
        ;
    }
}
