<?php
include_once __DIR__ . '/../lib/twitter/index.php';

$app->post('/twitter', function() use ($app) {
    $ezTweet = new ezTweet();

    return $ezTweet->fetch();
});
