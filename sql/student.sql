-- Database: `school` and php web application user
CREATE DATABASE school;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON school.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE school;
--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `country` varchar(255) NOT NULL,
  `studentNumber` int(10) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `firstName`, `lastName`, `country`, `studentNumber`, `pic`, `date`) VALUES
(1, 'John', 'Doe', 'United States', 20230001, '1.jpeg', curdate()),
(2, 'Jane', 'Smith', 'Canada', 20230002, '1.jpeg', curdate()),
(3, 'Michael', 'Johnson', 'Australia', 20230003, '1.jpeg', curdate()),
(4, 'Emily', 'Lee', 'United Kingdom', 20230004, '1.jpeg', curdate()),
(5, 'David', 'Kim', 'South Korea', 20230005, '1.jpeg', curdate());


--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `email` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


