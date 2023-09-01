<?php namespace App\Providers;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\Exception\JsonException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AuthenticationTokenProvider implements AuthenticationTokenProviderInterface
{
    private HttpClientInterface $httpClient;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $parameterBag, UrlGeneratorInterface $urlGenerator)
    {
        $httpClient = $httpClient->withOptions([
            'base_uri' => "{$parameterBag->get('api_base_scheme')}://{$parameterBag->get('api_base_uri')}",
            'headers' => [
                'ApiKey' => $parameterBag->get('api_key'),
            ],
        ]);

        $this->urlGenerator = $urlGenerator;
        $this->httpClient = $httpClient;
    }

    public function fetchAuthenticationToken(): string
    {
        try {
            $response = $this->httpClient->request('POST', $this->urlGenerator->generate('api_authenticator'));
            $content = $response->toArray();

            if (isset($content['token'])) {
                return $content['token'];
            }

            throw new \RuntimeException('No token in the response');
        } catch (TransportExceptionInterface|ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|JsonException $e) {
            throw new \RuntimeException('Unable to fetch authentication token', 0, $e);
        }
    }
}