<?php

namespace Ahshok\Tests\DAO;

use Ahshok\DAO\ProductDAO;

class ProductDAOTest extends BaseDAOTestCase {

  protected $dao;

  protected function setUp() {
    parent::setUp();

    $this->dao = new ProductDAO($this->db);
  }

  protected function tearDown() {
    $this->dao = null;

    parent::tearDown();
  }

  public function testFindRetrievesProductByASIN() {
    $result = $this->dao->find('0135974445');

    $this->assertEquals('0135974445', $result['asin']);
  }

  public function testCreateReturnsInsertedData() {
    $result = $this->dao->create(
      array(
        'asin'         => '0321146530',
        'title'        => 'Test Driven Development',
        'author'       => 'Kent Beck',
        'link'         => 'http://www.amazon.com/Test-Driven-Development-By-Example/dp/0321146530%3Ftag%3Dunindented-20',
        'small_image'  => NULL,
        'medium_image' => NULL,
        'large_image'  => NULL,
      )
    );

    $this->assertEquals('0321146530', $result['asin']);
  }

  public function testCreateInsertsData() {
    $this->dao->create(
      array(
        'asin'         => '0321146530',
        'title'        => 'Test Driven Development',
        'author'       => 'Kent Beck',
        'link'         => 'http://www.amazon.com/Test-Driven-Development-By-Example/dp/0321146530%3Ftag%3Dunindented-20',
        'small_image'  => NULL,
        'medium_image' => NULL,
        'large_image'  => NULL,
      )
    );
    $result = $this->dao->find('0321146530');

    $this->assertEquals('0321146530', $result['asin']);
  }

}
