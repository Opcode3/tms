-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 30, 2024 at 09:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments_tb`
--

CREATE TABLE `comments_tb` (
  `comment_id` bigint(20) NOT NULL,
  `comment_slug` varchar(255) NOT NULL,
  `comment_user_id` bigint(20) NOT NULL,
  `comment_task_id` bigint(20) NOT NULL,
  `comment_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments_tb`
--

INSERT INTO `comments_tb` (`comment_id`, `comment_slug`, `comment_user_id`, `comment_task_id`, `comment_content`, `created_at`, `updated_at`) VALUES
(3, '172682454166ed405ddddb4', 7, 8, 'Nice Brother', '2024-09-20 09:29:01', '2024-09-20 09:29:01'),
(4, '172682459266ed409076ccb', 1, 10, 'Work has been done', '2024-09-20 09:29:52', '2024-09-20 09:29:52');

-- --------------------------------------------------------

--
-- Table structure for table `files_tb`
--

CREATE TABLE `files_tb` (
  `file_id` bigint(20) NOT NULL,
  `file_slug` varchar(255) NOT NULL,
  `file_task_id` bigint(20) NOT NULL,
  `file_path` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files_tb`
--

INSERT INTO `files_tb` (`file_id`, `file_slug`, `file_task_id`, `file_path`, `created_at`, `updated_at`) VALUES
(8, '172682406866ed3e8485a7f', 8, '', '2024-09-20 09:21:08', '2024-09-20 09:21:08'),
(9, '172682408966ed3e99ed07c', 9, '', '2024-09-20 09:21:29', '2024-09-20 09:21:29'),
(10, '172682410966ed3ead1e945', 10, '', '2024-09-20 09:21:49', '2024-09-20 09:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `messages_tb`
--

CREATE TABLE `messages_tb` (
  `message_id` bigint(20) NOT NULL,
  `message_slug` varchar(255) NOT NULL,
  `message_task_id` bigint(20) NOT NULL,
  `message_user_id` bigint(20) NOT NULL,
  `message_content` text NOT NULL,
  `messge_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages_tb`
--

INSERT INTO `messages_tb` (`message_id`, `message_slug`, `message_task_id`, `message_user_id`, `message_content`, `messge_status`, `created_at`, `updated_at`) VALUES
(3, '172682444666ed3ffe9cf23', 8, 7, 'Please change bla bla', 0, '2024-09-20 09:27:26', '2024-09-20 09:27:26'),
(4, '172682449566ed402fd4046', 8, 1, 'Changed made as requested', 0, '2024-09-20 09:28:15', '2024-09-20 09:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `notifications_tb`
--

CREATE TABLE `notifications_tb` (
  `notification_id` bigint(20) NOT NULL,
  `notification_slug` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `task_id` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `read_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects_tb`
--

CREATE TABLE `projects_tb` (
  `project_id` bigint(20) NOT NULL,
  `project_slug` varchar(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `creator_id` bigint(20) NOT NULL,
  `project_deadline` date NOT NULL,
  `project_color` varchar(35) NOT NULL DEFAULT '#ccc',
  `project_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects_tb`
--

INSERT INTO `projects_tb` (`project_id`, `project_slug`, `project_name`, `creator_id`, `project_deadline`, `project_color`, `project_status`, `created_at`, `updated_at`) VALUES
(13, '172682315666ed3af455dfb', 'XYZ Project', 7, '2024-09-28', '#c20f0f', 1, '2024-09-20 09:05:56', '2024-09-20 10:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `project_user_tb`
--

CREATE TABLE `project_user_tb` (
  `pu_id` bigint(20) NOT NULL,
  `pu_slug` varchar(255) NOT NULL,
  `pu_project_id` bigint(20) NOT NULL,
  `pu_member` bigint(20) NOT NULL,
  `pu_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_user_tb`
--

INSERT INTO `project_user_tb` (`pu_id`, `pu_slug`, `pu_project_id`, `pu_member`, `pu_status`, `created_at`, `updated_at`) VALUES
(13, '172682315666ed3af4576f3', 13, 5, 0, '2024-09-20 09:05:56', '2024-09-20 09:05:56'),
(14, '172682315666ed3af457f80', 13, 1, 0, '2024-09-20 09:05:56', '2024-09-20 09:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `subtask_tb`
--

CREATE TABLE `subtask_tb` (
  `subtask_id` bigint(20) NOT NULL,
  `subtask_slug` varchar(255) NOT NULL,
  `subtask_desc` text NOT NULL,
  `subtask_status` int(11) DEFAULT 0,
  `subtask_parent_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subtask_tb`
--

INSERT INTO `subtask_tb` (`subtask_id`, `subtask_slug`, `subtask_desc`, `subtask_status`, `subtask_parent_id`, `created_at`, `updated_at`) VALUES
(11, '172682437266ed3fb457c02', 'Sub Task 1', 1, 8, '2024-09-20 09:26:12', '2024-09-20 10:26:25'),
(12, '172682438066ed3fbc8bdbc', 'Sub Task 2', 1, 8, '2024-09-20 09:26:20', '2024-09-20 10:26:26');

-- --------------------------------------------------------

--
-- Table structure for table `tasks_tb`
--

CREATE TABLE `tasks_tb` (
  `task_id` bigint(20) NOT NULL,
  `task_slug` varchar(255) NOT NULL,
  `task_project_id` bigint(20) NOT NULL,
  `task_title` text NOT NULL,
  `task_desc` text NOT NULL,
  `assigned_to` bigint(20) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `deadline` varchar(255) NOT NULL,
  `task_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks_tb`
--

INSERT INTO `tasks_tb` (`task_id`, `task_slug`, `task_project_id`, `task_title`, `task_desc`, `assigned_to`, `created_by`, `deadline`, `task_status`, `created_at`, `updated_at`) VALUES
(8, '172682406866ed3e8484007', 13, 'Task 1', 'DDD\r\n\r\nDD', 1, 7, '2024-09-22', 3, '2024-09-20 09:21:08', '2024-09-20 10:29:01'),
(9, '172682408966ed3e99ebcd1', 13, 'Task 2', 'DDD\r\n\r\nDD', 5, 7, '2024-09-22', 3, '2024-09-20 09:21:29', '2024-09-20 10:31:43'),
(10, '172682410966ed3ead1e2b5', 13, 'Task 3', 'WWWW\r\n\r\nWWW', 1, 7, '2024-09-25', 3, '2024-09-20 09:21:49', '2024-09-20 10:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `users_tb`
--

CREATE TABLE `users_tb` (
  `user_id` bigint(20) NOT NULL,
  `user_slug` varchar(255) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_picture` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tb`
--

INSERT INTO `users_tb` (`user_id`, `user_slug`, `user_fullname`, `user_email`, `user_username`, `user_password`, `user_picture`, `created_at`, `updated_at`) VALUES
(1, '172295720366b23d9332d45', 'Vitalis Chizoba Blessing', 'Chizoba2.vitalis@live.uwe.ac.uk', 'chizoba2', '$2y$10$Ej0P0h04YzaZkzUyyW9uduqcOAY4B8DaBQSDraDyiHdytPUu1fgry', '../../public/src/src_172501654266d1a9de6aed0.png', '2024-08-06 15:13:23', '2024-08-30 00:15:42'),
(4, '172389909566c09cd748eaa', 'Abigail Joseph', 'josephabigail3@gmail.com', 'josephabigail3', '$2y$10$o4wpi98ICnS2E/8O/7t.ruhpkJVkdP6knXcSucGQTo8CJJcX.DL1W', '../../public/src/src_172389918366c09d2fdbba3.jpg', '2024-08-17 12:51:35', '2024-08-17 01:53:03'),
(5, '172396091566c18e538d2e1', 'Martha Ali', 'martha3@gmail.com', 'martha3', '$2y$10$jYj2O93u5OTagqgW06XHe.YnsYSl78gqhtyDNMGhO4wv04Cc2I4M2', '../../public/src/src_172487985166cf93ebc2c23.jpg', '2024-08-18 06:01:55', '2024-08-28 10:17:31'),
(7, '172682302866ed3a74e4b83', 'John David ', 'johndavid@gmail.com', 'johndavid', '$2y$10$RKzenONJBCBLcW9qkPu85.aGQ3jmzbf5qRfy5Rk9GmwDm6LpUwsDG', NULL, '2024-09-20 09:03:48', '2024-09-20 09:03:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments_tb`
--
ALTER TABLE `comments_tb`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_user_id` (`comment_user_id`),
  ADD KEY `comment_task_id` (`comment_task_id`);

--
-- Indexes for table `files_tb`
--
ALTER TABLE `files_tb`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `file_task_id` (`file_task_id`);

--
-- Indexes for table `messages_tb`
--
ALTER TABLE `messages_tb`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `message_task_id` (`message_task_id`),
  ADD KEY `message_user_id` (`message_user_id`);

--
-- Indexes for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `projects_tb`
--
ALTER TABLE `projects_tb`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indexes for table `project_user_tb`
--
ALTER TABLE `project_user_tb`
  ADD PRIMARY KEY (`pu_id`),
  ADD KEY `pu_project_id` (`pu_project_id`),
  ADD KEY `pu_member` (`pu_member`);

--
-- Indexes for table `subtask_tb`
--
ALTER TABLE `subtask_tb`
  ADD PRIMARY KEY (`subtask_id`),
  ADD KEY `subtask_parent_id` (`subtask_parent_id`);

--
-- Indexes for table `tasks_tb`
--
ALTER TABLE `tasks_tb`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `team_id` (`task_project_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `users_tb`
--
ALTER TABLE `users_tb`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments_tb`
--
ALTER TABLE `comments_tb`
  MODIFY `comment_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `files_tb`
--
ALTER TABLE `files_tb`
  MODIFY `file_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages_tb`
--
ALTER TABLE `messages_tb`
  MODIFY `message_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  MODIFY `notification_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects_tb`
--
ALTER TABLE `projects_tb`
  MODIFY `project_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `project_user_tb`
--
ALTER TABLE `project_user_tb`
  MODIFY `pu_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subtask_tb`
--
ALTER TABLE `subtask_tb`
  MODIFY `subtask_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tasks_tb`
--
ALTER TABLE `tasks_tb`
  MODIFY `task_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments_tb`
--
ALTER TABLE `comments_tb`
  ADD CONSTRAINT `comments_tb_ibfk_1` FOREIGN KEY (`comment_user_id`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `comments_tb_ibfk_2` FOREIGN KEY (`comment_task_id`) REFERENCES `tasks_tb` (`task_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `files_tb`
--
ALTER TABLE `files_tb`
  ADD CONSTRAINT `files_tb_ibfk_1` FOREIGN KEY (`file_task_id`) REFERENCES `tasks_tb` (`task_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `messages_tb`
--
ALTER TABLE `messages_tb`
  ADD CONSTRAINT `messages_tb_ibfk_1` FOREIGN KEY (`message_task_id`) REFERENCES `tasks_tb` (`task_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `messages_tb_ibfk_2` FOREIGN KEY (`message_user_id`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  ADD CONSTRAINT `notifications_tb_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `notifications_tb_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks_tb` (`task_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `projects_tb`
--
ALTER TABLE `projects_tb`
  ADD CONSTRAINT `projects_tb_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `project_user_tb`
--
ALTER TABLE `project_user_tb`
  ADD CONSTRAINT `project_user_tb_ibfk_1` FOREIGN KEY (`pu_project_id`) REFERENCES `projects_tb` (`project_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `project_user_tb_ibfk_2` FOREIGN KEY (`pu_member`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `subtask_tb`
--
ALTER TABLE `subtask_tb`
  ADD CONSTRAINT `subtask_tb_ibfk_1` FOREIGN KEY (`subtask_parent_id`) REFERENCES `tasks_tb` (`task_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tasks_tb`
--
ALTER TABLE `tasks_tb`
  ADD CONSTRAINT `tasks_tb_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `tasks_tb_ibfk_2` FOREIGN KEY (`task_project_id`) REFERENCES `projects_tb` (`project_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `tasks_tb_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `users_tb` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
