-- MySQL dump 10.13  Distrib 5.7.10, for Linux (x86_64)
--
-- Host: localhost    Database: xtreme_site
-- ------------------------------------------------------
-- Server version	5.7.10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categoriaproduto`
--

DROP TABLE IF EXISTS `categoriaproduto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoriaproduto` (
  `idcategoriaproduto` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`idcategoriaproduto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoriaproduto`
--

LOCK TABLES `categoriaproduto` WRITE;
/*!40000 ALTER TABLE `categoriaproduto` DISABLE KEYS */;
INSERT INTO `categoriaproduto` VALUES (1,'Suplementos');
/*!40000 ALTER TABLE `categoriaproduto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_cliente`
--

DROP TABLE IF EXISTS `db_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_cliente` (
  `id_cliente` int(40) NOT NULL AUTO_INCREMENT,
  `login_cliente` varchar(50) NOT NULL,
  `nome_cliente` varchar(70) NOT NULL,
  `sobrenome` varchar(70) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `sexo` varchar(50) NOT NULL,
  `cep` varchar(30) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `rua` varchar(40) NOT NULL,
  `numero` varchar(40) NOT NULL,
  `complemento` varchar(40) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `login_cliente` (`login_cliente`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_cliente`
--

LOCK TABLES `db_cliente` WRITE;
/*!40000 ALTER TABLE `db_cliente` DISABLE KEYS */;
INSERT INTO `db_cliente` VALUES (1,'','Nicolas','','nicolas17172010@hotmail.com','','Masculino','','','n','mn','ndiojm','','(12)98230-6500','verificado'),(2,'asd','dada','dadafgoeo','ofmwofmw','s','Feminino','12235620','omfwomfwndaii','Parque Industrial','Rua Palmares','nsei','fowmfwo','fo','inativo');
/*!40000 ALTER TABLE `db_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estoqueProduto`
--

DROP TABLE IF EXISTS `estoqueProduto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estoqueProduto` (
  `idEstoqueProduto` int(11) NOT NULL AUTO_INCREMENT,
  `idProduto` int(11) NOT NULL,
  `quantidade` decimal(5,2) NOT NULL DEFAULT '0.00',
  `valorUnitario` decimal(5,2) NOT NULL DEFAULT '0.00',
  `porcentagemDesconto` int(11) NOT NULL DEFAULT '0',
  `comprimento` decimal(5,2) DEFAULT NULL,
  `altura` decimal(5,2) DEFAULT NULL,
  `largura` decimal(5,2) DEFAULT NULL,
  `diametro` decimal(5,2) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`idEstoqueProduto`),
  KEY `idProduto` (`idProduto`),
  CONSTRAINT `estoqueProduto_ibfk_1` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`idproduto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estoqueProduto`
--

LOCK TABLES `estoqueProduto` WRITE;
/*!40000 ALTER TABLE `estoqueProduto` DISABLE KEYS */;
INSERT INTO `estoqueProduto` VALUES (1,1,1.00,189.90,10,26.00,26.00,14.00,48.00,0.91),(2,2,1.00,200.00,0,26.00,26.00,14.00,48.00,0.91),(3,3,1.00,150.00,0,26.00,26.00,14.00,48.00,0.91),(4,4,1.00,150.00,5,26.00,26.00,14.00,48.00,0.91);
/*!40000 ALTER TABLE `estoqueProduto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fabricante`
--

DROP TABLE IF EXISTS `fabricante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fabricante` (
  `idfabricante` int(11) NOT NULL AUTO_INCREMENT,
  `nomefabricante` varchar(255) NOT NULL,
  PRIMARY KEY (`idfabricante`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fabricante`
--

LOCK TABLES `fabricante` WRITE;
/*!40000 ALTER TABLE `fabricante` DISABLE KEYS */;
INSERT INTO `fabricante` VALUES (1,'Midway'),(2,'Max Titanium zzzzzzzzzz'),(3,'iron man'),(4,'Max Titanium'),(5,'Integralmedica');
/*!40000 ALTER TABLE `fabricante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `integradorlogistica`
--

DROP TABLE IF EXISTS `integradorlogistica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `integradorlogistica` (
  `idIntegradorLogistica` int(11) NOT NULL AUTO_INCREMENT,
  `nomeIntegrador` varchar(255) DEFAULT NULL,
  `urlServicoConsulta` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idIntegradorLogistica`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `integradorlogistica`
--

LOCK TABLES `integradorlogistica` WRITE;
/*!40000 ALTER TABLE `integradorlogistica` DISABLE KEYS */;
INSERT INTO `integradorlogistica` VALUES (1,'Correios','http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx');
/*!40000 ALTER TABLE `integradorlogistica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto` (
  `idproduto` int(11) NOT NULL AUTO_INCREMENT,
  `idfabricante` int(11) NOT NULL,
  `idtipoproduto` int(11) NOT NULL,
  `nomeProduto` varchar(255) DEFAULT NULL,
  `nomeArquivoFoto` varchar(255) DEFAULT NULL,
  `quantidadeVendidos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idproduto`),
  KEY `idfabricante` (`idfabricante`),
  KEY `idtipoproduto` (`idtipoproduto`),
  CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`idfabricante`) REFERENCES `fabricante` (`idfabricante`),
  CONSTRAINT `produto_ibfk_2` FOREIGN KEY (`idtipoproduto`) REFERENCES `tipoproduto` (`idtipoproduto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (1,1,2,NULL,'whey2.jpg',0),(2,2,1,NULL,'whey1.jpg',0),(3,3,1,NULL,'whey2.jpg',0),(4,4,1,NULL,'whey2.jpg',0);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicologistica`
--

DROP TABLE IF EXISTS `servicologistica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicologistica` (
  `idServicoLogistica` int(11) NOT NULL AUTO_INCREMENT,
  `descricaoservico` varchar(255) NOT NULL,
  `codigoservico` varchar(9) NOT NULL,
  `idIntegradorLogistica` int(11) DEFAULT NULL,
  PRIMARY KEY (`idServicoLogistica`),
  UNIQUE KEY `descricaoservico` (`descricaoservico`),
  KEY `idIntegradorLogistica` (`idIntegradorLogistica`),
  CONSTRAINT `servicologistica_ibfk_1` FOREIGN KEY (`idIntegradorLogistica`) REFERENCES `integradorlogistica` (`idIntegradorLogistica`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicologistica`
--

LOCK TABLES `servicologistica` WRITE;
/*!40000 ALTER TABLE `servicologistica` DISABLE KEYS */;
INSERT INTO `servicologistica` VALUES (1,'PAC','41106',1),(2,'SEDEX','40010',1),(3,'SEDEX a Cobrar','40045',1),(4,'SEDEX 10','40215',1);
/*!40000 ALTER TABLE `servicologistica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoproduto`
--

DROP TABLE IF EXISTS `tipoproduto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoproduto` (
  `idtipoproduto` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `idcategoriaproduto` int(11) NOT NULL,
  PRIMARY KEY (`idtipoproduto`),
  KEY `idcategoriaproduto` (`idcategoriaproduto`),
  CONSTRAINT `tipoproduto_ibfk_1` FOREIGN KEY (`idcategoriaproduto`) REFERENCES `categoriaproduto` (`idcategoriaproduto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoproduto`
--

LOCK TABLES `tipoproduto` WRITE;
/*!40000 ALTER TABLE `tipoproduto` DISABLE KEYS */;
INSERT INTO `tipoproduto` VALUES (1,'Whey',1),(2,'Dextrose',1);
/*!40000 ALTER TABLE `tipoproduto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-01 22:39:57
