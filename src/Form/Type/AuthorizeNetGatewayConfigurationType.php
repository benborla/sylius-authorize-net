<?php

declare(strict_types=1);

namespace BenBorla\SyliusAuthorizeNetPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class AuthorizeNetGatewayConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login_id', TextType::class, [
                'label' => 'benborla_sylius_authorize_net.form.gateway_configuration.authorize_net.login_id',
                'constraints' => [
                    new NotBlank([
                        'message' => 'benborla_sylius_authorize_net.form.gateway_configuration.error.login_id.not_blank',
                        'groups' => 'sylius',
                    ]),
                ],
            ])
            ->add('transaction_key', TextType::class, [
                'label' => 'benborla_sylius_authorize_net.form.gateway_configuration.authorize_net.transaction_key',
                'constraints' => [
                    new NotBlank([
                        'message' => 'benborla_sylius_authorize_net.form.gateway_configuration.error.transaction_key.not_blank',
                        'groups' => 'sylius',
                    ]),
                ],
            ])
        ;
    }
}
