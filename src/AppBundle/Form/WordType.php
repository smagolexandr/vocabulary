<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class WordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('en', TextType::class,[
                'required' => true
            ])
            ->add('uk', TextType::class,[
                'required' =>false
            ])
            ->add('ru', TextType::class,[
                'required' =>false
            ])
            ->add('de', TextType::class,[
                'required' =>false
            ])
            ->add('pl', TextType::class,[
                'required' =>false
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Word',
        ]);
    }
}