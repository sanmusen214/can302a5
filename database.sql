-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2023-04-24 13:06:52
-- 服务器版本： 10.4.22-MariaDB
-- PHP 版本： 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `a5asm2`
--

CREATE DATABASE a5asm2 DEFAULT CHARSET=utf8mb4;

USE a5asm2;
-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(16) NOT NULL,
  `Admin_Account` varchar(16) NOT NULL,
  `Admin_Password` varchar(32) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Permission` varchar(16) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `admin`
--
INSERT INTO `admin` (`Admin_ID`, `Admin_Account`, `Admin_Password`, `Status`, `Permission`, `deleted`) VALUES (1, 'admin', 'admin', 1, 'admin', 0);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `Category_ID` int(16) NOT NULL,
  `Category_Name` varchar(32) NOT NULL,
  `Category_Status` varchar(16) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`Category_ID`, `Category_Name`, `Category_Status`, `Description`, `deleted`) VALUES
(1, 'Fruit', 'Available', 'Keep Healthy', 0),
(2, 'Food', 'Available', 'Eat Something', 0),
(3, 'Technical Items', 'Available', 'Amazing Technology
', 0);

-- --------------------------------------------------------

--
-- 表的结构 `coupon`
--

CREATE TABLE `coupon` (
  `Coupon_ID` int(16) NOT NULL,
  `Coupon_Name` varchar(32) NOT NULL,
  `Discount_Amount` double(6,2) NOT NULL,
  `Create_Time` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Expire_Time` timestamp NULL DEFAULT current_timestamp(),
  `Coupon_Status` int(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `Order_ID` int(16) NOT NULL,
  `Order_Product_ID` int(16) NOT NULL,
  `Order_Customer_ID` int(16) NOT NULL,
  `Order_Coupon_ID` int(16) NOT NULL,
  `Order_Status` int(1) NOT NULL,
  `Order_Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Order_Details` varchar(200) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `Product_ID` int(16) NOT NULL,
  `Product_Name` varchar(32) NOT NULL,
  `Product_Category_ID` int(16) NOT NULL,
  `Product_In_stock` int(6) NOT NULL,
  `Product_Price` double(6,2) NOT NULL,
  `Product_Description` varchar(200) NOT NULL,
  `Product_Image_link` varchar(100) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`Product_ID`, `Product_Name`, `Product_Category_ID`, `Product_In_stock`, `Product_Price`, `Product_Description`, `Product_Image_link`, `deleted`) VALUES (1, 'Apple IPhone 14', '3', '200', '100', 'Smartphone created by Apple', 'https://img0.baidu.com/it/u=4218582401,428653023&fm=253&fmt=auto&app=138&f=JPEG?w=1026&h=500', '0');;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `User_ID` int(16) NOT NULL,
  `User_Name` varchar(32) NOT NULL,
  `Telephone` varchar(16) NOT NULL,
  `Payment_Method` varchar(16) NOT NULL,
  `Shipping_Address` varchar(100) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`User_ID`, `User_Name`, `Telephone`, `Payment_Method`, `Shipping_Address`, `deleted`) VALUES
(1, 'Zhang', '12345678910', 'MASTERCARD', 'China', 0),
(2, 'Maven', '11111111111', 'MASTERCARD', 'Canada', 1);

--
-- 转储表的索引
--

--
-- 表的索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- 表的索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- 表的索引 `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`Coupon_ID`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Order_Product_ID` (`Order_Product_ID`),
  ADD KEY `Order_Coupon_ID` (`Order_Coupon_ID`),
  ADD KEY `Order_Customer_ID` (`Order_Customer_ID`);

--
-- 表的索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Product_Category_ID` (`Product_Category_ID`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_ID` int(16) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `coupon`
--
ALTER TABLE `coupon`
  MODIFY `Coupon_ID` int(16) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_ID` int(16) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(16) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 限制导出的表
--

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`Order_Product_ID`) REFERENCES `product` (`Product_ID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`Order_Coupon_ID`) REFERENCES `coupon` (`Coupon_ID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`Order_Customer_ID`) REFERENCES `user` (`User_ID`);

--
-- 限制表 `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Product_Category_ID`) REFERENCES `category` (`Category_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
