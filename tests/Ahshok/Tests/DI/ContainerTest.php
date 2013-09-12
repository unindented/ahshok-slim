<?php

namespace Ahshok\Tests\DI;

use Ahshok\DI\Container;

class ContainerTest extends \PHPUnit_Framework_TestCase {

  protected static $config;

  protected $container;

  public static function setUpBeforeClass() {
    self::$config = include(APPLICATION_PATH . '/config.php.dist');
  }

  protected function setUp() {
    $this->container = new Container(self::$config);
  }

  public function testContainerCreatesPDO() {
    $this->assertInstanceOf('PDO', $this->container['db']);
  }

  public function testContainerCreatesAmazonService() {
    $this->assertInstanceOf('Ahshok\Service\AmazonService', $this->container['amazonService']);
  }

  public function testContainerCreatesProductService() {
    $this->assertInstanceOf('Ahshok\Service\ProductService', $this->container['productService']);
  }

}
