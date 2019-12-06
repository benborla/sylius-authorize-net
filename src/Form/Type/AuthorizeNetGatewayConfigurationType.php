<?php
declare(strict_types=1);

namespace BenBorla\AuthorizeNetPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class AuthorizeNetGatewayConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login_id', TextType::class, [
                'label' => 'Login ID',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Login ID should not be empty',
                        'groups' => ['sylius']
                    ])
                ]
            ])
            ->add('transaction_key', TextType::class, [
                'label' => 'Transaction Key',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Transaction key should not be empty',
                        'groups' => ['sylius']
                    ])
                ]
            ])
            ->add('sandbox', ChoiceType::class, [
                'choices' => [
                    'yes' => 1,
                    'no' => 0
                ],
                'label' => 'Use Sandbox'
            ]);
    }

}
