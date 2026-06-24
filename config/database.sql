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
--  ADDITIONAL ADMIN USERS
-- ------------------------------------------------------------
INSERT INTO `admin_users` (`username`, `password`, `full_name`)
VALUES 
('admin@civilanka.com', '$2y$10$sPFH67/fF2iFBuRwA9ujsOVD6hHi2cf56PvmxryECS/MaXUXpspJy', 'CivilLanka Admin'),
('EngageLanka', '$2y$10$wMl0Pc3scc.KDS1TUfnhPuZsDllXYpC0IeykaOt.e5v4rffnqTtkG', 'EngageLanka')
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`), `full_name` = VALUES(`full_name`);

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

-- ------------------------------------------------------------
--  BLOG POSTS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title`       VARCHAR(255)  NOT NULL,
  `slug`        VARCHAR(255)  NOT NULL UNIQUE,
  `category`    VARCHAR(100)  NULL,
  `excerpt`     TEXT          NULL,
  `content`     LONGTEXT      NULL,
  `image`       VARCHAR(255)  NULL    COMMENT 'Cover image filename in uploads/blog/',
  `status`      ENUM('draft','published') NOT NULL DEFAULT 'published',
  `sort_order`  INT           NOT NULL DEFAULT 0,
  `created_at`  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_status` (`status`),
  INDEX `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
--  SHOP ITEMS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `shop_items` (
  `id`                      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title`                   VARCHAR(255)   NOT NULL,
  `price`                   DECIMAL(10,2)  NOT NULL DEFAULT 0.00,
  `original_price`          DECIMAL(10,2)  NULL      COMMENT 'Strike-through price before discount',
  `description`             TEXT           NULL,
  `additional_info`         LONGTEXT       NULL      COMMENT 'Rich-text additional information section',
  `additional_info_images`  JSON           NULL      COMMENT 'Array of image filenames for additional info',
  `whats_included`          TEXT           NULL,
  `whats_not_included`      TEXT           NULL,
  `spec_sqft`               VARCHAR(50)    NULL,
  `spec_beds`               VARCHAR(50)    NULL,
  `spec_baths`              VARCHAR(50)    NULL,
  `spec_floors`             VARCHAR(50)    NULL,
  `spec_garages`            VARCHAR(50)    NULL,
  `category`                VARCHAR(100)   NULL,
  `image`                   VARCHAR(255)   NULL      COMMENT 'Main image filename in uploads/shop/',
  `gallery_images`          JSON           NULL      COMMENT 'Array of gallery image filenames',
  `status`                  ENUM('draft','published') NOT NULL DEFAULT 'published',
  `sort_order`              INT            NOT NULL DEFAULT 0,
  `created_at`              TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
  `updated_at`              TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_status`   (`status`),
  INDEX `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
--  PARTNER LOGOS TABLE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `partner_logos` (
  `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `image`       VARCHAR(255)  NOT NULL COMMENT 'Logo image filename in uploads/logos/',
  `alt_text`    VARCHAR(255)  NULL     COMMENT 'Company name for alt text',
  `sort_order`  INT           NOT NULL DEFAULT 0,
  `created_at`  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
