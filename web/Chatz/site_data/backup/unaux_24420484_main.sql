-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql113.unaux.com
-- Generation Time: Mar 31, 2020 at 05:32 AM
-- Server version: 5.6.45-86.1
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unaux_24420484_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_chat`
--

CREATE TABLE `group_chat` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sent_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_chat`
--

INSERT INTO `group_chat` (`id`, `sender`, `message`, `receiver`, `type`, `sent_on`) VALUES
(9, 'chat1', ' hi', 'group_chat', 'text_message', '2019-11-19 01:50:56'),
(4, 'najeemba@chatz', './attach_temp/c07ac4db5a9940205be7ba242bf7d546543f5dc0.ico', 'group_chat', 'image/vnd.microsoft.icon', '2019-11-17 21:11:33'),
(5, 'najeemba@chatz', ' ', 'group_chat', 'text_message', '2019-11-17 21:11:46'),
(6, 'najeemba@chatz', './attach_temp/10f5e2146581f5afd6c442953b28107ffdb83328.jpg', 'group_chat', 'image/jpeg', '2019-11-17 21:12:15'),
(7, 'najeemba@chatz', './attach_temp/5957fb3a5b609bba3ee8da35be406a45893bad53.png', 'group_chat', 'image/png', '2019-11-17 21:12:16'),
(8, 'najeemba@chatz', './attach_temp/07b665fed438f1e3179f59bf3cd27e7cfe586f30.jpg', 'group_chat', 'image/jpeg', '2019-11-17 21:12:19'),
(10, 'chat1', ' hiow', 'group_chat', 'text_message', '2019-11-19 01:53:03'),
(11, 'testU@chatz', ' hi', 'group_chat', 'text_message', '2019-11-20 09:38:30'),
(12, 'testU@chatz', ' how are you', 'group_chat', 'text_message', '2019-11-20 09:38:39'),
(13, 'testU@chatz', './attach_temp/2893b9259084f32c895805c12f5f708c26744319.jpg', 'group_chat', 'image/jpeg', '2019-11-20 09:39:25'),
(14, 'testU@chatz', './attach_temp/7c2bf575c492eb16fe34503673844f9ce1ba6551.jpg', 'group_chat', 'image/jpeg', '2019-11-20 09:40:25'),
(15, 'alexg@chatz', ' hi', 'group_chat', 'text_message', '2019-11-20 10:04:19'),
(16, 'najeemb18@gmail.com', ' hello how are you', 'group_chat', 'text_message', '2019-11-20 11:02:29'),
(17, 'najeemb18@gmail.com', ' everyone i need more people to join because i need more developers to work with me', 'group_chat', 'text_message', '2019-11-20 11:02:46'),
(18, 'john@chatz', ' hello guys', 'group_chat', 'text_message', '2019-11-20 11:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `latest_message_log`
--

CREATE TABLE `latest_message_log` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `time_sent` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `latest_message_log`
--

INSERT INTO `latest_message_log` (`id`, `sender`, `receiver`, `time_sent`) VALUES
(1, '', '', '0000-00-00 00:00:00'),
(2, '', '', '0000-00-00 00:00:00'),
(3, '', '', '0000-00-00 00:00:00'),
(4, '', '', '0000-00-00 00:00:00'),
(5, '', '', '0000-00-00 00:00:00'),
(6, '', '', '0000-00-00 00:00:00'),
(7, '', '', '0000-00-00 00:00:00'),
(8, '', '', '0000-00-00 00:00:00'),
(9, '', '', '0000-00-00 00:00:00'),
(10, '', '', '0000-00-00 00:00:00'),
(11, '', '', '0000-00-00 00:00:00'),
(12, '', '', '0000-00-00 00:00:00'),
(13, '', '', '0000-00-00 00:00:00'),
(14, '', '', '0000-00-00 00:00:00'),
(15, '', '', '0000-00-00 00:00:00'),
(16, '', '', '0000-00-00 00:00:00'),
(17, '', '', '0000-00-00 00:00:00'),
(18, '', '', '0000-00-00 00:00:00'),
(19, '', '', '0000-00-00 00:00:00'),
(20, '', '', '0000-00-00 00:00:00'),
(21, '', '', '0000-00-00 00:00:00'),
(22, '', '', '0000-00-00 00:00:00'),
(23, '', '', '0000-00-00 00:00:00'),
(24, '', '', '0000-00-00 00:00:00'),
(25, '', '', '0000-00-00 00:00:00'),
(26, '', '', '0000-00-00 00:00:00'),
(27, '', '', '0000-00-00 00:00:00'),
(28, '', '', '0000-00-00 00:00:00'),
(29, '', '', '0000-00-00 00:00:00'),
(30, '', '', '0000-00-00 00:00:00'),
(31, '', '', '0000-00-00 00:00:00'),
(32, '', '', '0000-00-00 00:00:00'),
(33, '', '', '0000-00-00 00:00:00'),
(34, '', '', '0000-00-00 00:00:00'),
(35, '', '', '0000-00-00 00:00:00'),
(36, '', '', '0000-00-00 00:00:00'),
(37, '', '', '0000-00-00 00:00:00'),
(38, '', '', '0000-00-00 00:00:00'),
(39, '', '', '0000-00-00 00:00:00'),
(40, '', '', '0000-00-00 00:00:00'),
(41, '', '', '0000-00-00 00:00:00'),
(42, '', '', '0000-00-00 00:00:00'),
(43, '', '', '0000-00-00 00:00:00'),
(44, '', '', '0000-00-00 00:00:00'),
(45, '', '', '0000-00-00 00:00:00'),
(46, '', '', '0000-00-00 00:00:00'),
(47, '', '', '0000-00-00 00:00:00'),
(48, '', '', '0000-00-00 00:00:00'),
(49, '', '', '0000-00-00 00:00:00'),
(50, '', '', '0000-00-00 00:00:00'),
(51, '', '', '0000-00-00 00:00:00'),
(52, '', '', '0000-00-00 00:00:00'),
(53, '', '', '0000-00-00 00:00:00'),
(54, 'najeemb18@gmail.com', 'helperd@chatz', '2019-11-20 11:00:24'),
(55, 'najeemb18@gmail.com', 'group_chat', '2019-11-20 11:02:29'),
(56, 'najeemb18@gmail.com', 'group_chat', '2019-11-20 11:02:46'),
(57, 'john@chatz', 'group_chat', '2019-11-20 11:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `type` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `sent_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `message`, `type`, `receiver`, `sent_on`) VALUES
(1, 'najeemb18@gmail.com', ' hi', 'text_message', 'john@chatz', '2019-10-07 12:54:07'),
(2, 'najeemb18@gmail.com', ' comment ca va?', 'text_message', 'john@chatz', '2019-10-07 12:54:18'),
(3, 'john@chatz', ' ok je veux bien', 'text_message', 'najeemb18@gmail.com', '2019-10-07 12:54:40'),
(4, 'najeemb18@gmail.com', ' qu\'est que tu fais', 'text_message', 'john@chatz', '2019-10-07 12:54:54'),
(5, 'yobitchsup', ' hey man wassup', 'text_message', 'najeemb18@gmail.com', '2019-10-07 13:41:02'),
(6, 'hello', ' hay jon ?', 'text_message', 'john@chatz', '2019-10-07 14:18:22'),
(7, 'john@chatz', ' hi how are you ?', 'text_message', 'hello', '2019-10-07 14:18:38'),
(8, 'john@chatz', ' are you ok ?', 'text_message', 'hello', '2019-10-07 14:18:48'),
(9, 'hello', ' not fucking ok thou', 'text_message', 'john@chatz', '2019-10-07 14:19:49'),
(10, 'john@chatz', ' what that is mean guy ?', 'text_message', 'hello', '2019-10-07 14:20:11'),
(11, 'mona@chatz', ' hi I am Mona.', 'text_message', 'john@chatz', '2019-10-07 14:45:39'),
(12, 'amirwaqas289562@gmail.com', ' hi', 'text_message', 'najeemb18@gmail.com', '2019-10-19 10:26:36'),
(13, 'najeemb18@gmail.com', ' How are you ', 'text_message', 'amirwaqas289562@gmail.com', '2019-10-19 10:34:58'),
(14, 'najeemb18@gmail.com', ' Change your profile picture', 'text_message', 'amirwaqas289562@gmail.com', '2019-10-19 10:35:12'),
(15, 'babarjohn604@gmail.com', ' Hi', 'text_message', 'najeemb18@gmail.com', '2019-10-19 11:03:27'),
(16, 'najeemb18@gmail.com', ' How are you friend ', 'text_message', 'babarjohn604@gmail.com', '2019-10-19 11:04:15'),
(17, 'najeemb18@gmail.com', ' Welcome ', 'text_message', 'babarjohn604@gmail.com', '2019-10-19 11:04:22'),
(18, 'babarjohn604@gmail.com', ' Fine ', 'text_message', 'najeemb18@gmail.com', '2019-10-19 11:05:29'),
(19, 'najeemb18@gmail.com', ' Change your profile picture ', 'text_message', 'babarjohn604@gmail.com', '2019-10-19 11:06:06'),
(20, 'najeemb18@gmail.com', ' Find settings', 'text_message', 'babarjohn604@gmail.com', '2019-10-19 11:07:48'),
(21, 'babarjohn604@gmail.com', ' I found', 'text_message', 'najeemb18@gmail.com', '2019-10-19 11:08:23'),
(22, 'najeemb18@gmail.com', ' Ok', 'text_message', 'babarjohn604@gmail.com', '2019-10-19 11:08:44'),
(23, 'najeemb18@gmail.com', ' Ok', 'text_message', 'babarjohn604@gmail.com', '2019-10-19 11:08:46'),
(24, 'najeemb18@gmail.com', ' What are we waiting for ', 'text_message', 'babarjohn604@gmail.com', '2019-10-19 11:44:24'),
(25, 'najeemba@chatz', ' hi', 'text_message', 'Abcd', '2019-11-17 19:28:36'),
(26, 'najeemba@chatz', './najeembdt/attach_temp/10f5e2146581f5afd6c442953b28107ffdb83328.jpg', 'image/jpeg', 'Abcd', '2019-11-17 19:53:09'),
(27, 'najeemba@chatz', './attach_temp/bfc324df47e6b83516a16015400b4cb951f08b0d.jpg', 'image/jpeg', 'Abcd', '2019-11-17 20:06:44'),
(28, 'najeemba@chatz', './attach_temp/5957fb3a5b609bba3ee8da35be406a45893bad53.png', 'image/png', 'Abcd', '2019-11-17 20:13:33'),
(29, 'najeemba@chatz', './attach_temp/909172e1e0862874086daf91f1e89edd378e75c8.png', 'image/png', 'Abcd', '2019-11-17 20:13:46'),
(30, 'najeemba@chatz', './attach_temp/10f5e2146581f5afd6c442953b28107ffdb83328.jpg', 'image/jpeg', 'Abcd', '2019-11-17 20:13:56'),
(31, 'najeemba@chatz', './attach_temp/6777abe7e6d787ea1ab979f3235ff6cdd3b65dea.jpg', 'image/jpeg', 'Abcd', '2019-11-17 20:14:07'),
(32, 'najeemba@chatz', './attach_temp/c07ac4db5a9940205be7ba242bf7d546543f5dc0.ico', 'image/vnd.microsoft.icon', 'Abcd', '2019-11-17 20:15:32'),
(33, 'najeemba@chatz', './attach_temp/5957fb3a5b609bba3ee8da35be406a45893bad53.png', 'image/png', 'Abcd', '2019-11-17 20:15:44'),
(34, 'najeemba@chatz', ' hi how are you', 'text_message', 'Abcd', '2019-11-17 20:16:13'),
(35, 'chat1', ' hi', 'text_message', 'chat', '2019-11-19 01:50:40'),
(36, 'helperd@chatz', ' hey hi', 'text_message', 'najeemb18@gmail.com', '2019-11-20 10:57:49'),
(37, 'najeemb18@gmail.com', ' ok', 'text_message', 'helperd@chatz', '2019-11-20 11:00:01'),
(38, 'helperd@chatz', ' great help me', 'text_message', 'najeemb18@gmail.com', '2019-11-20 11:00:13'),
(39, 'najeemb18@gmail.com', ' why not off course', 'text_message', 'helperd@chatz', '2019-11-20 11:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `sex` char(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `temp_password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `p_link` varchar(255) NOT NULL,
  `registered_on` datetime NOT NULL,
  `verificationc` varchar(255) NOT NULL,
  `userl_ip` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `sex`, `email`, `phone`, `site`, `username`, `password`, `temp_password`, `status`, `p_link`, `registered_on`, `verificationc`, `userl_ip`) VALUES
(1, 'Ahmad Najeem Barekzai', 'male', 'najeemb18@gmail.com', '+306945631764', 'newbuston', 'najeemb18@gmail.com', '89776aa74efc63afb5983f13a5b07279', 'password', 'offline', './profile_pictures/6777abe7e6d787ea1ab979f3235ff6cdd3b65dea.jpg', '2019-10-07 11:41:13', 'gLZBfVGbmusYPHvSaDxOXQM3elzoGnFIU0qdywkN30jhrcCtpRiAWETK', '188.73.248.214'),
(2, 'john', 'male', 'lohatajean@gmail.com', '+3069454215078988', 'newbuston', 'john@chatz', 'a7592cfb44e73775157d2d22c48ca9a8', 'password', 'offline', './profile_pictures/b107bc513ab36007d6a85612cce877de8a2d107a.jpg', '2019-10-07 12:51:46', 'dTDkeYGyNcrHq5nE2mXKpRwGMFz4jZW5QPVOUaoSsLiBvhfutxAglbIC', '213.249.14.118'),
(3, 'Ahmad Sohail Haqyar', 'male', 'Haqyarsohail@gmail.com', '+30698502149', 'newbuston', 'yobitchsup', 'ea28f8726cf8573fb7d00e51253c82be', '0321tnucbmuD9', 'online', './profile_pictures/default_profile_picture/default.jpeg', '2019-10-07 13:37:20', 'N1uTWGp5GMfeahlLHzcsimSYdwgjnQDVOZFRbB8CqIoxrKAkUEXyPvt', '213.249.14.118'),
(4, 'hello', 'male', 'hello@hello.com', '+301234567890', 'newbuston', 'hello', '2b1f3e79706bca0c4b8346cf01c3b43f', '0321olleHolleh2', 'online', './profile_pictures/default_profile_picture/default.jpeg', '2019-10-07 14:16:59', 'LUGSYG8k1yXNucIzswMmfiHdQRVpOeAnZEKToPqBbxr52CWlvtDFhagj', '213.249.14.118'),
(5, 'Mona akbarpour', 'female', 'flowers.vampire1@gmail.com', '+306980958110', 'newbuston', 'mona@chatz', '5247e63be3031ef070d420afbd83bfe0', '754321anoM2', 'online', './profile_pictures/default_profile_picture/default.jpeg', '2019-10-07 14:43:44', 'a3tCsnvckRZALmPFzygHdoVXu3M4hQrEUOSG3BYTWpIxiqjfDNeKlwGb', '213.249.14.118'),
(6, 'Alejandra', 'female', 'ale.cabez@gmail.com', '+306949384443', 'newbuston', 'alecabez', '1817c0c636a3c2b4133936455b2c75b7', '1192042eLa5', 'online', './profile_pictures/default_profile_picture/default.jpeg', '2019-10-16 08:30:13', 'yDRSmgiHltYKvNaBPIMhAzfU3GdEFsCecG47uVWZQLwqrTxObko6Xpnj', '2.87.220.37'),
(7, 'Amir sam', 'male', 'amirsam289562@gmail.com', '+306942089487', 'najeembdt', 'amirwaqas289562@gmail.com', '99f80dd34e32c205509786cbc4d17999', '54321rimA6', 'online', './profile_pictures/default_profile_picture/default.jpeg', '2019-10-19 10:23:48', 'wgYksnIKfGvxhHpldQ3bXZcitTj7PU2CGMAmOSLEoeFDVr9qBuzNaRWy', '62.74.8.250'),
(8, 'Babar', 'male', 'babarjohn604@gmail.com', '+306955776530', 'najeembdt', 'babarjohn604@gmail.com', '76376766439913ce418d9140f1469350', '54321rabaB8', 'online', './profile_pictures/ff26a2b474517f5e6baf7ae3dfc9bfa1df760af2.jpg', '2019-10-19 11:00:05', 'GxUWtIRzDeVkAMQTvdKfYEnXsiGl1SoyuPBLOa0hNcbF6grjm9qHpZCw', '188.73.248.238'),
(9, 'Alex', 'male', 'alex.malcom@phpacademy.org', '+436876533443', 'najeembdt', 'alex@chatz', '89776aa74efc63afb5983f13a5b07279', '7$#@!4321dcbA4', 'online', './profile_pictures/default_profile_picture/default.jpeg', '2019-11-18 16:58:14', 'I6CiNt3cXwoVhBkbYGLldevmpuzqaAyjSTQZfsRH0WKPMEUnFGxDOrg', '188.73.249.216'),
(10, 'Test User', 'male', 'testuser@chatz.org', '+30694563789844', 'najeembdt', 'Abcd', '325a2cc052914ceeb8c19016c091d2ac', '74321dcbA9', 'online', './profile_pictures/default_profile_picture/default.jpeg', '2019-11-15 10:12:53', 'QsUPryNlTFkGbLIhcuxeagG8Mf9XBdAO1ipRomzDZStVqwnE7vjWKHYC', '213.249.14.118'),
(100, 'NajeemB', 'male', 'najeemb18@yahoo.com', '+306945631764', 'friends', 'najeemb@chatz', '4cc22c0feb4be67b4cab12582484e858', 'password', 'offline', './profile_pictures/default_profile_picture/default.jpeg', '2019-11-22 03:49:13', 'ZxmlQ7uhAjp3qWtz8feaTUHcDbkXdOgByMNwPYKi6sGoEnILSCGVrvFR', '188.73.248.215'),
(101, 'FORGE for humanity', 'other', 'admin@forgeforhumanity.org', '+306949384443', 'FORGE for humanity', 'Alejandra', '150b7f24941b407033d2ec2a3859a1e2', 'password', 'offline', './profile_pictures/default_profile_picture/default.jpeg', '2019-11-28 08:19:16', 'c0GPgleLdXposFrBOTGmj2qKZDwCUbaEH2IVYMxfSyhznQtNkWAuvRi3', '85.74.160.96'),
(102, 'John Egbe', 'male', 'ewubetravo@gmail.com', '+306943461345', 'Freelance spices', 'Ewube', '89a7e7530218eee35ec9ad4b9ed97fea', 'password', 'offline', './profile_pictures/default_profile_picture/default.jpeg', '2019-12-17 10:41:05', 'WUOEBou1aISqCTYeslRtmrbGg4QGnDApNX0yifMxdZzvHcK5FLjhkwPV', '94.66.56.7'),
(11, 'HelperD', 'male', 'testdwork7@gmail.com', '+304234333333', 'najeembdt', 'helperd@chatz', '325a2cc052914ceeb8c19016c091d2ac', 'password', 'offline', './profile_pictures/default_profile_picture/default.jpeg', '2019-11-20 10:56:38', '8eZLdjyx6sWXihKn4tIfuw9MYFmUGAHTPcqpkSVolNzRObQEDaCBvGrg', '213.249.14.118');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_chat`
--
ALTER TABLE `group_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `latest_message_log`
--
ALTER TABLE `latest_message_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_chat`
--
ALTER TABLE `group_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `latest_message_log`
--
ALTER TABLE `latest_message_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
