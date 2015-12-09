-- --------------------------------------------------------
-- Сервер:                       127.0.0.1
-- Версія сервера:               5.1.73-community - MySQL Community Server (GPL)
-- ОС сервера:                   Win32
-- HeidiSQL Версія:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for таблиця todolist.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_description` varchar(100) NOT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table todolist.tasks: ~7 rows (приблизно)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`task_id`, `task_description`, `due_date`) VALUES
	(1, 'Проснуться', '2015-12-09 12:29:56'),
	(2, 'Принять душ', NULL),
	(3, 'Выпить чашечку кофе', NULL),
	(4, 'Пойти на работу', NULL),
	(5, 'Пообедать', NULL);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
