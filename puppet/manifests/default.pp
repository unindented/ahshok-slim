group { 'puppet': ensure => present }

Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/' ] }
File { owner => 0, group => 0, mode => 0644 }

class { 'apt':
  always_apt_update => true,
}

Class['::apt::update'] -> Package <|
    title != 'python-software-properties'
and title != 'software-properties-common'
|>

class { 'puphpet::dotfiles': }

package { [
    'build-essential',
    'curl',
    'vim',
    'tmux',
    'git-core'
  ]:
  ensure  => 'installed',
}

class { 'apache': }

apache::dotconf { 'custom':
  content => 'EnableSendfile Off',
}

apache::module { 'rewrite': }

apache::vhost { 'ahshok.dev':
  server_name   => 'ahshok.dev',
  serveraliases => ['www.ahshok.dev'],
  docroot       => '/var/www/public/',
  port          => '80',
  priority      => '1',
  env_variables => [
    'APP_ENV development',
    'SLIM_MODE development',
  ],
}

class { 'php':
  service             => 'apache',
  service_autorestart => false,
  module_prefix       => '',
}

php::module { 'php5-mysql': }
php::module { 'php5-cli': }
php::module { 'php5-curl': }
php::module { 'php5-intl': }
php::module { 'php5-mcrypt': }
php::module { 'php5-sqlite': }

class { 'php::devel':
  require => Class['php'],
}

class { 'composer':
  require => Package['php5', 'curl'],
}

puphpet::ini { 'php':
  value   => [
    'date.timezone = "Europe/London"'
  ],
  ini     => '/etc/php5/conf.d/zzz_php.ini',
  notify  => Service['apache'],
  require => Class['php'],
}

puphpet::ini { 'custom':
  value   => [
    'error_reporting = -1',
    'display_errors = On',
    'display_startup_errors = On',
    'short_open_tag = Off'
  ],
  ini     => '/etc/php5/conf.d/zzz_custom.ini',
  notify  => Service['apache'],
  require => Class['php'],
}

class { 'mysql::server':
  config_hash => { 'root_password' => 'root' }
}

mysql::db { 'ahshok':
  grant    => ['all'],
  user     => 'ahshok',
  password => 'ahshok',
  host     => 'localhost',
  charset  => 'utf8',
  require  => Class['mysql::server'],
}

class { 'phpmyadmin':
  require => [Class['mysql::server'], Class['mysql::config'], Class['php']],
}

apache::vhost { 'db.ahshok.dev':
  server_name => 'db.ahshok.dev',
  docroot     => '/usr/share/phpmyadmin',
  port        => '80',
  priority    => '10',
  require     => Class['phpmyadmin'],
}
