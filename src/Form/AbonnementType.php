<?php

namespace PrestaShop\Module\Abonnement\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbonnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_abonnement', HiddenType::class)
            ->add('id_abonnement_stripe', TextType::class, [
                'label' => 'Id Abonnement Stripe',
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('sous_titre', TextType::class, [
                'label' => 'Sous titre',
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix',
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ]);;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PrestaShop\Module\Abonnement\Entity\Abonnement'
        ));
    }
}