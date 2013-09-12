<?php

namespace Ahshok\DI;

use Ahshok\DAO\ProductDAO;
use Ahshok\Service\ProductService;
use Ahshok\Service\AmazonService;
use ZendService\Amazon\Amazon;

class Container extends \Pimple {

  public function __construct(array $config) {
    parent::__construct();

    $this['config'] = $config;

    $this->configureContainer();
  }

  protected function configureContainer() {
    $cont = $this;

    $this['db'] = $this->share(function () use ($cont) {
      $config = $cont['config']['pdo'];
      return new \PDO(
        $config['dsn'],
        $config['username'],
        $config['password'],
        $config['options']
      );
    });

    $this['zendService'] = function () use ($cont) {
      $config = $cont['config']['amazon'];
      return new Amazon(
        $config['key'],
        $config['country'],
        $config['secret']
      );
    };

    $this['amazonService'] = function () use ($cont) {
      $config = $cont['config']['amazon'];
      return new AmazonService($config, $cont['zendService']);
    };

    $this['productDAO'] = function () use ($cont) {
      return new ProductDAO($cont['db']);
    };

    $this['productService'] = function () use ($cont) {
      return new ProductService($cont['productDAO'], $cont['amazonService']);
    };
  }

}
