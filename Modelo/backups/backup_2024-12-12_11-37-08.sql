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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO Regiones VALUES ("41","1","2024-11-29 12:50:19");
INSERT INTO Regiones VALUES ("42","2","2024-11-29 12:50:32");
INSERT INTO Regiones VALUES ("43","3","2024-11-29 12:50:43");
INSERT INTO Regiones VALUES ("44","4","2024-11-29 12:50:53");
INSERT INTO Regiones VALUES ("45","Noroeste","2024-11-29 13:40:33");
INSERT INTO Regiones VALUES ("46","Noreste","2024-12-02 10:31:05");
INSERT INTO Regiones VALUES ("47","Occidente","2024-12-02 12:28:15");
INSERT INTO Regiones VALUES ("48","Norte","2024-12-02 12:29:01");
INSERT INTO Regiones VALUES ("49","4","2024-12-02 12:38:31");
INSERT INTO Regiones VALUES ("50","5","2024-12-02 12:50:26");
INSERT INTO Regiones VALUES ("51","IPN","2024-12-02 12:54:32");
INSERT INTO Regiones VALUES ("52","1","2024-12-02 12:55:40");
INSERT INTO Regiones VALUES ("53","2","2024-12-02 12:56:28");
INSERT INTO Regiones VALUES ("54","3","2024-12-02 12:57:38");
INSERT INTO Regiones VALUES ("56","Varias 1","2024-12-02 13:15:03");
INSERT INTO Regiones VALUES ("57","Varias 2","2024-12-02 17:37:05");
INSERT INTO Regiones VALUES ("58","CDMX","2024-12-06 17:10:53");

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
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO Estado_Region VALUES ("75","41","26");
INSERT INTO Estado_Region VALUES ("76","42","12");
INSERT INTO Estado_Region VALUES ("77","43","17");
INSERT INTO Estado_Region VALUES ("78","44","2");
INSERT INTO Estado_Region VALUES ("79","45","3");
INSERT INTO Estado_Region VALUES ("80","45","2");
INSERT INTO Estado_Region VALUES ("81","45","26");
INSERT INTO Estado_Region VALUES ("82","45","25");
INSERT INTO Estado_Region VALUES ("83","46","28");
INSERT INTO Estado_Region VALUES ("84","46","19");
INSERT INTO Estado_Region VALUES ("85","46","24");
INSERT INTO Estado_Region VALUES ("86","47","1");
INSERT INTO Estado_Region VALUES ("87","47","14");
INSERT INTO Estado_Region VALUES ("88","47","18");
INSERT INTO Estado_Region VALUES ("89","47","32");
INSERT INTO Estado_Region VALUES ("90","48","10");
INSERT INTO Estado_Region VALUES ("91","48","6");
INSERT INTO Estado_Region VALUES ("92","48","7");
INSERT INTO Estado_Region VALUES ("93","49","17");
INSERT INTO Estado_Region VALUES ("94","49","12");
INSERT INTO Estado_Region VALUES ("95","49","20");
INSERT INTO Estado_Region VALUES ("96","49","21");
INSERT INTO Estado_Region VALUES ("97","49","9");
INSERT INTO Estado_Region VALUES ("98","49","11");
INSERT INTO Estado_Region VALUES ("99","49","15");
INSERT INTO Estado_Region VALUES ("100","50","28");
INSERT INTO Estado_Region VALUES ("101","50","30");
INSERT INTO Estado_Region VALUES ("102","50","27");
INSERT INTO Estado_Region VALUES ("103","50","4");
INSERT INTO Estado_Region VALUES ("104","50","20");
INSERT INTO Estado_Region VALUES ("105","50","5");
INSERT INTO Estado_Region VALUES ("106","51","13");
INSERT INTO Estado_Region VALUES ("107","51","15");
INSERT INTO Estado_Region VALUES ("108","51","28");
INSERT INTO Estado_Region VALUES ("109","51","17");
INSERT INTO Estado_Region VALUES ("110","51","32");
INSERT INTO Estado_Region VALUES ("111","51","2");
INSERT INTO Estado_Region VALUES ("112","51","25");
INSERT INTO Estado_Region VALUES ("113","51","16");
INSERT INTO Estado_Region VALUES ("114","51","26");
INSERT INTO Estado_Region VALUES ("115","51","22");
INSERT INTO Estado_Region VALUES ("116","51","20");
INSERT INTO Estado_Region VALUES ("117","51","5");
INSERT INTO Estado_Region VALUES ("118","51","27");
INSERT INTO Estado_Region VALUES ("119","51","10");
INSERT INTO Estado_Region VALUES ("120","51","11");
INSERT INTO Estado_Region VALUES ("121","51","3");
INSERT INTO Estado_Region VALUES ("122","51","29");
INSERT INTO Estado_Region VALUES ("123","51","30");
INSERT INTO Estado_Region VALUES ("124","51","21");
INSERT INTO Estado_Region VALUES ("125","51","4");
INSERT INTO Estado_Region VALUES ("126","51","23");
INSERT INTO Estado_Region VALUES ("127","51","6");
INSERT INTO Estado_Region VALUES ("128","52","2");
INSERT INTO Estado_Region VALUES ("129","52","3");
INSERT INTO Estado_Region VALUES ("130","52","26");
INSERT INTO Estado_Region VALUES ("131","52","25");
INSERT INTO Estado_Region VALUES ("132","53","6");
INSERT INTO Estado_Region VALUES ("133","53","7");
INSERT INTO Estado_Region VALUES ("134","53","19");
INSERT INTO Estado_Region VALUES ("135","53","28");
INSERT INTO Estado_Region VALUES ("136","53","10");
INSERT INTO Estado_Region VALUES ("137","53","25");
INSERT INTO Estado_Region VALUES ("138","54","15");
INSERT INTO Estado_Region VALUES ("139","54","10");
INSERT INTO Estado_Region VALUES ("140","54","11");
INSERT INTO Estado_Region VALUES ("141","54","14");
INSERT INTO Estado_Region VALUES ("142","54","16");
INSERT INTO Estado_Region VALUES ("143","54","18");
INSERT INTO Estado_Region VALUES ("144","54","22");
INSERT INTO Estado_Region VALUES ("145","54","25");
INSERT INTO Estado_Region VALUES ("146","54","32");
INSERT INTO Estado_Region VALUES ("148","56","12");
INSERT INTO Estado_Region VALUES ("149","56","5");
INSERT INTO Estado_Region VALUES ("150","56","4");
INSERT INTO Estado_Region VALUES ("151","56","23");
INSERT INTO Estado_Region VALUES ("152","56","31");
INSERT INTO Estado_Region VALUES ("153","56","3");
INSERT INTO Estado_Region VALUES ("154","56","20");
INSERT INTO Estado_Region VALUES ("155","56","9");
INSERT INTO Estado_Region VALUES ("156","56","18");
INSERT INTO Estado_Region VALUES ("157","56","14");
INSERT INTO Estado_Region VALUES ("174","57","15");
INSERT INTO Estado_Region VALUES ("175","58","9");

-- Table structure for table `Cuenta`
CREATE TABLE `Cuenta` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCuenta` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `NroElemetos` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Cuenta`
INSERT INTO Cuenta VALUES ("1","CFE","357");
INSERT INTO Cuenta VALUES ("5","Cuenta Prueba","123");
INSERT INTO Cuenta VALUES ("7","CAPUFE","1000");
INSERT INTO Cuenta VALUES ("8","IPN","300");
INSERT INTO Cuenta VALUES ("9","ISSSTE","700");
INSERT INTO Cuenta VALUES ("10","IMSS Ordinario","4000");
INSERT INTO Cuenta VALUES ("11","Cuentas Varias","500");
INSERT INTO Cuenta VALUES ("12","AICM","1103");

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO Cuenta_Region VALUES ("40","9","41");
INSERT INTO Cuenta_Region VALUES ("41","9","42");
INSERT INTO Cuenta_Region VALUES ("42","9","43");
INSERT INTO Cuenta_Region VALUES ("43","9","44");
INSERT INTO Cuenta_Region VALUES ("44","10","45");
INSERT INTO Cuenta_Region VALUES ("45","10","46");
INSERT INTO Cuenta_Region VALUES ("46","10","47");
INSERT INTO Cuenta_Region VALUES ("47","10","48");
INSERT INTO Cuenta_Region VALUES ("48","7","49");
INSERT INTO Cuenta_Region VALUES ("49","7","50");
INSERT INTO Cuenta_Region VALUES ("50","7","51");
INSERT INTO Cuenta_Region VALUES ("51","7","52");
INSERT INTO Cuenta_Region VALUES ("52","7","53");
INSERT INTO Cuenta_Region VALUES ("53","7","54");
INSERT INTO Cuenta_Region VALUES ("55","11","56");
INSERT INTO Cuenta_Region VALUES ("56","11","57");
INSERT INTO Cuenta_Region VALUES ("57","12","58");

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
  PRIMARY KEY (`ID_Usuario`),
  KEY `ID_Tipo_Usuario` (`ID_Tipo_Usuario`),
  CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`ID_Tipo_Usuario`) REFERENCES `Tipo_Usuarios` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Usuario`
INSERT INTO Usuario VALUES ("1","Moises","Silva","Gonzalez","7774449107","mochito619@gmail.com","$2y$10$H990TbynmXllBVVhzIXbOeEPaiVQr2LzGo6BSbFX9p6KnSEh3NWoe","7771234567","1");
INSERT INTO Usuario VALUES ("2","Mario","Quintana","Cortes","7771800550","mquintanapryse@gmail.com","$2y$10$.fFb9d1jh5PxvjXrJA2O0uxillnO2eoIpSE1G7MS0Hq/ksxN.8gDK","7771620029","1");
INSERT INTO Usuario VALUES ("3","Karen","Paterno","Materno","55 5956 6030","karendireccion@gmail.com","$2y$10$tVeaCFitmCNuraOJnRq5o.RztSZ7CbL9h1sRGRENyTdjxUOr3xOOa","7771234567","2");
INSERT INTO Usuario VALUES ("4","Monserrat","Morales","Gomez","5610371996","monserrat.pryse@gmail.com","$2y$10$HngIEpiTkpAXgBu4RLIf/O5orsfh/E6ryVi7Waacc7wEjADmuXiE.","55 2888 2483","3");
INSERT INTO Usuario VALUES ("5","Monserrat","Morales","Gomez","5610371996","onserrat.pryse@gmail.com","$2y$10$4xwlmJP3lvY8g.YqbQEwu.s6Am7Elgo4yb9JhwcW3bWukOvFDltG6","7775607165","4");
INSERT INTO Usuario VALUES ("6","Yessica","Heracleo","Garcia","56 1036 5116","yesicahg.pryse@gmail.com","$2y$10$8uVPGbfl/a6wwFHZiiqw4OKm9XVmOJLy4YgPR3wpV6z9.O.gGA1w2","7773216137","5");
INSERT INTO Usuario VALUES ("18","Administrador","Pruebas","Pruebas","1234567891","administrador.prueba@grupopryse.mx","$2y$10$m2E2xN0n/IorWoRb1bO3YucD6nAuXI4idiRAWAmhpYTkU22EzI9Y2","1234567890","3");
INSERT INTO Usuario VALUES ("19","Isaias","Reyes","Velazquez","7773272756","i.reyes@almacen.grupopryse.mx","$2y$10$QE.HEnMquXGmYKiQRH80GONFmYTempy2xxDIcNuX6JkIu4pen4qqi","7771408330","5");
INSERT INTO Usuario VALUES ("20","Iris Itzeel","Flores","Jaimez","5610385726","i.flores@grupopryse.mx","$2y$10$2Gu4oRDnWliFU8w3FBqh8OLZ2MndgDEVevaU2TvNMkjF8ciYVU5o6","7773772335","3");
INSERT INTO Usuario VALUES ("21","Yuliam","Roman","Uribe","56 2609 1728","y.roman@grupopryse.mx","$2y$10$Aceth.XtOInK/rs9x5vVR.uwCjCzI8lAi8ufZB0t0Vhq4vCu8j2pu","56 2609 1728","3");
INSERT INTO Usuario VALUES ("22","Jessica","Parada","Soria","5591416891","jessica.grupopryse@gmail.com","$2y$10$e6ipFnXskD2rh537uVpWHuG1z.RTWqdRQt9keOHzGHixKAsQRwLMa","5591416891","3");
INSERT INTO Usuario VALUES ("23","Linda Elizabeth","Arriaga","Ramirez","5559566461","linda.pryse2022@gmail.com","$2y$10$1WS2VRiUr0fKAji/ctIzPOhNbBmnWmLR2BEYXTROSRBOu6.EY3wp6","7621093272","3");
INSERT INTO Usuario VALUES ("24","Estefanía ","Macedo","Herrera","2294376890","estefania.pryse@gmail.com","$2y$10$/GHhhpzCrSATkxAK1E7BFe22j943n.SsBq0b2dNOExL/DzYB6mEay","5559567942","3");
INSERT INTO Usuario VALUES ("25","Miguel","Linares","Estrada","7333359098","miguel.linares@grupopryse.mx","$2y$10$1mmSXWfkjf1PyvN8daeq/Op8/ncFu0tgXVrONUdDyiBtVVH0KIZQm","7333359098","3");
INSERT INTO Usuario VALUES ("26","Isabel","Yañez","Celis","6242459447","isabelcelis.pryse@gmail.com","$2y$10$a1XEnVSKUhuxhobJRZyc8e1PWvaTin2gMKcqAOAQ2du8RZZgLLqLO","6242459447","3");
INSERT INTO Usuario VALUES ("27","Yenifer","Campuzano","Flores","5563161999","pryse374@gmail.com","$2y$10$1ONwS1sd5ZgqCmmN5QyEbut66/rcFz/BNIX1BRfQVDYHTGWC0/kVO","5563161999","3");
INSERT INTO Usuario VALUES ("28","Flor de Maria","Cruz","Luis","5615229517","flor.cruz.2024@gmail.com","$2y$10$W1ZxGI0ZXrTmNTxnzrcPU.VEGRqGs18gbxNFodVBBQ.qU05e3ODOC","5615229517","3");
INSERT INTO Usuario VALUES ("29","Georgina","Meade","Ocaranza","5615234087","gina.meade.ote@gmail.com","$2y$10$QUkx9t1HiG1tJWYYnifNnOd80xrRrg8jLmJ76b.SjiwQ1jSrAHJ0u","5615234087","3");
INSERT INTO Usuario VALUES ("30","Maria de Lourdes","Armas","Mota","5610121957","l.armas.pryse@gmail.com","$2y$10$VUYTndePeQyhEtAQOnrcPO26MDzaRd9sm2khl05QHnqtnzca4zF8O","5610121957","3");
INSERT INTO Usuario VALUES ("31","Sergio","Arteaga","Sosa","5559549465","gerenciaaicmpryse@gmail.com","$2y$10$3jd44ceJo0RTDSQWKhPDku0FBS/TUuV3XinPbJ19JSGF1L32u.arS","5559549465","3");

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `CEmpresas`
INSERT INTO CEmpresas VALUES ("1","PRYSE","Prueba 1","Prueba 1","M0987654321","Prueba 1");
INSERT INTO CEmpresas VALUES ("2","PRYSE/LIMP","Prueba 2","Prueba 2","C0908070605","Prueba 2");
INSERT INTO CEmpresas VALUES ("3","PROTE","Prueba 3","Prueba 3","Y6968676665","Prueba 3");
INSERT INTO CEmpresas VALUES ("4","VALBON","Prueba 4","Prueba 4","D0000012345","Prueba 4");
INSERT INTO CEmpresas VALUES ("5","PRYSE/AICM","Prueba 5","Prueba 5","E0192837465","Prueba 5");
INSERT INTO CEmpresas VALUES ("6","PRYSE/PROTE","Prueba 6","Prueba 6","E0192837466","Prueba 6");
INSERT INTO CEmpresas VALUES ("7","VALVON","Prueba 7","Prueba 7","E0192837467","Prueba 7");
INSERT INTO CEmpresas VALUES ("8","MULTISISTEMAS URIBE","","","","");

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
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Producto`
INSERT INTO Producto VALUES ("1","1","1","1","Camisa","Azul, manga corta, PRYSE","../../../img/Productos/product_6661ff4cc36d3.png","2024-06-06 12:26:20");
INSERT INTO Producto VALUES ("2","1","1","1","Camisa","Blanca, manga larga, bolsas, PRYSE","../../../img/Productos/product_666200e314683.png","2024-06-06 12:33:07");
INSERT INTO Producto VALUES ("3","1","1","1","Camisa","Blanca, manga corta azul, PRYSE","../../../img/Productos/product_666201c5f1991.png","2024-12-09 17:20:47");
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
INSERT INTO Producto VALUES ("64","8","1","1","CAMISA BLANCA MANGA CORTA ","Nuevo logo de multisistemas Uribe","../../../img/Productos/product_674f59cb6839e.jpeg","2024-12-03 13:19:39");

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
) ENGINE=InnoDB AUTO_INCREMENT=298 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Inventario`
INSERT INTO Inventario VALUES ("1","1","7","0");
INSERT INTO Inventario VALUES ("2","1","9","0");
INSERT INTO Inventario VALUES ("3","1","11","0");
INSERT INTO Inventario VALUES ("4","1","13","1");
INSERT INTO Inventario VALUES ("5","1","14","0");
INSERT INTO Inventario VALUES ("6","1","15","0");
INSERT INTO Inventario VALUES ("7","1","16","0");
INSERT INTO Inventario VALUES ("8","1","17","194");
INSERT INTO Inventario VALUES ("9","1","18","953");
INSERT INTO Inventario VALUES ("10","1","19","68");
INSERT INTO Inventario VALUES ("11","1","20","185");
INSERT INTO Inventario VALUES ("12","1","21","9");
INSERT INTO Inventario VALUES ("13","1","22","0");
INSERT INTO Inventario VALUES ("14","1","23","0");
INSERT INTO Inventario VALUES ("15","1","24","0");
INSERT INTO Inventario VALUES ("16","2","7","0");
INSERT INTO Inventario VALUES ("17","2","9","0");
INSERT INTO Inventario VALUES ("18","2","11","86");
INSERT INTO Inventario VALUES ("19","2","13","5");
INSERT INTO Inventario VALUES ("20","2","14","0");
INSERT INTO Inventario VALUES ("21","2","15","12");
INSERT INTO Inventario VALUES ("22","2","16","0");
INSERT INTO Inventario VALUES ("23","2","17","12");
INSERT INTO Inventario VALUES ("24","2","18","53");
INSERT INTO Inventario VALUES ("25","2","19","3");
INSERT INTO Inventario VALUES ("26","2","20","57");
INSERT INTO Inventario VALUES ("27","2","21","82");
INSERT INTO Inventario VALUES ("28","2","22","41");
INSERT INTO Inventario VALUES ("29","2","23","0");
INSERT INTO Inventario VALUES ("30","2","24","0");
INSERT INTO Inventario VALUES ("31","3","7","0");
INSERT INTO Inventario VALUES ("32","3","9","0");
INSERT INTO Inventario VALUES ("33","3","11","523");
INSERT INTO Inventario VALUES ("34","3","13","733");
INSERT INTO Inventario VALUES ("35","3","14","797");
INSERT INTO Inventario VALUES ("36","3","15","864");
INSERT INTO Inventario VALUES ("37","3","16","1143");
INSERT INTO Inventario VALUES ("38","3","17","1027");
INSERT INTO Inventario VALUES ("39","3","18","1220");
INSERT INTO Inventario VALUES ("40","3","19","1124");
INSERT INTO Inventario VALUES ("41","3","20","224");
INSERT INTO Inventario VALUES ("42","3","21","53");
INSERT INTO Inventario VALUES ("43","3","22","119");
INSERT INTO Inventario VALUES ("44","3","23","0");
INSERT INTO Inventario VALUES ("45","3","24","0");
INSERT INTO Inventario VALUES ("46","4","7","1368");
INSERT INTO Inventario VALUES ("47","4","9","1073");
INSERT INTO Inventario VALUES ("48","4","11","1007");
INSERT INTO Inventario VALUES ("49","4","13","940");
INSERT INTO Inventario VALUES ("50","4","14","640");
INSERT INTO Inventario VALUES ("51","4","15","420");
INSERT INTO Inventario VALUES ("52","4","16","357");
INSERT INTO Inventario VALUES ("53","4","17","198");
INSERT INTO Inventario VALUES ("54","4","18","150");
INSERT INTO Inventario VALUES ("55","4","19","86");
INSERT INTO Inventario VALUES ("56","4","20","133");
INSERT INTO Inventario VALUES ("57","4","21","92");
INSERT INTO Inventario VALUES ("58","4","22","114");
INSERT INTO Inventario VALUES ("59","4","23","101");
INSERT INTO Inventario VALUES ("60","4","24","0");
INSERT INTO Inventario VALUES ("61","5","7","93");
INSERT INTO Inventario VALUES ("62","5","9","84");
INSERT INTO Inventario VALUES ("63","5","11","95");
INSERT INTO Inventario VALUES ("64","5","13","0");
INSERT INTO Inventario VALUES ("65","5","14","0");
INSERT INTO Inventario VALUES ("66","5","15","0");
INSERT INTO Inventario VALUES ("67","5","16","1");
INSERT INTO Inventario VALUES ("68","5","17","33");
INSERT INTO Inventario VALUES ("69","5","18","0");
INSERT INTO Inventario VALUES ("70","5","19","0");
INSERT INTO Inventario VALUES ("71","5","20","0");
INSERT INTO Inventario VALUES ("72","5","21","0");
INSERT INTO Inventario VALUES ("73","5","22","0");
INSERT INTO Inventario VALUES ("74","5","23","0");
INSERT INTO Inventario VALUES ("75","5","24","0");
INSERT INTO Inventario VALUES ("76","6","26","292");
INSERT INTO Inventario VALUES ("77","6","27","155");
INSERT INTO Inventario VALUES ("78","6","28","89");
INSERT INTO Inventario VALUES ("79","6","29","78");
INSERT INTO Inventario VALUES ("80","6","30","21");
INSERT INTO Inventario VALUES ("81","6","31","126");
INSERT INTO Inventario VALUES ("82","7","26","102");
INSERT INTO Inventario VALUES ("83","7","27","109");
INSERT INTO Inventario VALUES ("84","7","28","66");
INSERT INTO Inventario VALUES ("85","7","29","36");
INSERT INTO Inventario VALUES ("86","7","30","0");
INSERT INTO Inventario VALUES ("87","7","31","0");
INSERT INTO Inventario VALUES ("88","8","26","17");
INSERT INTO Inventario VALUES ("89","8","27","0");
INSERT INTO Inventario VALUES ("90","8","28","0");
INSERT INTO Inventario VALUES ("91","8","29","0");
INSERT INTO Inventario VALUES ("92","8","30","0");
INSERT INTO Inventario VALUES ("93","8","31","1");
INSERT INTO Inventario VALUES ("94","9","26","802");
INSERT INTO Inventario VALUES ("95","9","27","585");
INSERT INTO Inventario VALUES ("96","9","28","1543");
INSERT INTO Inventario VALUES ("97","9","29","756");
INSERT INTO Inventario VALUES ("98","9","30","0");
INSERT INTO Inventario VALUES ("99","9","31","0");
INSERT INTO Inventario VALUES ("100","10","1","162");
INSERT INTO Inventario VALUES ("101","10","2","242");
INSERT INTO Inventario VALUES ("102","10","3","539");
INSERT INTO Inventario VALUES ("103","10","4","488");
INSERT INTO Inventario VALUES ("104","10","5","426");
INSERT INTO Inventario VALUES ("105","10","6","385");
INSERT INTO Inventario VALUES ("106","10","7","394");
INSERT INTO Inventario VALUES ("107","10","8","467");
INSERT INTO Inventario VALUES ("108","10","9","167");
INSERT INTO Inventario VALUES ("109","10","10","82");
INSERT INTO Inventario VALUES ("110","10","11","59");
INSERT INTO Inventario VALUES ("111","10","12","0");
INSERT INTO Inventario VALUES ("112","11","1","0");
INSERT INTO Inventario VALUES ("113","11","2","0");
INSERT INTO Inventario VALUES ("114","11","3","0");
INSERT INTO Inventario VALUES ("115","11","4","0");
INSERT INTO Inventario VALUES ("116","11","5","0");
INSERT INTO Inventario VALUES ("117","11","6","0");
INSERT INTO Inventario VALUES ("118","11","7","0");
INSERT INTO Inventario VALUES ("119","11","8","0");
INSERT INTO Inventario VALUES ("120","11","9","0");
INSERT INTO Inventario VALUES ("121","11","10","0");
INSERT INTO Inventario VALUES ("122","11","11","0");
INSERT INTO Inventario VALUES ("123","11","12","0");
INSERT INTO Inventario VALUES ("124","12","1","13");
INSERT INTO Inventario VALUES ("125","12","2","15");
INSERT INTO Inventario VALUES ("126","12","3","26");
INSERT INTO Inventario VALUES ("127","12","4","0");
INSERT INTO Inventario VALUES ("128","12","5","55");
INSERT INTO Inventario VALUES ("129","12","6","129");
INSERT INTO Inventario VALUES ("130","12","7","57");
INSERT INTO Inventario VALUES ("131","12","8","22");
INSERT INTO Inventario VALUES ("132","12","9","18");
INSERT INTO Inventario VALUES ("133","12","10","0");
INSERT INTO Inventario VALUES ("134","12","11","0");
INSERT INTO Inventario VALUES ("135","12","12","3");
INSERT INTO Inventario VALUES ("136","13","26","4");
INSERT INTO Inventario VALUES ("137","13","27","0");
INSERT INTO Inventario VALUES ("138","13","28","0");
INSERT INTO Inventario VALUES ("139","13","29","0");
INSERT INTO Inventario VALUES ("140","13","30","0");
INSERT INTO Inventario VALUES ("141","13","31","0");
INSERT INTO Inventario VALUES ("142","14","26","0");
INSERT INTO Inventario VALUES ("143","14","27","104");
INSERT INTO Inventario VALUES ("144","14","28","657");
INSERT INTO Inventario VALUES ("145","14","29","393");
INSERT INTO Inventario VALUES ("146","14","30","140");
INSERT INTO Inventario VALUES ("147","14","31","0");
INSERT INTO Inventario VALUES ("148","15","32","134");
INSERT INTO Inventario VALUES ("149","16","32","0");
INSERT INTO Inventario VALUES ("150","17","32","12");
INSERT INTO Inventario VALUES ("151","18","32","1");
INSERT INTO Inventario VALUES ("152","19","26","69");
INSERT INTO Inventario VALUES ("153","19","27","150");
INSERT INTO Inventario VALUES ("154","19","28","150");
INSERT INTO Inventario VALUES ("155","19","29","69");
INSERT INTO Inventario VALUES ("156","19","30","0");
INSERT INTO Inventario VALUES ("157","19","31","0");
INSERT INTO Inventario VALUES ("158","20","32","0");
INSERT INTO Inventario VALUES ("159","21","32","86");
INSERT INTO Inventario VALUES ("160","22","32","713");
INSERT INTO Inventario VALUES ("161","23","28","18");
INSERT INTO Inventario VALUES ("162","24","32","0");
INSERT INTO Inventario VALUES ("163","25","32","0");
INSERT INTO Inventario VALUES ("164","26","32","81");
INSERT INTO Inventario VALUES ("165","27","32","8");
INSERT INTO Inventario VALUES ("166","28","32","0");
INSERT INTO Inventario VALUES ("167","29","32","18");
INSERT INTO Inventario VALUES ("168","30","32","0");
INSERT INTO Inventario VALUES ("169","31","32","95");
INSERT INTO Inventario VALUES ("170","32","32","0");
INSERT INTO Inventario VALUES ("171","33","32","67");
INSERT INTO Inventario VALUES ("172","34","32","1201");
INSERT INTO Inventario VALUES ("173","35","32","0");
INSERT INTO Inventario VALUES ("174","36","32","81");
INSERT INTO Inventario VALUES ("175","37","32","663");
INSERT INTO Inventario VALUES ("176","38","32","288");
INSERT INTO Inventario VALUES ("177","39","32","8");
INSERT INTO Inventario VALUES ("178","40","32","64");
INSERT INTO Inventario VALUES ("179","41","32","80");
INSERT INTO Inventario VALUES ("180","42","32","82");
INSERT INTO Inventario VALUES ("181","43","7","140");
INSERT INTO Inventario VALUES ("182","43","9","4");
INSERT INTO Inventario VALUES ("183","43","11","0");
INSERT INTO Inventario VALUES ("184","43","13","0");
INSERT INTO Inventario VALUES ("185","43","14","0");
INSERT INTO Inventario VALUES ("186","43","15","45");
INSERT INTO Inventario VALUES ("187","43","16","5");
INSERT INTO Inventario VALUES ("188","43","17","0");
INSERT INTO Inventario VALUES ("189","43","18","0");
INSERT INTO Inventario VALUES ("190","43","19","0");
INSERT INTO Inventario VALUES ("191","43","20","0");
INSERT INTO Inventario VALUES ("192","43","21","0");
INSERT INTO Inventario VALUES ("193","43","22","0");
INSERT INTO Inventario VALUES ("194","43","23","0");
INSERT INTO Inventario VALUES ("195","43","24","0");
INSERT INTO Inventario VALUES ("196","44","7","91");
INSERT INTO Inventario VALUES ("197","44","9","70");
INSERT INTO Inventario VALUES ("198","44","11","56");
INSERT INTO Inventario VALUES ("199","44","13","25");
INSERT INTO Inventario VALUES ("200","44","14","54");
INSERT INTO Inventario VALUES ("201","44","15","81");
INSERT INTO Inventario VALUES ("202","44","16","40");
INSERT INTO Inventario VALUES ("203","44","17","15");
INSERT INTO Inventario VALUES ("204","44","18","0");
INSERT INTO Inventario VALUES ("205","44","19","0");
INSERT INTO Inventario VALUES ("206","44","20","0");
INSERT INTO Inventario VALUES ("207","44","21","0");
INSERT INTO Inventario VALUES ("208","44","22","0");
INSERT INTO Inventario VALUES ("209","44","23","0");
INSERT INTO Inventario VALUES ("210","44","24","0");
INSERT INTO Inventario VALUES ("211","45","26","17");
INSERT INTO Inventario VALUES ("212","45","27","0");
INSERT INTO Inventario VALUES ("213","45","28","0");
INSERT INTO Inventario VALUES ("214","45","29","64");
INSERT INTO Inventario VALUES ("215","45","30","101");
INSERT INTO Inventario VALUES ("216","45","31","0");
INSERT INTO Inventario VALUES ("217","46","7","0");
INSERT INTO Inventario VALUES ("218","46","9","0");
INSERT INTO Inventario VALUES ("219","46","11","0");
INSERT INTO Inventario VALUES ("220","46","13","0");
INSERT INTO Inventario VALUES ("221","46","14","0");
INSERT INTO Inventario VALUES ("222","46","15","0");
INSERT INTO Inventario VALUES ("223","46","16","0");
INSERT INTO Inventario VALUES ("224","46","17","0");
INSERT INTO Inventario VALUES ("225","46","18","0");
INSERT INTO Inventario VALUES ("226","46","19","0");
INSERT INTO Inventario VALUES ("227","46","20","0");
INSERT INTO Inventario VALUES ("228","46","21","0");
INSERT INTO Inventario VALUES ("229","46","22","0");
INSERT INTO Inventario VALUES ("230","46","23","0");
INSERT INTO Inventario VALUES ("231","46","24","0");
INSERT INTO Inventario VALUES ("232","47","26","0");
INSERT INTO Inventario VALUES ("233","47","27","0");
INSERT INTO Inventario VALUES ("234","47","28","0");
INSERT INTO Inventario VALUES ("235","47","29","84");
INSERT INTO Inventario VALUES ("236","47","30","91");
INSERT INTO Inventario VALUES ("237","47","31","0");
INSERT INTO Inventario VALUES ("238","48","32","55");
INSERT INTO Inventario VALUES ("239","49","32","405");
INSERT INTO Inventario VALUES ("240","50","32","8");
INSERT INTO Inventario VALUES ("241","51","32","10");
INSERT INTO Inventario VALUES ("242","52","32","10");
INSERT INTO Inventario VALUES ("243","53","32","2000");
INSERT INTO Inventario VALUES ("244","54","7","346");
INSERT INTO Inventario VALUES ("245","54","9","296");
INSERT INTO Inventario VALUES ("246","54","11","267");
INSERT INTO Inventario VALUES ("247","54","13","278");
INSERT INTO Inventario VALUES ("248","54","14","298");
INSERT INTO Inventario VALUES ("249","54","15","165");
INSERT INTO Inventario VALUES ("250","54","16","0");
INSERT INTO Inventario VALUES ("251","54","17","0");
INSERT INTO Inventario VALUES ("252","54","18","0");
INSERT INTO Inventario VALUES ("253","54","19","42");
INSERT INTO Inventario VALUES ("254","54","20","10");
INSERT INTO Inventario VALUES ("255","54","21","0");
INSERT INTO Inventario VALUES ("256","54","22","0");
INSERT INTO Inventario VALUES ("257","54","23","0");
INSERT INTO Inventario VALUES ("258","54","24","0");
INSERT INTO Inventario VALUES ("259","55","26","380");
INSERT INTO Inventario VALUES ("260","55","27","251");
INSERT INTO Inventario VALUES ("261","55","28","101");
INSERT INTO Inventario VALUES ("262","55","29","147");
INSERT INTO Inventario VALUES ("263","55","30","0");
INSERT INTO Inventario VALUES ("264","55","31","0");
INSERT INTO Inventario VALUES ("265","56","32","0");
INSERT INTO Inventario VALUES ("266","57","7","0");
INSERT INTO Inventario VALUES ("267","57","9","0");
INSERT INTO Inventario VALUES ("268","57","11","0");
INSERT INTO Inventario VALUES ("269","57","13","0");
INSERT INTO Inventario VALUES ("270","57","14","502");
INSERT INTO Inventario VALUES ("271","57","15","300");
INSERT INTO Inventario VALUES ("272","57","16","436");
INSERT INTO Inventario VALUES ("273","57","17","243");
INSERT INTO Inventario VALUES ("274","57","18","163");
INSERT INTO Inventario VALUES ("275","57","19","42");
INSERT INTO Inventario VALUES ("276","57","20","56");
INSERT INTO Inventario VALUES ("277","57","21","0");
INSERT INTO Inventario VALUES ("278","57","22","0");
INSERT INTO Inventario VALUES ("279","57","23","0");
INSERT INTO Inventario VALUES ("280","57","24","0");
INSERT INTO Inventario VALUES ("281","58","26","0");
INSERT INTO Inventario VALUES ("282","58","27","5");
INSERT INTO Inventario VALUES ("283","58","28","0");
INSERT INTO Inventario VALUES ("284","58","29","0");
INSERT INTO Inventario VALUES ("285","58","30","0");
INSERT INTO Inventario VALUES ("286","58","31","0");
INSERT INTO Inventario VALUES ("287","59","26","125");
INSERT INTO Inventario VALUES ("288","59","27","142");
INSERT INTO Inventario VALUES ("289","59","28","199");
INSERT INTO Inventario VALUES ("290","59","29","36");
INSERT INTO Inventario VALUES ("291","59","30","0");
INSERT INTO Inventario VALUES ("292","59","31","0");
INSERT INTO Inventario VALUES ("293","60","32","0");
INSERT INTO Inventario VALUES ("294","64","13","42");
INSERT INTO Inventario VALUES ("295","64","14","115");
INSERT INTO Inventario VALUES ("296","64","15","97");
INSERT INTO Inventario VALUES ("297","64","16","24");

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `EntradaE`
INSERT INTO EntradaE VALUES ("5","2024-11-28 10:32:46","2024-11-28 10:35:06","1","6","juan carlos de la cruz ","yessica heracleo","entrega personal del proveedor fedex","Modificado");
INSERT INTO EntradaE VALUES ("6","2024-12-02 15:49:19","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","Entrega de 200 pares de bota tactica","Creada");
INSERT INTO EntradaE VALUES ("7","2024-12-02 15:51:31","","","6","CHARBEL","EQUIPO ALMACEN","Entrega de chamarra cazadora, la trajo beto","Creada");
INSERT INTO EntradaE VALUES ("8","2024-12-02 15:57:43","","","6","ARTE GRAFICO","EQUIPO ALMACEN","Entrega de blocks, asistencia diaria","Creada");
INSERT INTO EntradaE VALUES ("9","2024-12-02 16:01:50","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","Primer entrega de nuevo pedido de botas por 2500 pares, entregan 150 pares \n22/11/2024","Creada");
INSERT INTO EntradaE VALUES ("10","2024-12-02 16:04:45","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","Entrega de botas 200 pares","Creada");
INSERT INTO EntradaE VALUES ("11","2024-12-03 13:27:54","","","6","Floraly","EQUIPO ALMACEN","Entrega de nueva camisa, con logo de multisistemas uribe","Creada");
INSERT INTO EntradaE VALUES ("12","2024-12-05 15:25:44","","","6","FLORALY","EQUIPO ALMACEN","Entrega de 157 pz de camisa manga corta Pryse","Creada");
INSERT INTO EntradaE VALUES ("13","2024-12-06 16:56:14","","","6","FLORALY","EQUIPO ALMACEN","Entrega de sueter para aeropuerto","Creada");
INSERT INTO EntradaE VALUES ("14","2024-12-10 10:38:59","","","6","FLORALY","EQUIPO ALMACEN","Entrega de sueter aeropuerto","Creada");
INSERT INTO EntradaE VALUES ("15","2024-12-10 10:40:49","","","6","FLORALY","EQUIPO ALMACEN","Entrega de sueter ","Creada");
INSERT INTO EntradaE VALUES ("16","2024-12-10 10:46:31","","","6","FLORALY","EQUIPO ALMACEN","Entrega de uniformes por flor","Creada");

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
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `EntradaD`
INSERT INTO EntradaD VALUES ("23","5","10","3","30");
INSERT INTO EntradaD VALUES ("24","5","10","1","5");
INSERT INTO EntradaD VALUES ("25","5","10","5","10");
INSERT INTO EntradaD VALUES ("26","5","10","7","45");
INSERT INTO EntradaD VALUES ("27","5","10","8","55");
INSERT INTO EntradaD VALUES ("28","5","10","9","30");
INSERT INTO EntradaD VALUES ("29","5","10","10","5");
INSERT INTO EntradaD VALUES ("30","5","10","11","5");
INSERT INTO EntradaD VALUES ("31","6","10","1","5");
INSERT INTO EntradaD VALUES ("32","6","10","3","30");
INSERT INTO EntradaD VALUES ("33","6","10","5","10");
INSERT INTO EntradaD VALUES ("34","6","10","6","15");
INSERT INTO EntradaD VALUES ("35","6","10","7","45");
INSERT INTO EntradaD VALUES ("36","6","10","8","55");
INSERT INTO EntradaD VALUES ("37","6","10","9","30");
INSERT INTO EntradaD VALUES ("38","6","10","10","5");
INSERT INTO EntradaD VALUES ("39","6","10","11","5");
INSERT INTO EntradaD VALUES ("40","7","9","29","770");
INSERT INTO EntradaD VALUES ("41","8","41","32","70");
INSERT INTO EntradaD VALUES ("42","9","10","3","40");
INSERT INTO EntradaD VALUES ("43","9","10","4","5");
INSERT INTO EntradaD VALUES ("44","9","10","6","10");
INSERT INTO EntradaD VALUES ("45","9","10","7","15");
INSERT INTO EntradaD VALUES ("46","9","10","8","40");
INSERT INTO EntradaD VALUES ("47","9","10","9","10");
INSERT INTO EntradaD VALUES ("48","9","10","11","5");
INSERT INTO EntradaD VALUES ("49","9","10","2","25");
INSERT INTO EntradaD VALUES ("50","10","10","3","25");
INSERT INTO EntradaD VALUES ("51","10","10","4","60");
INSERT INTO EntradaD VALUES ("52","10","10","5","20");
INSERT INTO EntradaD VALUES ("53","10","10","6","5");
INSERT INTO EntradaD VALUES ("54","10","10","7","30");
INSERT INTO EntradaD VALUES ("55","10","10","8","30");
INSERT INTO EntradaD VALUES ("56","10","10","9","20");
INSERT INTO EntradaD VALUES ("57","10","10","11","10");
INSERT INTO EntradaD VALUES ("58","11","64","13","42");
INSERT INTO EntradaD VALUES ("59","11","64","14","115");
INSERT INTO EntradaD VALUES ("60","11","64","15","97");
INSERT INTO EntradaD VALUES ("61","11","64","16","24");
INSERT INTO EntradaD VALUES ("62","12","3","14","50");
INSERT INTO EntradaD VALUES ("63","12","3","15","24");
INSERT INTO EntradaD VALUES ("64","12","3","19","25");
INSERT INTO EntradaD VALUES ("65","12","3","20","15");
INSERT INTO EntradaD VALUES ("66","12","3","21","18");
INSERT INTO EntradaD VALUES ("67","12","3","22","25");
INSERT INTO EntradaD VALUES ("68","13","59","26","89");
INSERT INTO EntradaD VALUES ("69","13","59","27","96");
INSERT INTO EntradaD VALUES ("70","13","59","28","166");
INSERT INTO EntradaD VALUES ("71","14","59","27","46");
INSERT INTO EntradaD VALUES ("72","14","59","28","13");
INSERT INTO EntradaD VALUES ("73","15","59","26","36");
INSERT INTO EntradaD VALUES ("74","15","59","28","10");
INSERT INTO EntradaD VALUES ("75","15","59","29","36");
INSERT INTO EntradaD VALUES ("76","16","59","28","10");
INSERT INTO EntradaD VALUES ("77","16","4","13","38");
INSERT INTO EntradaD VALUES ("78","16","4","14","38");
INSERT INTO EntradaD VALUES ("79","16","3","14","44");
INSERT INTO EntradaD VALUES ("80","16","3","15","26");
INSERT INTO EntradaD VALUES ("81","16","3","16","25");
INSERT INTO EntradaD VALUES ("82","16","3","20","38");
INSERT INTO EntradaD VALUES ("83","16","3","21","35");
INSERT INTO EntradaD VALUES ("84","16","3","22","1");

-- Table structure for table `RequisicionE`
CREATE TABLE `RequisicionE` (
  `IDRequisicionE` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) DEFAULT NULL,
  `FchCreacion` datetime NOT NULL,
  `FchAutoriza` datetime DEFAULT NULL,
  `Estatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Supervisor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `IdCuenta` int(11) DEFAULT NULL,
  `IdRegion` int(11) DEFAULT NULL,
  `CentroTrabajo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NroElementos` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
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
  KEY `IdCuenta` (`IdCuenta`),
  KEY `IdRegion` (`IdRegion`),
  KEY `IdEstado` (`IdEstado`),
  CONSTRAINT `RequisicionE_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`ID_Usuario`),
  CONSTRAINT `RequisicionE_ibfk_2` FOREIGN KEY (`IdCuenta`) REFERENCES `Cuenta` (`ID`),
  CONSTRAINT `RequisicionE_ibfk_3` FOREIGN KEY (`IdRegion`) REFERENCES `Regiones` (`ID_Region`),
  CONSTRAINT `RequisicionE_ibfk_4` FOREIGN KEY (`IdEstado`) REFERENCES `Estados` (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `RequisicionE`
INSERT INTO RequisicionE VALUES ("8","20","2024-11-29 13:05:40","2024-11-29 13:06:23","Parcial","Gustavo Rascon Evans","9","41","Varios","","Karla Edith Fontes Navarro","6624508810","FOLK860804BJ7","Doteción de uniformes para nuevo contrato","26","Hermosillo","Nueva Galicia","Nueva Esperanza","41","83245");
INSERT INTO RequisicionE VALUES ("9","20","2024-11-29 13:30:41","2024-12-03 18:02:25","Surtido","YADIRA GARCIA PEREZ","9","43","CENTENARIO","","YADIRA GARCIA PEREZ","777 565 4094","","DOTACION DE LISTAS DE ASISTENCIA, CUADRICULAS Y NOVEDADES","17","","","","","");
INSERT INTO RequisicionE VALUES ("10","21","2024-11-29 13:49:53","2024-11-29 13:52:00","Parcial","Edgar Acosta Escariaga","10","45","Varios","","Edgar Acosta Escariaga","6645205086","AOEE820107JI7","Solicitud por el jefe de conservación y contratos, para no afectar la penalización en la factura.","2","Castores Ocurre Mexicalli","Castores Ocurre Mexicalli","Castores Ocurre Mexicalli","0","21399");
INSERT INTO RequisicionE VALUES ("11","26","2024-12-04 09:41:37","2024-12-05 12:02:11","Autorizado","LEONARDO PATIÑO","11","56","FONATUR ARMADOS","","LEONARDO PATIÑO","5576887600","","PARA AUDITORIA","9","","","","","");
INSERT INTO RequisicionE VALUES ("12","23","2024-12-04 13:46:42","2024-12-04 13:48:32","Parcial","Martha Guadalupe Santiago Barron","7","52","Plaza de Cobro No. 195 \"Aeropuerto los Cabos\"","","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO RequisicionE VALUES ("13","23","2024-12-04 14:29:54","2024-12-04 14:31:25","Parcial","Edgar Ramon Cazares Palacios","7","52","Campamento de Conservación, \"Ensenada\"","","Edgar Ramon Cazares Palacios","6241380989","CAPE8501096KA","Reposición de uniformes y equipo por deterioro, ultimo envio 29/07/2024","2","Ensenada","Maestros","Avenida Ignacio Altamirano","2040","22840");
INSERT INTO RequisicionE VALUES ("14","23","2024-12-04 14:30:01","2024-12-04 14:31:31","Parcial","Edgar Ramon Cazares Palacios","7","52","Plaza de Cobro No. 36 \"Ensenada\"",""," Edgar Ramon Cazares Palacios","6241380989","CAPE8501096KA","Reposición de uniformes y equipo de deterioro, ultimo envío 29/07/2024","2","Ensenada","Maestros","Avenida Ignacio Altamirano","2040","22840");
INSERT INTO RequisicionE VALUES ("15","23","2024-12-04 14:30:08","2024-12-04 14:31:43","Surtido","Martha Guadalupe Santiago Barron","7","52","Plaza de Cobro No. 195 ","","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Solicitud de botas, se le descuentan a los elementos via nomina","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO RequisicionE VALUES ("16","23","2024-12-04 14:30:14","2024-12-04 14:31:17","Parcial","Martha Guadalupe Santiago Barron","7","52","Plaza de Cobro No. 197 \"El Mangle\"","","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO RequisicionE VALUES ("17","23","2024-12-04 14:30:19","2024-12-04 14:31:13","Surtido","Martha Guadalupe Santiago Barron","7","52","Plaza de Cobro No. 196 \"San Lucas\"","","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO RequisicionE VALUES ("18","23","2024-12-04 14:30:24","2024-12-04 14:31:09","Parcial","Martha Guadalupe Santiago Barron","7","52","Plaza de Cobro No. 86 \"San José del Cabo\"","","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO RequisicionE VALUES ("19","23","2024-12-04 14:30:31","2024-12-04 18:05:07","Parcial","Martha Guadalupe Santiago Barron","7","52","Campamento de Conservación, \"San Jose del Cabo","","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO RequisicionE VALUES ("21","22","2024-12-05 12:17:40","2024-12-05 12:22:08","Surtido","Gustavo Nuñez","7","54","PC 4 Tepotzotlan","","Gustavo Nuñez","5540553118","","Se solicita nueva dotación parcial del chalecos reflejantes debido a que los que tienen ya están desgastados, el ultimo requerimiento se mando en marzo 2024. Supervisor pasa a la bodega el 06/12/2024","15","","","","","");
INSERT INTO RequisicionE VALUES ("22","23","2024-12-06 12:16:54","","Pendiente","Héctor Alfonso Luján Floriano","7","53","Residencia de Conservación Bermejillo","","Héctor Alfonso Luján Floriano","8713855411","LUFH821030JJ3","Reposición de uniformes y equipo por desgaste, equipo 10-04-24 y uniformes 04-10-24.","7","Torreón","Residencial del Norte","Opalo ","81","27274");
INSERT INTO RequisicionE VALUES ("23","23","2024-12-06 12:17:20","","Pendiente","Héctor Alfonso Luján Floriano","7","53","Parador La Carbonera","","Héctor Alfonso Luján Floriano","8713855411","LUFH821030JJ3","Reposición de uniformes y equipo por desgaste, equipo 10-04-24 y uniformes 04-10-24.","7","Torreón","Residencial del Norte","Opalo ","81","27274");
INSERT INTO RequisicionE VALUES ("24","23","2024-12-06 12:17:35","","Pendiente","Héctor Alfonso Luján Floriano","7","53","Plazas de Cobro No. 160 Bermejillos","","Héctor Alfonso Luján Floriano","8713855411","LUFH821030JJ3","Reposición de uniformes y equipo por desgaste, equipo 10-04-24 y uniformes 04-10-24.","10","Torreón","Residencial del Norte","Opalo ","81","27274");
INSERT INTO RequisicionE VALUES ("25","23","2024-12-06 12:17:58","","Pendiente","Héctor Alfonso Luján Floriano","7","53","Plazas de Cobro 161 Ceballos","","Héctor Alfonso Luján Floriano","8713855411","LUFH821030JJ3","Reposición de uniformes y equipo por desgaste, último envío de uniformes 04-10-24 y de equipo 10-04-24.","10","Torreón","Residencial del Norte","Opalo ","81","27274");
INSERT INTO RequisicionE VALUES ("31","23","2024-12-09 00:14:55","","Pendiente","Efrain Hernandez Sanchez","7","53","Plazas de Cobro No. 140 La Carbonera","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("32","23","2024-12-09 00:16:28","2024-12-10 13:07:48","Autorizado","Efrain Hernandez Sanchez","7","53","Parador La Carbonera","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez. ","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("33","23","2024-12-09 09:53:54","","Pendiente","Efrain Hernandez Sanchez","7","53","Plazas de Cobro No. 162 Plan de Ayala","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("34","23","2024-12-09 09:57:18","2024-12-10 13:07:28","Autorizado","Efrain Hernandez Sanchez","7","53","Residencia de Conservación de la Cuchilla","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("35","23","2024-12-09 10:12:09","2024-12-10 13:06:57","Autorizado","Efrain Hernandez Sanchez","7","53","Plazas de Cobro No. 141 Los Chorros","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("36","23","2024-12-09 10:16:19","2024-12-10 13:03:27","Autorizado","Efrain Hernandez Sanchez","7","53","Almacen Los Chorros","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("37","23","2024-12-09 10:25:39","2024-12-10 13:03:08","Autorizado","Efrain Hernandez Sanchez","7","53","Residencia de Conservación Plan de Ayala","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("38","23","2024-12-09 10:37:09","2024-12-10 13:03:01","Autorizado","Efrain Hernandez Sanchez","7","53","Oficinas de la Unidad Regional Saltillo","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("39","23","2024-12-09 10:59:34","2024-12-12 11:00:22","Autorizado","Efrain Hernandez Sanchez","7","53","Plazas de Cobro No. 142 Huachichil","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("40","23","2024-12-09 11:11:40","2024-12-10 13:02:42","Autorizado","Efrain Hernandez Sanchez","7","53","Plazas de Cobro No. 163 La Cuchilla","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("41","31","2024-12-10 11:59:09","2024-12-10 11:59:31","Parcial","Gabriel Reyes Garces","12","58","T2 AICM","1180","Julian Suarez Tovar","5536525342","SUTJ700908S16","Se hace requerimiento por la entrega de botas a elementos con un año laborando","9","VENUSTIANO CARRANZA","AVIACION CIVIL","ROLANDO GARROS","131","9210");
INSERT INTO RequisicionE VALUES ("42","4","2024-12-12 10:04:41","2024-12-12 10:59:56","Autorizado","Yvan Islas","1","10","","2","De la Cruz Velázquez Yessenia","9333277968","CUVY840803BH2","Se solicita uniforme para elemento de nuevo ingreso, ya que no tiene uniforme","27","Comalcalco","Ria Jose Ma Pino Suarez 3ra Sección","Loc Pino Suarez","S/N","86640");
INSERT INTO RequisicionE VALUES ("43","25","2024-12-12 10:53:24","","Pendiente","Angel Bazan","7","49","pc 59 oaxtepec","50","Angel Bazan","5528169856","","se solicitan uniformes por deterioro, ultima requisición 24-11-23 \n(pasan por ellos), se solicita autorización por cambio de chamarra a tipo cazadora ya que no hay en almacén, lo anterior es para evitar deductivas por parte de CAPUFE ","17","","","","","");
INSERT INTO RequisicionE VALUES ("44","25","2024-12-12 10:56:49","2024-12-12 11:02:02","Autorizado","Angel Bazan","7","49","PC 24 TEPOZTLAN","20","Angel Bazan","5528169856","","se solicitan chamarras por deterioro, ultima requisición 12 de noviembre del 2023 y uniformes para nuevos ingresos. (pasan por ellos)se solicita autorización por cambio de chamarra a tipo cazadora ya que no hay en almacén, lo anterior es para evitar ","17","","","","","");
INSERT INTO RequisicionE VALUES ("45","25","2024-12-12 11:19:27","","Pendiente","Angel Bazan","7","49","Pc 191 Ixtapaluca","14","Angel Bazan","5528169856","","se solicitan uniformes por deterioro y nuevos ingresos, ultima requisición diciembre del 2023. (Pasan por ellos) se solicita autorización por cambio de chamarra a tipo cazadora ya que no hay en almacén, lo anterior es para evitar deductivas por parte","17","","","","","");
INSERT INTO RequisicionE VALUES ("46","25","2024-12-12 11:20:02","","Pendiente","Angel Bazan","7","49","Pc 25 Oacalco","20","Angel Bazan","5528169856","","se solicitan chamarras por deterioro, ultima requisición 22 de noviembre del 2023. (Pasan por ellos) se solicita autorización por cambio de chamarra a tipo cazadora ya que no hay en almacén, lo anterior es para evitar deductivas por parte de CAPUFE","17","","","","","");
INSERT INTO RequisicionE VALUES ("47","25","2024-12-12 11:24:40","","Pendiente","Angel Bazan","7","49","Pc 184 Francisco Duran","20","Angel Bazan","5528169856","","se solicitan chamarras por deterioro, ultima requisición 14-01-24, se solicita autorización por cambio de chamarra a tipo cazadora ya que no hay en almacén, lo anterior es para evitar deductivas por parte de CAPUFE pasan por ellas.","17","","","","","");

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
) ENGINE=InnoDB AUTO_INCREMENT=320 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `RequisicionD`
INSERT INTO RequisicionD VALUES ("12","8","4","11","6");
INSERT INTO RequisicionD VALUES ("13","8","4","13","10");
INSERT INTO RequisicionD VALUES ("14","8","4","14","10");
INSERT INTO RequisicionD VALUES ("15","8","4","15","10");
INSERT INTO RequisicionD VALUES ("16","8","4","16","6");
INSERT INTO RequisicionD VALUES ("17","8","4","17","4");
INSERT INTO RequisicionD VALUES ("18","8","4","18","4");
INSERT INTO RequisicionD VALUES ("19","8","4","19","3");
INSERT INTO RequisicionD VALUES ("20","8","4","21","2");
INSERT INTO RequisicionD VALUES ("21","8","3","13","8");
INSERT INTO RequisicionD VALUES ("22","8","3","14","8");
INSERT INTO RequisicionD VALUES ("23","8","3","15","10");
INSERT INTO RequisicionD VALUES ("24","8","3","16","10");
INSERT INTO RequisicionD VALUES ("25","8","3","17","8");
INSERT INTO RequisicionD VALUES ("26","8","3","18","4");
INSERT INTO RequisicionD VALUES ("27","8","3","19","4");
INSERT INTO RequisicionD VALUES ("28","8","3","21","3");
INSERT INTO RequisicionD VALUES ("29","8","23","28","35");
INSERT INTO RequisicionD VALUES ("30","8","20","32","55");
INSERT INTO RequisicionD VALUES ("31","8","30","32","10");
INSERT INTO RequisicionD VALUES ("32","8","36","32","25");
INSERT INTO RequisicionD VALUES ("33","8","31","32","10");
INSERT INTO RequisicionD VALUES ("34","9","40","32","5");
INSERT INTO RequisicionD VALUES ("35","9","41","32","7");
INSERT INTO RequisicionD VALUES ("36","9","42","32","4");
INSERT INTO RequisicionD VALUES ("37","10","8","29","10");
INSERT INTO RequisicionD VALUES ("38","10","8","30","20");
INSERT INTO RequisicionD VALUES ("39","10","8","31","5");
INSERT INTO RequisicionD VALUES ("40","10","3","16","10");
INSERT INTO RequisicionD VALUES ("41","10","3","17","10");
INSERT INTO RequisicionD VALUES ("42","11","11","6","2");
INSERT INTO RequisicionD VALUES ("43","11","29","32","2");
INSERT INTO RequisicionD VALUES ("44","12","9","29","3");
INSERT INTO RequisicionD VALUES ("45","12","9","28","3");
INSERT INTO RequisicionD VALUES ("46","12","4","14","2");
INSERT INTO RequisicionD VALUES ("47","12","37","32","1");
INSERT INTO RequisicionD VALUES ("48","12","30","32","5");
INSERT INTO RequisicionD VALUES ("49","12","10","8","1");
INSERT INTO RequisicionD VALUES ("50","12","10","6","1");
INSERT INTO RequisicionD VALUES ("51","13","3","15","1");
INSERT INTO RequisicionD VALUES ("52","13","3","16","1");
INSERT INTO RequisicionD VALUES ("53","13","3","18","1");
INSERT INTO RequisicionD VALUES ("54","13","4","15","2");
INSERT INTO RequisicionD VALUES ("55","13","4","18","1");
INSERT INTO RequisicionD VALUES ("56","13","20","32","4");
INSERT INTO RequisicionD VALUES ("57","14","4","16","2");
INSERT INTO RequisicionD VALUES ("58","14","4","15","3");
INSERT INTO RequisicionD VALUES ("59","14","4","14","3");
INSERT INTO RequisicionD VALUES ("60","14","4","13","5");
INSERT INTO RequisicionD VALUES ("61","14","3","19","2");
INSERT INTO RequisicionD VALUES ("62","14","3","16","4");
INSERT INTO RequisicionD VALUES ("63","14","3","15","4");
INSERT INTO RequisicionD VALUES ("64","14","3","14","3");
INSERT INTO RequisicionD VALUES ("65","14","37","32","3");
INSERT INTO RequisicionD VALUES ("66","14","20","32","8");
INSERT INTO RequisicionD VALUES ("67","15","10","6","4");
INSERT INTO RequisicionD VALUES ("68","16","9","28","3");
INSERT INTO RequisicionD VALUES ("69","16","9","29","3");
INSERT INTO RequisicionD VALUES ("70","16","37","32","2");
INSERT INTO RequisicionD VALUES ("71","16","30","32","5");
INSERT INTO RequisicionD VALUES ("72","16","10","7","1");
INSERT INTO RequisicionD VALUES ("73","17","9","29","3");
INSERT INTO RequisicionD VALUES ("74","17","9","28","3");
INSERT INTO RequisicionD VALUES ("75","17","4","14","2");
INSERT INTO RequisicionD VALUES ("76","17","3","14","2");
INSERT INTO RequisicionD VALUES ("77","17","37","32","1");
INSERT INTO RequisicionD VALUES ("78","17","10","7","2");
INSERT INTO RequisicionD VALUES ("79","17","10","8","1");
INSERT INTO RequisicionD VALUES ("80","18","9","29","3");
INSERT INTO RequisicionD VALUES ("81","18","9","28","3");
INSERT INTO RequisicionD VALUES ("82","18","37","32","1");
INSERT INTO RequisicionD VALUES ("83","18","30","32","5");
INSERT INTO RequisicionD VALUES ("84","18","10","6","1");
INSERT INTO RequisicionD VALUES ("85","19","10","6","1");
INSERT INTO RequisicionD VALUES ("86","19","30","32","5");
INSERT INTO RequisicionD VALUES ("87","19","37","32","1");
INSERT INTO RequisicionD VALUES ("88","19","3","15","2");
INSERT INTO RequisicionD VALUES ("89","19","9","29","2");
INSERT INTO RequisicionD VALUES ("91","21","55","26","15");
INSERT INTO RequisicionD VALUES ("92","21","55","28","40");
INSERT INTO RequisicionD VALUES ("93","21","55","29","15");
INSERT INTO RequisicionD VALUES ("94","22","4","13","2");
INSERT INTO RequisicionD VALUES ("95","22","3","13","2");
INSERT INTO RequisicionD VALUES ("96","22","9","27","2");
INSERT INTO RequisicionD VALUES ("97","22","9","28","2");
INSERT INTO RequisicionD VALUES ("98","22","18","32","2");
INSERT INTO RequisicionD VALUES ("99","22","31","32","2");
INSERT INTO RequisicionD VALUES ("100","22","20","32","4");
INSERT INTO RequisicionD VALUES ("101","22","21","32","2");
INSERT INTO RequisicionD VALUES ("102","22","37","32","2");
INSERT INTO RequisicionD VALUES ("103","23","3","15","4");
INSERT INTO RequisicionD VALUES ("104","23","3","16","2");
INSERT INTO RequisicionD VALUES ("105","23","4","14","3");
INSERT INTO RequisicionD VALUES ("106","23","4","15","3");
INSERT INTO RequisicionD VALUES ("107","23","9","28","4");
INSERT INTO RequisicionD VALUES ("108","23","9","27","4");
INSERT INTO RequisicionD VALUES ("109","23","18","32","4");
INSERT INTO RequisicionD VALUES ("110","23","31","32","4");
INSERT INTO RequisicionD VALUES ("111","23","20","32","8");
INSERT INTO RequisicionD VALUES ("112","23","21","32","4");
INSERT INTO RequisicionD VALUES ("113","23","37","32","4");
INSERT INTO RequisicionD VALUES ("114","24","4","13","1");
INSERT INTO RequisicionD VALUES ("115","24","4","15","2");
INSERT INTO RequisicionD VALUES ("116","24","4","17","2");
INSERT INTO RequisicionD VALUES ("117","24","4","19","2");
INSERT INTO RequisicionD VALUES ("118","24","3","13","1");
INSERT INTO RequisicionD VALUES ("119","24","3","15","1");
INSERT INTO RequisicionD VALUES ("120","24","3","17","1");
INSERT INTO RequisicionD VALUES ("121","24","3","19","1");
INSERT INTO RequisicionD VALUES ("122","24","18","32","5");
INSERT INTO RequisicionD VALUES ("123","24","31","32","5");
INSERT INTO RequisicionD VALUES ("124","24","20","32","10");
INSERT INTO RequisicionD VALUES ("125","24","21","32","5");
INSERT INTO RequisicionD VALUES ("126","24","37","32","5");
INSERT INTO RequisicionD VALUES ("127","24","9","28","4");
INSERT INTO RequisicionD VALUES ("128","24","9","26","2");
INSERT INTO RequisicionD VALUES ("129","24","9","30","4");
INSERT INTO RequisicionD VALUES ("130","25","18","32","5");
INSERT INTO RequisicionD VALUES ("131","25","31","32","5");
INSERT INTO RequisicionD VALUES ("132","25","20","32","10");
INSERT INTO RequisicionD VALUES ("133","25","21","32","5");
INSERT INTO RequisicionD VALUES ("134","25","37","32","5");
INSERT INTO RequisicionD VALUES ("135","25","4","13","1");
INSERT INTO RequisicionD VALUES ("136","25","4","17","1");
INSERT INTO RequisicionD VALUES ("137","25","4","19","1");
INSERT INTO RequisicionD VALUES ("138","25","3","13","1");
INSERT INTO RequisicionD VALUES ("139","25","4","15","1");
INSERT INTO RequisicionD VALUES ("140","25","3","15","1");
INSERT INTO RequisicionD VALUES ("141","25","3","17","1");
INSERT INTO RequisicionD VALUES ("142","25","3","19","1");
INSERT INTO RequisicionD VALUES ("143","25","9","28","4");
INSERT INTO RequisicionD VALUES ("144","25","9","26","2");
INSERT INTO RequisicionD VALUES ("145","25","9","30","4");
INSERT INTO RequisicionD VALUES ("182","31","9","26","2");
INSERT INTO RequisicionD VALUES ("183","31","9","27","8");
INSERT INTO RequisicionD VALUES ("184","31","9","28","7");
INSERT INTO RequisicionD VALUES ("185","31","9","29","2");
INSERT INTO RequisicionD VALUES ("186","31","3","16","2");
INSERT INTO RequisicionD VALUES ("187","31","3","14","1");
INSERT INTO RequisicionD VALUES ("188","31","3","13","1");
INSERT INTO RequisicionD VALUES ("189","31","3","15","1");
INSERT INTO RequisicionD VALUES ("190","31","20","32","5");
INSERT INTO RequisicionD VALUES ("191","31","4","13","2");
INSERT INTO RequisicionD VALUES ("192","31","4","15","2");
INSERT INTO RequisicionD VALUES ("193","31","4","14","1");
INSERT INTO RequisicionD VALUES ("194","31","37","32","7");
INSERT INTO RequisicionD VALUES ("195","31","22","32","8");
INSERT INTO RequisicionD VALUES ("196","32","9","28","2");
INSERT INTO RequisicionD VALUES ("197","32","9","27","1");
INSERT INTO RequisicionD VALUES ("198","32","9","29","1");
INSERT INTO RequisicionD VALUES ("199","33","9","28","3");
INSERT INTO RequisicionD VALUES ("200","33","9","27","3");
INSERT INTO RequisicionD VALUES ("201","33","9","26","2");
INSERT INTO RequisicionD VALUES ("202","33","3","13","1");
INSERT INTO RequisicionD VALUES ("203","33","3","15","2");
INSERT INTO RequisicionD VALUES ("204","33","3","14","1");
INSERT INTO RequisicionD VALUES ("205","33","3","16","1");
INSERT INTO RequisicionD VALUES ("206","33","4","13","2");
INSERT INTO RequisicionD VALUES ("207","33","4","14","3");
INSERT INTO RequisicionD VALUES ("208","33","20","32","5");
INSERT INTO RequisicionD VALUES ("209","33","22","32","5");
INSERT INTO RequisicionD VALUES ("210","33","37","32","4");
INSERT INTO RequisicionD VALUES ("211","34","9","28","2");
INSERT INTO RequisicionD VALUES ("212","34","9","27","2");
INSERT INTO RequisicionD VALUES ("213","35","9","26","2");
INSERT INTO RequisicionD VALUES ("214","35","9","25","8");
INSERT INTO RequisicionD VALUES ("215","35","9","28","7");
INSERT INTO RequisicionD VALUES ("216","35","9","29","1");
INSERT INTO RequisicionD VALUES ("217","35","9","31","1");
INSERT INTO RequisicionD VALUES ("218","36","9","26","1");
INSERT INTO RequisicionD VALUES ("219","36","9","27","1");
INSERT INTO RequisicionD VALUES ("220","36","9","28","2");
INSERT INTO RequisicionD VALUES ("221","36","22","32","2");
INSERT INTO RequisicionD VALUES ("222","36","37","32","2");
INSERT INTO RequisicionD VALUES ("223","37","9","27","2");
INSERT INTO RequisicionD VALUES ("224","37","9","28","1");
INSERT INTO RequisicionD VALUES ("225","37","9","29","1");
INSERT INTO RequisicionD VALUES ("226","37","3","17","1");
INSERT INTO RequisicionD VALUES ("227","37","4","15","1");
INSERT INTO RequisicionD VALUES ("228","37","20","32","1");
INSERT INTO RequisicionD VALUES ("229","37","22","32","1");
INSERT INTO RequisicionD VALUES ("230","37","37","32","1");
INSERT INTO RequisicionD VALUES ("231","38","9","28","2");
INSERT INTO RequisicionD VALUES ("232","38","9","29","1");
INSERT INTO RequisicionD VALUES ("233","38","9","27","3");
INSERT INTO RequisicionD VALUES ("234","38","3","19","1");
INSERT INTO RequisicionD VALUES ("235","38","3","16","1");
INSERT INTO RequisicionD VALUES ("236","38","4","16","1");
INSERT INTO RequisicionD VALUES ("237","38","4","13","1");
INSERT INTO RequisicionD VALUES ("238","38","22","32","3");
INSERT INTO RequisicionD VALUES ("239","38","37","32","3");
INSERT INTO RequisicionD VALUES ("240","39","9","29","1");
INSERT INTO RequisicionD VALUES ("241","39","9","28","3");
INSERT INTO RequisicionD VALUES ("242","39","3","16","1");
INSERT INTO RequisicionD VALUES ("243","39","4","14","1");
INSERT INTO RequisicionD VALUES ("244","39","37","32","1");
INSERT INTO RequisicionD VALUES ("245","39","22","32","2");
INSERT INTO RequisicionD VALUES ("246","39","20","32","2");
INSERT INTO RequisicionD VALUES ("247","40","9","27","7");
INSERT INTO RequisicionD VALUES ("248","40","9","28","7");
INSERT INTO RequisicionD VALUES ("249","40","9","26","6");
INSERT INTO RequisicionD VALUES ("250","40","9","29","4");
INSERT INTO RequisicionD VALUES ("251","40","3","13","2");
INSERT INTO RequisicionD VALUES ("252","40","3","14","2");
INSERT INTO RequisicionD VALUES ("253","40","3","16","1");
INSERT INTO RequisicionD VALUES ("254","40","4","15","2");
INSERT INTO RequisicionD VALUES ("255","40","4","14","1");
INSERT INTO RequisicionD VALUES ("256","40","4","13","1");
INSERT INTO RequisicionD VALUES ("257","40","4","11","1");
INSERT INTO RequisicionD VALUES ("258","40","37","32","5");
INSERT INTO RequisicionD VALUES ("259","40","20","32","5");
INSERT INTO RequisicionD VALUES ("260","40","22","32","5");
INSERT INTO RequisicionD VALUES ("261","41","10","3","3");
INSERT INTO RequisicionD VALUES ("262","41","10","4","4");
INSERT INTO RequisicionD VALUES ("263","41","10","5","2");
INSERT INTO RequisicionD VALUES ("264","41","10","6","3");
INSERT INTO RequisicionD VALUES ("265","41","10","7","3");
INSERT INTO RequisicionD VALUES ("266","41","54","11","10");
INSERT INTO RequisicionD VALUES ("267","41","54","13","15");
INSERT INTO RequisicionD VALUES ("268","41","54","14","15");
INSERT INTO RequisicionD VALUES ("269","41","54","15","10");
INSERT INTO RequisicionD VALUES ("270","41","54","16","10");
INSERT INTO RequisicionD VALUES ("271","41","54","17","10");
INSERT INTO RequisicionD VALUES ("272","42","3","11","2");
INSERT INTO RequisicionD VALUES ("273","42","4","9","1");
INSERT INTO RequisicionD VALUES ("274","42","8","28","1");
INSERT INTO RequisicionD VALUES ("275","42","10","3","1");
INSERT INTO RequisicionD VALUES ("276","42","20","32","1");
INSERT INTO RequisicionD VALUES ("277","42","21","32","1");
INSERT INTO RequisicionD VALUES ("278","42","22","32","1");
INSERT INTO RequisicionD VALUES ("279","42","24","32","1");
INSERT INTO RequisicionD VALUES ("280","43","3","13","10");
INSERT INTO RequisicionD VALUES ("281","43","3","15","10");
INSERT INTO RequisicionD VALUES ("282","43","3","16","15");
INSERT INTO RequisicionD VALUES ("283","43","4","14","15");
INSERT INTO RequisicionD VALUES ("284","43","4","15","15");
INSERT INTO RequisicionD VALUES ("285","43","4","13","5");
INSERT INTO RequisicionD VALUES ("286","43","9","26","10");
INSERT INTO RequisicionD VALUES ("287","43","9","28","15");
INSERT INTO RequisicionD VALUES ("288","43","9","27","15");
INSERT INTO RequisicionD VALUES ("289","43","18","32","25");
INSERT INTO RequisicionD VALUES ("290","43","20","32","40");
INSERT INTO RequisicionD VALUES ("291","44","4","15","1");
INSERT INTO RequisicionD VALUES ("292","44","4","11","1");
INSERT INTO RequisicionD VALUES ("293","44","3","21","1");
INSERT INTO RequisicionD VALUES ("294","44","3","15","1");
INSERT INTO RequisicionD VALUES ("295","44","9","28","20");
INSERT INTO RequisicionD VALUES ("296","44","20","32","20");
INSERT INTO RequisicionD VALUES ("297","45","20","32","14");
INSERT INTO RequisicionD VALUES ("298","45","22","32","5");
INSERT INTO RequisicionD VALUES ("299","45","3","14","6");
INSERT INTO RequisicionD VALUES ("300","45","3","15","4");
INSERT INTO RequisicionD VALUES ("301","45","3","13","4");
INSERT INTO RequisicionD VALUES ("302","45","4","13","6");
INSERT INTO RequisicionD VALUES ("303","45","4","14","4");
INSERT INTO RequisicionD VALUES ("304","45","4","15","2");
INSERT INTO RequisicionD VALUES ("305","45","10","5","2");
INSERT INTO RequisicionD VALUES ("306","45","10","3","1");
INSERT INTO RequisicionD VALUES ("307","45","10","2","1");
INSERT INTO RequisicionD VALUES ("308","45","9","28","5");
INSERT INTO RequisicionD VALUES ("309","45","9","27","7");
INSERT INTO RequisicionD VALUES ("310","45","9","29","2");
INSERT INTO RequisicionD VALUES ("311","45","40","32","2");
INSERT INTO RequisicionD VALUES ("312","45","41","32","2");
INSERT INTO RequisicionD VALUES ("313","46","9","26","2");
INSERT INTO RequisicionD VALUES ("314","46","9","27","11");
INSERT INTO RequisicionD VALUES ("315","46","9","28","6");
INSERT INTO RequisicionD VALUES ("316","46","9","29","1");
INSERT INTO RequisicionD VALUES ("317","47","9","29","20");
INSERT INTO RequisicionD VALUES ("318","47","40","32","2");
INSERT INTO RequisicionD VALUES ("319","47","42","32","2");

-- Table structure for table `Borrador_RequisicionE`
CREATE TABLE `Borrador_RequisicionE` (
  `BIDRequisicionE` int(11) NOT NULL AUTO_INCREMENT,
  `BIdUsuario` int(11) DEFAULT NULL,
  `BFchCreacion` datetime NOT NULL,
  `BEstatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `BSupervisor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `BIdCuenta` int(11) DEFAULT NULL,
  `BIdRegion` int(11) DEFAULT NULL,
  `BCentroTrabajo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BNroElementos` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
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
  KEY `BIdCuenta` (`BIdCuenta`),
  KEY `BIdRegion` (`BIdRegion`),
  KEY `BIdEstado` (`BIdEstado`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_1` FOREIGN KEY (`BIdUsuario`) REFERENCES `Usuario` (`ID_Usuario`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_2` FOREIGN KEY (`BIdCuenta`) REFERENCES `Cuenta` (`ID`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_3` FOREIGN KEY (`BIdRegion`) REFERENCES `Regiones` (`ID_Region`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_4` FOREIGN KEY (`BIdEstado`) REFERENCES `Estados` (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Borrador_RequisicionE`
INSERT INTO Borrador_RequisicionE VALUES ("14","","2024-12-04 13:58:18","Borrador","Martha Guadalupe Santiago Barron","7","52","Campamento de Conservación, \"San Jose del Cabo","","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");

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
) ENGINE=InnoDB AUTO_INCREMENT=537 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Borrador_RequisicionD`
INSERT INTO Borrador_RequisicionD VALUES ("60","14","9","29","2");
INSERT INTO Borrador_RequisicionD VALUES ("61","14","3","15","2");
INSERT INTO Borrador_RequisicionD VALUES ("62","14","37","32","1");
INSERT INTO Borrador_RequisicionD VALUES ("63","14","30","32","5");
INSERT INTO Borrador_RequisicionD VALUES ("64","14","10","6","1");

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Salida_E`
INSERT INTO Salida_E VALUES ("10","8","19","2024-12-02 16:25:42");
INSERT INTO Salida_E VALUES ("11","10","19","2024-12-02 16:30:13");
INSERT INTO Salida_E VALUES ("12","9","6","2024-12-05 15:26:44");
INSERT INTO Salida_E VALUES ("13","13","6","2024-12-05 15:32:03");
INSERT INTO Salida_E VALUES ("14","12","6","2024-12-05 15:39:56");
INSERT INTO Salida_E VALUES ("15","14","6","2024-12-05 15:42:10");
INSERT INTO Salida_E VALUES ("16","15","6","2024-12-05 15:43:19");
INSERT INTO Salida_E VALUES ("17","16","6","2024-12-05 15:44:19");
INSERT INTO Salida_E VALUES ("18","17","6","2024-12-05 15:45:45");
INSERT INTO Salida_E VALUES ("19","18","6","2024-12-05 15:47:22");
INSERT INTO Salida_E VALUES ("20","19","6","2024-12-05 15:48:38");
INSERT INTO Salida_E VALUES ("21","21","6","2024-12-06 16:57:54");
INSERT INTO Salida_E VALUES ("22","41","6","2024-12-10 12:01:31");

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
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Salida_D`
INSERT INTO Salida_D VALUES ("22","10","3","13","8");
INSERT INTO Salida_D VALUES ("23","10","3","14","8");
INSERT INTO Salida_D VALUES ("24","10","3","15","10");
INSERT INTO Salida_D VALUES ("25","10","3","16","10");
INSERT INTO Salida_D VALUES ("26","10","3","17","8");
INSERT INTO Salida_D VALUES ("27","10","3","18","4");
INSERT INTO Salida_D VALUES ("28","10","3","19","4");
INSERT INTO Salida_D VALUES ("29","10","3","21","0");
INSERT INTO Salida_D VALUES ("30","10","4","11","6");
INSERT INTO Salida_D VALUES ("31","10","4","13","10");
INSERT INTO Salida_D VALUES ("32","10","4","14","10");
INSERT INTO Salida_D VALUES ("33","10","4","15","10");
INSERT INTO Salida_D VALUES ("34","10","4","16","6");
INSERT INTO Salida_D VALUES ("35","10","4","17","4");
INSERT INTO Salida_D VALUES ("36","10","4","18","4");
INSERT INTO Salida_D VALUES ("37","10","4","19","3");
INSERT INTO Salida_D VALUES ("38","10","4","21","2");
INSERT INTO Salida_D VALUES ("39","10","20","32","0");
INSERT INTO Salida_D VALUES ("40","10","23","28","35");
INSERT INTO Salida_D VALUES ("41","10","30","32","0");
INSERT INTO Salida_D VALUES ("42","10","31","32","10");
INSERT INTO Salida_D VALUES ("43","10","36","32","25");
INSERT INTO Salida_D VALUES ("44","11","3","16","10");
INSERT INTO Salida_D VALUES ("45","11","3","17","10");
INSERT INTO Salida_D VALUES ("46","11","8","29","0");
INSERT INTO Salida_D VALUES ("47","11","8","30","0");
INSERT INTO Salida_D VALUES ("48","11","8","31","0");
INSERT INTO Salida_D VALUES ("49","12","40","32","5");
INSERT INTO Salida_D VALUES ("50","12","41","32","7");
INSERT INTO Salida_D VALUES ("51","12","42","32","4");
INSERT INTO Salida_D VALUES ("52","13","3","15","1");
INSERT INTO Salida_D VALUES ("53","13","3","16","1");
INSERT INTO Salida_D VALUES ("54","13","3","18","1");
INSERT INTO Salida_D VALUES ("55","13","4","15","2");
INSERT INTO Salida_D VALUES ("56","13","4","18","1");
INSERT INTO Salida_D VALUES ("57","13","20","32","0");
INSERT INTO Salida_D VALUES ("58","14","4","14","2");
INSERT INTO Salida_D VALUES ("59","14","9","28","3");
INSERT INTO Salida_D VALUES ("60","14","9","29","3");
INSERT INTO Salida_D VALUES ("61","14","10","6","1");
INSERT INTO Salida_D VALUES ("62","14","10","8","1");
INSERT INTO Salida_D VALUES ("63","14","30","32","0");
INSERT INTO Salida_D VALUES ("64","14","37","32","1");
INSERT INTO Salida_D VALUES ("65","15","3","14","3");
INSERT INTO Salida_D VALUES ("66","15","3","15","4");
INSERT INTO Salida_D VALUES ("67","15","3","16","4");
INSERT INTO Salida_D VALUES ("68","15","3","19","2");
INSERT INTO Salida_D VALUES ("69","15","4","13","5");
INSERT INTO Salida_D VALUES ("70","15","4","14","3");
INSERT INTO Salida_D VALUES ("71","15","4","15","3");
INSERT INTO Salida_D VALUES ("72","15","4","16","2");
INSERT INTO Salida_D VALUES ("73","15","20","32","0");
INSERT INTO Salida_D VALUES ("74","15","37","32","3");
INSERT INTO Salida_D VALUES ("75","16","10","6","4");
INSERT INTO Salida_D VALUES ("76","17","9","28","3");
INSERT INTO Salida_D VALUES ("77","17","9","29","3");
INSERT INTO Salida_D VALUES ("78","17","10","7","1");
INSERT INTO Salida_D VALUES ("79","17","30","32","0");
INSERT INTO Salida_D VALUES ("80","17","37","32","2");
INSERT INTO Salida_D VALUES ("81","18","3","14","2");
INSERT INTO Salida_D VALUES ("82","18","4","14","2");
INSERT INTO Salida_D VALUES ("83","18","9","28","3");
INSERT INTO Salida_D VALUES ("84","18","9","29","3");
INSERT INTO Salida_D VALUES ("85","18","10","7","2");
INSERT INTO Salida_D VALUES ("86","18","10","8","1");
INSERT INTO Salida_D VALUES ("87","18","37","32","1");
INSERT INTO Salida_D VALUES ("88","19","9","28","3");
INSERT INTO Salida_D VALUES ("89","19","9","29","3");
INSERT INTO Salida_D VALUES ("90","19","10","6","1");
INSERT INTO Salida_D VALUES ("91","19","30","32","0");
INSERT INTO Salida_D VALUES ("92","19","37","32","1");
INSERT INTO Salida_D VALUES ("93","20","3","15","2");
INSERT INTO Salida_D VALUES ("94","20","9","29","2");
INSERT INTO Salida_D VALUES ("95","20","10","6","1");
INSERT INTO Salida_D VALUES ("96","20","30","32","0");
INSERT INTO Salida_D VALUES ("97","20","37","32","1");
INSERT INTO Salida_D VALUES ("98","21","55","26","15");
INSERT INTO Salida_D VALUES ("99","21","55","28","40");
INSERT INTO Salida_D VALUES ("100","21","55","29","15");
INSERT INTO Salida_D VALUES ("101","22","10","3","3");
INSERT INTO Salida_D VALUES ("102","22","10","4","4");
INSERT INTO Salida_D VALUES ("103","22","10","5","2");
INSERT INTO Salida_D VALUES ("104","22","10","6","3");
INSERT INTO Salida_D VALUES ("105","22","10","7","3");
INSERT INTO Salida_D VALUES ("106","22","54","11","10");
INSERT INTO Salida_D VALUES ("107","22","54","13","15");
INSERT INTO Salida_D VALUES ("108","22","54","14","15");
INSERT INTO Salida_D VALUES ("109","22","54","15","10");
INSERT INTO Salida_D VALUES ("110","22","54","16","0");
INSERT INTO Salida_D VALUES ("111","22","54","17","0");

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

