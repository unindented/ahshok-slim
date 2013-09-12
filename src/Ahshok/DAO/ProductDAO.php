<?php

namespace Ahshok\DAO;

class ProductDAO {

  private $db;

  public function __construct(\PDO $db) {
    $this->db = $db;
  }

  public function find($asin) {
    $sql = <<<'EOD'
      SELECT * FROM products WHERE asin = :asin
EOD;

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':asin', $asin);
    $stmt->execute();

    return $stmt->fetch();
  }

  public function create(array $data) {
    $sql = <<<'EOD'
      INSERT INTO products (asin, title, author, link, small_image, medium_image, large_image)
      VALUES (:asin, :title, :author, :link, :small_image, :medium_image, :large_image)
EOD;

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':asin',         $data['asin']);
    $stmt->bindValue(':title',        $data['title']);
    $stmt->bindValue(':author',       $data['author']);
    $stmt->bindValue(':link',         $data['link']);
    $stmt->bindValue(':small_image',  $data['small_image']);
    $stmt->bindValue(':medium_image', $data['medium_image']);
    $stmt->bindValue(':large_image',  $data['large_image']);
    $stmt->execute();

    return $data;
  }

}
