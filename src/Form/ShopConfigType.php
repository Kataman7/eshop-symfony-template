<?php

namespace App\Form;

use App\Entity\ShopConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shopName', null, [
                'label' => 'Shop Name',
                'attr' => ['class' => 'form-control']
            ])
            ->add('shopDescription', null, [
                'label' => 'Shop Description',
                'attr' => ['class' => 'form-control', 'rows' => 4]
            ])
            ->add('bannerMessage', null, [
                'label' => 'Top Banner Message (Optional)',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('instagramLink', null, [
                'label' => 'Instagram URL',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('twitterLink', null, [
                'label' => 'Twitter URL',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('facebookLink', null, [
                'label' => 'Facebook URL',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('supportEmail', null, [
                'label' => 'Support Email',
                'attr' => ['class' => 'form-control']
            ])
            ->add('supportPhone', null, [
                'label' => 'Support Phone',
                'attr' => ['class' => 'form-control']
            ])
            ->add('address', null, [
                'label' => 'Address',
                'attr' => ['class' => 'form-control']
            ])
            ->add('aboutText', null, [
                'label' => 'About Text',
                'help' => 'This text appears in the footer and About page.',
                'attr' => ['class' => 'form-control', 'rows' => 4]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShopConfig::class,
        ]);
    }
}
