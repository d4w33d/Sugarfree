<?php

$this->attachHandler('/', function($request, $response)
{
    return $response->json(array(
        'song' => array(
            'artist' => 'Joan Baez',
            'title' => 'Diamonds And Rust',
            'duration' => 4 + (47 / 60),
            'url' => 'http://open.spotify.com/track/5lZ4Dm9BBGcCBVbfzxnyCX'
        )
    ));
});
