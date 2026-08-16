<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Nfse\Http\Retry;

it('retries a GET when the national environment answers 503', function () {
    $mock = new MockHandler([
        new Response(503),
        new Response(200, [], '%PDF-1.7'),
    ]);

    $response = (new Client(['handler' => Retry::stack($mock)]))->get('/danfse/123');

    expect($response->getStatusCode())->toBe(200)
        ->and((string) $response->getBody())->toBe('%PDF-1.7')
        ->and($mock->count())->toBe(0);
});

it('gives up after the retry limit', function () {
    $mock = new MockHandler([
        new Response(503),
        new Response(503),
        new Response(503),
    ]);

    expect(fn () => (new Client(['handler' => Retry::stack($mock)]))->get('/danfse/123'))
        ->toThrow(ServerException::class);

    expect($mock->count())->toBe(0);
});

it('never retries a POST, to avoid duplicating NFS-e', function () {
    $mock = new MockHandler([
        new Response(503),
        new Response(200, [], 'ok'),
    ]);

    expect(fn () => (new Client(['handler' => Retry::stack($mock)]))->post('/nfse'))
        ->toThrow(ServerException::class);

    expect($mock->count())->toBe(1);
});
