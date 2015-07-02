<?php


namespace Screecher\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MaintainerType extends AbstractType
{
    private $apiCollection;


    public function __construct($apiCollection)
    {
        $this->apiCollection = $apiCollection;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', array(
                'label' => 'Email',
                'constraints' => new Assert\NotBlank(),
            ))
            ->add('api', 'choice', array(
                'choices' => $this->formatApiChoiceData(),
                'multiple' => false
            ))
            ->add('save', 'submit', array(
                'label' => 'Add new maintainer',
                'attr' => array('class' => 'btn btn-inverse'),
            ));
    }

    /**
     * @return array
     */
    private function formatApiChoiceData()
    {
        $formattedData = [];

        if (!empty($this->apiCollection)) {

            foreach ($this->apiCollection as $apiObject) {
                $formattedData[$apiObject->getId()] = $apiObject->getName();
            }

        }

        return $formattedData;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'maintainer';
    }
}