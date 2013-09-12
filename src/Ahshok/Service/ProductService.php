<?php

namespace Ahshok\Service;

use Ahshok\DAO\ProductDAO;

class ProductService {

  private $dao;
  private $amazon;

  public function __construct(ProductDAO $dao, AmazonService $amazon) {
    $this->dao = $dao;
    $this->amazon = $amazon;
  }

  public function findOrCreate($asin) {
    $product = $this->dao->find($asin);

    if (!$product) {
      $product = $this->dao->create($this->amazon->lookup($asin));
    }

    return $product;
  }

}
