/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100128
 Source Host           : localhost:3306
 Source Schema         : corridas_compartilhadas

 Target Server Type    : MySQL
 Target Server Version : 100128
 File Encoding         : 65001

 Date: 02/11/2017 23:37:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for corrida
-- ----------------------------
DROP TABLE IF EXISTS `corrida`;
CREATE TABLE `corrida`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `motorista_cpf` char(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `passageiro_cpf` char(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `valor` float(10, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `motorista_cpf`(`motorista_cpf`) USING BTREE,
  INDEX `passageiro_corrida_cpf`(`passageiro_cpf`) USING BTREE,
  CONSTRAINT `motorista_corrida_cpf` FOREIGN KEY (`motorista_cpf`) REFERENCES `motorista` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `passageiro_corrida_cpf` FOREIGN KEY (`passageiro_cpf`) REFERENCES `passageiro` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for motorista
-- ----------------------------
DROP TABLE IF EXISTS `motorista`;
CREATE TABLE `motorista`  (
  `cpf` char(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dt_nasc` date NOT NULL,
  `modelo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `estado` enum('1','0') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sexo` enum('F','M') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cpf`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for passageiro
-- ----------------------------
DROP TABLE IF EXISTS `passageiro`;
CREATE TABLE `passageiro`  (
  `cpf` char(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dt_nasc` date NOT NULL,
  `sexo` enum('F','M') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cpf`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
