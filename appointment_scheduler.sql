CREATE DATABASE IF NOT EXISTS `appointment_scheduler`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `appointment_scheduler`;

CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `avatar` VARCHAR(255) DEFAULT 'default.png',
  `address` TEXT DEFAULT NULL,
  `gender` ENUM('Male','Female','Other') DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `role` ENUM('admin','user') NOT NULL DEFAULT 'user',
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `appointments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `client_name` VARCHAR(255) NOT NULL,
  `client_email` VARCHAR(255) DEFAULT NULL,
  `client_phone` VARCHAR(20) DEFAULT NULL,
  `service` VARCHAR(255) NOT NULL,
  `appointment_date` DATETIME NOT NULL,
  `duration` INT NOT NULL DEFAULT 30,
  `status` ENUM('Scheduled','Completed','Cancelled') NOT NULL DEFAULT 'Scheduled',
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_appointments_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password is bcrypt of "password"
INSERT INTO `users` (`name`,`email`,`password`,`role`,`gender`,`address`,`phone`) VALUES
('Admin User','admin@appointment.com','$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin','Male','Manila, Philippines','09171234567'),
('Juan Dela Cruz','juan@appointment.com','$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','user','Male','Quezon City, Philippines','09281234567');

INSERT INTO `appointments` (`user_id`,`title`,`client_name`,`client_phone`,`service`,`appointment_date`,`duration`,`status`) VALUES
(1,'Hair Cut - Mark','Mark Santos','09171111111','Haircut',DATE_ADD(NOW(),INTERVAL 1 DAY),30,'Scheduled'),
(1,'Full Body Massage','Anna Reyes','09172222222','Massage',DATE_ADD(NOW(),INTERVAL 2 DAY),60,'Scheduled'),
(1,'Dental Checkup','Pedro Cruz','09173333333','Consultation',DATE_ADD(NOW(),INTERVAL 3 DAY),45,'Scheduled'),
(1,'Nail Art Session','Maria Lim','09174444444','Nail Art',DATE_SUB(NOW(),INTERVAL 1 DAY),90,'Completed'),
(1,'Eye Brow Threading','Rosa Garcia','09175555555','Threading',DATE_SUB(NOW(),INTERVAL 2 DAY),15,'Completed'),
(1,'Facial Treatment','Jose Bautista','09176666666','Facial',DATE_SUB(NOW(),INTERVAL 3 DAY),60,'Cancelled'),
(2,'Business Consultation','Carlo Mendoza','09189999999','Consultation',DATE_ADD(NOW(),INTERVAL 5 DAY),60,'Scheduled');
