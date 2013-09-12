<?php

namespace Ahshok\Tests\Service;

use Ahshok\Service\AmazonService;

class AmazonServiceTest extends \PHPUnit_Framework_TestCase {

  protected static $config;

  protected $amazon;
  protected $service;

  public static function setUpBeforeClass() {
    self::$config = include(APPLICATION_PATH . '/config.php.dist');
  }

  protected function setUp() {
    $this->amazon = $this->getMockBuilder('ZendService\Amazon\Amazon')
      ->disableOriginalConstructor()
      ->getMock();

    $this->service = new AmazonService(self::$config['amazon'], $this->amazon);
  }

  protected function tearDown() {
    $this->service = null;
  }

  public function testLookup() {
    $productData = array(
      'asin'         => '0135974445',
      'title'        => 'Agile Software Development',
      'author'       => '',
      'link'         => '',
      'small_image'  => '',
      'medium_image' => '',
      'large_image'  => ''
    );

    $item = $this->getMockBuilder('ZendService\Amazon\Item')
      ->disableOriginalConstructor()
      ->getMock();

    $item->ASIN  = $productData['asin'];
    $item->Title = $productData['title'];

    $this->amazon->expects($this->once())
      ->method('itemLookup')
      ->with($productData['asin'])
      ->will($this->returnValue($item));

    $result = $this->service->lookup($productData['asin']);

    $this->assertEquals($productData, $result);
  }

}
