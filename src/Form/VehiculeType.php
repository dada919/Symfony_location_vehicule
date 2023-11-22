<?php

namespace App\Form;

use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    private $repo ;

    public function __construct(VehiculeRepository $repo)
    {
        $this->repo =  $repo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre') 
            ->add('marque')
            ->add('modele')
            ->add('description')
            ->add('photo')
            ->add('prix_journalier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class, 
        ]);
    }
}