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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Regiones`
INSERT INTO Regiones VALUES ("1","Centro Sur","2024-07-04 14:15:00");
INSERT INTO Regiones VALUES ("2","Oficinas Divisionales","2024-08-06 13:40:48");
INSERT INTO Regiones VALUES ("4","Zona Acapulco","2024-08-06 16:13:32");
INSERT INTO Regiones VALUES ("5","Zona Altamirano","2024-08-06 16:14:12");
INSERT INTO Regiones VALUES ("6","Zona Atlacomulco","2024-08-06 16:14:44");
INSERT INTO Regiones VALUES ("7","Zona Campeche","2024-08-06 16:15:08");
INSERT INTO Regiones VALUES ("8","Zona Carmen","2024-08-06 16:15:25");
INSERT INTO Regiones VALUES ("9","Zona Chilpancingo","2024-08-06 16:15:45");
INSERT INTO Regiones VALUES ("10","Zona Chontalpa","2024-08-06 16:16:01");
INSERT INTO Regiones VALUES ("11","Zona Coatzacoalcos","2024-08-06 16:16:27");
INSERT INTO Regiones VALUES ("12","Zona Colima","2024-08-06 16:16:42");
INSERT INTO Regiones VALUES ("13","Zona Constitución","2024-08-06 16:16:56");
INSERT INTO Regiones VALUES ("14","Zona Córdoba","2024-08-06 16:17:18");
INSERT INTO Regiones VALUES ("15","Zona Cuautla","2024-08-06 16:17:36");
INSERT INTO Regiones VALUES ("16","Zona Cuernavaca","2024-08-06 16:17:55");
INSERT INTO Regiones VALUES ("17","Zona Ensenada","2024-08-06 16:18:12");
INSERT INTO Regiones VALUES ("18","Zona Iguala","2024-08-06 16:18:24");
INSERT INTO Regiones VALUES ("19","Zona Jiquilpan","2024-08-06 16:18:38");
INSERT INTO Regiones VALUES ("20","Zona Los Cabos","2024-08-06 16:18:50");
INSERT INTO Regiones VALUES ("21","Zona los Ríos","2024-08-06 16:19:16");
INSERT INTO Regiones VALUES ("22","Zona Los Tuxtlas","2024-08-06 16:19:29");
INSERT INTO Regiones VALUES ("23","Zona Mérida","2024-08-06 16:19:40");
INSERT INTO Regiones VALUES ("24","Zona Morelos","2024-08-06 16:19:52");
INSERT INTO Regiones VALUES ("25","Zona Motul","2024-08-06 16:20:08");
INSERT INTO Regiones VALUES ("26","Zona Orizaba","2024-08-06 16:20:19");
INSERT INTO Regiones VALUES ("27","Zona Papaloapan","2024-08-06 16:21:01");
INSERT INTO Regiones VALUES ("28","Zona Poza Rica","2024-08-06 16:21:34");
INSERT INTO Regiones VALUES ("29","Zona San Luis","2024-08-06 16:21:56");
INSERT INTO Regiones VALUES ("30","Zona Teziutlán","2024-08-06 16:22:16");
INSERT INTO Regiones VALUES ("31","Zona Ticul","2024-08-06 16:22:29");
INSERT INTO Regiones VALUES ("32","Zona Tizimín","2024-08-06 16:22:47");
INSERT INTO Regiones VALUES ("33","Zona Valle de Bravo","2024-08-06 16:23:00");
INSERT INTO Regiones VALUES ("34","Zona Veracruz","2024-08-06 16:23:18");
INSERT INTO Regiones VALUES ("35","Zona Xalapa","2024-08-06 16:23:29");
INSERT INTO Regiones VALUES ("36","Zona Zihuatanejo","2024-08-06 16:23:49");

-- Table structure for table `Estados`
CREATE TABLE `Estados` (
  `Id_Estado` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_estado` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Estados`
INSERT INTO Estados VALUES ("1","Aguascalientes");
INSERT INTO Estados VALUES ("2","Baja California");
INSERT INTO Estados VALUES ("3","Baja California Sur");
INSERT INTO Estados VALUES ("4","Campeche");
INSERT INTO Estados VALUES ("5","Chiapas");
INSERT INTO Estados VALUES ("6","Chihuahua");
INSERT INTO Estados VALUES ("7","Coahuila");
INSERT INTO Estados VALUES ("8","Colima");
INSERT INTO Estados VALUES ("9","Ciudad de México (CDMX)");
INSERT INTO Estados VALUES ("10","Durango");
INSERT INTO Estados VALUES ("11","Guanajuato");
INSERT INTO Estados VALUES ("12","Guerrero");
INSERT INTO Estados VALUES ("13","Hidalgo");
INSERT INTO Estados VALUES ("14","Jalisco");
INSERT INTO Estados VALUES ("15","México (Estado de México)");
INSERT INTO Estados VALUES ("16","Michoacán");
INSERT INTO Estados VALUES ("17","Morelos");
INSERT INTO Estados VALUES ("18","Nayarit");
INSERT INTO Estados VALUES ("19","Nuevo León");
INSERT INTO Estados VALUES ("20","Oaxaca");
INSERT INTO Estados VALUES ("21","Puebla");
INSERT INTO Estados VALUES ("22","Querétaro");
INSERT INTO Estados VALUES ("23","Quintana Roo");
INSERT INTO Estados VALUES ("24","San Luis Potosí");
INSERT INTO Estados VALUES ("25","Sinaloa");
INSERT INTO Estados VALUES ("26","Sonora");
INSERT INTO Estados VALUES ("27","Tabasco");
INSERT INTO Estados VALUES ("28","Tamaulipas");
INSERT INTO Estados VALUES ("29","Tlaxcala");
INSERT INTO Estados VALUES ("30","Veracruz");
INSERT INTO Estados VALUES ("31","Yucatán");
INSERT INTO Estados VALUES ("32","Zacatecas");

-- Table structure for table `Estado_Region`
CREATE TABLE `Estado_Region` (
  `IDEstReg` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Regiones` int(11) DEFAULT NULL,
  `ID_Estados` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDEstReg`),
  KEY `ID_Regiones` (`ID_Regiones`),
  KEY `ID_Estados` (`ID_Estados`),
  CONSTRAINT `Estado_Region_ibfk_1` FOREIGN KEY (`ID_Regiones`) REFERENCES `Regiones` (`ID_Region`),
  CONSTRAINT `Estado_Region_ibfk_2` FOREIGN KEY (`ID_Estados`) REFERENCES `Estados` (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Estado_Region`
INSERT INTO Estado_Region VALUES ("1","2","2");
INSERT INTO Estado_Region VALUES ("2","2","16");
INSERT INTO Estado_Region VALUES ("3","2","17");
INSERT INTO Estado_Region VALUES ("4","2","30");
INSERT INTO Estado_Region VALUES ("5","2","31");
INSERT INTO Estado_Region VALUES ("24","4","12");
INSERT INTO Estado_Region VALUES ("25","5","12");
INSERT INTO Estado_Region VALUES ("26","5","16");
INSERT INTO Estado_Region VALUES ("27","6","15");
INSERT INTO Estado_Region VALUES ("28","7","4");
INSERT INTO Estado_Region VALUES ("29","8","4");
INSERT INTO Estado_Region VALUES ("30","9","12");
INSERT INTO Estado_Region VALUES ("31","10","27");
INSERT INTO Estado_Region VALUES ("32","11","30");
INSERT INTO Estado_Region VALUES ("33","12","8");
INSERT INTO Estado_Region VALUES ("34","13","3");
INSERT INTO Estado_Region VALUES ("35","14","30");
INSERT INTO Estado_Region VALUES ("36","15","17");
INSERT INTO Estado_Region VALUES ("37","16","17");
INSERT INTO Estado_Region VALUES ("38","17","2");
INSERT INTO Estado_Region VALUES ("39","18","12");
INSERT INTO Estado_Region VALUES ("40","19","16");
INSERT INTO Estado_Region VALUES ("41","20","3");
INSERT INTO Estado_Region VALUES ("42","21","27");
INSERT INTO Estado_Region VALUES ("43","21","5");
INSERT INTO Estado_Region VALUES ("44","21","4");
INSERT INTO Estado_Region VALUES ("45","22","30");
INSERT INTO Estado_Region VALUES ("46","23","31");
INSERT INTO Estado_Region VALUES ("47","24","17");
INSERT INTO Estado_Region VALUES ("48","25","31");
INSERT INTO Estado_Region VALUES ("49","26","30");
INSERT INTO Estado_Region VALUES ("51","27","30");
INSERT INTO Estado_Region VALUES ("52","27","20");
INSERT INTO Estado_Region VALUES ("53","27","21");
INSERT INTO Estado_Region VALUES ("54","28","30");
INSERT INTO Estado_Region VALUES ("55","28","21");
INSERT INTO Estado_Region VALUES ("56","29","26");
INSERT INTO Estado_Region VALUES ("57","29","2");
INSERT INTO Estado_Region VALUES ("58","30","30");
INSERT INTO Estado_Region VALUES ("59","30","21");
INSERT INTO Estado_Region VALUES ("60","31","31");
INSERT INTO Estado_Region VALUES ("61","32","31");
INSERT INTO Estado_Region VALUES ("62","32","23");
INSERT INTO Estado_Region VALUES ("63","33","15");
INSERT INTO Estado_Region VALUES ("64","34","30");
INSERT INTO Estado_Region VALUES ("65","35","30");
INSERT INTO Estado_Region VALUES ("66","36","12");

-- Table structure for table `Cuenta`
CREATE TABLE `Cuenta` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCuenta` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `NroElemetos` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Cuenta`
INSERT INTO Cuenta VALUES ("1","CFE","357");

-- Table structure for table `Cuenta_Region`
CREATE TABLE `Cuenta_Region` (
  `IDRegCu` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Cuentas` int(11) DEFAULT NULL,
  `ID_Regiones` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDRegCu`),
  KEY `ID_Cuentas` (`ID_Cuentas`),
  KEY `ID_Regiones` (`ID_Regiones`),
  CONSTRAINT `Cuenta_Region_ibfk_1` FOREIGN KEY (`ID_Cuentas`) REFERENCES `Cuenta` (`ID`),
  CONSTRAINT `Cuenta_Region_ibfk_2` FOREIGN KEY (`ID_Regiones`) REFERENCES `Regiones` (`ID_Region`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Cuenta_Region`
INSERT INTO Cuenta_Region VALUES ("1","1","2");
INSERT INTO Cuenta_Region VALUES ("3","1","4");
INSERT INTO Cuenta_Region VALUES ("4","1","5");
INSERT INTO Cuenta_Region VALUES ("5","1","6");
INSERT INTO Cuenta_Region VALUES ("6","1","7");
INSERT INTO Cuenta_Region VALUES ("7","1","8");
INSERT INTO Cuenta_Region VALUES ("8","1","9");
INSERT INTO Cuenta_Region VALUES ("9","1","10");
INSERT INTO Cuenta_Region VALUES ("10","1","11");
INSERT INTO Cuenta_Region VALUES ("11","1","12");
INSERT INTO Cuenta_Region VALUES ("12","1","13");
INSERT INTO Cuenta_Region VALUES ("13","1","14");
INSERT INTO Cuenta_Region VALUES ("14","1","15");
INSERT INTO Cuenta_Region VALUES ("15","1","16");
INSERT INTO Cuenta_Region VALUES ("16","1","17");
INSERT INTO Cuenta_Region VALUES ("17","1","18");
INSERT INTO Cuenta_Region VALUES ("18","1","19");
INSERT INTO Cuenta_Region VALUES ("19","1","20");
INSERT INTO Cuenta_Region VALUES ("20","1","21");
INSERT INTO Cuenta_Region VALUES ("21","1","22");
INSERT INTO Cuenta_Region VALUES ("22","1","23");
INSERT INTO Cuenta_Region VALUES ("23","1","24");
INSERT INTO Cuenta_Region VALUES ("24","1","25");
INSERT INTO Cuenta_Region VALUES ("25","1","26");
INSERT INTO Cuenta_Region VALUES ("26","1","27");
INSERT INTO Cuenta_Region VALUES ("27","1","28");
INSERT INTO Cuenta_Region VALUES ("28","1","29");
INSERT INTO Cuenta_Region VALUES ("29","1","30");
INSERT INTO Cuenta_Region VALUES ("30","1","31");
INSERT INTO Cuenta_Region VALUES ("31","1","32");
INSERT INTO Cuenta_Region VALUES ("32","1","33");
INSERT INTO Cuenta_Region VALUES ("33","1","34");
INSERT INTO Cuenta_Region VALUES ("34","1","35");
INSERT INTO Cuenta_Region VALUES ("35","1","36");

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
INSERT INTO Tipo_Usuarios VALUES ("2","Directivo ");
INSERT INTO Tipo_Usuarios VALUES ("3","Administrador");
INSERT INTO Tipo_Usuarios VALUES ("4","Usuario");
INSERT INTO Tipo_Usuarios VALUES ("5","Almacenista");

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
  `Constrasena` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `NumContactoSOS` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ID_Tipo_Usuario` int(11) DEFAULT NULL,
  `ID_Cuenta` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Usuario`),
  KEY `ID_Tipo_Usuario` (`ID_Tipo_Usuario`),
  KEY `ID_Cuenta` (`ID_Cuenta`),
  CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`ID_Tipo_Usuario`) REFERENCES `Tipo_Usuarios` (`ID`),
  CONSTRAINT `Usuario_ibfk_2` FOREIGN KEY (`ID_Cuenta`) REFERENCES `Cuenta` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Usuario`
INSERT INTO Usuario VALUES ("1","Moises","Silva","Gonzalez","7774449107","mochito619@gmail.com","$2y$10$H990TbynmXllBVVhzIXbOeEPaiVQr2LzGo6BSbFX9p6KnSEh3NWoe","7771234567","1","");
INSERT INTO Usuario VALUES ("2","Mario","Quintana","Cortes","7771800550","mquintanapryse@gmail.com","$2y$10$.fFb9d1jh5PxvjXrJA2O0uxillnO2eoIpSE1G7MS0Hq/ksxN.8gDK","7771620029","1","");
INSERT INTO Usuario VALUES ("12","Cibeles","Torres","Henestrosa","55 1798 0299","pryse392@gmail.com","$2y$10$TEzHo3akhwMjPSYsLFfIgemgfpevvxQ2BHhPjVdQGGcRw009rGXN2","55 2888 2483","3","1");
INSERT INTO Usuario VALUES ("13","Monserrat","Morales","Gomez","5610371996","monserrat.pryse@gmail.com","$2y$10$4xwlmJP3lvY8g.YqbQEwu.s6Am7Elgo4yb9JhwcW3bWukOvFDltG6","7775607165","4","1");
INSERT INTO Usuario VALUES ("14","Yessica","Heracleo","Garcia","56 1036 5116","yesicahg.pryse@gmail.com","$2y$10$8uVPGbfl/a6wwFHZiiqw4OKm9XVmOJLy4YgPR3wpV6z9.O.gGA1w2","7773216137","5","");
INSERT INTO Usuario VALUES ("15","Karen","Paterno","Materno","55 5956 6030","karendireccion@gmail.com","$2y$10$tVeaCFitmCNuraOJnRq5o.RztSZ7CbL9h1sRGRENyTdjxUOr3xOOa","7771234567","2","");

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Inventario`
INSERT INTO Inventario VALUES ("1","1","5","147");
INSERT INTO Inventario VALUES ("2","8","28","195");
INSERT INTO Inventario VALUES ("3","55","26","243");
INSERT INTO Inventario VALUES ("4","60","32","303");

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
INSERT INTO EntradaE VALUES ("1","2024-08-06 17:00:51","","","14","Prueba","UsuarioPrueba","Comentarios prueba","Creada");

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `EntradaD`
INSERT INTO EntradaD VALUES ("1","1","1","5","150");
INSERT INTO EntradaD VALUES ("2","1","8","28","200");
INSERT INTO EntradaD VALUES ("3","1","55","26","250");
INSERT INTO EntradaD VALUES ("4","1","60","32","400");

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `RequisicionE`
INSERT INTO RequisicionE VALUES ("1","12","2024-08-06 16:52:20","2024-08-06 16:57:36","Parcial","Julio Arambula","13","","Julio Arambula","7771234567","Prueba RFC","Prueba justificacion","3","","","","","");

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `RequisicionD`
INSERT INTO RequisicionD VALUES ("1","1","1","5","100");
INSERT INTO RequisicionD VALUES ("2","1","8","28","200");
INSERT INTO RequisicionD VALUES ("3","1","55","26","300");
INSERT INTO RequisicionD VALUES ("4","1","60","32","350");

-- Table structure for table `Borrador_RequisicionE`
CREATE TABLE `Borrador_RequisicionE` (
  `BIDRequisicionE` int(11) NOT NULL AUTO_INCREMENT,
  `BIdUsuario` int(11) DEFAULT NULL,
  `BFchCreacion` datetime NOT NULL,
  `BEstatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `BSupervisor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `BIdRegion` int(11) DEFAULT NULL,
  `BCentroTrabajo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BReceptor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `BTelReceptor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `BRfcReceptor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `BJustificacion` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BIdEstado` int(11) DEFAULT NULL,
  `BMpio` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BColonia` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BCalle` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BNro` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BCP` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`BIDRequisicionE`),
  KEY `BIdUsuario` (`BIdUsuario`),
  KEY `BIdRegion` (`BIdRegion`),
  KEY `BIdEstado` (`BIdEstado`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_1` FOREIGN KEY (`BIdUsuario`) REFERENCES `Usuario` (`ID_Usuario`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_2` FOREIGN KEY (`BIdRegion`) REFERENCES `Regiones` (`ID_Region`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_3` FOREIGN KEY (`BIdEstado`) REFERENCES `Estados` (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Borrador_RequisicionE`
INSERT INTO Borrador_RequisicionE VALUES ("3","13","2024-08-19 11:14:47","Borrador","Ellen","2","Zona Alta","Mario Octavio","7774449018","SIGM071001MS","Prueba para ver si funciona correctamente","17","","","","","");

-- Table structure for table `Borrador_RequisicionD`
CREATE TABLE `Borrador_RequisicionD` (
  `BId` int(11) NOT NULL AUTO_INCREMENT,
  `BIdReqE` int(11) DEFAULT NULL,
  `BIdCProd` int(11) DEFAULT NULL,
  `BIdTalla` int(11) DEFAULT NULL,
  `BCantidad` int(11) NOT NULL,
  PRIMARY KEY (`BId`),
  KEY `BIdReqE` (`BIdReqE`),
  KEY `BIdCProd` (`BIdCProd`),
  KEY `BIdTalla` (`BIdTalla`),
  CONSTRAINT `Borrador_RequisicionD_ibfk_1` FOREIGN KEY (`BIdReqE`) REFERENCES `Borrador_RequisicionE` (`BIDRequisicionE`),
  CONSTRAINT `Borrador_RequisicionD_ibfk_2` FOREIGN KEY (`BIdCProd`) REFERENCES `Producto` (`IdCProducto`),
  CONSTRAINT `Borrador_RequisicionD_ibfk_3` FOREIGN KEY (`BIdTalla`) REFERENCES `CTallas` (`IdCTallas`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Borrador_RequisicionD`
INSERT INTO Borrador_RequisicionD VALUES ("15","3","2","9","10");
INSERT INTO Borrador_RequisicionD VALUES ("16","3","3","13","11");
INSERT INTO Borrador_RequisicionD VALUES ("17","3","1","1","13");

-- Table structure for table `Salida_E`
CREATE TABLE `Salida_E` (
  `Id_SalE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ReqE` int(11) DEFAULT NULL,
  `ID_Usuario_Salida` int(11) DEFAULT NULL,
  `FchSalidad` datetime NOT NULL,
  PRIMARY KEY (`Id_SalE`),
  KEY `ID_ReqE` (`ID_ReqE`),
  KEY `ID_Usuario_Salida` (`ID_Usuario_Salida`),
  CONSTRAINT `Salida_E_ibfk_1` FOREIGN KEY (`ID_ReqE`) REFERENCES `RequisicionE` (`IDRequisicionE`),
  CONSTRAINT `Salida_E_ibfk_2` FOREIGN KEY (`ID_Usuario_Salida`) REFERENCES `Usuario` (`ID_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Salida_E`
INSERT INTO Salida_E VALUES ("11","1","1","2024-08-13 11:14:33");
INSERT INTO Salida_E VALUES ("12","1","14","2024-08-13 11:16:21");

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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Salida_D`
INSERT INTO Salida_D VALUES ("41","11","1","5","1");
INSERT INTO Salida_D VALUES ("42","11","8","28","2");
INSERT INTO Salida_D VALUES ("43","11","55","26","3");
INSERT INTO Salida_D VALUES ("44","11","60","32","43");
INSERT INTO Salida_D VALUES ("45","12","1","5","2");
INSERT INTO Salida_D VALUES ("46","12","8","28","3");
INSERT INTO Salida_D VALUES ("47","12","55","26","4");
INSERT INTO Salida_D VALUES ("48","12","60","32","54");

-- Trigger structure for trigger `actualizar_inventario_despues_borrar_entrada`
CREATE DEFINER=`grupova9`@`localhost` TRIGGER `actualizar_inventario_despues_borrar_entrada` AFTER DELETE ON `EntradaD` FOR EACH ROW BEGIN
    DECLARE Cant_Entrada INT;
    DECLARE Id_Prod INT;
    DECLARE Id_Tall INT;

    -- Obtener los valores de los registros elimanos en EntradaD
    SELECT OLD.Cantidad, OLD.IdProd, OLD.IdTalla INTO Cant_Entrada, Id_Prod, Id_Tall;

    -- Actualizar los valores en la tabla inventarios
    UPDATE Inventario I SET I.Cantidad = I.Cantidad - Cant_Entrada WHERE I.IdCPro = Id_Prod AND I.IdCTal = Id_Tall;
END;

-- Trigger structure for trigger `actualizar_inventario_despues_borrar_salida`
CREATE DEFINER=`grupova9`@`localhost` TRIGGER `actualizar_inventario_despues_borrar_salida` AFTER DELETE ON `Salida_D` FOR EACH ROW BEGIN
    DECLARE cantidad_salida INT;
    DECLARE id_producto INT;
    DECLARE id_talla INT;

    -- Obtener los valores de los registros elimanos en SalidaD
    SELECT OLD.Cantidad, OLD.IdCProd, OLD.IdTallas INTO cantidad_salida, id_producto, id_talla;

    -- Actualizar los valores en la tabla inventarios
    UPDATE Inventario I SET I.Cantidad = I.Cantidad + cantidad_salida WHERE I.IdCPro = id_producto AND I.IdCTal = id_talla;
END;

