<?php

namespace InvitadosBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvitadosFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'form.guests.name',
                'required' => true,
                'translation_domain' => 'messages'
            ])
            ->add('evento', EntityType::class, [
                'placeholder' => '-- Escoge un evento --',
                'class' => 'EventosBundle\Entity\Eventos',
                'required' => true,
                'label' => 'form.guests.event',
                'translation_domain' => 'messages'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => 'InvitadosBundle\Entity\Invitados'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'invitados_bundle_invitados_form_type';
    }
}
