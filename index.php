<?php
header('content-type: text/html; charset: utf-8');
ini_set('default_charset', 'UTF-8');

ini_set('display_errors','On');
error_reporting('ALL');

defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/app'));

defined('APPLICATION_ROOT')
|| define('APPLICATION_ROOT', realpath(dirname(__FILE__) ));

defined('BASE_URL')
|| define('BASE_URL', url() );

// Slim
require APPLICATION_PATH . '/vendor/Slim/Slim.php';
require APPLICATION_PATH . '/vendor/Views/TwigView.php';
 
// Paris and Idiorm
require APPLICATION_PATH . '/vendor/Paris/idiorm.php';
require APPLICATION_PATH . '/vendor/Paris/paris.php';

// Configuration
TwigView::$twigDirectory = APPLICATION_PATH . '/vendor/Twig/lib/Twig/';
TwigView::$twigOptions = array('debug' => true);


/**
 * IF we need database access
 * ORM::configure('mysql:host=localhost;dbname=blog');
 * ORM::configure('username', 'root');
 * ORM::configure('password', '');
 * 
 */
// Start Slim.
$app = new Slim(array(
        'view' =>           new TwigView,
		'templates.path' => APPLICATION_ROOT . '/public/templates'
));

require APPLICATION_PATH . '/routes/test.php';
require APPLICATION_PATH . '/routes/home.php';
require APPLICATION_PATH . '/routes/twitter.php';
require APPLICATION_PATH . '/routes/contact.php';
require APPLICATION_PATH . '/lib/mercadopago/mercadopago.php';
require APPLICATION_PATH . '/routes/mercadopagonotifications.php';

$app->hook('slim.before', function () use ($app) {
	$app->view()->appendData(array('baseUrl' => BASE_URL . '/../public'));
});


// Slim Run.
$app->run();


function url(){
	$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	return $protocol . "://" . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'],PHP_URL_FRAGMENT);
}
