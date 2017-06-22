CREATE TABLE IF NOT EXISTS `articles_has_categories` (
  `article_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  KEY `fk_categories_has_categories_articles` (`article_id`),
  KEY `fk_categories_has_categories_categories` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE articles 
ALTER lasteditedby_userid SET DEFAULT '1';