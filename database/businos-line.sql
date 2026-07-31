-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema businos-line
-- -----------------------------------------------------
-- == Datamodel for the "businos-line" application
-- == Designed by Xanders Samoth
-- == https://team.xsamtech.com/xanderssamoth
DROP SCHEMA IF EXISTS `businos-line` ;

-- -----------------------------------------------------
-- Schema businos-line
--
-- == Datamodel for the "businos-line" application
-- == Designed by Xanders Samoth
-- == https://team.xsamtech.com/xanderssamoth
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `businos-line` DEFAULT CHARACTER SET utf8mb4 ;
USE `businos-line` ;

-- -----------------------------------------------------
-- Table `businos-line`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`users` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`users` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `uuid` CHAR(36) NOT NULL,
  `firstname` VARCHAR(255) NULL,
  `lastname` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `phone` VARCHAR(20) NULL,
  `address_1` TEXT NULL,
  `address_2` TEXT NULL,
  `country` VARCHAR(255) NOT NULL DEFAULT 'France',
  `city` VARCHAR(255) NULL,
  `department` VARCHAR(255) NULL,
  `password` VARCHAR(255) NULL,
  `remember_token` VARCHAR(100) NULL,
  `status` ENUM('pending', 'active', 'suspended', 'blocked', 'deleted') NULL,
  `email_verified_at` TIMESTAMP NULL,
  `phone_verified_at` TIMESTAMP NULL,
  `last_login_at` TIMESTAMP NULL,
  `last_login_ip` VARCHAR(45) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_users_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `email_users_UNIQUE` (`email` ASC) VISIBLE,
  UNIQUE INDEX `phone_users_UNIQUE` (`phone` ASC) VISIBLE,
  UNIQUE INDEX `uuid_users_UNIQUE` (`uuid` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`about_subjects`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`about_subjects` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`about_subjects` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `uuid` CHAR(36) NOT NULL,
  `subject` JSON NOT NULL,
  `description` JSON NULL,
  `icon` VARCHAR(45) NULL,
  `is_available` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_aboutsubjects_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `uuid_aboutsubjects_UNIQUE` (`uuid` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`about_titles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`about_titles` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`about_titles` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `uuid` CHAR(36) NOT NULL,
  `title` TEXT NOT NULL,
  `icon` VARCHAR(45) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  `about_subject_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_abouttitles_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_abouttitles_aboutsubjects_idx` (`about_subject_id` ASC) VISIBLE,
  UNIQUE INDEX `uuid_abouttitles_UNIQUE` (`uuid` ASC) VISIBLE,
  CONSTRAINT `fk_abouttitles_aboutsubjects`
    FOREIGN KEY (`about_subject_id`)
    REFERENCES `businos-line`.`about_subjects` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`about_contents`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`about_contents` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`about_contents` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `uuid` CHAR(36) NOT NULL,
  `subtitle` TEXT NULL,
  `content` LONGTEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  `about_title_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_aboutcontents_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_aboutcontents_abouttitles_idx` (`about_title_id` ASC) VISIBLE,
  UNIQUE INDEX `uuid_UNIQUE` (`uuid` ASC) VISIBLE,
  CONSTRAINT `fk_aboutcontents_abouttitles`
    FOREIGN KEY (`about_title_id`)
    REFERENCES `businos-line`.`about_titles` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`roles` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`roles` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `uuid` CHAR(36) NOT NULL,
  `role_name` JSON NOT NULL,
  `role_description` JSON NULL,
  `slug` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_roles_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `slug_roles_UNIQUE` (`slug` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`role_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`role_user` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`role_user` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `role_id` BIGINT NOT NULL,
  `user_id` BIGINT NOT NULL,
  `is_default` TINYINT(1) NOT NULL DEFAULT 0,
  `assigned_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_roleuser_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_roleuser_roles_idx` (`role_id` ASC) VISIBLE,
  INDEX `fk_roleuser_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_roleuser_roles`
    FOREIGN KEY (`role_id`)
    REFERENCES `businos-line`.`roles` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_roleuser_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `businos-line`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`histories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`histories` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`histories` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `word` TEXT NULL COMMENT 'This refers to a search history of a user',
  `entity` ENUM('about_subject', 'saving', 'user') NULL,
  `entity_id` BIGINT NULL,
  `action` ENUM('search', 'save', 'change') NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_histories_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_histories_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_histories_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `businos-line`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`gains`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`gains` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`gains` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `uuid` CHAR(36) NOT NULL,
  `amount` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `currency` VARCHAR(45) NOT NULL DEFAULT 'EUR',
  `is_general_interest_paid` TINYINT(1) NOT NULL DEFAULT 0,
  `is_gain_paid` TINYINT(1) NOT NULL DEFAULT 0,
  `month` INT NOT NULL,
  `year` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  `user_id` BIGINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_gains_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_gains_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_gains_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `businos-line`.`users` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`files`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`files` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`files` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `file_name` VARCHAR(255) NULL,
  `file_description` LONGTEXT NULL COMMENT 'This might be useful for describing advertisements, for example.',
  `file_url` TEXT NULL,
  `file_type` ENUM('video', 'photo', 'audio', 'document', 'id_card', 'ad', 'qr_code') NOT NULL DEFAULT 'photo',
  `mime_type` VARCHAR(100) NULL,
  `file_size` BIGINT NULL,
  `width` INT NULL,
  `height` INT NULL,
  `duration` INT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  `about_content_id` BIGINT NULL,
  `user_id` BIGINT NULL,
  `gain_id` BIGINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_files_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_files_aboutcontents_idx` (`about_content_id` ASC) VISIBLE,
  INDEX `fk_files_users_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_files_gains_idx` (`gain_id` ASC) VISIBLE,
  CONSTRAINT `fk_files_aboutcontents`
    FOREIGN KEY (`about_content_id`)
    REFERENCES `businos-line`.`about_contents` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_files_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `businos-line`.`users` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_files_gains`
    FOREIGN KEY (`gain_id`)
    REFERENCES `businos-line`.`gains` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`payments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`payments` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`payments` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `reference` VARCHAR(45) NULL,
  `provider` VARCHAR(45) NULL,
  `provider_reference` VARCHAR(45) NULL,
  `order_number` TEXT NULL,
  `amount` DECIMAL(9,2) NULL,
  `amount_customer` DECIMAL(9,2) NULL,
  `phone` VARCHAR(45) NULL,
  `currency` VARCHAR(45) NULL,
  `channel` VARCHAR(45) NULL,
  `reason` ENUM('save', 'payoff', 'ad', 'sponsoring') NULL,
  `entity` ENUM('saving', 'gain') NULL,
  `entity_id` BIGINT NULL,
  `type` INT NULL,
  `status` INT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` BIGINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_payments_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_payments_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_payments_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `businos-line`.`users` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`savings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`savings` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`savings` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `uuid` CHAR(36) NOT NULL,
  `is_saving_sent` TINYINT(1) NOT NULL DEFAULT 0,
  `amount` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `currency` VARCHAR(45) NOT NULL DEFAULT 'EUR',
  `month` INT NOT NULL,
  `year` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  `user_id` BIGINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_savings_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_savings_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_savings_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `businos-line`.`users` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`notifications`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`notifications` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`notifications` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `type` ENUM('welcome_new_member', 'saving_send', 'gain_obtained', 'payment_done', 'payment_canceled', 'payment_failed') NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `from_user_id` BIGINT NULL,
  `to_user_id` BIGINT NULL,
  `payment_id` BIGINT NULL,
  `saving_id` BIGINT NULL,
  `gain_id` BIGINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_notifications_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_notifications_fromusers_idx` (`from_user_id` ASC) VISIBLE,
  INDEX `fk_notifications_tousers_idx` (`to_user_id` ASC) VISIBLE,
  INDEX `fk_notifications_payments_idx` (`payment_id` ASC) VISIBLE,
  INDEX `fk_notifications_savings_idx` (`saving_id` ASC) VISIBLE,
  INDEX `fk_notifications_gains_idx` (`gain_id` ASC) VISIBLE,
  CONSTRAINT `fk_notifications_fromusers`
    FOREIGN KEY (`from_user_id`)
    REFERENCES `businos-line`.`users` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_notifications_tousers`
    FOREIGN KEY (`to_user_id`)
    REFERENCES `businos-line`.`users` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_notifications_payments`
    FOREIGN KEY (`payment_id`)
    REFERENCES `businos-line`.`payments` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_notifications_savings`
    FOREIGN KEY (`saving_id`)
    REFERENCES `businos-line`.`savings` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_notifications_gains`
    FOREIGN KEY (`gain_id`)
    REFERENCES `businos-line`.`gains` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`password_resets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`password_resets` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`password_resets` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NULL,
  `phone` VARCHAR(45) NULL,
  `token` VARCHAR(45) NULL,
  `former_password` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_passwordresets_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`personal_access_tokens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`personal_access_tokens` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`personal_access_tokens` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT NULL,
  `last_used_at` TIMESTAMP NULL,
  `expires_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_personalaccesstokens_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`about_dashes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`about_dashes` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`about_dashes` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `dash_content` JSON NOT NULL,
  `belongs_to` BIGINT NULL COMMENT 'A subdash within another dash.',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  `about_content_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_aboutdashes_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_aboutdashes_aboutcontents_idx` (`about_content_id` ASC) VISIBLE,
  CONSTRAINT `fk_aboutdashes_aboutcontents`
    FOREIGN KEY (`about_content_id`)
    REFERENCES `businos-line`.`about_contents` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`cache`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`cache` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`),
  INDEX `cache_expiration_index` (`expiration` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`cache_locks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`cache_locks` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`),
  INDEX `cache_locks_expiration_index` (`expiration` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`failed_jobs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`failed_jobs` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` VARCHAR(45) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `failed_jobs_uuid_unique` (`uuid` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`jobs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`jobs` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `jobs_queue_index` (`queue` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`job_batches`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`job_batches` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`job_batches` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT NOT NULL,
  `pending_jobs` INT NOT NULL,
  `failed_jobs` INT NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` VARCHAR(45) NULL,
  `cancelled_at` INT NULL,
  `created_at` INT NOT NULL,
  `finished_at` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businos-line`.`blocked_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `businos-line`.`blocked_users` ;

CREATE TABLE IF NOT EXISTS `businos-line`.`blocked_users` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `uuid` CHAR(36) NOT NULL,
  `complaint` LONGTEXT NULL,
  `is_unlocked` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  `user_id` BIGINT NOT NULL,
  `about_title_id` BIGINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_blockedusers_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_blockedusers_users_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_blockedusers_abouttitles_idx` (`about_title_id` ASC) VISIBLE,
  CONSTRAINT `fk_blockedusers_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `businos-line`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_blockedusers_abouttitles`
    FOREIGN KEY (`about_title_id`)
    REFERENCES `businos-line`.`about_titles` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
