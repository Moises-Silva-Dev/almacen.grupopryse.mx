-- MySQL Host: localhost
-- MySQL User: grupova9_TecPryse
-- MySQL Password: M0ch1t*_619
-- Database Name: grupova9_Pryse

-- Table structure for table `Regiones`
CREATE TABLE `Regiones` (
  `ID_Region` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Region` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Fch_Registro` datetime NOT NULL,
  PRIMARY KEY (`ID_Region`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Regiones`
INSERT INTO Regiones VALUES ("1","Centro Sur","2024-07-04 14:15:00");

-- Table structure for table `Cuenta`
CREATE TABLE `Cuenta` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCuenta` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `NroElemetos` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Cuenta`
INSERT INTO Cuenta VALUES ("1","CFE","357");

-- Table structure for table `Centro_Trabajo`
CREATE TABLE `Centro_Trabajo` (
  `ID_Centro` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Centro` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Num_Empleados` int(11) NOT NULL,
  `Servicios_Ofrecidos` text COLLATE utf8_unicode_ci NOT NULL,
  `Turnos_Trabajo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Fecha_Creacion` datetime NOT NULL,
  `IDRegion` int(11) DEFAULT NULL,
  `IDEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Centro`),
  KEY `IDRegion` (`IDRegion`),
  KEY `IDEstado` (`IDEstado`),
  CONSTRAINT `Centro_Trabajo_ibfk_1` FOREIGN KEY (`IDRegion`) REFERENCES `Regiones` (`ID_Region`),
  CONSTRAINT `Centro_Trabajo_ibfk_2` FOREIGN KEY (`IDEstado`) REFERENCES `Estados` (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Centro_Trabajo`
INSERT INTO Centro_Trabajo VALUES ("1","Sistemas PRYSE","10","Servicio Tecnico","24 horas","2024-05-06 15:40:46","1","1");

-- Table structure for table `Tipo_Usuarios`
CREATE TABLE `Tipo_Usuarios` (
  `ID` int(11) NOT NULL,
  `Tipo_Usuario` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Tipo_Usuarios`
INSERT INTO Tipo_Usuarios VALUES ("1","Programador");
INSERT INTO Tipo_Usuarios VALUES ("2","ADMIN");
INSERT INTO Tipo_Usuarios VALUES ("3","USER");
INSERT INTO Tipo_Usuarios VALUES ("4","Almacenista");
INSERT INTO Tipo_Usuarios VALUES ("5","SUPERADMIN");

-- Table structure for table `Tipo_Colaboradores`
CREATE TABLE `Tipo_Colaboradores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Colaborador` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Tipo_Colaboradores`
INSERT INTO Tipo_Colaboradores VALUES ("1","Supervisor");
INSERT INTO Tipo_Colaboradores VALUES ("2","Coordinador");
INSERT INTO Tipo_Colaboradores VALUES ("3","Ejecutivo");
INSERT INTO Tipo_Colaboradores VALUES ("4","Colaborador");

-- Table structure for table `Usuario`
CREATE TABLE `Usuario` (
  `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Apellido_Paterno` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Apellido_Materno` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `NumTel` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Correo_Electronico` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `Constrasena` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `NumContactoSOS` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ID_Tipo_Usuario` int(11) DEFAULT NULL,
  `ID_Cuenta` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Usuario`),
  KEY `ID_Tipo_Usuario` (`ID_Tipo_Usuario`),
  KEY `ID_Cuenta` (`ID_Cuenta`),
  CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`ID_Tipo_Usuario`) REFERENCES `Tipo_Usuarios` (`ID`),
  CONSTRAINT `Usuario_ibfk_2` FOREIGN KEY (`ID_Cuenta`) REFERENCES `Cuenta` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Usuario`
INSERT INTO Usuario VALUES ("1","Moises","Silva","Gonzalez","7774449107","mochito619@gmail.com","12345","7771234567","1","1");
INSERT INTO Usuario VALUES ("2","Cibeles","Torres","T","7774449107","mochito61@gmail.com","12345","7771234567","2","1");
INSERT INTO Usuario VALUES ("3","Monse","Hernandez","Perez","7774449107","mochito6@gmail.com","12345","7771234567","3","1");
INSERT INTO Usuario VALUES ("4","Ricardo","Constatino","Perez","7774449107","mochito@gmail.com","12345","7771234567","4","1");
INSERT INTO Usuario VALUES ("5","Karen","Sampayo","Diaz","7774449107","moi619@gmail.com","12345","7771234567","5","1");

-- Table structure for table `Colaborador`
CREATE TABLE `Colaborador` (
  `ID_Colaborador` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Apellido_Paterno` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Apellido_Materno` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CURP` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Correo_Electronico` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Fecha_Alta` datetime NOT NULL,
  `ID_Tipo_Colaborador` int(11) DEFAULT NULL,
  `ID_CentroT` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Colaborador`),
  KEY `ID_Tipo_Colaborador` (`ID_Tipo_Colaborador`),
  KEY `ID_CentroT` (`ID_CentroT`),
  CONSTRAINT `Colaborador_ibfk_1` FOREIGN KEY (`ID_Tipo_Colaborador`) REFERENCES `Tipo_Colaboradores` (`ID`),
  CONSTRAINT `Colaborador_ibfk_2` FOREIGN KEY (`ID_CentroT`) REFERENCES `Centro_Trabajo` (`ID_Centro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Colaborador`

-- Table structure for table `Respaldo_Equipo`
CREATE TABLE `Respaldo_Equipo` (
  `ID_Equipo` int(11) NOT NULL AUTO_INCREMENT,
  `Marca` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Modelo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Tipo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Procesador` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `GbRAM` int(11) DEFAULT NULL,
  `Almacenamiento` int(11) NOT NULL,
  `Tipo_Almacenamiento` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ID_Colaboradores` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Equipo`),
  KEY `ID_Colaboradores` (`ID_Colaboradores`),
  CONSTRAINT `Respaldo_Equipo_ibfk_1` FOREIGN KEY (`ID_Colaboradores`) REFERENCES `Colaborador` (`ID_Colaborador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Respaldo_Equipo`

-- Table structure for table `CEmpresas`
CREATE TABLE `CEmpresas` (
  `IdCEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Empresa` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `RazonSocial` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `RFC` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `RegistroPatronal` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Especif` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IdCEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `CEmpresas`
INSERT INTO CEmpresas VALUES ("1","PRYSE","Prueba 1","Prueba 1","M0987654321","Prueba 1");
INSERT INTO CEmpresas VALUES ("2","PRYSE/LIMP","Prueba 2","Prueba 2","C0908070605","Prueba 2");
INSERT INTO CEmpresas VALUES ("3","PROTE","Prueba 3","Prueba 3","Y6968676665","Prueba 3");
INSERT INTO CEmpresas VALUES ("4","VALBON","Prueba 4","Prueba 4","D0000012345","Prueba 4");
INSERT INTO CEmpresas VALUES ("5","PRYSE/AICM","Prueba 5","Prueba 5","E0192837465","Prueba 5");
INSERT INTO CEmpresas VALUES ("6","PRYSE/PROTE","Prueba 6","Prueba 6","E0192837466","Prueba 6");
INSERT INTO CEmpresas VALUES ("7","VALVON","Prueba 7","Prueba 7","E0192837467","Prueba 7");

-- Table structure for table `CCategorias`
CREATE TABLE `CCategorias` (
  `IdCCate` int(11) NOT NULL AUTO_INCREMENT,
  `Descrp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IdCCate`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `CCategorias`
INSERT INTO CCategorias VALUES ("1","Uniformes");
INSERT INTO CCategorias VALUES ("2","Equipamiento");
INSERT INTO CCategorias VALUES ("3","Accesorios");

-- Table structure for table `CTipoTallas`
CREATE TABLE `CTipoTallas` (
  `IdCTipTall` int(11) NOT NULL AUTO_INCREMENT,
  `Descrip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IdCTipTall`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `CTipoTallas`
INSERT INTO CTipoTallas VALUES ("1","Numerica");
INSERT INTO CTipoTallas VALUES ("2","Alfabetica");
INSERT INTO CTipoTallas VALUES ("3","Unitalla");

-- Table structure for table `CTallas`
CREATE TABLE `CTallas` (
  `IdCTallas` int(11) NOT NULL AUTO_INCREMENT,
  `IdCTipTal` int(11) NOT NULL,
  `Talla` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IdCTallas`),
  KEY `IdCTipTal` (`IdCTipTal`),
  CONSTRAINT `CTallas_ibfk_1` FOREIGN KEY (`IdCTipTal`) REFERENCES `CTipoTallas` (`IdCTipTall`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `CTallas`
INSERT INTO CTallas VALUES ("1","1","22");
INSERT INTO CTallas VALUES ("2","1","23");
INSERT INTO CTallas VALUES ("3","1","24");
INSERT INTO CTallas VALUES ("4","1","25");
INSERT INTO CTallas VALUES ("5","1","26");
INSERT INTO CTallas VALUES ("6","1","27");
INSERT INTO CTallas VALUES ("7","1","28");
INSERT INTO CTallas VALUES ("8","1","29");
INSERT INTO CTallas VALUES ("9","1","30");
INSERT INTO CTallas VALUES ("10","1","31");
INSERT INTO CTallas VALUES ("11","1","32");
INSERT INTO CTallas VALUES ("12","1","33");
INSERT INTO CTallas VALUES ("13","1","34");
INSERT INTO CTallas VALUES ("14","1","36");
INSERT INTO CTallas VALUES ("15","1","38");
INSERT INTO CTallas VALUES ("16","1","40");
INSERT INTO CTallas VALUES ("17","1","42");
INSERT INTO CTallas VALUES ("18","1","44");
INSERT INTO CTallas VALUES ("19","1","46");
INSERT INTO CTallas VALUES ("20","1","48");
INSERT INTO CTallas VALUES ("21","1","50");
INSERT INTO CTallas VALUES ("22","1","52");
INSERT INTO CTallas VALUES ("23","1","54");
INSERT INTO CTallas VALUES ("24","1","56");
INSERT INTO CTallas VALUES ("25","2","XCH");
INSERT INTO CTallas VALUES ("26","2","CH");
INSERT INTO CTallas VALUES ("27","2","M");
INSERT INTO CTallas VALUES ("28","2","GDE");
INSERT INTO CTallas VALUES ("29","2","XG");
INSERT INTO CTallas VALUES ("30","2","XXG");
INSERT INTO CTallas VALUES ("31","2","XXXG");
INSERT INTO CTallas VALUES ("32","3","UNITALLA");

-- Table structure for table `Producto`
CREATE TABLE `Producto` (
  `IdCProducto` int(11) NOT NULL AUTO_INCREMENT,
  `IdCEmp` int(11) DEFAULT NULL,
  `IdCCat` int(11) DEFAULT NULL,
  `IdCTipTal` int(11) DEFAULT NULL,
  `Descripcion` text COLLATE utf8_unicode_ci NOT NULL,
  `Especificacion` text COLLATE utf8_unicode_ci NOT NULL,
  `IMG` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Fecha_Registro` datetime NOT NULL,
  PRIMARY KEY (`IdCProducto`),
  KEY `IdCEmp` (`IdCEmp`),
  KEY `IdCCat` (`IdCCat`),
  KEY `IdCTipTal` (`IdCTipTal`),
  CONSTRAINT `Producto_ibfk_1` FOREIGN KEY (`IdCEmp`) REFERENCES `CEmpresas` (`IdCEmpresa`),
  CONSTRAINT `Producto_ibfk_2` FOREIGN KEY (`IdCCat`) REFERENCES `CCategorias` (`IdCCate`),
  CONSTRAINT `Producto_ibfk_3` FOREIGN KEY (`IdCTipTal`) REFERENCES `CTipoTallas` (`IdCTipTall`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Producto`
INSERT INTO Producto VALUES ("1","1","1","1","Camisa","Azul, manga corta, PRYSE","../../../img/Productos/product_6661ff4cc36d3.png","2024-06-06 12:26:20");
INSERT INTO Producto VALUES ("2","1","1","1","Camisa","Blanca, manga larga, bolsas, PRYSE","../../../img/Productos/product_666200e314683.png","2024-06-06 12:33:07");
INSERT INTO Producto VALUES ("3","1","1","1","Camisa","Blanca, manga corta, PRYSE","../../../img/Productos/product_666201c5f1991.png","2024-06-06 12:36:53");
INSERT INTO Producto VALUES ("4","1","1","1","Pantalón","Azul marino, comando","../../../img/Productos/product_66620216223f3.png","2024-06-06 12:38:14");
INSERT INTO Producto VALUES ("5","2","1","1","Pantalón","Azul marino","../../../img/Productos/product_6662025622949.png","2024-06-06 12:39:18");
INSERT INTO Producto VALUES ("6","1","1","2","Bata","Azul marino, PRYSE","../../../img/Productos/product_666202f922f6c.png","2024-06-06 12:42:01");
INSERT INTO Producto VALUES ("7","6","1","2","Bata","Azul marino, PROTE","../../../img/Productos/product_666203ffbbc84.png","2024-06-06 12:46:23");
INSERT INTO Producto VALUES ("8","1","1","2","Chamarra","Azul Marino","../../../img/Productos/product_666204a901995.png","2024-06-06 12:49:13");
INSERT INTO Producto VALUES ("9","1","1","2","Chamarra","Azul Marino, Cazadora","../../../img/Productos/product_6662055753ba7.png","2024-06-06 12:52:07");
INSERT INTO Producto VALUES ("10","1","1","1","Botas","Tacticas","../../../img/Productos/product_66620845cd799.png","2024-06-06 13:04:37");
INSERT INTO Producto VALUES ("11","1","1","1","Botas","Hule","../../../img/Productos/product_6662089919114.png","2024-06-06 13:06:01");
INSERT INTO Producto VALUES ("12","1","1","1","Botas","Poli Amida","../../../img/Productos/product_666208eadab06.png","2024-06-06 13:07:22");
INSERT INTO Producto VALUES ("13","1","1","2","Playera","Blanca, Polo","../../../img/Productos/product_6662099306bb1.png","2024-06-06 13:10:11");
INSERT INTO Producto VALUES ("14","1","1","2","Chaleco","Táctico","../../../img/Productos/product_66620a03b982e.png","2024-06-06 14:17:23");
INSERT INTO Producto VALUES ("15","1","1","3","Chaleco","Táctico, unitalla","../../../img/Productos/product_666219bdacb43.png","2024-06-06 14:19:09");
INSERT INTO Producto VALUES ("16","1","1","3","Chaleco","Verde, reflejante","../../../img/Productos/product_66621a0c24dcc.png","2024-06-06 14:20:28");
INSERT INTO Producto VALUES ("17","1","1","3","Chaleco","Rojo, reflejante","../../../img/Productos/product_66621a5c222e4.png","2024-06-06 14:21:48");
INSERT INTO Producto VALUES ("18","1","1","3","Chaleco","Naranja, reflejante","../../../img/Productos/product_66621abe6d904.png","2024-06-06 14:23:26");
INSERT INTO Producto VALUES ("19","1","1","2","Chaleco","Azul marino, PRYSE","../../../img/Productos/product_66621b440fedb.png","2024-06-06 14:25:40");
INSERT INTO Producto VALUES ("20","1","1","3","Gorra","PRYSE","../../../img/Productos/product_66621b83c9e6e.png","2024-06-06 14:26:43");
INSERT INTO Producto VALUES ("21","1","2","3","Gas Pimienta","Ninguna.","../../../img/Productos/product_66621bc981126.png","2024-06-06 14:27:53");
INSERT INTO Producto VALUES ("22","1","2","3","Fornitura","Unitalla","../../../img/Productos/product_66621c37ea1cd.png","2024-06-06 14:29:43");
INSERT INTO Producto VALUES ("23","1","2","2","Fornitura","Alfabética","../../../img/Productos/product_66621c69e99ba.png","2024-06-06 14:30:33");
INSERT INTO Producto VALUES ("24","1","2","3","TOLETE","Ninguna.","../../../img/Productos/product_66621cd072d0b.png","2024-06-06 14:32:16");
INSERT INTO Producto VALUES ("25","1","3","3","Liston","Azulmarino","../../../img/Productos/product_66621d09c459a.png","2024-06-06 14:33:13");
INSERT INTO Producto VALUES ("26","1","3","3","Liston","Rojo","../../../img/Productos/product_66621d46e629b.png","2024-06-06 14:34:14");
INSERT INTO Producto VALUES ("27","1","3","3","Silbato","Ninguna.","../../../img/Productos/product_66621d92923cf.png","2024-06-06 14:35:30");
INSERT INTO Producto VALUES ("28","1","1","3","Corbata","Azul marino","../../../img/Productos/product_66621dc9e9a42.png","2024-06-06 14:36:25");
INSERT INTO Producto VALUES ("29","1","1","3","Impermeable","Azul marino, PRYSE","../../../img/Productos/product_66621e05038df.png","2024-06-06 14:37:25");
INSERT INTO Producto VALUES ("30","1","3","3","Broche Fornitura","Ninguna.","../../../img/Productos/product_66621e486c1d2.png","2024-06-06 14:38:32");
INSERT INTO Producto VALUES ("31","1","2","3","Lampara","Chica","../../../img/Productos/product_66621e9cad865.png","2024-06-06 14:39:56");
INSERT INTO Producto VALUES ("32","1","2","3","Lampara","Grande","../../../img/Productos/product_66621edbee15f.png","2024-06-06 14:40:59");
INSERT INTO Producto VALUES ("33","1","3","3","Libro Florete","Ninguna.","../../../img/Productos/product_6662215bbde4d.png","2024-06-06 14:51:39");
INSERT INTO Producto VALUES ("34","1","3","3","Cubreboca","Azul marino","../../../img/Productos/product_666221a745b36.png","2024-06-06 14:52:55");
INSERT INTO Producto VALUES ("35","1","3","3","Careta de Mica","Ninguna.","../../../img/Productos/product_666221fea16f8.png","2024-06-06 14:54:22");
INSERT INTO Producto VALUES ("36","1","2","3","Radio","Steren RAD 510","../../../img/Productos/product_6662226e8b0ef.png","2024-06-06 14:56:58");
INSERT INTO Producto VALUES ("37","1","2","3","Radio","Steren RAD 010","../../../img/Productos/product_666222fd43f86.png","2024-06-06 14:58:37");
INSERT INTO Producto VALUES ("38","1","1","3","Overol COVID","Ninguna.","../../../img/Productos/product_6662234547194.png","2024-06-06 14:59:49");
INSERT INTO Producto VALUES ("39","1","2","3","Garret","Ninguna.","../../../img/Productos/product_666223ae6aa4a.png","2024-06-06 15:01:34");
INSERT INTO Producto VALUES ("40","1","3","3","BLOCK","Novedades, PROTE & PRYSE","../../../img/Productos/product_666223f96c022.png","2024-06-06 15:02:49");
INSERT INTO Producto VALUES ("41","1","3","3","BLOCK","Asistencia Diaria, PROTE & PRYSE","../../../img/Productos/product_66622448b85c4.png","2024-06-06 15:04:08");
INSERT INTO Producto VALUES ("42","1","3","3","BLOCK","Cuadricula, PROTE & PRYSE","../../../img/Productos/product_666224ad17471.png","2024-06-06 15:05:49");
INSERT INTO Producto VALUES ("43","7","1","1","Overol","Negro, VALVON","../../../img/Productos/product_666224fdc8cf9.png","2024-06-06 15:07:09");
INSERT INTO Producto VALUES ("44","7","1","1","Pantalón","Negro","../../../img/Productos/product_6662268b9fca3.png","2024-06-06 15:13:47");
INSERT INTO Producto VALUES ("45","7","1","2","Playera","Negro, polo, VALBON","../../../img/Productos/product_666226ca59198.png","2024-06-06 15:14:50");
INSERT INTO Producto VALUES ("46","7","1","1","Chamarra","Negro, Talla numérica, VALBON","../../../img/Productos/product_6662274c32e70.png","2024-06-06 15:17:00");
INSERT INTO Producto VALUES ("47","7","1","2","Chamarra","Negro, Talla alfabética, VALBON","../../../img/Productos/product_66622783c6a06.png","2024-06-06 15:17:55");
INSERT INTO Producto VALUES ("48","7","1","3","Gorra","Negro, VALVON","../../../img/Productos/product_666227decc2e6.png","2024-06-06 15:19:26");
INSERT INTO Producto VALUES ("49","7","1","3","Cubreboca","Negro","../../../img/Productos/product_666228599024c.png","2024-06-06 15:21:29");
INSERT INTO Producto VALUES ("50","7","3","3","BLOCK","Novedades, VALVON","../../../img/Productos/product_6662289fbfc2b.png","2024-06-06 15:22:39");
INSERT INTO Producto VALUES ("51","7","3","3","BLOCK","Asistencia Diaria, VALVON","../../../img/Productos/product_66622907f2f3a.png","2024-06-06 15:24:23");
INSERT INTO Producto VALUES ("52","7","3","3","BLOCK","Cuadricula, VALVON","../../../img/Productos/product_666229b00af4d.png","2024-06-06 15:27:12");
INSERT INTO Producto VALUES ("53","1","3","3","Hoja","Membretada, PRYSE","../../../img/Productos/product_666229f167dbf.png","2024-06-06 15:28:17");
INSERT INTO Producto VALUES ("54","5","1","1","Pantalón","Azul marino, vestir","../../../img/Productos/product_66622a45adafa.png","2024-06-06 15:29:41");
INSERT INTO Producto VALUES ("55","5","1","2","Chaleco","Verde, reflejante, PRYSE","../../../img/Productos/product_66622ad2c583e.png","2024-06-06 15:32:02");
INSERT INTO Producto VALUES ("56","1","3","3","Fajilla","Negro","../../../img/Productos/product_66622b0117349.png","2024-06-06 15:32:49");
INSERT INTO Producto VALUES ("57","5","1","1","Camisa","Blanca, manga larga, PRYSE","../../../img/Productos/product_66622b2ef2e7f.png","2024-06-06 15:33:34");
INSERT INTO Producto VALUES ("58","5","1","2","Chaleco","Verde, reflejante, AICM T2, PRYSE","../../../img/Productos/product_66622b4eccf59.png","2024-06-06 15:34:06");
INSERT INTO Producto VALUES ("59","5","1","2","Sueter","Azul marino, PRYSE","../../../img/Productos/product_66622b732e936.png","2024-06-06 15:34:43");
INSERT INTO Producto VALUES ("60","1","2","3","Porta Radio","Negro, fornitura","../../../img/Productos/product_66622ba4ce29b.png","2024-06-06 15:35:32");

-- Table structure for table `Inventario`
CREATE TABLE `Inventario` (
  `IdInv` int(11) NOT NULL AUTO_INCREMENT,
  `IdCPro` int(11) DEFAULT NULL,
  `IdCTal` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT '0',
  PRIMARY KEY (`IdInv`),
  KEY `IdCPro` (`IdCPro`),
  KEY `IdCTal` (`IdCTal`),
  CONSTRAINT `Inventario_ibfk_1` FOREIGN KEY (`IdCPro`) REFERENCES `Producto` (`IdCProducto`),
  CONSTRAINT `Inventario_ibfk_2` FOREIGN KEY (`IdCTal`) REFERENCES `CTallas` (`IdCTallas`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Inventario`
INSERT INTO Inventario VALUES ("1","1","1","0");
INSERT INTO Inventario VALUES ("2","15","32","0");
INSERT INTO Inventario VALUES ("3","30","32","0");
INSERT INTO Inventario VALUES ("4","45","28","0");
INSERT INTO Inventario VALUES ("5","60","32","0");
INSERT INTO Inventario VALUES ("6","16","32","0");
INSERT INTO Inventario VALUES ("7","2","6","117");

-- Table structure for table `EntradaE`
CREATE TABLE `EntradaE` (
  `IdEntE` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha_Creacion` datetime NOT NULL,
  `Fecha_Modificacion` datetime DEFAULT NULL,
  `Nro_Modif` int(11) DEFAULT NULL,
  `Usuario_Creacion` int(11) NOT NULL,
  `Proveedor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Receptor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Comentarios` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Estatus` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IdEntE`),
  KEY `Usuario_Creacion` (`Usuario_Creacion`),
  CONSTRAINT `EntradaE_ibfk_1` FOREIGN KEY (`Usuario_Creacion`) REFERENCES `Usuario` (`ID_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `EntradaE`
INSERT INTO EntradaE VALUES ("1","2024-07-30 16:15:18","2024-07-30 16:25:47","2","4","Moises Silva Gonzalez","Mario Octavia","tjhkgfhjkvgbnhjdkfsbvgjsnbvijkdrfv","Eliminado");

-- Table structure for table `EntradaD`
CREATE TABLE `EntradaD` (
  `IdEntD` int(11) NOT NULL AUTO_INCREMENT,
  `IdEntradaE` int(11) DEFAULT NULL,
  `IdProd` int(11) DEFAULT NULL,
  `IdTalla` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`IdEntD`),
  KEY `IdEntradaE` (`IdEntradaE`),
  KEY `IdProd` (`IdProd`),
  KEY `IdTalla` (`IdTalla`),
  CONSTRAINT `EntradaD_ibfk_1` FOREIGN KEY (`IdEntradaE`) REFERENCES `EntradaE` (`IdEntE`),
  CONSTRAINT `EntradaD_ibfk_2` FOREIGN KEY (`IdProd`) REFERENCES `Producto` (`IdCProducto`),
  CONSTRAINT `EntradaD_ibfk_3` FOREIGN KEY (`IdTalla`) REFERENCES `CTallas` (`IdCTallas`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `EntradaD`
INSERT INTO EntradaD VALUES ("12","1","2","6","117");

-- Table structure for table `RequisicionE`
CREATE TABLE `RequisicionE` (
  `IDRequisicionE` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) DEFAULT NULL,
  `FchCreacion` datetime NOT NULL,
  `FchAutoriza` datetime DEFAULT NULL,
  `Estatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Supervisor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `IdRegion` int(11) DEFAULT NULL,
  `CentroTrabajo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Receptor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `TelReceptor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `RfcReceptor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Justificacion` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IdEstado` int(11) DEFAULT NULL,
  `Mpio` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Colonia` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Calle` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Nro` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CP` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IDRequisicionE`),
  KEY `IdUsuario` (`IdUsuario`),
  KEY `IdRegion` (`IdRegion`),
  KEY `IdEstado` (`IdEstado`),
  CONSTRAINT `RequisicionE_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`ID_Usuario`),
  CONSTRAINT `RequisicionE_ibfk_2` FOREIGN KEY (`IdRegion`) REFERENCES `Regiones` (`ID_Region`),
  CONSTRAINT `RequisicionE_ibfk_3` FOREIGN KEY (`IdEstado`) REFERENCES `Estados` (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `RequisicionE`
INSERT INTO RequisicionE VALUES ("1","2","2024-07-30 16:51:55","2024-07-30 16:54:19","Autorizado","alma luisa ","1","Ultrimatrix","Mario Octavia","7651234587","SIGM071001MS","esto es una prueba final ","1","Jiutepec","Progreso","Alvaro Obregón","7","62574");

-- Table structure for table `RequisicionD`
CREATE TABLE `RequisicionD` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdReqE` int(11) DEFAULT NULL,
  `IdCProd` int(11) DEFAULT NULL,
  `IdTalla` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `IdReqE` (`IdReqE`),
  KEY `IdCProd` (`IdCProd`),
  KEY `IdTalla` (`IdTalla`),
  CONSTRAINT `RequisicionD_ibfk_1` FOREIGN KEY (`IdReqE`) REFERENCES `RequisicionE` (`IDRequisicionE`),
  CONSTRAINT `RequisicionD_ibfk_2` FOREIGN KEY (`IdCProd`) REFERENCES `Producto` (`IdCProducto`),
  CONSTRAINT `RequisicionD_ibfk_3` FOREIGN KEY (`IdTalla`) REFERENCES `CTallas` (`IdCTallas`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `RequisicionD`
INSERT INTO RequisicionD VALUES ("1","1","3","13","10");
INSERT INTO RequisicionD VALUES ("2","1","10","11","10");
INSERT INTO RequisicionD VALUES ("3","1","7","28","12");
INSERT INTO RequisicionD VALUES ("4","1","17","32","12");
INSERT INTO RequisicionD VALUES ("5","1","60","32","11");

-- Table structure for table `Salida_E`
CREATE TABLE `Salida_E` (
  `Id_SalE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ReqE` int(11) DEFAULT NULL,
  `FchSalidad` datetime NOT NULL,
  PRIMARY KEY (`Id_SalE`),
  KEY `ID_ReqE` (`ID_ReqE`),
  CONSTRAINT `Salida_E_ibfk_1` FOREIGN KEY (`ID_ReqE`) REFERENCES `RequisicionE` (`IDRequisicionE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Salida_E`

-- Table structure for table `Salida_D`
CREATE TABLE `Salida_D` (
  `Id_SalD` int(11) NOT NULL AUTO_INCREMENT,
  `Id` int(11) DEFAULT NULL,
  `IdCProd` int(11) DEFAULT NULL,
  `IdTallas` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`Id_SalD`),
  KEY `IdCProd` (`IdCProd`),
  KEY `IdTallas` (`IdTallas`),
  KEY `Id` (`Id`),
  CONSTRAINT `Salida_D_ibfk_1` FOREIGN KEY (`IdCProd`) REFERENCES `Producto` (`IdCProducto`),
  CONSTRAINT `Salida_D_ibfk_2` FOREIGN KEY (`IdTallas`) REFERENCES `CTallas` (`IdCTallas`),
  CONSTRAINT `Salida_D_ibfk_3` FOREIGN KEY (`Id`) REFERENCES `Salida_E` (`Id_SalE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Salida_D`

-- Trigger structure for trigger `actualizar_inventario_despues_borrar_entrada`
CREATE DEFINER=`grupova9`@`localhost` TRIGGER actualizar_inventario_despues_borrar_entrada
AFTER DELETE ON EntradaD FOR EACH ROW
BEGIN
    DECLARE Cant_Entrada INT;
    DECLARE Id_Prod INT;
    DECLARE Id_Tall INT;

    -- Obtener los valores de los registros elimanos en EntradaD
    SELECT OLD.Cantidad, OLD.IdProd, OLD.IdTalla INTO Cant_Entrada, Id_Prod, Id_Tall;

    -- Actualizar los valores en la tabla inventarios
    UPDATE Inventario I SET I.Cantidad = I.Cantidad - Cant_Entrada WHERE I.IdCPro = Id_Prod AND I.IdCTal = Id_Tall;
END;

-- Trigger structure for trigger `actualizar_inventario_despues_borrar_salida`
CREATE DEFINER=`grupova9`@`localhost` TRIGGER actualizar_inventario_despues_borrar_salida
AFTER DELETE ON Salida_D FOR EACH ROW
BEGIN
    DECLARE cantidad_salida INT;
    DECLARE id_producto INT;
    DECLARE id_talla INT;

    -- Obtener los valores de los registros elimanos en SalidaD
    SELECT OLD.Cantidad, OLD.IdCProd, OLD.IdTallas INTO cantidad_salida, id_producto, id_talla;

    -- Actualizar los valores en la tabla inventarios
    UPDATE Inventario I SET I.Cantidad = I.Cantidad + cantidad_salida WHERE I.IdCPro = id_producto AND I.IdCTal = id_talla;
END;

