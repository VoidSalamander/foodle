-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 
-- 伺服器版本： 8.0.17
-- PHP 版本： 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `foodle_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `restaurant`
--

CREATE TABLE `restaurant` (
  `rest_name` varchar(255) NOT NULL,
  `ID` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `rest_info` text,
  `is_chain_store` tinyint(1) DEFAULT NULL,
  `is_official` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `restaurant`
--

INSERT INTO `restaurant` (`rest_name`, `ID`, `address`, `district`, `city`, `rest_info`, `is_chain_store`, `is_official`) VALUES
('阿里媽媽', 10, '羅斯福路四段', '中正區', '台北市', '兩層樓學生料理餐廳，食物份量大實惠，每週一免費奶茶，推薦烤雞腿麻婆豆腐飯和咖哩蔬菜。', 0, 1),
('義樂麵屋', 12, '羅斯福路', '中正區', '台北市', '適合學生的平價義大利麵，口味多且餐餐附優惠券。', 0, 1),
('稻咖哩', 13, '溫州街', '大安區', '台北市', '氣氛悠閒的餐廳，供應經典日式咖哩和肉類料理，並設有簡樸的用餐區。', 0, 1),
('韓天閣', 14, '羅斯福路四段', '中正區', '台北市', '氣氛悠閒的現代風韓式餐廳，供應套餐、熱炒與烤肉料理。', 0, 1),
('好吃好吃', 15, '羅斯福路三段', '中正區', '台北市', '這家牛排店以威靈頓牛排和經典牛排聞名，價格實惠，環境昏暗但適合大口吃肉，學生價更優惠。', 0, 1),
('塊雞師食務所', 16, '羅斯福路四段', '中正區', '台北市', '這家炸雞店的酥脆炸雞和南洋咖哩醬非常美味，自助吧提供多樣醬料和小菜，空間大，學生價友善，CP值高。炸雞現炸需等，二樓座位略擁擠。', 0, 1),
('Mr. 雪腐', 17, '羅斯福路三段', '中正區', '台北市', '雪花冰店用料實在，濃郁而不過甜，非常喜歡！', 0, 1),
('墨洋', 18, '羅斯福路四段', '中正區', '台北市', '氛圍溫馨的拉麵店，供應湯品、麵食和海鮮料理等療癒美食。', 0, 1),
('金鋒魯肉飯', 20, '羅斯福路一段', '中正區', '台北市', '被各家媒體評選為外國觀光客必吃的知名魯肉飯，以實惠的價格提供穩定的好滋味，用餐時間必定排隊', 0, 1),
('甩泰', 21, '羅斯福路五段', '文山區', '台北市', '中午提供咖哩飯，晚上則是餐酒館。日式咖哩牛十分好吃，味道濃郁且可搭配起司增添風味，但現在都只提供泰式咖哩飯。', 0, 1),
('師大分部臭豆腐', 22, '溫州街', '文山區', '台北市', '讓人一吃上癮，臭豆腐控絕對要吃，每人限購3份', 0, 1),
('紅蕃茄自助餐', 23, '汀州路四段', '文山區', '台北市', '師大分部的平價美食。因為好吃所以人多？需要排隊，可以免費盛湯', 0, 1),
('京都日式料理', 24, '基隆路四段', '大安區', '台北市', '乾淨整潔衛生，服務態度親切，食材相較於其他店家少油少鹽。', 0, 1),
('帝一味自助餐', 25, '基隆路四段', '大安區', '台北市', '在台科大裡面的學餐，台北生活的省錢救星，住附近可以來，真的很便宜', 0, 1),
('神秘花園', 26, 'x', 'x', 'x', '好吃', 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `rest_tag`
--

CREATE TABLE `rest_tag` (
  `rest_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `rest_tag`
--

INSERT INTO `rest_tag` (`rest_id`, `tag_id`) VALUES
(10, 17),
(21, 17),
(15, 18),
(13, 19),
(18, 19),
(14, 20),
(20, 21),
(24, 21),
(25, 21),
(26, 21),
(12, 24),
(10, 26),
(13, 26),
(15, 26),
(16, 26),
(21, 26),
(16, 28),
(24, 28),
(23, 30),
(24, 30),
(25, 30),
(26, 30),
(18, 31),
(14, 33),
(24, 33),
(26, 33),
(24, 34),
(17, 35),
(16, 36),
(12, 37),
(14, 39),
(17, 39),
(13, 40),
(10, 48),
(13, 48),
(16, 48),
(17, 48),
(20, 48),
(22, 48),
(23, 48),
(24, 48),
(25, 48),
(26, 48),
(12, 49),
(14, 49),
(15, 49),
(18, 49),
(21, 49),
(10, 54),
(23, 54),
(26, 54),
(10, 55),
(23, 55),
(26, 55),
(17, 56),
(22, 57),
(22, 58),
(10, 60),
(13, 60),
(15, 60),
(16, 60),
(18, 60),
(12, 62),
(17, 62),
(12, 69),
(26, 69),
(12, 70),
(15, 70),
(16, 70),
(24, 70),
(25, 70),
(26, 70),
(13, 71),
(15, 71),
(17, 71),
(18, 71),
(22, 71),
(12, 72),
(20, 72),
(23, 73),
(24, 73),
(25, 73),
(10, 74),
(14, 74),
(15, 74),
(16, 74),
(18, 74),
(14, 75),
(15, 75),
(16, 75),
(10, 76),
(13, 76),
(21, 76),
(23, 76),
(10, 77),
(10, 78),
(10, 79),
(16, 79),
(20, 79),
(23, 79),
(10, 80),
(12, 81),
(15, 82),
(16, 83),
(17, 84),
(18, 85),
(20, 88),
(20, 89),
(20, 90),
(21, 91),
(22, 92),
(22, 93),
(22, 94),
(23, 95),
(25, 95),
(24, 96),
(26, 97);

-- --------------------------------------------------------

--
-- 資料表結構 `tag`
--

CREATE TABLE `tag` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `tag_info` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `tag`
--

INSERT INTO `tag` (`ID`, `name`, `type`, `tag_info`) VALUES
(17, '泰式', 'style', '飲食風格為泰式'),
(18, '美式', 'style', '飲食風格為美式'),
(19, '日式', 'style', '飲食風格為日式'),
(20, '韓式', 'style', '飲食風格為韓式'),
(21, '台式', 'style', '飲食風格為台式'),
(22, '港式', 'style', '飲食風格為港式'),
(23, '中式', 'style', '飲食風格為中式'),
(24, '義式', 'style', '飲食風格為義式'),
(25, '西式', 'style', '飲食風格為西式'),
(26, '咖哩', 'food', '餐廳提供咖哩'),
(27, '漢堡', 'food', '餐廳提供漢堡'),
(28, '炸雞', 'food', '餐廳提供炸雞'),
(29, '牛肉麵', 'food', '餐廳提供牛肉麵'),
(30, '便當', 'food', '餐廳提供便當'),
(31, '拉麵', 'food', '餐廳提供拉麵'),
(32, '烏龍麵', 'food', '餐廳提供烏龍麵'),
(33, '定食', 'food', '餐廳提供定食'),
(34, '丼飯', 'food', '餐廳提供丼飯'),
(35, '甜點', 'food', '餐廳提供甜點'),
(36, '粥', 'food', '餐廳提供粥'),
(37, '義大利麵', 'food', '餐廳提供義大利麵'),
(38, '烤肉', 'food', '烤肉為該店特色餐點'),
(39, '火鍋', 'food', '火鍋為該店特色餐點'),
(40, '墨魚', 'food', '墨魚為該店特色餐點'),
(41, '干貝', 'food', '干貝為該店特色餐點'),
(42, '酸菜魚', 'food', '酸菜魚為該店特色餐點'),
(43, '鹹水雞', 'food', '鹹水雞為該店特色餐點'),
(44, '愛玉', 'food', '愛玉為該店特色餐點'),
(45, '生魚飯', 'food', '生魚飯為該店特色餐點'),
(46, '健康餐', 'food', '健康餐為該店特色餐點'),
(47, '螺獅粉', 'food', '螺獅粉為該店特色餐點'),
(48, '$', 'price', '最低消費價格位於 1-200'),
(49, '$$', 'price', '最低消費價格位於 200-500'),
(50, '$$$', 'price', '最低消費價格位於 500-1000'),
(51, '$$$$', 'price', '最低消費價格位大於 1000'),
(52, '燒臘', 'food', '燒臘為該店特色餐點'),
(53, '早餐', 'time', '早餐時段供餐'),
(54, '午餐', 'time', '午餐時段供餐'),
(55, '晚餐', 'time', '晚餐時段供餐'),
(56, '點心', 'time', '餐點提供小點心'),
(57, '宵夜', 'time', '宵夜時段供餐'),
(58, '不固定打烊', 'time', '供餐時段不定'),
(59, '不打烊', 'time', '24小時供餐'),
(60, '公館', 'location', '鄰近公館地區'),
(61, '古亭', 'location', '鄰近古亭地區'),
(62, '台電大樓', 'location', '鄰近台電大樓地區'),
(63, '萬隆', 'location', '鄰近萬隆地區'),
(64, '景美', 'location', '鄰近景美地區'),
(65, '師大夜市', 'location', '鄰近師大夜市地區'),
(66, '中和', 'location', '鄰近中和地區'),
(67, '永和', 'location', '鄰近永和地區'),
(68, '可集點', 'other', '餐廳有集點優惠'),
(69, '優惠券', 'other', '持優惠券可享折扣'),
(70, '學生折扣', 'other', '憑學生證可享折扣'),
(71, '品項簡單', 'other', '餐點選擇簡單'),
(72, '品項複雜', 'other', '餐點樣式繁多'),
(73, '學餐', 'other', '在學生餐廳內'),
(74, '自助吧', 'other', '餐廳內有自助吧'),
(75, '飲料吧', 'other', '餐廳內有飲料吧'),
(76, '飯', 'other', '提供飯為主食'),
(77, '麵', 'other', '提供麵為主食'),
(78, '飲料', 'other', '餐點有附飲料'),
(79, '湯', 'other', '餐點有附湯品'),
(80, '南洋', 'customTags', ''),
(81, '燉飯', 'customTags', ''),
(82, '牛排', 'customTags', ''),
(83, '麻辣鴨血', 'customTags', ''),
(84, '冰', 'customTags', ''),
(85, '干貝', 'customTags', ''),
(86, '火烤兩吃', 'customTags', ''),
(87, '便宜', 'customTags', ''),
(88, '滷肉飯', 'customTags', ''),
(89, '小菜', 'customTags', ''),
(90, '中正紀念堂', 'customTags', ''),
(91, '餐酒館', 'customTags', ''),
(92, '限購', 'customTags', ''),
(93, '攤販', 'customTags', ''),
(94, '臭豆腐', 'customTags', ''),
(95, '自助餐', 'customTags', ''),
(96, '台科', 'customTags', ''),
(97, '好吃', 'customTags', '');

-- --------------------------------------------------------

--
-- 資料表結構 `userdata`
--

CREATE TABLE `userdata` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `play_count` int(11) DEFAULT NULL,
  `win_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `userdata`
--

INSERT INTO `userdata` (`ID`, `username`, `password`, `email`, `play_count`, `win_count`) VALUES
(1, 'voidsalamander', '$2y$10$hQ5uX323iPkM9NwhNY5yEezT.qLIdv227rW1ty99cGwUGITpAAEn.', 'eric05020502@gmail.com', 102, 102),
(2, 'zoe', '$2y$10$wwEgyElNQVt6574mFSX4pOeJJWglpLjG1T9hRy6FN3QIqNu0kDVOO', 'zoe2746@gmail.com', 1, 1),
(9, 'MELO', '$2y$10$scPmuYOErVE1OqZyDf8rKu0mhMFDJtRkVFOJzKV8bXNWraIODezFi', 'thomas20030413@gmail.com', 0, 0),
(10, 'test', '$2y$10$eBJ3WvkhTiOEch7vfe1u0OJ2HP4ezyAtX.EtajrlUILMN.RJouarS', 'test@gmail.com', 8, 8),
(12, 'z', '$2y$10$8dodbxNshFoUvz9n9FO2ouyK6uUqzV6KE8sxkdXrVCSyLWgHu1TPG', 'a@10344', 0, 0),
(13, 'gordon', '$2y$10$Fz5FWO/HZ5ZWUKUmTc0xrOUX5cEVc6IX/TC32bFkD5KFulLL.UBpq', 'aasaa', 0, 0),
(3, 'root', '$2y$10$av2ayESD0yoyHRo1JXutR.kIciozFQu8IzvNZzgyDxoomshnLIoJe', 'r@e.w', 0, 0),
(15, '呂冠磊', '$2y$10$cHE1JSFjydFyY.i8TUsjQOWmt5MCTEb/Dn70LEmo2HMK2gwryduXy', 'nice7415296@gmail.com', 0, 0),
(16, 'nice', '$2y$10$XQdNWqi18YoF7E70GZPG6uGTiLNaasy1n.u.0Ct2uitcNuOYaQnVq', 'kol7415296@gmail.com', 0, 0);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `rest_tag`
--
ALTER TABLE `rest_tag`
  ADD PRIMARY KEY (`rest_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- 資料表索引 `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`ID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tag`
--
ALTER TABLE `tag`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `userdata`
--
ALTER TABLE `userdata`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `rest_tag`
--
ALTER TABLE `rest_tag`
  ADD CONSTRAINT `rest_tag_ibfk_1` FOREIGN KEY (`rest_id`) REFERENCES `restaurant` (`ID`),
  ADD CONSTRAINT `rest_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
