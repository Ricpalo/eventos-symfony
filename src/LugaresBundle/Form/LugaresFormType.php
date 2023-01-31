<?php

namespace LugaresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LugaresFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'form.places.name',
                'required' => true,
                'translation_domain' => 'messages'
            ])
            ->add('direccion', TextType::class, [
                'label' => 'form.places.address',
                'required' => true,
                'translation_domain' => 'messages'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => 'LugaresBundle\Entity\Lugares'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'lugares_bundle_lugares_form_type';
    }
}
