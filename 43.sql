-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2017 at 06:39 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `43`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(255) NOT NULL,
  `viewed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`id`, `user`, `page`, `timestamp`, `ip`, `viewed`) VALUES
(1, 1, '42', '2017-02-20 17:31:13', '::1', 0),
(2, 0, '44', '2017-08-14 17:32:22', '::1', 0),
(3, 0, '4', '2017-09-16 17:53:58', '::1', 0),
(4, 0, '4', '2017-09-16 17:57:07', '::1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `crons`
--

CREATE TABLE `crons` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `sort` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crons`
--

INSERT INTO `crons` (`id`, `active`, `sort`, `name`, `file`, `createdby`, `created`, `modified`) VALUES
(1, 0, 100, 'Auto-Backup', 'backup.php', 1, '2017-09-16 07:49:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `crons_logs`
--

CREATE TABLE `crons_logs` (
  `id` int(11) NOT NULL,
  `cron_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `website_name` varchar(100) NOT NULL,
  `smtp_server` varchar(100) NOT NULL,
  `smtp_port` int(10) NOT NULL,
  `email_login` varchar(150) NOT NULL,
  `email_pass` varchar(100) NOT NULL,
  `from_name` varchar(100) NOT NULL,
  `from_email` varchar(150) NOT NULL,
  `transport` varchar(255) NOT NULL,
  `verify_url` varchar(255) NOT NULL,
  `email_act` int(1) NOT NULL,
  `debug_level` int(1) NOT NULL DEFAULT '0',
  `isSMTP` int(1) NOT NULL DEFAULT '0',
  `isHTML` varchar(5) NOT NULL DEFAULT 'true',
  `useSMTPauth` varchar(6) NOT NULL DEFAULT 'true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `website_name`, `smtp_server`, `smtp_port`, `email_login`, `email_pass`, `from_name`, `from_email`, `transport`, `verify_url`, `email_act`, `debug_level`, `isSMTP`, `isHTML`, `useSMTPauth`) VALUES
(1, 'User Spice', 'smtp.gmail.com', 587, 'yourEmail@gmail.com', '1234', 'User Spice', 'yourEmail@gmail.com', 'tls', 'http://localhost/43', 0, 0, 0, 'true', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `groups_menus`
--

CREATE TABLE `groups_menus` (
  `id` int(11) NOT NULL,
  `group_id` int(15) NOT NULL,
  `menu_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups_menus`
--

INSERT INTO `groups_menus` (`id`, `group_id`, `menu_id`) VALUES
(11, 0, 4),
(12, 1, 4),
(13, 3, 4),
(14, 0, 5),
(15, 0, 3),
(16, 0, 1),
(17, 0, 6),
(18, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `stripe_ts` varchar(255) NOT NULL,
  `stripe_tp` varchar(255) NOT NULL,
  `stripe_ls` varchar(255) NOT NULL,
  `stripe_lp` varchar(255) NOT NULL,
  `recap_pub` varchar(100) NOT NULL,
  `recap_pri` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(3) NOT NULL,
  `logdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logtype` varchar(25) NOT NULL,
  `lognote` text NOT NULL,
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `logdate`, `logtype`, `lognote`, `added`) VALUES
(1, 1, '2017-09-20 09:38:04', 'Admin Verification', 'Access denied to users/admin_users.php via password verification due to invalid password.', '2017-09-19 17:38:04'),
(2, 1, '2017-09-20 09:38:11', 'Admin Verification', 'Access granted to users/admin_users.php via password verification.', '2017-09-19 17:38:11'),
(3, 1, '2017-09-20 10:08:51', 'Setting Changed', 'Changed recaptcha from 0 to 2.', '2017-09-19 18:08:51'),
(4, 1, '2017-09-20 10:15:59', 'Setting Changed', 'Changed recaptcha from 2 to 1.', '2017-09-19 18:15:59'),
(5, 1, '2017-09-20 10:16:31', 'User', 'User logged in.', '2017-09-19 18:16:31'),
(6, 1, '2017-09-20 10:16:40', 'User', 'User logged in.', '2017-09-19 18:16:40'),
(7, 1, '2017-09-20 10:32:27', 'Setting Changed', 'Changed recaptcha public key from 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI to 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI.', '2017-09-19 18:32:27'),
(8, 1, '2017-09-20 10:32:27', 'Setting Changed', 'Changed recaptcha private key from 6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe to .', '2017-09-19 18:32:27'),
(9, 1, '2017-09-20 10:37:40', 'Setting Changed', 'Changed recaptcha public key from 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI to 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI.', '2017-09-19 18:37:40'),
(10, 1, '2017-09-20 10:37:40', 'Setting Changed', 'Changed recaptcha private key from 6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe to 6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe.', '2017-09-19 18:37:40'),
(11, 1, '2017-09-20 10:38:02', 'Setting Changed', 'Changed recaptcha public key from 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI to 16LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI.', '2017-09-19 18:38:02'),
(12, 1, '2017-09-20 10:38:02', 'Setting Changed', 'Changed recaptcha private key from 6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe to 16LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe.', '2017-09-19 18:38:02'),
(13, 1, '2017-09-24 02:46:46', 'User', 'User logged in.', '2017-09-23 10:46:46'),
(14, 1, '2017-09-24 02:47:31', 'Email Settings', 'Updated smtp_server from mail.userspice.com to smtp.gmail.com.', '2017-09-23 10:47:31'),
(15, 1, '2017-09-24 02:47:31', 'Email Settings', 'Updated email_login.', '2017-09-23 10:47:31'),
(16, 1, '2017-09-24 02:47:31', 'Email Settings', 'Updated email_pass.', '2017-09-23 10:47:31'),
(17, 1, '2017-09-24 02:47:31', 'Email Settings', 'Updated from_name from Your Name to Dan Hoover.', '2017-09-23 10:47:31'),
(18, 1, '2017-09-24 02:47:31', 'Email Settings', 'Updated from_email from noreply@userspice.com to userspicephp@gmail.com.', '2017-09-23 10:47:31'),
(19, 1, '2017-09-24 02:47:31', 'Email Settings', 'Updated verify_url from http://localhost/us4/ to http://localhost/43.', '2017-09-23 10:47:31'),
(20, 1, '2017-09-24 03:27:09', 'Email Settings', 'Updated email_pass.', '2017-09-23 11:27:09'),
(21, 1, '2017-09-24 03:27:09', 'Email Settings', 'Updated from_name from  to 1234.', '2017-09-23 11:27:09'),
(22, 1, '2017-09-24 03:27:09', 'Email Settings', 'Updated email_act from 2 to 1.', '2017-09-23 11:27:09'),
(23, 1, '2017-09-24 03:27:09', 'Email Settings', 'Updated isSMTP from 0 to 1.', '2017-09-23 11:27:09'),
(24, 1, '2017-09-24 03:27:09', 'Email Settings', 'Updated isHTML from true to false.', '2017-09-23 11:27:09'),
(25, 1, '2017-09-24 03:27:09', 'Email Settings', 'Updated useSMTPauth from true to false.', '2017-09-23 11:27:09'),
(26, 1, '2017-09-24 03:27:50', 'Email Settings', 'Updated from_name from 1234 to User Spice.', '2017-09-23 11:27:50'),
(27, 1, '2017-09-24 03:27:50', 'Email Settings', 'Updated isSMTP from 1 to 0.', '2017-09-23 11:27:50'),
(28, 1, '2017-09-24 03:27:50', 'Email Settings', 'Updated isHTML from false to true.', '2017-09-23 11:27:50'),
(29, 1, '2017-09-24 03:27:50', 'Email Settings', 'Updated useSMTPauth from false to true.', '2017-09-23 11:27:50'),
(30, 1, '2017-09-24 03:30:47', 'Email Settings', 'Updated email_act from 1 to 0.', '2017-09-23 11:30:47'),
(31, 1, '2017-09-24 05:31:07', 'Admin Verification', 'Access granted to users/admin_users.php via password verification.', '2017-09-23 13:31:07'),
(32, 1, '2017-09-24 05:38:57', 'User Manager', 'Added user test.', '2017-09-23 13:38:57'),
(33, 1, '2017-09-24 05:45:45', 'User', 'User logged in.', '2017-09-23 13:45:45'),
(34, 1, '2017-09-24 06:22:37', 'User', 'User logged in.', '2017-09-23 14:22:37'),
(35, 1, '2017-09-24 06:26:18', 'User Manager', 'Added user test67.', '2017-09-23 14:26:18'),
(36, 1, '2017-09-24 06:33:01', 'User', 'Changed fname from Dan to Dan2.', '2017-09-23 14:33:01'),
(37, 1, '2017-09-24 08:38:44', 'Setting Change', 'Changed page_default_private from 1 to 0.', '2017-09-23 16:38:44'),
(38, 1, '2017-09-25 00:02:51', 'Pages Manager', 'Added 1 permission(s) to users/update.php.', '2017-09-24 08:02:51'),
(39, 1, '2017-09-25 00:47:19', 'Pages Manager', 'Changed private from public to private for Page #55.', '2017-09-24 08:47:19'),
(40, 1, '2017-09-25 00:47:19', 'Pages Manager', 'Added 1 permission(s) to users/admin_logs.php.', '2017-09-24 08:47:19'),
(41, 1, '2017-09-25 00:47:30', 'Pages Manager', 'Changed private from public to private for Page #56.', '2017-09-24 08:47:30'),
(42, 1, '2017-09-25 00:47:30', 'Pages Manager', 'Added 1 permission(s) to users/admin_logs_exempt.php.', '2017-09-24 08:47:30'),
(43, 1, '2017-09-25 05:37:27', 'Pages Manager', 'Added 1 permission(s) to users/admin_menu.php.', '2017-09-24 13:37:27'),
(44, 2, '2017-10-08 23:23:56', 'User', 'User logged in.', '2017-10-08 07:23:56'),
(45, 1, '2017-10-08 23:24:26', 'User', 'User logged in.', '2017-10-08 07:24:26'),
(46, 1, '2017-10-08 23:24:37', 'Admin Verification', 'Access granted to users/admin_users.php via password verification.', '2017-10-08 07:24:37'),
(47, 1, '2017-10-08 23:24:55', 'User Manager', 'Updated active for Sample from 1 to 0.', '2017-10-08 07:24:55'),
(48, 1, '2017-10-08 23:24:55', 'User Manager', 'Updated email_verified for Sample to ..', '2017-10-08 07:24:55'),
(49, 2, '2017-10-08 23:25:11', 'User', 'User logged in.', '2017-10-08 07:25:11'),
(50, 2, '2017-10-08 23:26:39', 'User', 'User logged in.', '2017-10-08 07:26:39'),
(51, 1, '2017-10-08 23:29:45', 'User', 'User logged in.', '2017-10-08 07:29:45'),
(52, 2, '2017-10-08 23:29:57', 'User', 'User logged in.', '2017-10-08 07:29:57'),
(53, 2, '2017-10-08 23:32:08', 'User', 'User logged in.', '2017-10-08 07:32:08'),
(54, 1, '2017-10-08 23:32:17', 'User Manager', 'Updated active for Sample from 1 to 1.', '2017-10-08 07:32:17'),
(55, 1, '2017-10-08 23:32:17', 'User Manager', 'Updated email_verified for Sample to ..', '2017-10-08 07:32:17'),
(56, 2, '2017-10-08 23:37:42', 'User', 'User logged in.', '2017-10-08 07:37:42'),
(57, 2, '2017-10-08 23:47:41', 'User', 'User logged in.', '2017-10-08 07:47:41'),
(58, 1, '2017-10-09 00:01:14', 'User', 'User logged in.', '2017-10-08 08:01:14'),
(59, 1, '2017-10-09 00:10:22', 'User', 'User logged in.', '2017-10-08 08:10:22'),
(60, 1, '2017-10-09 00:10:58', 'Pages Manager', 'Retitled ''users/admin_ips.php'' to ''Admin IPs''.', '2017-10-08 08:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `logs_exempt`
--

CREATE TABLE `logs_exempt` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) NOT NULL,
  `menu_title` varchar(255) NOT NULL,
  `parent` int(10) NOT NULL,
  `dropdown` int(1) NOT NULL,
  `logged_in` int(1) NOT NULL,
  `display_order` int(10) NOT NULL,
  `label` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon_class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_title`, `parent`, `dropdown`, `logged_in`, `display_order`, `label`, `link`, `icon_class`) VALUES
(1, 'main', -1, 0, 1, 0, 'Home', '', 'fa fa-fw fa-home'),
(2, 'main', -1, 0, 1, 2, 'Dashboard', 'users/admin.php', 'fa fa-fw fa-cogs'),
(3, 'main', -1, 1, 1, 1, '{{username}}', '', 'fa fa-fw fa-user'),
(4, 'main', 3, 0, 1, 1, 'Profile', 'users/profile.php', 'fa fa-fw fa-home'),
(5, 'main', 3, 0, 1, 1, 'Logout', 'users/logout.php', 'fa fa-fw fa-home'),
(6, 'main', -1, 1, 1, 3, 'Help', '', 'fa fa-fw fa-life-ring'),
(8, 'main', -1, 0, 0, 1, 'Register', 'users/join.php', 'fa fa-fw fa-plus-square'),
(9, 'main', -1, 0, 0, 2, 'Log In', 'users/login.php', 'fa fa-fw fa-sign-in'),
(10, 'admin', -1, 0, 1, 0, 'Info', 'users/admin.php', ''),
(11, 'admin', -1, 1, 1, 1, 'Settings', '', ''),
(12, 'admin', 11, 0, 1, 2, 'Security', 'users/admin_security.php', ''),
(13, 'admin', 11, 0, 1, 3, 'CSS', 'users/admin_css.php', ''),
(14, 'admin', -1, 0, 1, 4, 'Users', 'users/admin_users.php', ''),
(15, 'admin', -1, 0, 1, 5, 'Groups', 'users/admin_groups.php', ''),
(16, 'admin', -1, 0, 1, 6, 'Pages', 'users/admin_pages.php', ''),
(17, 'admin', 20, 0, 1, 7, 'Settings', 'users/admin_email.php', ''),
(18, 'admin', -1, 0, 1, 8, 'Menus', 'users/admin_menus.php', ''),
(20, 'admin', -1, 1, 1, 7, 'Email', '', ''),
(21, 'admin', 20, 0, 1, 99999, 'Email Verify Template', 'users/admin_email_template.php?type=verify', ''),
(22, 'admin', 20, 0, 1, 99999, 'Forgot Password Template', 'users/admin_email_template.php?type=forgot', ''),
(23, 'main', 6, 0, 0, 99999, 'Verify Resend', 'users/verify_resend.php', ''),
(24, 'admin', 11, 0, 1, 0, 'General', 'users/admin_general.php', ''),
(25, 'admin', 11, 0, 1, 1, 'Redirects', 'users/admin_redirects.php', ''),
(26, 'admin', -1, 0, 1, 99999, 'Add User(s)', 'users/admin_users_add.php', ''),
(27, 'admin', 20, 0, 1, 99999, 'Test', 'users/admin_email_test.php', ''),
(28, 'admin', -1, 1, 1, 99999, 'System', '', ''),
(29, 'admin', 28, 0, 1, 99999, 'Updates', 'users/admin_updates.php', ''),
(30, 'admin', 28, 0, 1, 99999, 'Backup', 'users/admin_backup.php', ''),
(31, 'admin', 28, 0, 1, 99999, 'Restore', 'users/admin_restore.php', ''),
(32, 'admin', 28, 0, 1, 99999, 'Status', 'users/admin_status.php', ''),
(33, 'admin', 28, 0, 1, 99999, 'PHP Info', 'users/admin_phpinfo.php', ''),
(34, 'admin', 11, 0, 1, 99999, 'Registration', 'users/admin_registration.php', ''),
(35, 'admin', 11, 0, 1, 99999, 'Google Login', 'users/admin_googlelogin.php', ''),
(36, 'admin', 11, 0, 1, 99999, 'Facebook Login', 'users/admin_facebooklogin.php', '');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `msg_from` int(11) NOT NULL,
  `msg_to` int(11) NOT NULL,
  `msg_body` text NOT NULL,
  `msg_read` int(1) NOT NULL,
  `msg_thread` int(11) NOT NULL,
  `deleted` int(1) NOT NULL,
  `sent_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `msg_from`, `msg_to`, `msg_body`, `msg_read`, `msg_thread`, `deleted`, `sent_on`) VALUES
(1, 1, 2, '&lt;p&gt;fgds&lt;/p&gt;', 0, 1, 0, '2017-08-06 00:13:47'),
(2, 1, 2, '&lt;p&gt;Did it work?&lt;/p&gt;', 0, 2, 0, '2017-09-09 15:10:09');

-- --------------------------------------------------------

--
-- Table structure for table `message_threads`
--

CREATE TABLE `message_threads` (
  `id` int(11) NOT NULL,
  `msg_to` int(11) NOT NULL,
  `msg_from` int(11) NOT NULL,
  `msg_subject` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL,
  `last_update_by` int(11) NOT NULL,
  `archive_from` int(1) NOT NULL DEFAULT '0',
  `archive_to` int(1) NOT NULL DEFAULT '0',
  `hidden_from` int(1) NOT NULL DEFAULT '0',
  `hidden_to` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_threads`
--

INSERT INTO `message_threads` (`id`, `msg_to`, `msg_from`, `msg_subject`, `last_update`, `last_update_by`, `archive_from`, `archive_to`, `hidden_from`, `hidden_to`) VALUES
(1, 2, 1, 'Testiing123', '2017-08-06 00:13:47', 1, 0, 0, 0, 0),
(2, 2, 1, 'Testing Message Badge', '2017-09-09 15:10:09', 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mqtt`
--

CREATE TABLE `mqtt` (
  `id` int(11) NOT NULL,
  `server` varchar(255) NOT NULL,
  `port` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mqtt`
--

INSERT INTO `mqtt` (`id`, `server`, `port`, `username`, `password`, `nickname`) VALUES
(2, '192.168.0.222', 1883, '', '', 'Raspberry PI MQTT2');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` mediumtext NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `is_archived` tinyint(1) DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_read` datetime NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `is_archived`, `date_created`, `date_read`, `last_updated`) VALUES
(10, 1, 'This is a sample notification! <a href="/43/users/logout.php">Go to Logout Page</a>', 1, 1, '2017-09-09 06:59:13', '2017-09-16 08:11:11', '2017-09-16 17:30:17');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page` varchar(100) NOT NULL,
  `title` varchar(50) NOT NULL,
  `private` int(11) NOT NULL DEFAULT '0',
  `re_auth` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page`, `title`, `private`, `re_auth`) VALUES
(1, 'index.php', 'Home', 0, 0),
(2, 'z_us_root.php', '', 0, 0),
(3, 'users/account.php', 'Account Dashboard', 1, 0),
(4, 'users/admin.php', 'Admin Dashboard', 1, 0),
(5, 'users/admin_page.php', 'Manage Page', 1, 0),
(6, 'users/admin_pages.php', 'Manage Pages', 1, 0),
(7, 'users/admin_permission.php', 'Manage Permission', 1, 0),
(8, 'users/admin_permissions.php', 'Manage Permissions', 1, 0),
(9, 'users/admin_user.php', 'Manage User', 1, 0),
(10, 'users/admin_users.php', 'Manage Users', 1, 1),
(11, 'users/edit_profile.php', 'Edit Profile', 1, 0),
(12, 'users/email_settings.php', 'Email Settings', 1, 0),
(13, 'users/email_test.php', 'Email Test', 1, 0),
(14, 'users/forgot_password.php', 'Forgotten Password', 0, 0),
(15, 'users/forgot_password_reset.php', 'Reset Forgotten Password', 0, 0),
(16, 'users/index.php', 'Home', 0, 0),
(17, 'users/init.php', '', 0, 0),
(18, 'users/join.php', 'Join', 0, 0),
(19, 'users/joinThankYou.php', 'Join', 0, 0),
(20, 'users/login.php', 'Login', 0, 0),
(21, 'users/logout.php', 'Logout', 0, 0),
(22, 'users/profile.php', 'Profile', 1, 0),
(23, 'users/times.php', '', 0, 0),
(24, 'users/user_settings.php', 'My Settings', 1, 0),
(25, 'users/verify.php', 'Account Verification', 0, 0),
(26, 'users/verify_resend.php', 'Account Verification', 0, 0),
(27, 'users/view_all_users.php', 'View All Users', 1, 0),
(28, 'usersc/empty.php', '', 0, 0),
(31, 'users/oauth_success.php', '', 0, 0),
(33, 'users/fb-callback.php', '', 0, 0),
(37, 'users/check_updates.php', 'Check For Updates', 1, 0),
(38, 'users/google_helpers.php', '', 0, 0),
(39, 'users/tomfoolery.php', 'Security Log', 1, 0),
(41, 'users/messages.php', 'My Messages', 1, 0),
(42, 'users/message.php', 'My Messages', 1, 0),
(44, 'users/admin_backup.php', 'Backup Files', 1, 0),
(45, 'users/maintenance.php', 'Maintenance', 0, 0),
(47, 'users/mqtt_settings.php', 'MQTT Settings', 1, 0),
(49, 'users/admin_verify.php', 'Verify Password', 1, 0),
(50, 'users/cron_manager.php', 'Cron Manager', 1, 0),
(51, 'users/cron_post.php', 'Post a Cron Job', 1, 0),
(52, 'users/admin_message.php', 'View Message', 1, 0),
(53, 'users/admin_messages.php', 'View Messages', 0, 0),
(55, 'users/admin_logs.php', 'Site Logs', 1, 0),
(56, 'users/admin_logs_exempt.php', 'Site Logs', 1, 0),
(57, 'users/admin_logs_manager.php', 'Site Logs', 0, 0),
(58, 'users/admin_logs_mapper.php', 'Site Logs', 0, 0),
(68, 'users/update.php', 'Update UserSpice', 1, 0),
(69, 'users/admin_menu_item.php', 'Manage Menus', 1, 0),
(70, 'users/admin_menus.php', 'Manage Menus', 1, 0),
(71, 'users/admin_menu.php', 'Manage Menus', 1, 0),
(72, 'users/admin_ips.php', 'Admin IPs', 1, 0),
(73, 'users/subscribe.php', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'User'),
(2, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `permission_page_matches`
--

CREATE TABLE `permission_page_matches` (
  `id` int(11) NOT NULL,
  `permission_id` int(15) NOT NULL,
  `page_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission_page_matches`
--

INSERT INTO `permission_page_matches` (`id`, `permission_id`, `page_id`) VALUES
(2, 2, 27),
(3, 1, 24),
(4, 1, 22),
(5, 2, 13),
(6, 2, 12),
(7, 1, 11),
(8, 2, 10),
(9, 2, 9),
(10, 2, 8),
(11, 2, 7),
(12, 2, 6),
(13, 2, 5),
(14, 2, 4),
(15, 1, 3),
(16, 2, 37),
(17, 2, 39),
(19, 2, 40),
(21, 2, 41),
(23, 2, 42),
(27, 1, 42),
(28, 1, 27),
(29, 1, 41),
(30, 1, 40),
(31, 2, 44),
(32, 2, 47),
(33, 2, 51),
(34, 2, 50),
(35, 2, 49),
(36, 2, 53),
(37, 2, 52),
(38, 2, 68),
(39, 2, 55),
(40, 2, 56),
(41, 2, 71);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `bio`) VALUES
(1, 1, '<h1>This is the Admin''s bio.</h1>'),
(2, 2, 'This is your bio');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(50) NOT NULL,
  `recaptcha` int(1) NOT NULL DEFAULT '0',
  `force_ssl` int(1) NOT NULL,
  `css_sample` int(1) NOT NULL,
  `us_css1` varchar(255) NOT NULL,
  `us_css2` varchar(255) NOT NULL,
  `us_css3` varchar(255) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `language` varchar(255) NOT NULL,
  `track_guest` int(1) NOT NULL,
  `site_offline` int(1) NOT NULL,
  `force_pr` int(1) NOT NULL,
  `glogin` int(1) NOT NULL DEFAULT '0',
  `fblogin` int(1) NOT NULL,
  `gid` varchar(255) NOT NULL,
  `gsecret` varchar(255) NOT NULL,
  `gredirect` varchar(255) NOT NULL,
  `ghome` varchar(255) NOT NULL,
  `fbid` varchar(255) NOT NULL,
  `fbsecret` varchar(255) NOT NULL,
  `fbcallback` varchar(255) NOT NULL,
  `graph_ver` varchar(255) NOT NULL,
  `finalredir` varchar(255) NOT NULL,
  `req_cap` int(1) NOT NULL,
  `req_num` int(1) NOT NULL,
  `min_pw` int(2) NOT NULL,
  `max_pw` int(3) NOT NULL,
  `min_un` int(2) NOT NULL,
  `max_un` int(3) NOT NULL,
  `messaging` int(1) NOT NULL,
  `snooping` int(1) NOT NULL,
  `echouser` int(11) NOT NULL,
  `wys` int(1) NOT NULL,
  `change_un` int(1) NOT NULL,
  `backup_dest` varchar(255) NOT NULL,
  `backup_source` varchar(255) NOT NULL,
  `backup_table` varchar(255) NOT NULL,
  `msg_notification` int(1) NOT NULL DEFAULT '0',
  `permission_restriction` int(1) NOT NULL DEFAULT '0',
  `auto_assign_un` int(1) NOT NULL DEFAULT '0',
  `page_permission_restriction` int(1) NOT NULL DEFAULT '0',
  `msg_blocked_users` int(1) NOT NULL DEFAULT '0',
  `msg_default_to` int(1) NOT NULL DEFAULT '1',
  `notif_daylimit` int(3) NOT NULL DEFAULT '7',
  `recap_public` varchar(100) NOT NULL,
  `recap_private` varchar(100) NOT NULL,
  `page_default_private` int(1) NOT NULL DEFAULT '1',
  `navigation_type` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `recaptcha`, `force_ssl`, `css_sample`, `us_css1`, `us_css2`, `us_css3`, `site_name`, `language`, `track_guest`, `site_offline`, `force_pr`, `glogin`, `fblogin`, `gid`, `gsecret`, `gredirect`, `ghome`, `fbid`, `fbsecret`, `fbcallback`, `graph_ver`, `finalredir`, `req_cap`, `req_num`, `min_pw`, `max_pw`, `min_un`, `max_un`, `messaging`, `snooping`, `echouser`, `wys`, `change_un`, `backup_dest`, `backup_source`, `backup_table`, `msg_notification`, `permission_restriction`, `auto_assign_un`, `page_permission_restriction`, `msg_blocked_users`, `msg_default_to`, `notif_daylimit`, `recap_public`, `recap_private`, `page_default_private`, `navigation_type`) VALUES
(1, 1, 0, 0, '../users/css/color_schemes/bootstrap.min.css', '../users/css/sb-admin.css', '../users/css/custom.css', 'UserSpice', 'en', 1, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', 0, 0, 6, 30, 4, 30, 1, 1, 0, 1, 0, '/', 'everything', '', 0, 0, 0, 0, 0, 1, 7, '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `id` int(11) NOT NULL,
  `migration` varchar(15) NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(155) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `permissions` int(11) NOT NULL,
  `logins` int(100) NOT NULL,
  `account_owner` tinyint(4) NOT NULL DEFAULT '0',
  `account_id` int(11) NOT NULL DEFAULT '0',
  `company` varchar(255) NOT NULL,
  `join_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `email_verified` tinyint(4) NOT NULL DEFAULT '0',
  `vericode` varchar(15) NOT NULL,
  `active` int(1) NOT NULL,
  `oauth_provider` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gpluslink` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `fb_uid` varchar(255) NOT NULL,
  `un_changed` int(1) NOT NULL,
  `msg_exempt` int(1) NOT NULL DEFAULT '0',
  `last_confirm` datetime DEFAULT NULL,
  `protected` int(1) NOT NULL DEFAULT '0',
  `dev_user` int(1) NOT NULL DEFAULT '0',
  `msg_notification` int(1) NOT NULL DEFAULT '1',
  `force_pr` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `fname`, `lname`, `permissions`, `logins`, `account_owner`, `account_id`, `company`, `join_date`, `last_login`, `email_verified`, `vericode`, `active`, `oauth_provider`, `oauth_uid`, `gender`, `locale`, `gpluslink`, `picture`, `created`, `modified`, `fb_uid`, `un_changed`, `msg_exempt`, `last_confirm`, `protected`, `dev_user`, `msg_notification`, `force_pr`) VALUES
(1, 'userspicephp@gmail.com', 'admin', '$2y$12$1v06jm2KMOXuuo3qP7erTuTIJFOnzhpds1Moa8BadnUUeX0RV3ex.', 'Dan2', 'Hoover', 1, 59, 1, 0, 'UserSpice', '2016-01-01 00:00:00', '2017-10-08 16:10:22', 1, '322418', 0, '', '', '', '', '', '', '0000-00-00 00:00:00', '1899-11-30 00:00:00', '', 0, 1, '2017-10-08 15:24:37', 0, 0, 1, 0),
(2, 'noreply@userspice.com', 'user', '$2y$12$HZa0/d7evKvuHO8I3U8Ff.pOjJqsGTZqlX8qURratzP./EvWetbkK', 'Sample', 'User', 1, 13, 1, 0, 'none', '2016-01-02 00:00:00', '2017-10-08 15:47:41', 1, '970748', 1, '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, NULL, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(10) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `user_id` int(10) NOT NULL,
  `session` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `ip`, `timestamp`, `user_id`, `session`) VALUES
(1, '::1', '1507480697', 1, ''),
(2, '::1', '1507478433', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `uagent` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_permission_matches`
--

CREATE TABLE `user_permission_matches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_permission_matches`
--

INSERT INTO `user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES
(100, 1, 1),
(101, 1, 2),
(102, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `us_ip_blacklist`
--

CREATE TABLE `us_ip_blacklist` (
  `id` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `last_user` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `us_ip_whitelist`
--

CREATE TABLE `us_ip_whitelist` (
  `id` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crons`
--
ALTER TABLE `crons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crons_logs`
--
ALTER TABLE `crons_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_menus`
--
ALTER TABLE `groups_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs_exempt`
--
ALTER TABLE `logs_exempt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `logs_exempt_type` (`name`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_threads`
--
ALTER TABLE `message_threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mqtt`
--
ALTER TABLE `mqtt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_page_matches`
--
ALTER TABLE `permission_page_matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EMAIL` (`email`) USING BTREE;

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permission_matches`
--
ALTER TABLE `user_permission_matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_ip_blacklist`
--
ALTER TABLE `us_ip_blacklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_ip_whitelist`
--
ALTER TABLE `us_ip_whitelist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `crons`
--
ALTER TABLE `crons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `crons_logs`
--
ALTER TABLE `crons_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `groups_menus`
--
ALTER TABLE `groups_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `logs_exempt`
--
ALTER TABLE `logs_exempt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `message_threads`
--
ALTER TABLE `message_threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mqtt`
--
ALTER TABLE `mqtt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `permission_page_matches`
--
ALTER TABLE `permission_page_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_permission_matches`
--
ALTER TABLE `user_permission_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `us_ip_blacklist`
--
ALTER TABLE `us_ip_blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `us_ip_whitelist`
--
ALTER TABLE `us_ip_whitelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
