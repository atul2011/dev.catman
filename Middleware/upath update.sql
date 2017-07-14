CREATE TABLE IF NOT EXISTS `Articles_has_Categories` (
  `article_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  KEY `fk_categories_has_categories_articles` (`article_id`),
  KEY `fk_categories_has_categories_categories` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE articles 
ALTER lasteditedby_userid SET DEFAULT '1';

ALTER TABLE news
ADD COLUMN `publish_date` date

ALTER TABLE news
ADD COLUMN `link_text` char(200)

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `Category_has_Tag` (
  `category_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  FOREIGN KEY (`category_id` ) REFERENCES `Categories`(`id`),
  FOREIGN KEY (`tag_id`) REFERENCES `Tag`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `Article_has_Tag` (
  `article_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  FOREIGN KEY (`article_id` ) REFERENCES `Articles`(`id`),
  FOREIGN KEY (`tag_id`) REFERENCES `Tag`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;