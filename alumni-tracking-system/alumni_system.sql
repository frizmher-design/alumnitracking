SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `alumni` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `graduation_year` year(4) DEFAULT NULL,
  `employment_status` varchar(100) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `job_title` varchar(150) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `alumni` (`id`, `student_id`, `firstname`, `lastname`, `gender`, `birthdate`, `email`, `phone`, `address`, `course`, `graduation_year`, `employment_status`, `company`, `job_title`, `profile_picture`, `created_at`) VALUES
(1, NULL, 'Juan', 'Dela Cruz', NULL, NULL, NULL, NULL, NULL, 'BSIT', '2022', 'Employed', NULL, NULL, NULL, '2026-04-11 14:04:20'),
(2, NULL, 'Maria', 'Santos', NULL, NULL, NULL, NULL, NULL, 'BSBA', '2021', 'Unemployed', NULL, NULL, NULL, '2026-04-11 14:04:20');


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin User', 'admin@gmail.com', '$2y$10$wH8Q6Pz0yK0F5zqX6Ch12uF6sQ7q9eJ1k9Yl8R9KZ1fYzT2d6eY9e', 'admin', '2026-04-11 14:04:20'),
(2, 'Rizzmer', 'riz@gmail.com', '$2y$10$Kx.cYvGVlo32Qtq.2AyZH.ac8Rd3wFW9YZw8v9cuUfpQ3bwwX.vFa', 'staff', '2026-04-11 14:23:21'),
(3, 'howell', 'howell@gmail.com', '$2y$10$4yaFQ43o8VAEqyPDPBWuCOORWj1WqEI2wXx97k8hhGHpgmwsPiXA.', 'staff', '2026-04-11 14:59:03');


ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;