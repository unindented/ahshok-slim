<?php

namespace Ahshok\DI;

use Slim\Slim;

class SlimContainer extends Container {

  public function __construct(Slim $app, array $config) {
    parent::__construct($config);

    $this['slim'] = $app;
  }

}
