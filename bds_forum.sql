-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2020 at 06:40 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bds_forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_chat`
--

CREATE TABLE `tb_chat` (
  `chat_id` int(10) NOT NULL,
  `send_to` int(10) NOT NULL,
  `send_by` int(10) NOT NULL,
  `message` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_chat`
--

INSERT INTO `tb_chat` (`chat_id`, `send_to`, `send_by`, `message`, `time`) VALUES
(24, 37, 10, 'coba', '2018-05-21 10:17:40'),
(42, 37, 10, 'agr', '2018-05-21 10:29:50'),
(44, 37, 10, 'agar', '2018-05-21 10:30:34'),
(45, 37, 10, 'a', '2018-05-22 03:46:29'),
(56, 39, 10, 'tony', '2018-08-12 03:55:42'),
(57, 39, 10, 'apa', '2018-08-12 04:03:01'),
(58, 39, 10, 'apa?', '2018-08-12 04:15:19'),
(59, 0, 37, 'h', '2018-10-21 04:20:08'),
(60, 0, 37, 'hallo', '2018-10-21 04:20:19'),
(61, 0, 37, 'h', '2018-10-21 04:21:24'),
(62, 39, 37, 't', '2018-10-21 04:21:33'),
(63, 55, 39, 'tes', '2018-11-24 06:41:37');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `category_id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`category_id`, `parent_id`, `name`, `slug`, `date_added`, `date_edit`) VALUES
(13, 0, 'CSS', 'css', '0000-00-00 00:00:00', '2018-05-08 05:30:08'),
(24, 0, 'Java', 'java', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 0, 'C++', 'c', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 0, 'PHP', 'php', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 0, 'Android', 'android', '0000-00-00 00:00:00', '2018-11-14 11:56:08'),
(28, 26, 'Codeigniter', 'codeigniter', '2018-05-08 05:35:15', '0000-00-00 00:00:00'),
(29, 0, 'Javascript', 'javascript', '2018-08-05 11:17:42', '2018-08-05 11:35:48'),
(30, 26, 'Laravel', 'laravel', '2018-10-20 17:04:21', '2018-10-20 17:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `tb_post`
--

CREATE TABLE `tb_post` (
  `post_id` int(10) NOT NULL,
  `topic_id` int(10) NOT NULL,
  `reply_to_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `post` text NOT NULL,
  `likes` int(10) NOT NULL,
  `love` tinyint(1) NOT NULL,
  `date_add` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_post`
--

INSERT INTO `tb_post` (`post_id`, `topic_id`, `reply_to_id`, `user_id`, `post`, `likes`, `love`, `date_add`, `date_edit`) VALUES
(178, 42, 0, 11, 'bagaimana cara membuat animasi?', 0, 0, '2018-04-05 06:23:41', '0000-00-00 00:00:00'),
(232, 45, 0, 10, '<p>coy..</p>', 0, 0, '2018-07-23 17:10:56', '2018-08-04 11:18:18'),
(274, 58, 0, 10, '<p>&nbsp;teesss</p>', 0, 0, '2018-08-05 17:31:06', '0000-00-00 00:00:00'),
(283, 61, 275, 10, '<div style=\"font-size: 12px; background: #e3e3e3; padding: 5px;\">posted by <strong>@peter_quill </strong>\r\n<p><strong>kuda</strong></p>\r\n</div>\r\n<p>coba<br /><br /></p>', 0, 0, '2018-08-12 10:31:28', '2018-08-12 11:24:39'),
(284, 61, 276, 10, '<div style=\"font-size: 12px; background: #e3e3e3; padding: 5px;\">posted by <strong>@peter_quill </strong>\r\n<p>w</p>\r\n</div>\r\n<p>tes<br /><br /></p>', 0, 0, '2018-08-12 10:36:36', '2018-08-12 11:23:53'),
(289, 61, 0, 39, '<p>how</p>', 1, 0, '2018-08-13 16:43:19', '0000-00-00 00:00:00'),
(301, 63, 0, 43, '<p>File tinymce.min.js dipanggil terlebih dahulu.</p>', 5, 0, '2018-10-23 11:05:32', '0000-00-00 00:00:00'),
(303, 63, 0, 37, '<pre class=\"language-javascript\"><code>tinymce.init({\r\n            selector: \"textarea\",\r\n            theme: \'modern\',\r\n            plugins: [\r\n                \"advlist autolink lists link image charmap print preview anchor\",\r\n                \"searchreplace visualblocks code fullscreen\",\r\n                \"emoticons\", \"codesample\"\r\n            ],\r\n\r\n            toolbar: \"insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample\"\r\n        });</code></pre>', 4, 1, '2018-10-23 12:14:41', '0000-00-00 00:00:00'),
(305, 63, 301, 39, '<div style=\"font-size: 12px; background: #e3e3e3; padding: 5px;\">posted by <strong>@yanto </strong>\r\n<p>File tinymce.min.js dipanggil terlebih dahulu.</p>\r\n</div>\r\n<p>terus cara ke textareanya gimana?<br /><br /></p>', 0, 0, '2018-10-23 12:10:28', '2018-11-07 17:24:17'),
(315, 64, 0, 57, '<p>coba</p>\r\n<pre class=\"language-javascript\"><code>$(function () {\r\n   $(\'[data-toggle=\"popover\"]\').popover()\r\n})</code></pre>', 2, 1, '2018-11-27 15:53:15', '2018-11-27 15:56:00'),
(316, 71, 0, 58, '<p>contoh balas</p>', 1, 0, '2018-11-29 15:33:05', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_postlikes`
--

CREATE TABLE `tb_postlikes` (
  `id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_postlikes`
--

INSERT INTO `tb_postlikes` (`id`, `post_id`, `user_id`, `date`) VALUES
(124, 303, 37, '2018-10-23 05:15:11'),
(125, 303, 41, '2018-10-23 05:15:55'),
(126, 303, 43, '2018-10-23 05:16:23'),
(127, 303, 39, '2018-10-23 05:16:59'),
(150, 301, 39, '2018-11-10 04:44:22'),
(151, 315, 57, '2018-11-27 08:56:02'),
(153, 315, 39, '2018-11-28 12:01:33'),
(154, 316, 58, '2018-11-29 08:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `tb_topic`
--

CREATE TABLE `tb_topic` (
  `topic_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `title` varchar(30) NOT NULL,
  `th_slug` varchar(255) NOT NULL,
  `jenis_topic` enum('Tanya','Diskusi','Berbagi') NOT NULL,
  `f_post` text NOT NULL,
  `hit_count` int(10) NOT NULL,
  `date_add` datetime NOT NULL,
  `date_edit` datetime NOT NULL,
  `date_last_post` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_topic`
--

INSERT INTO `tb_topic` (`topic_id`, `category_id`, `user_id`, `title`, `th_slug`, `jenis_topic`, `f_post`, `hit_count`, `date_add`, `date_edit`, `date_last_post`) VALUES
(42, 11, 11, 'Bagaimana', 'bagaimana', 'Tanya', '', 32, '2018-04-05 06:23:41', '0000-00-00 00:00:00', '2018-07-24 11:50:45'),
(49, 27, 10, 'Bahasa Pemrograman', 'bahasa-pemrograman', 'Diskusi', '<p>coba</p>', 26, '2018-05-14 06:49:27', '2018-09-26 13:30:35', '2018-09-26 13:30:42'),
(60, 26, 10, 'Contoh', 'contoh', 'Tanya', '<p>ini contoh post</p>', 105, '2018-08-06 10:59:07', '2018-09-26 13:30:21', '2018-10-03 08:56:34'),
(61, 13, 39, 'Bagaimana Membuat Nav Bar', 'bagaimana-membuat-nav-bar', 'Tanya', '<p>gimana ya?</p>', 751, '2018-08-06 11:31:46', '0000-00-00 00:00:00', '2018-08-13 16:44:53'),
(63, 26, 39, 'cara setting tynimce', 'cara-setting-tynimce', 'Tanya', '<p>bagaimana cara menyeting plugin dan toolbar tynimce</p>', 318, '2018-08-14 17:43:03', '2018-08-23 11:33:43', '2018-10-23 12:18:55'),
(64, 29, 39, 'Coba', 'coba', 'Tanya', '<p>hanya coba-coba.</p>', 203, '2018-08-14 17:43:50', '2018-11-27 15:58:04', '2018-11-27 15:55:40'),
(67, 27, 39, 'baru', 'baru', 'Diskusi', '<p>bbb</p>', 26, '2018-11-07 11:47:08', '0000-00-00 00:00:00', '2018-11-07 17:17:22'),
(71, 26, 58, 'contoh topik', 'contoh-topik', 'Tanya', '<p>contoh</p>', 4, '2018-11-29 15:33:04', '0000-00-00 00:00:00', '2018-11-29 15:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(10) NOT NULL,
  `level` enum('admin','member') NOT NULL,
  `name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki_laki','Wanita') NOT NULL,
  `foto` varchar(40) NOT NULL,
  `tgl_join` date NOT NULL,
  `last_login` datetime NOT NULL,
  `bio` text NOT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `level`, `name`, `username`, `email`, `password`, `jenis_kelamin`, `foto`, `tgl_join`, `last_login`, `bio`, `aktif`) VALUES
(10, 'admin', 'Quill', 'admin', 'quil@guardian.com', '$2y$10$EgIlh/Mhv6vkrmnewpXOF.OV.nP3TCykdiqVOCCtdWwUOzWbzQPAi', 'Laki_laki', '18279844.jpg', '2018-04-24', '2020-04-06 11:35:31', 'Star Lord', 1),
(37, 'member', 'coba', 'cobacoba', 'cobacoba@coba.com', '1621a5dc746d5d19665ed742b2ef9736', 'Laki_laki', 'IMG_20180318_0637401.jpg', '2018-04-23', '2018-11-03 11:35:45', '', 1),
(38, 'member', 'Yondu', 'yondu', 'yond@mail.com', 'c3b7e1b3d7867ea2cca82b672745f25a', 'Laki_laki', '', '2018-07-11', '2018-10-04 16:56:31', '', 1),
(39, 'member', 'tony', 'tony_stark', 't@gmail.com', 'f67f6132cfb6ce6ce51f68b47215320a', 'Laki_laki', '', '2018-08-01', '2018-12-01 10:51:07', 'saya suka php', 1),
(41, 'admin', 'parker', 'peter_parker', 'parker@mail.com', 'd0204ad84e19075f95a176b65152ffde', 'Laki_laki', '', '2018-10-13', '2018-11-29 15:40:53', '', 1),
(43, 'member', 'M. Yanto ', 'yanto', 'yanto@gmail.com', '7849816e52e7d1596c51f3e36f21c498', 'Laki_laki', '', '2018-10-23', '2018-10-28 11:30:33', '', 1),
(55, 'member', 'uji', 'username', 'uji@mail.com', '14c4b06b824ec593239362517f538b29', 'Laki_laki', '', '2018-10-28', '0000-00-00 00:00:00', '', 1),
(56, 'member', 'romanof', 'roamanof', 'r@gmail.com', 'bbfd48c3bb7f0081d10fd9c3b4202f16', 'Wanita', '', '2018-11-06', '0000-00-00 00:00:00', '', 1),
(57, 'member', 'santoso', 'santoso', 'santoso@gmail.com', 'e15f849d84745e80106b74097a501059', '', '', '2018-11-27', '2020-04-06 11:21:45', '', 1),
(58, 'member', 'benny', 'benny', 'benny@gmail.com', '$2y$10$Rkj/RF0TlzEEydpLCAvUOedANRN/41DH/zkVSdzN/Du4V/ethMJJe', 'Laki_laki', '', '2018-11-29', '2020-04-06 11:32:18', '', 1),
(59, 'member', 'afkar', 'afkar', 'afkar@gmail.com', '$2y$10$PNQutWrRo.mmowYAvCGbeuo3UFM6sMiezYShV3uhU..H5BkOU.k1G', '', '', '2020-04-06', '2020-04-06 11:22:03', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `send_by` (`send_by`),
  ADD KEY `send_to` (`send_to`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tb_post`
--
ALTER TABLE `tb_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tb_postlikes`
--
ALTER TABLE `tb_postlikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_topic`
--
ALTER TABLE `tb_topic`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_chat`
--
ALTER TABLE `tb_chat`
  MODIFY `chat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tb_post`
--
ALTER TABLE `tb_post`
  MODIFY `post_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=317;

--
-- AUTO_INCREMENT for table `tb_postlikes`
--
ALTER TABLE `tb_postlikes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `tb_topic`
--
ALTER TABLE `tb_topic`
  MODIFY `topic_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD CONSTRAINT `tb_chat_ibfk_1` FOREIGN KEY (`send_by`) REFERENCES `tb_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
