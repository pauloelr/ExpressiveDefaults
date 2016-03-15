<?php

namespace App\Action;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class PicturePageAction
{
    private $router;

    private $template;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null)
    {
        $this->router   = $router;
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $client = new Client();

        $headers = ['Accept' => 'application/json'];

        $request = new Request(
            'GET',
            'http://api.primebuilder.com/api/v1/integration/43?username=psycoadmin&password=090316&company=792',
            $headers
        );

        $response = $client->send($request, ['timeout' => 200]);
        $response = $response->getBody()->getContents();
        $response = json_decode($response);
        $data = [
            'response' => $response
        ];

        return new HtmlResponse($this->template->render('app::pic-view', $data));
    }
}
