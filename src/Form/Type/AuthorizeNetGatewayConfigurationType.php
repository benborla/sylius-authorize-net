<?php

declare(strict_types=1);

namespace BenBorla\AuthorizeNetPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class AuthorizeNetGatewayConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('login_id', TextType::class);
        $builder->add('transaction_key', TextType::class);
    }
}
