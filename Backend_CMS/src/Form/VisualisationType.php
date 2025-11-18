<?php

namespace App\Form;

use App\Entity\Bloc;
use App\Entity\Dataset;
use App\Entity\Visualisation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisualisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_visualisation')
            ->add('correspondance_json')
            ->add('style_json')
            ->add('filter_json')
            ->add('note')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('updated_at', null, [
                'widget' => 'single_text',
            ])
            ->add('bloc', EntityType::class, [
                'class' => Bloc::class,
                'choice_label' => 'id',
            ])
            ->add('dataset', EntityType::class, [
                'class' => Dataset::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visualisation::class,
        ]);
    }
}
