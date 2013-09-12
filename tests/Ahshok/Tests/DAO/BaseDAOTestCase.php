<?php

namespace Ahshok\Tests\DAO;

class BaseDAOTestCase extends \PHPUnit_Framework_TestCase {

  protected static $config;

  protected $db;

  public static function setUpBeforeClass() {
    self::$config = include(APPLICATION_PATH . '/config.php.dist');
  }

  protected function setUp() {
    $pdo = self::$config['pdo'];

    $this->db = new \PDO(
      $pdo['dsn'],
      $pdo['username'],
      $pdo['password'],
      $pdo['options']
    );

    $this->db->exec(file_get_contents(self::$config['schema']));
    $this->db->exec(file_get_contents(self::$config['seed']));
  }

  protected function tearDown() {
    $this->db = null;
  }

}
