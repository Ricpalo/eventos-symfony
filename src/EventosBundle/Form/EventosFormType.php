<?php

namespace EventosBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventosFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class,[
                'label' => "form.events.name",
                'required' => true,
                'translation_domain' => 'messages'
            ])
            ->add('eventosLugares', EntityType::class, [
                'class' => 'LugaresBundle\Entity\Lugares',
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'nombre',
                'by_reference' => false,
                'required' => true,
                'label' => 'form.events.places',
                'translation_domain' => 'messages'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => 'EventosBundle\Entity\Eventos'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'eventos_bundle_eventos_form_type';
    }
}
