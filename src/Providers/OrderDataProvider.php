<?php namespace App\Providers;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\Exception\JsonException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderDataProvider implements OrderDataProviderInterface
{
    private HttpClientInterface $httpClient;
    private UrlGeneratorInterface $urlGenerator;
    private string $token;
    private ParameterBagInterface $parameterBag;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $parameterBag, UrlGeneratorInterface $urlGenerator)
    {
        $this->parameterBag = $parameterBag;
        $this->urlGenerator = $urlGenerator;
        $this->httpClient = $httpClient;
    }

    public function setupHttpClient($token)
    {
        $this->httpClient = $this->httpClient->withOptions([
            'base_uri' => "{$this->parameterBag->get('api_base_scheme')}://{$this->parameterBag->get('api_base_uri')}",
            'headers' => [
                'token' => $token,
            ],
        ]);
    }

    public function fetchOrders($page): array
    {
        try {
            $response = $this->httpClient->request('GET', $this->urlGenerator->generate('api_orders', ['page' => $page]));
            $content = $response->toArray();

            if (isset($content['data'])) {
                return $content['data'];
            }

            throw new \RuntimeException('No orders in the response');
        } catch (TransportExceptionInterface|ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|JsonException $e) {
            throw new \RuntimeException('Unable to fetch orders', 0, $e);
        }
    }

    public function fetchPageCount(): int
    {
        try {
            $response = $this->httpClient->request('GET', $this->urlGenerator->generate('api_orders', ['page' => 1]));
            $content = $response->toArray();

            if (isset($content['pageCount'])) {
                return $content['pageCount'];
            }

            throw new \RuntimeException('No orders in the response');
        } catch (TransportExceptionInterface|ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|JsonException $e) {
            throw new \RuntimeException('Unable to fetch orders', 0, $e);
        }
    }
}