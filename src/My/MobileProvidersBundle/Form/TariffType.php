<?php
namespace My\MobileProvidersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TariffType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('provider')
            ->add('monthlyPayment')
            ->add('freeMinutes')
            ->add('internalCallsPrice')
            ->add('externalCallsPrice')
            ->add('save', 'submit')
            ->add('saveAndEdit', 'submit')
            ->add('saveAndNew', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'My\MobileProvidersBundle\Document\Tariff'
        ));
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return "Tariff";
    }
}