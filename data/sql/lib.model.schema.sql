
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- user
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;


CREATE TABLE `user`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(255),
	`name` VARCHAR(255),
	`nickname` VARCHAR(255),
	`password_hash` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`last_login` DATETIME,
	`account_credit` DECIMAL,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- user_permission
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user_permission`;


CREATE TABLE `user_permission`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER,
	`permission` VARCHAR(32),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `user_permission_FI_1` (`user_id`),
	CONSTRAINT `user_permission_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `product`;


CREATE TABLE `product`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255),
	`price` DECIMAL,
	`inventory` INTEGER,
	`image_url` VARCHAR(255),
	`sort_order` INTEGER,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- purchase
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `purchase`;


CREATE TABLE `purchase`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER,
	`product_id` INTEGER,
	`quantity` INTEGER,
	`price` DECIMAL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `purchase_FI_1` (`user_id`),
	CONSTRAINT `purchase_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
		ON DELETE SET NULL,
	INDEX `purchase_FI_2` (`product_id`),
	CONSTRAINT `purchase_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `product` (`id`)
		ON DELETE SET NULL
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- credit
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `credit`;


CREATE TABLE `credit`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER,
	`product_id` INTEGER,
	`quantity` INTEGER,
	`price` DECIMAL,
	PRIMARY KEY (`id`),
	INDEX `credit_FI_1` (`user_id`),
	CONSTRAINT `credit_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
		ON DELETE SET NULL,
	INDEX `credit_FI_2` (`product_id`),
	CONSTRAINT `credit_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `product` (`id`)
		ON DELETE SET NULL
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- email
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `email`;


CREATE TABLE `email`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER,
	`to_address` VARCHAR(255),
	`to_name` VARCHAR(255),
	`from_address` VARCHAR(255),
	`from_name` VARCHAR(255),
	`subject` VARCHAR(255),
	`body` LONGTEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`sent_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `email_FI_1` (`user_id`),
	CONSTRAINT `email_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
		ON DELETE SET NULL
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- email_attachment
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `email_attachment`;


CREATE TABLE `email_attachment`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`email_id` INTEGER,
	`filename` VARCHAR(255),
	`media_type` VARCHAR(255),
	`content` LONGBLOB,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `email_attachment_FI_1` (`email_id`),
	CONSTRAINT `email_attachment_FK_1`
		FOREIGN KEY (`email_id`)
		REFERENCES `email` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
