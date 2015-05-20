<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 12:16
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('bxslider')};
CREATE TABLE {$this->getTable('bxslider')} (
 	`bxslider_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL DEFAULT '',
	`content` TEXT NOT NULL,
	`stores` TEXT NULL,
	`status` SMALLINT(6) NOT NULL DEFAULT '0',
	`created_time` DATETIME NULL DEFAULT NULL,
	`update_time` DATETIME NULL DEFAULT NULL,
	`page_id` TEXT NULL,
	`category_id` TEXT NULL,
	`position` VARCHAR(128) NULL DEFAULT '',
	`advanced_settings` TEXT NULL DEFAULT '',
	PRIMARY KEY (`bxslider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();