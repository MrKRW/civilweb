-- ============================================================
--  CivilLanka Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS `civillanka_db`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE `civillanka_db`;

-- ------------------------------------------------------------
--  PROJECTS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `projects` (
  `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title`         VARCHAR(255)   NOT NULL,
  `category`      ENUM('local','international') NOT NULL DEFAULT 'local',
  `description`   TEXT           NULL,
  `location`      VARCHAR(255)   NULL,
  `client`        VARCHAR(255)   NULL,
  `year`          YEAR           NULL,
  `service_type`  VARCHAR(100)   NULL  COMMENT 'e.g. WELLNESS, INTERIOR, ARCHITECTURE, COMMERCIAL',
  `image_main`    VARCHAR(255)   NULL  COMMENT 'Main image filename',
  `image_gallery` JSON           NULL  COMMENT 'Array of additional image filenames',
  `featured`      TINYINT(1)     NOT NULL DEFAULT 0  COMMENT '1 = show on homepage slider',
  `status`        ENUM('draft','published') NOT NULL DEFAULT 'published',
  `sort_order`    INT            NOT NULL DEFAULT 0,
  `created_at`    TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_category` (`category`),
  INDEX `idx_featured` (`featured`),
  INDEX `idx_status`   (`status`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
--  ADMIN USERS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username`   VARCHAR(50)   NOT NULL UNIQUE,
  `password`   VARCHAR(255)  NOT NULL  COMMENT 'bcrypt hash',
  `full_name`  VARCHAR(100)  NULL,
  `created_at` TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
--  DEFAULT ADMIN  (password: admin123)
-- ------------------------------------------------------------
INSERT INTO `admin_users` (`username`, `password`, `full_name`)
VALUES ('admin', '$2y$10$RkVHNEaaKixPN0XuEEPXru0E49gzv6FOTzxXktFGJraGZ99RXprpu', 'Administrator')
ON DUPLICATE KEY UPDATE `username` = `username`;

-- ------------------------------------------------------------
--  PRODUCT REVIEWS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `product_id`     INT UNSIGNED NOT NULL,
  `reviewer_name`  VARCHAR(100) NOT NULL,
  `reviewer_email` VARCHAR(150) NOT NULL,
  `rating`         TINYINT UNSIGNED NOT NULL DEFAULT 5,
  `review_text`    TEXT NOT NULL,
  `created_at`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
