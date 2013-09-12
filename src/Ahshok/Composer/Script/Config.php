<?php

namespace Ahshok\Composer\Script;

use Composer\Script\Event;

class Config {

  public static function create(Event $event) {
    $io = $event->getIO();
    $root = dirname($event->getComposer()->getConfig()->get('vendor-dir'));
    $configPath = $root . '/config.php';
    $configDistPath = $root . '/config.php.dist';

    $io->write('Reviewing your configuration...', true);

    if (file_exists($configPath)) {
      $io->write('Configuration found!', true);
    } else {
      $io->write('Creating configuration...', true);
      copy($configDistPath, $configPath);
    }
  }

}
