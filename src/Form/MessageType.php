<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Conversation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', null, [
                'label' => 'Content',
                'attr' => ['class' => 'form-control']
            ])
            ->add('conversation', EntityType::class, [
                'class' => Conversation::class,
                'label' => 'Conversation',
                'choice_label' => 'participant', // or any other property you want to display
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}