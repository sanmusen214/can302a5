-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2023-04-23 09:02:18
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
  `Admin_ID` int(16) NOT NULL AUTO_INCREMENT,
  `Admin_Password` varchar(32) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Permission` varchar(16) NOT NULL,
  `deleted` boolean DEFAULT FALSE NOT NULL,
  PRIMARY KEY (`Admin_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `Category_ID` int(16) NOT NULL AUTO_INCREMENT,
  `Category_Name` varchar(32) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `deleted` boolean DEFAULT FALSE NOT NULL,
  PRIMARY KEY (`Category_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `coupon`
--

CREATE TABLE `coupon` (
  `Coupon_ID` int(16) NOT NULL AUTO_INCREMENT,
  `Coupon_Name` varchar(32) NOT NULL,
  `Discount_Amount` double(6,2) NOT NULL,
  `Create_Time` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Expire_Time` timestamp NULL DEFAULT current_timestamp(),
  `Coupon_Status` int(1) NOT NULL,
  `deleted` boolean DEFAULT FALSE NOT NULL,
  PRIMARY KEY (`Coupon_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `Order_ID` int(16) NOT NULL AUTO_INCREMENT,
  `Order_Product_ID` int(16) NOT NULL,
  `Order_Customer_ID` int(16) NOT NULL,
  `Order_Coupon_ID` int(16) NOT NULL,
  `Order_Status` int(1) NOT NULL,
  `Order_Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Order_Details` varchar(200) NOT NULL,
  `deleted` boolean DEFAULT FALSE NOT NULL,
  PRIMARY KEY (`Order_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `Product_ID` int(16) NOT NULL AUTO_INCREMENT,
  `Product_Name` varchar(32) NOT NULL,
  `Product_Category_ID` int(16) NOT NULL,
  `Product_In_stock` int(6) NOT NULL,
  `Product_Price` double(6,2) NOT NULL,
  `Product_Description` varchar(200) NOT NULL,
  `Product_Image_link` varchar(100) NOT NULL,
  `deleted` boolean DEFAULT FALSE NOT NULL,
  PRIMARY KEY (`Product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `User_ID` int(16) NOT NULL AUTO_INCREMENT,
  `User_Name` varchar(32) NOT NULL,
  `Telephone` varchar(16) NOT NULL,
  `Payment_Method` varchar(16) NOT NULL,
  `Shipping_Address` varchar(100) NOT NULL,
  `deleted` boolean DEFAULT FALSE NOT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转储表的索引
--

--
-- 表的索引 `admin`
--
-- ALTER TABLE `admin`
  -- ADD PRIMARY KEY (`Admin_ID`);

--
-- 表的索引 `category`
--
-- ALTER TABLE `category`
  -- ADD PRIMARY KEY (`Category_ID`);

--
-- 表的索引 `coupon`
--
-- ALTER TABLE `coupon`
  -- ADD PRIMARY KEY (`Coupon_ID`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  -- ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Order_Product_ID` (`Order_Product_ID`),
  ADD KEY `Order_Coupon_ID` (`Order_Coupon_ID`),
  ADD KEY `Order_Customer_ID` (`Order_Customer_ID`);

--
-- 表的索引 `product`
--
ALTER TABLE `product`
  -- ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Product_Category_ID` (`Product_Category_ID`);

--
-- 表的索引 `user`
--
-- ALTER TABLE `user`
  -- ADD PRIMARY KEY (`User_ID`);

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
