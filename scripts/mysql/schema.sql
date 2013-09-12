CREATE TABLE IF NOT EXISTS `products` (
  `id`           INTEGER PRIMARY KEY AUTO_INCREMENT,
  `asin`         CHAR(10) UNIQUE NOT NULL,
  `title`        TINYTEXT NOT NULL,
  `author`       TINYTEXT,
  `link`         TEXT NOT NULL,
  `small_image`  TEXT,
  `medium_image` TEXT,
  `large_image`  TEXT
) CHARSET=utf8;
