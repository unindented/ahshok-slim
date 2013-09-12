<?php

namespace Ahshok\Composer\Script;

use Composer\Script\Event;

class Database {

  public static function prepare(Event $event) {
    $io = $event->getIO();
    $root = dirname($event->getComposer()->getConfig()->get('vendor-dir'));
    $config = include($root . '/config.php');

    $db = new \PDO(
      $config['pdo']['dsn'],
      $config['pdo']['username'],
      $config['pdo']['password'],
      $config['pdo']['options']
    );

    $io->write('Recreating database...', true);
    $db->exec(file_get_contents($config['schema']));
  }

}
