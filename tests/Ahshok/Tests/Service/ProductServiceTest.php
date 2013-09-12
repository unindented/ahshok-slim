<?php

namespace Ahshok\Tests\Service;

use Ahshok\Service\ProductService;

class ProductServiceTest extends \PHPUnit_Framework_TestCase {

  protected $dao;
  protected $service;

  protected function setUp() {
    $this->dao = $this->getMockBuilder('Ahshok\DAO\ProductDAO')
      ->disableOriginalConstructor()
      ->getMock();
    $this->amazon = $this->getMockBuilder('Ahshok\Service\AmazonService')
      ->disableOriginalConstructor()
      ->getMock();

    $this->service = new ProductService($this->dao, $this->amazon);
  }

  protected function tearDown() {
    $this->service = null;
  }

  public function testFindOrCreateWhenProductExists() {
    $productData = array(
      'asin'  => '0135974445',
      'title' => 'Agile Software Development'
    );

    $this->dao->expects($this->once())
      ->method('find')
      ->with($productData['asin'])
      ->will($this->returnValue($productData));

    $result = $this->service->findOrCreate($productData['asin']);

    $this->assertEquals($productData, $result);
  }

  public function testFindOrCreateWhenProductDoesNotExist() {
    $productData = array(
      'asin'  => '0321146530',
      'title' => 'Test Driven Development'
    );

    $this->dao->expects($this->once())
      ->method('find')
      ->with($productData['asin'])
      ->will($this->returnValue(false));

    $this->amazon->expects($this->once())
      ->method('lookup')
      ->with($productData['asin'])
      ->will($this->returnValue($productData));

    $this->dao->expects($this->once())
      ->method('create')
      ->with($productData)
      ->will($this->returnValue($productData));

    $result = $this->service->findOrCreate($productData['asin']);

    $this->assertEquals($productData, $result);
  }

}
