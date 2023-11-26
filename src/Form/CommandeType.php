<?php

namespace App\Form;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CommandeType extends AbstractType
{
    private $repo;

    public function __construct(CommandeRepository $repo)
    {
        $this->repo =  $repo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_vehicule')
            ->add('prix_total')
            ->add('date_heure_depart', DateTimeType::class, [
                'label' => 'Date et heure de début',
                'widget' => 'single_text',
            ])
            ->add('date_heure_fin', DateTimeType::class, [
                'label' => 'Date et heure de fin',
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
