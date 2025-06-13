
--
-- Database: `gcuems_db`
--

-- --------------------------------------------------------

-- Drop tables if they exist
DROP TABLE IF EXISTS `club`;
DROP TABLE IF EXISTS `participant`;
DROP TABLE IF EXISTS `program`;
DROP TABLE IF EXISTS `user`;

--
-- Table structure for table `club`
--

CREATE TABLE `club` (
  `club_id` bigint(20) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` bigint(20) NOT NULL
);

--
-- Dumping data for table `club`
--

INSERT INTO `club` (`club_id`, `user_name`, `name`, `email`, `phone`) VALUES
(1, 'sportsclub', 'Sports Club', 'sportsclub@gmail.com', 1234567890),
(2, 'danceclub', 'Dance club', 'danceclub@gmail.com', 1234567890),
(3, 'singingclub', 'Singing Club', 'singingclub@gmail.com', 1234567890),
(4, 'photographyclub', 'Photography Club', 'photographyclub@gmail.com', 1234567890),
(5, 'artclub', 'Art & Craft Club', 'artclub@gmail.com', 1234567890),
(6, 'bikeclub', 'Bike Club', 'bikeclub@gmail.com', 1234123412);

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `participant_id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `sem` varchar(50) NOT NULL,
  `college` varchar(50) NOT NULL,
  `program_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
);

--
-- Dumping data for table `participant`
--

INSERT INTO `participant` (`participant_id`, `name`, `email`, `phone`, `branch`, `sem`, `college`, `program_id`, `user_id`) VALUES
(1, 'dishanta adhikari', 'dishantaadhikari35614@gmail.com', 1234567890, 'BCA', '5th', 'Girijananda Chowdhury University', 1, 2),
(2, 'shujan Kr Ray', 'shujan@gmail.com', 1234567891, 'BCA', '5th', 'Girijananda Chowdhury University', 1, 2),
(3, 'dishanta adhikari', 'dishantaadhikari35614@gmail.com', 1234567890, 'BCA', '5th', 'Girijananda Chowdhury University', 2, 4),
(4, 'shujan Kr Ray', 'shujan@gmail.com', 1234567891, 'BCA', '5th', 'Girijananda Chowdhury University', 2, 4),
(5, 'dishanta adhikari', 'dishantaadhikari35614@gmail.com', 1234567890, 'BCA', '5th', 'Girijananda Chowdhury University', 3, 4),
(6, 'shujan Kr Ray', 'shujan@gmail.com', 1234567891, 'BCA', '5th', 'Girijananda Chowdhury University', 3, 4),
(7, 'dishanta adhikari', 'dishantaadhikari35614@gmail.com', 1234567890, 'BCA', '5th', 'Girijananda Chowdhury University', 4, 3),
(8, 'shujan Kr Ray', 'shujan@gmail.com', 1234567891, 'BCA', '5th', 'Girijananda Chowdhury University', 4, 3),
(9, 'dishanta adhikari', 'dishantaadhikari35614@gmail.com', 1234567890, 'BCA', '5th', 'Girijananda Chowdhury University', 5, 3),
(10, 'shujan Kr Ray', 'shujan@gmail.com', 1234567891, 'BCA', '5th', 'Girijananda Chowdhury University', 5, 3),
(11, 'dishanta adhikari', 'dishantaadhikari35614@gmail.com', 1234567890, 'BCA', '5th', 'Girijananda Chowdhury University', 6, 5),
(12, 'shujan Kr Ray', 'shujan@gmail.com', 1234567891, 'BCA', '5th', 'Girijananda Chowdhury University', 6, 5),
(13, 'dishanta adhikari', 'dishantaadhikari35614@gmail.com', 1234567890, 'BCA', '5th', 'Girijananda Chowdhury University', 7, 6),
(14, 'shujan Kr Ray', 'dishantaadhikari35614@gmail.com', 1234567891, 'BCA', '5th', 'Girijananda Chowdhury University', 7, 6),
(15, 'dishanta adhikari', 'dishantaadhikari35614@gmail.com', 1234567890, 'BCA', '5th', 'Girijananda Chowdhury University', 8, 1),
(16, 'shujan Kr Ray', 'shujan@gmail.com', 1234567891, 'BCA', '5th', 'Girijananda Chowdhury University', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `program_id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(20) NOT NULL,
  `venue` varchar(50) NOT NULL,
  `image` longblob NOT NULL,
  `staff_coordinator` varchar(50) NOT NULL,
  `phone1` bigint(20) NOT NULL,
  `student_coordinator` varchar(50) NOT NULL,
  `phone2` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
);

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`program_id`, `name`, `date`, `time`, `venue`, `image`, `staff_coordinator`, `phone1`, `student_coordinator`, `phone2`, `user_id`) VALUES
(1, 'Marathon', '2024-01-01', '04:00 AM', 'Girijananda Chowdhury University , Guwahati.', 0x2e2f6173736574732f696d616765732f4576656e74496d616765732f4d61726174686f6e2d576562736974652d436172642d373638783736382e706e67, 'GCU stuff', 1234567890, 'GCU student', 1234567890, 2),
(2, 'Master the Mic', '2024-01-02', '09:00 AM', 'Girijananda Chowdhury University , Guwahati.', 0x2e2f6173736574732f696d616765732f4576656e74496d616765732f4d61737465722d7468652d4d69632d373638783736382e706e67, 'GCU stuff', 1234567890, 'GCU student', 1234567890, 4),
(3, 'Rap Battle', '2024-01-02', '07:00 PM', 'Girijananda Chowdhury University , Guwahati.', 0x2e2f6173736574732f696d616765732f4576656e74496d616765732f5261702d426174746c652d373638783736382e706e67, 'GCU stuff', 1234567890, 'GCU student', 1234567890, 4),
(4, 'Beat Fanatsy', '2024-01-03', '05:00 PM', 'Girijananda Chowdhury University , Guwahati.', 0x2e2f6173736574732f696d616765732f4576656e74496d616765732f426561742d46616e746173792d373638783736382e706e67, 'GCU stuff', 1234567890, 'GCU student', 1234567890, 3),
(5, 'Street Battle', '2024-01-04', '09:00 AM', 'Girijananda Chowdhury University , Guwahati.', 0x2e2f6173736574732f696d616765732f4576656e74496d616765732f5374726565742d426174746c652d373638783736382e706e67, 'GCU stuff', 1234567890, 'GCU student', 1234567890, 3),
(6, 'Photography', '2024-01-05', '09:00 AM', 'Girijananda Chowdhury University , Guwahati.', 0x2e2f6173736574732f696d616765732f4576656e74496d616765732f50686f746f6772617068792d373638783736382e6a706567, 'GCU stuff', 1234567890, 'GCU student', 1234567890, 5),
(7, 'Cartoon Art', '2024-01-06', '09:00 AM', 'Girijananda Chowdhury University , Guwahati.', 0x2e2f6173736574732f696d616765732f4576656e74496d616765732f5374726f6b652d312d373638783736382e706e67, 'GCU stuff', 1234567890, 'GCU student', 1234567890, 6),
(8, 'Faculty Program', '2024-01-06', '05:00 PM', 'Girijananda Chowdhury University , Guwahati.', 0x2e2f6173736574732f696d616765732f4576656e74496d616765732f466163756c74792d373638783736382e706e67, 'GCU stuff', 1234567890, 'GCU student', 1234567890, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL
);

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `name`, `email`, `phone`, `pass`, `user_type`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 1234567890, '81dc9bdb52d04dc20036dbd8313ed055', 'admin'),
(2, 'sportsclub', 'Sports Club', 'sportsclub@gmail.com', 1234567890, '81dc9bdb52d04dc20036dbd8313ed055', 'club'),
(3, 'danceclub', 'Dance club', 'danceclub@gmail.com', 1234567890, '81dc9bdb52d04dc20036dbd8313ed055', 'club'),
(4, 'singingclub', 'Singing Club', 'singingclub@gmail.com', 1234567890, '81dc9bdb52d04dc20036dbd8313ed055', 'club'),
(5, 'photographyclub', 'Photography Club', 'photographyclub@gmail.com', 1234567890, '81dc9bdb52d04dc20036dbd8313ed055', 'club'),
(6, 'artclub', 'Art & Craft Club', 'artclub@gmail.com', 1234567890, '81dc9bdb52d04dc20036dbd8313ed055', 'club'),
(7, 'bikeclub', 'Bike Club', 'bikeclub@gmail.com', 1234123412, '81dc9bdb52d04dc20036dbd8313ed055', 'club');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`club_id`),
  ADD UNIQUE KEY `UNIQUE` (`user_name`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`participant_id`),
  ADD KEY `FKEY` (`program_id`),
  ADD KEY `FKEY2` (`user_id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`program_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `club`
--
ALTER TABLE `club`
  MODIFY `club_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `participant`
--
ALTER TABLE `participant`
  MODIFY `participant_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `program_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `FKEY` FOREIGN KEY (`program_id`) REFERENCES `program` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKEY2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `program`
--
ALTER TABLE `program`
  ADD CONSTRAINT `FKEY1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
