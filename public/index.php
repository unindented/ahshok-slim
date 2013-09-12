<?php

use Ahshok\DI\SlimContainer;
use Slim\Slim;

require(__DIR__ . '/../vendor/autoload.php');

$config = require_once(__DIR__ . '/../config.php');

$app = new Slim($config['slim']);
$container = new SlimContainer($app, $config);

// Product URL.
$app->get('/:asin', function ($asin) use ($app, $container) {
  $product = $container['productService']->findOrCreate($asin);
  $app->redirect($product['link'], 301);
})->conditions(array('asin' => '([0-9A-Z]{10})'));

// Image URL.
$app->get('/:asin.jpg', function ($asin) use ($app, $container) {
  $product = $container['productService']->findOrCreate($asin);
  $app->redirect($product['medium_image'], 301);
})->conditions(array('asin' => '([0-9A-Z]{10})'));

$app->run();
