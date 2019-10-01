<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class, array(
                'label' => 'Id de la vidéo à remplacer',
                'attr' => array(
                    'placeholder' => 'Evolution : Relier cet input invisible en JS au bouton'
                )
            ))
            ->add('url', TextareaType::class, array(
                'label' => 'URL de la vidéo youtube',
                'attr' => array(
                    'placeholder' => 'Merci de coller le lien EMBED'
                )
            ))
            ->add('trick')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
