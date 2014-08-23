<?php

// Homepage.
$app->get('/', function() use ($app) {
	return $app->render('home.html', array('pageurl' => 'home'));
});

