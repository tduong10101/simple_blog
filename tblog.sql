-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2013 at 02:35 AM
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
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(75) NOT NULL,
  `password` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('tduong10101', 'a97af19464fce985216ffd4860feebb1035a0caf');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `blog_id`, `name`, `email`, `comment`, `date`) VALUES
(23, 81, 'Anonymous', 'Anonymous', 'Nice', '2013-01-07 13:40:00'),
(24, 100, 'Tam Duong', 'tduong10101@gmail.com', 'OMG OMG', '2013-01-09 04:29:11');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `entry`
--

INSERT INTO `entry` (`id`, `title`, `image`, `entry`, `url`, `created`) VALUES
(81, 'Greeting!!!', '/simple_blog/img/1357717981_6979.jpg', 'Hi there, my name is Terry Duong and I am a programmer graduate at University of Sunshine Coast year 2011. My expertise is in java programming. However, I am self-studying the art of web developing. Currently, I am working with html, css and php. Hopefully, I will find my way around in web development. My goal at the moment is mastering as much web language as I can. \r\n\r\nI started this blog mainly for studying web development purpose. However I would continue posting entry, blogging seems interesting!  This blog would mainly about my IT experience and coding tips (mostly for me). I’ll try to keep the posting coming, 1 or 2 posts per day may be. You can hit the rss button on left to book mark me. Thank you for visiting this blog and please watch my work on github. Also, you can find out more about me by visit the social links on the right panel.\r\n\r\nCheers!\r\n\r\nPs: This blog is my first ''completed'' web product. I will try to improve it as my skill and knowledge progress. Feel free to leave comments below about this page. Criticizes are appreciated ^^. \r\n																																									', 'greeting', '2013-01-07 13:39:35'),
(82, 'Cut the rope', '/simple_blog/img/1357567773_5225.jpg', 'This game is about cutting ropes to deliver the candy to the little frog. The creative of the game is amazing. In each level, the candy hangs by one or several of the titular ropes which the player must cut with a swipe of their finger (or mouse on the web-based version). Using various objects such as floating bubbles and bellows, the candy must also be manipulated around obstacles to get to Om Nom’s mouth.\r\n\r\nEach level pack introduces new challenges. Levels are scored with a zero to three star rating, according to how many stars the player picked up, and a point score depending on the number of stars collected and the amount of time taken to complete the level. An in-app purchase called "Superpowers" makes play easier.\r\n\r\nCut the rope is really a good game! I have great time playing it :D.  If you haven''t play it you can try it <a href="http://www.cuttherope.ie/">here.</a> \r\n\r\nI really like problem solving games, so if you have in mind any similar game to this, please leave a your suggestion on comment section below I''d definitely give it a try. Thank you ^^  																																																', 'cut-the-rope', '2013-01-07 14:09:33'),
(83, 'PHP - how to get start?', '/simple_blog/img/1357717908_8467.jpg', 'When studying a web development code the page to go for is <a href="http://www.w3schools.com/php/default.asp">w3schools<a/>. However, for beginner I found it hard to get start with the way <a href="http://www.w3schools.com/php/default.asp">w3schools<a/> introduce PHP. Especially the <a href="http://www.w3schools.com/php/php_install.asp">PHP Install</a> part, it''s only cover a little bit about PHP, Appache and MySQL installation. The way it has shown is hard to follow and full of technician jargon which do not make any sense till you spend hours dug through many pages of explanation. This could leave beginner developers with lost, doubting if they have correctly set up the required software.\r\n\r\nFortunately for us new beginner, there are all-in-one solutions that make the installation much much easier. So here we go! All you need is to download either <a href="http://www.apachefriends.org/en/xampp.html">xampp</a> or <a href="http://www.wampserver.com/en/">wamp</a>. Follow the prompt to install and then your all set for PHP. You can now start writing your code on notepad or IDE. I personally chose <a href="http://www.eclipse.org/downloads/">eclipse</a> for PHP because I learnt java using it. Hope this information is useful for you, please let me know if it is! :D\r\n																																																																							', 'php---how-to-get-start', '2013-01-08 00:58:00'),
(100, 'CES 2013: Kingston’s HyperX Predator Flash Drives Go to 1TB', '/simple_blog/img/1357717919_4912.jpg', 'WoW!!! I still remember the first usb i have, it is 128MB. Now they have 1TB, I can not believe how fast the technology grow!\r\n\r\nHere''s the article about the flash drive:\r\n\r\nby Rob Williams\r\nsource: <a href="http://techgage.com/news/ces-2013-kingstons-hyperx-predator-flash-drives-go-to-1tb-yes-1tb/"> http://techgage.com/news/ces-2013-kingstons-hyperx-predator-flash-drives-go-to-1tb-yes-1tb/</a>\r\n\r\nGiven the sheer number of products that get unveiled at each CES, it’s of no surprise that some will shine a bit brighter than others, causing people to do a double-take or drop their jaws. This year, the first product to manage both of those for me is Kingston’s DataTraveler HyperX Predator 3.0, a flash drive that boasts not only a seriously long name, but huge storage. How does 1TB sound? \r\n\r\nLet’s put this into perspective. About a year ago, I took a look at Kingston’s first-ever HyperX flash drive, weighing in at 64GB. At the time, that was in all regards impressive – though not quite as impressive as the 256GB offering the company also had. It’s not uncommon for technology to move at such a pace where densities can double each year, but I am not sure anyone expected Kingston to be announcing a drive today that quadruples last year’s top-end model.	\r\n\r\nDespite its massive storage, Kingston was able to retain a modest size with Predator. The 64GB DT HyperX I mentioned before came in at 2.95&#8243; x 0.92&#8243; x 0.63&#8243;. By comparison, the Predator is a tad shorter but also a tad beefier at the sides, at 2.83&#8243; x 1.06&#8243; x 0.83&#8243;.\r\n\r\nPerformance-wise, Predator boasts SSD-like throughput at 240MB/s read and 160MB/s write. These speeds make the Predator not only useful to store large files, but store large files fast.\r\n\r\nAt Predator’s retail launch, which should take place soon, only a 512GB model will become available. The 1TB model that I’ve been raving over will see its launch later in Q1. Unfortunately, the vital piece of information we’d all like to know isn’t yet available: pricing. Given the fact that Kingston’s smallest Predator offering is 512GB, we have to assume that these will not be consumer-focused, but are instead targeted at the business or workstation user. Either way, for what it offers, I think Predator is aptly-named.													', 'ces-2013kingstons-hyperx-predator-flash-drives-go-to-1tb', '2013-01-08 04:19:42'),
(101, 'Adding Stroke to Web Text ', '/simple_blog/img/1357717879_6861.png', 'Trick that add outline to a text or title:\r\n\r\nUse webkit\r\nh1 {\r\n   -webkit-text-stroke: 1px black;\r\n}\r\nUse text shadow:\r\nh1 {\r\n	color: white;\r\n   	text-shadow:\r\n       0px 0px 0 #000,\r\n     -1px -1px 0 #000,  \r\n      1px -1px 0 #000,\r\n      -1px 1px 0 #000,\r\n       1px 1px 0 #000;\r\n}\r\n\r\nFound this trick while modify h1 for this blog.\r\nSource: <a href="http://css-tricks.com/adding-stroke-to-web-text/">http://css-tricks.com/adding-stroke-to-web-text/</a>																						', 'adding-stroke-to-web-text-', '2013-01-09 07:35:13');

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
