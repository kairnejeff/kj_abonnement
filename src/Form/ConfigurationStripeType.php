<?php


namespace PrestaShop\Module\Abonnement\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationStripeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('public_key', TextType::class, [
                'label' => 'Clé public Stripe',
            ])
            ->add('secret_key', TextType::class, [
                'label' => 'Clé secrète Stripe',
            ])->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PrestaShop\Module\Abonnement\Entity\ConfigurationStripe'
        ));
    }

}