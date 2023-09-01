<?php namespace App\Providers;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

interface AuthenticationTokenProviderInterface
{
    public function fetchAuthenticationToken(): string;
}