-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2013 at 02:24 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) DEFAULT NULL,
  `name` varchar(75) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `comment` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `blog_id`, `name`, `email`, `comment`, `date`) VALUES
(18, 60, 'Anonymous', 'Anonymous', 'Interesting...', '2013-01-07 13:12:15'),
(19, 60, 'Anonymous', 'Anonymous', 'Who care!', '2013-01-07 13:14:45'),
(20, 59, 'Anonymous', 'Anonymous', 'PSVISTA......... I want it!!!!', '2013-01-07 13:15:25');

-- --------------------------------------------------------

--
-- Table structure for table `entry`
--

CREATE TABLE IF NOT EXISTS `entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(75) NOT NULL DEFAULT 'blog',
  `image` varchar(150) NOT NULL DEFAULT '/simple_blog/img/no_img.jpg',
  `entry` text,
  `url` varchar(250) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `entry`
--

INSERT INTO `entry` (`id`, `title`, `image`, `entry`, `url`, `created`) VALUES
(52, 'Taxi -Thu Minh', '/simple_blog/img/1357295247_1901.jpg', 'Oh oh tik tak &#273;&#7891;ng h&#7891; quay vòng\r\nTik tak r&#7891;i quay vòng...\r\nT&#7915;ng ngày t&#7915;ng ngày bình th&#432;&#7901;ng\r\n\r\nÔi không gian quanh &#273;ây, bao ng&#432;&#7901;i r&#7897;n ràng là th&#7871; &#273;&#7845;y\r\nThôi cho tôi &#273;i ngay, r&#7901;i xa n&#417;i &#273;ây uh oh\r\nM&#7897;t ngày n&#7855;ng &#273;ã lên cao, &#273;ôi m&#7855;t hao g&#7847;y vì ph&#7889; xá thênh thang\r\nÁnh n&#7855;ng chói lóa th&#7871; mà bình th&#432;&#7901;ng\r\n&#272;&#7913;ng gi&#7919;a &#273;&#7913;ng gi&#7919;a lòng &#273;&#432;&#7901;ng...\r\n\r\nTaxi d&#7915;ng chân l&#7841;i chút &#273;i, &#273;&#7915;ng chen vào phía dòng ng&#432;&#7901;i bên kia\r\nUh oh uh oh...\r\nTaxi ch&#7901; thêm 1 phút &#273;i, ngày nay là th&#7871; lòng &#273;&#432;&#7901;ng &#273;ông ghê\r\nUh oh uh oh...\r\n\r\nThôi cho tôi vô &#273;ây, bên ngoài ch&#7881; là ngày n&#7855;ng cháy\r\nBên kia nh&#432; bên &#273;ây mà lao nh&#432; bay,uh oh\r\nNg&#432;&#7901;i ng&#432;&#7901;i c&#7913; th&#7871; tuôn ra, &#273;&#432;a m&#7855;t theo nhìn lòng chán ngán hoang mang\r\nT&#7855;t m&#7855;t, ch&#7871;t máy, th&#7871; mà bình th&#432;&#7901;ng\r\n&#272;&#7913;ng gi&#7919;a &#273;&#7913;ng gi&#7919;a lòng ng&#432;&#7901;i...													', 'taxi--thu-minh', '2013-01-04 10:27:27'),
(53, 'Samsung offers free flip covers and TecTiles for GS III and Note II device ', '/simple_blog/img/1357295647_7563.jpg', 'If you just received a Galaxy S III or a Note II this holiday season, you could do yourself a favor and register it on Samsung''s Facebook page to get even more goodies from Santa Sammy. What do you get in exchange for handing over some personal details and giving the Korean company access to your timeline? Why, a free flip cover and six TecTiles, which usually go for about $15 for a pack of five. We haven''t heard much about wide adoption of these programmable NFC tags, but maybe it''ll gain some traction after a recent 3.0 app update and this promotional giveaway. We''re not sure why the offer doesn''t extend to other Samsung phones, but maybe they just don''t have enough of those pastel covers to go around.					', 'samsung-offers-free-flip-covers-and-tectiles-for-gs-iii-and-note-ii-device-registrations-mobile-', '2013-01-04 10:34:07'),
(54, 'Samsung Galaxy Note 10.1 swoops by FCC with Verizon-friendly LTE', '/simple_blog/img/1357295970_5799.jpg', 'An LTE-equipped Galaxy Note 10.1 slipped through the FCC''s doors last month, but it was missing 4G bands that would allow it to work with American carriers. Now, however, the FCC has rubber-stamped a model with Verizon-friendly LTE, which includes support for the firm''s traditional Band 13, along with its fresh Band 4 (AWS) spectrum. In addition, the slate packs 3G connectivity and the expected support for Bluetooth and WiFi. Big Red and Samsung haven''t made a peep regarding a release, but with one of the final regulatory hurdles cleared for US availability, we imagine that an official announcement isn''t far off.\r\n					', 'samsung-galaxy-note-101-swoops-by-fcc-with-verizon-friendly-lte', '2013-01-04 10:39:30'),
(55, 'WiFi and WiGig Alliances become one, work to promote 60GHz wireless', '/simple_blog/img/1357296153_1749.jpg', 'The WiFi Alliance and Wireless Gigabit Alliance have a pretty long history of working together. The two are ringing in the new year by removing the last barrier to their cooperation and officially becoming one organization. By the end of the year the group hopes to have an interoperability program launched for 60GHz wireless under the banner of the new unified WiFi Alliance. The hope is that joining forces will lead to broader compatibility and quicker adoption of of the high speed wireless standard. For now there''s no new products to announce, but expect a year full exciting wireless developments. For a few more details and some salient quotes from the involved parties, hit up the PR after the break.							', 'wifi-and-wigig-alliances-become-onework-to-promote-60ghz-wireless', '2013-01-04 10:42:33'),
(56, 'Hot Chocolate Tastes Much Better In an Orange Cup', '/simple_blog/img/1357296319_5400.jpg', 'Scientists have discovered that an orange or creme-colored cup definitely makes chocolate taste better, while a white or red cup will not enhance the flavor. The discovery demonstrates once again that our taste buds are definitely influenced by the colors our eyes perceive.\r\n\r\nPublished in the Journal of Sensory Studies, the research by scientists at the Polytechnic University of Valencia and Oxford University involved 57 participants. They had to taste the same type of hot chocolate in cups of four external colors—white, creme, red and orange—and white interior. The results were clear: all of them thought the chocolate in the orange and creme cups was better than the others, even while it was the exact same type. Some even said that the chocolate in the creme cups tasted sweeter and was more aromatic.\r\n\r\nWe already knew that the color of food itself may affect our perception of taste. A spicy meal, for example, will be perceived as hotter than the same food if it''s more red. We also knew that containers themselves may affect the flavor but the relationship is still not well understood. There are no common rules, and changes depend on the food itself, says Betina Piqueras-Fiszman, one of the authors of the study:\r\n\r\nThe color of the container where you serve food and drinks can enhance some of its attributes, like flavor and aroma. There''s no fixed rule to tell which color enhances what food. This varies depending on the type of food but the truth is that the effect is there. Companies should pay more attention to the container because it has a lot more potential than what you imagine.\r\n\r\nThe same team has conducted other experiments that confirm all this. One showed that strawberry mousse tastes more intense and sweet in a white plate as opposed to a black one. Soda and lemon-based beverages are more refreshing and lemony in a blue can, while those in pink vessels are perceived as sweeter (which explains Tab). Coffee is affected too; a brown packaging makes its taste stronger and more aromatic, while red makes it less strong and yellow or blue make it smoother. [El Mundo—In Spanish]\r\n\r\nImage by Brandonht/Shutterstock\r\n\r\n																			', 'hot-chocolate-tastes-much-better-in-an-orange-cup', '2013-01-04 10:45:20'),
(57, 'Google bringing YouTube Android app pairing, updated UI to more TVs  HD ', '/simple_blog/img/1357345248_7621.png', 'By Donald Melanson\r\nGoogle updated its YouTube app for Android back in November to allow for pairing with TVs equipped with Google TV, and it looks we''ll soon be seeing quite a few more sets ready to work with your smartphone or tablet. The company confirmed today that new TVs from Bang & Olufsen, LG, Panasonic and Sony will be making their debut at CES, with additional sets and set-top boxes coming from Philips, Samsung, Sharp, Toshiba, Vizio, Western Digital and others over the course of 2013. In related news, Google''s announced that its new UI for YouTube on TV -- previously seen on the Wii U and PlayStation 3 -- will also be featured on those new devices, offering full 1080p videos and a fairly minimalist interface. You can check out a quick video of how the pairing works after the break.												', 'google-bringing-youtube-android-app-pairingupdated-ui-to-more-tvs-hd-', '2013-01-05 00:20:48'),
(58, 'Samsung rolling out Exynos security patch to UK Galaxy S III owners', '/simple_blog/img/1357362133_4259.jpg', 'A few weeks back a security exploit was discovered that left owners of select Exynos-powered Samsung devices feeling uneasy. While an independent developer quickly cooked up a fix, Samsung soon acknowledged the issue and pledged that an official patch was in the works. UK Galaxy S III owners can now breathe a sigh of relief, as Sammy has made good on its word and is now issuing an over-the-air update that addresses this potential security flaw. While we''re happy to see Samsung actively working on this issue, there''s still no word of when the company will release this fix to other devices and additional regions. Hopefully the software''s ongoing European tour is a sign of things to come globally.					', 'samsung-rolling-out-exynos-security-patch-to-uk-galaxy-s-iii-owners', '2013-01-05 05:02:14'),
(59, 'Epix heading to PlayStation 3 and PS Vita', '/simple_blog/img/1357362211_8907.jpg', 'iOS, Android, Google TV, XBox -- heck, Epix even has an app for the BlackBerry PlayPook. So, what''s surprising is not that the premium movie channel is coming to the PS3 and Vita, but that it took so long for it to happen. Soon Sony''s gaming faithful will be able to download the app from the PlayStation Store and start streaming the network''s sizable catalog of movies and original content. Of course, you''ll have to have actually subscribe to it through your cable provider first, but you knew that already, didn''t you. For more check out the PR after the break.\r\n\r\n						', 'epix-heading-to-playstation-3-and-ps-vita', '2013-01-05 05:03:31'),
(60, 'Cisco and NXP invest in Cohda, will work together to enable connected car', '/simple_blog/img/1357362506_1714.jpg', 'More than a year after NXP Semiconductors worked with Cohda Wireless to hook up cars via 802.11p, the chip maker has decided to invest in its partner with a little help from Uncle Cisco. While the PR is mum on the exact amount, the investment is apparently significant enough that all three companies are set to work together. Cohda''s wireless knowhow, NXP''s semiconductor chops and Cisco''s vast infrastructure would join forces -- á la Voltron -- to help usher in the era of the connected car. By enabling car-to-car (C2C) and car-to-infrastructure (C2I) communications, drivers could avoid hazards, evade bad traffic and even form "trains" of vehicles on the road like what Volvo''s demonstrated with its SARTRE project. No word on a timeline for when we''ll see this on public roads, but automotive-qualified IEEE 802.11p products are said to be one of the trio''s first goals, so hopefully it''ll be sooner rather than later.					', 'cisco-and-nxp-invest-in-cohdawill-work-together-to-enable-connected-car', '2013-01-05 05:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `about` text,
  `name` text,
  `address` text,
  `education` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `about`, `name`, `address`, `education`) VALUES
(1, 'Hi there, my name is Terry Duong and I am a programmer graduate at University of Sunshine Coast year 2011. My expertise is in java programming. However, I am self studying the art of web developing. Currently, I am working with html, css and php. Hopefully, I will find my way around in web development. My goal at the moment is mastering as much web language as I can. Thank you for visiting this blog and please follow/watch my work on <a href="https://github.com/tduong10101">github<a>.\r\n\r\nCheer!', 'Terry Duong', 'Hawthorn East VIC 3123', 'Bachelor of Software Engineering - University of the Sunshine Coast');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
