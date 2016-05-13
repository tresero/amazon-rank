# amazon-rank
All this little program does is run through a database to pull out your ASIN numbers and looks up the Amazon rank on whatever store(s) you wish.

Database structure:
~~~~
--
-- Table structure for table `book_rank`
--

CREATE TABLE IF NOT EXISTS `book_rank` (
`id` int(11) NOT NULL,
  `asin` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `rank` int(11) NOT NULL,
  `region` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=881 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for table `book_rank`
--
ALTER TABLE `book_rank`
 ADD PRIMARY KEY (`id`), ADD KEY `date_ix` (`date`) COMMENT 'Date index', ADD KEY `asin_ix` (`asin`), ADD KEY `rank_ix` (`rank`), ADD KEY `region_ix` (`region`);
~~~~

This is part of my personal publishing system and I have a table for products that includes the ASIN (called ISBN, for historical reasons) of the book and a flag for tracking. You will need to either make
a table called product with those fields, or modify the query.


