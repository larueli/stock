<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Consommable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsommableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, array("label"=>"Nom du produit"))
            ->add('quantite', IntegerType::class, array("label"=>"Quantite actuelle"))
            ->add('quantiteOptimale', IntegerType::class, array("label"=>"Quantite optimale à avoir en stock"))
            ->add('quantiteEnMoinsJour', IntegerType::class, array("label"=>"Nombre de consommable en moins par jour, mettre 0 pour gestion manuelle", "empty_data"=>0, "required"=>false))
            ->add('venduParPaquetsDe', IntegerType::class, array("label"=>"Vendu par paquets de x consommables"))
            ->add('prixPaquet', MoneyType::class, array("label"=>"Prix du paquet", "currency"=>"EUR"))
            ->add('prixUnite', MoneyType::class, array("label"=>"Prix a l'unité si appliquable", "empty_data"=>0.0, "required"=>false, "currency"=>"EUR"))
            ->add('categorie', EntityType::class, array("class"=>Categorie::class, "choice_label"=>"nom"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consommable::class,
        ]);
    }
}
