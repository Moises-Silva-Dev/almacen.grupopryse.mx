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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO Regiones VALUES ("51","IPN","2024-12-18 14:27:05");
INSERT INTO Regiones VALUES ("52","1","2024-12-02 12:55:40");
INSERT INTO Regiones VALUES ("53","2","2024-12-02 12:56:28");
INSERT INTO Regiones VALUES ("54","3","2024-12-02 12:57:38");
INSERT INTO Regiones VALUES ("56","Varias 1","2024-12-02 13:15:03");
INSERT INTO Regiones VALUES ("57","Varias 2","2024-12-02 17:37:05");
INSERT INTO Regiones VALUES ("58","CDMX","2024-12-06 17:10:53");
INSERT INTO Regiones VALUES ("59","Republica Mexicana","2024-12-23 13:42:10");

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
) ENGINE=InnoDB AUTO_INCREMENT=230 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO Estado_Region VALUES ("176","51","13");
INSERT INTO Estado_Region VALUES ("177","51","15");
INSERT INTO Estado_Region VALUES ("178","51","28");
INSERT INTO Estado_Region VALUES ("179","51","17");
INSERT INTO Estado_Region VALUES ("180","51","32");
INSERT INTO Estado_Region VALUES ("181","51","2");
INSERT INTO Estado_Region VALUES ("182","51","25");
INSERT INTO Estado_Region VALUES ("183","51","16");
INSERT INTO Estado_Region VALUES ("184","51","26");
INSERT INTO Estado_Region VALUES ("185","51","22");
INSERT INTO Estado_Region VALUES ("186","51","20");
INSERT INTO Estado_Region VALUES ("187","51","5");
INSERT INTO Estado_Region VALUES ("188","51","27");
INSERT INTO Estado_Region VALUES ("189","51","10");
INSERT INTO Estado_Region VALUES ("190","51","11");
INSERT INTO Estado_Region VALUES ("191","51","3");
INSERT INTO Estado_Region VALUES ("192","51","29");
INSERT INTO Estado_Region VALUES ("193","51","30");
INSERT INTO Estado_Region VALUES ("194","51","21");
INSERT INTO Estado_Region VALUES ("195","51","4");
INSERT INTO Estado_Region VALUES ("196","51","23");
INSERT INTO Estado_Region VALUES ("197","51","6");
INSERT INTO Estado_Region VALUES ("198","59","1");
INSERT INTO Estado_Region VALUES ("199","59","2");
INSERT INTO Estado_Region VALUES ("200","59","3");
INSERT INTO Estado_Region VALUES ("201","59","4");
INSERT INTO Estado_Region VALUES ("202","59","5");
INSERT INTO Estado_Region VALUES ("203","59","6");
INSERT INTO Estado_Region VALUES ("204","59","7");
INSERT INTO Estado_Region VALUES ("205","59","8");
INSERT INTO Estado_Region VALUES ("206","59","9");
INSERT INTO Estado_Region VALUES ("207","59","10");
INSERT INTO Estado_Region VALUES ("208","59","11");
INSERT INTO Estado_Region VALUES ("209","59","12");
INSERT INTO Estado_Region VALUES ("210","59","13");
INSERT INTO Estado_Region VALUES ("211","59","14");
INSERT INTO Estado_Region VALUES ("212","59","15");
INSERT INTO Estado_Region VALUES ("213","59","16");
INSERT INTO Estado_Region VALUES ("214","59","17");
INSERT INTO Estado_Region VALUES ("215","59","18");
INSERT INTO Estado_Region VALUES ("216","59","19");
INSERT INTO Estado_Region VALUES ("217","59","20");
INSERT INTO Estado_Region VALUES ("218","59","21");
INSERT INTO Estado_Region VALUES ("219","59","22");
INSERT INTO Estado_Region VALUES ("220","59","23");
INSERT INTO Estado_Region VALUES ("221","59","24");
INSERT INTO Estado_Region VALUES ("222","59","25");
INSERT INTO Estado_Region VALUES ("223","59","26");
INSERT INTO Estado_Region VALUES ("224","59","27");
INSERT INTO Estado_Region VALUES ("225","59","28");
INSERT INTO Estado_Region VALUES ("226","59","29");
INSERT INTO Estado_Region VALUES ("227","59","30");
INSERT INTO Estado_Region VALUES ("228","59","31");
INSERT INTO Estado_Region VALUES ("229","59","32");

-- Table structure for table `Cuenta`
CREATE TABLE `Cuenta` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCuenta` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `NroElemetos` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Cuenta`
INSERT INTO Cuenta VALUES ("1","CFE","357");
INSERT INTO Cuenta VALUES ("5","Cuenta Prueba","123");
INSERT INTO Cuenta VALUES ("7","CAPUFE","1000");
INSERT INTO Cuenta VALUES ("8","IPN","300");
INSERT INTO Cuenta VALUES ("9","ISSSTE","700");
INSERT INTO Cuenta VALUES ("10","IMSS Ordinario","4000");
INSERT INTO Cuenta VALUES ("11","Cuentas Varias","500");
INSERT INTO Cuenta VALUES ("12","AICM","1103");
INSERT INTO Cuenta VALUES ("13","Normatividad","1000");

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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO Cuenta_Region VALUES ("50","8","51");
INSERT INTO Cuenta_Region VALUES ("51","7","52");
INSERT INTO Cuenta_Region VALUES ("52","7","53");
INSERT INTO Cuenta_Region VALUES ("53","7","54");
INSERT INTO Cuenta_Region VALUES ("55","11","56");
INSERT INTO Cuenta_Region VALUES ("56","11","57");
INSERT INTO Cuenta_Region VALUES ("57","12","58");
INSERT INTO Cuenta_Region VALUES ("58","13","59");

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO Usuario VALUES ("28","Cora Estefania ","Blancas","Aguilar","6625137639","estefania.grupopryse@gmail.com","$2y$10$4zL74t/KRK4fNmzz6zftFehZjRfFkChcM2Wfq2NBhtwRmLSMotOxm","6625137639","3");
INSERT INTO Usuario VALUES ("29","Georgina","Meade","Ocaranza","5615234087","gina.meade.ote@gmail.com","$2y$10$QUkx9t1HiG1tJWYYnifNnOd80xrRrg8jLmJ76b.SjiwQ1jSrAHJ0u","5615234087","3");
INSERT INTO Usuario VALUES ("30","Giselle ","Galvan","Lewis","5620808483","giselle.galvan@grupopryse.mx","$2y$10$XrWgf4IBtwV8gYLMnRL1UeII/jHTywT2LK.qs1KZz6vXyOaLdDYra","5620808483","3");
INSERT INTO Usuario VALUES ("31","Sergio","Arteaga","Sosa","5559549465","gerenciaaicmpryse@gmail.com","$2y$10$3jd44ceJo0RTDSQWKhPDku0FBS/TUuV3XinPbJ19JSGF1L32u.arS","5559549465","3");
INSERT INTO Usuario VALUES ("32","Lizet ","Luna","Jimenez","5563160541","l.luna@grupopryse.mx","$2y$10$ceLI//0jY3oel5i1pVA2r.Xlz7VZ5sMOUgxzvkd128MxRl9SLnC4C","5563160541","3");
INSERT INTO Usuario VALUES ("33","Fabiola","Peñaloza","Diego","7771957828","grupopryse01nom@gmail.com","$2y$10$s5A7IJH4ZboKtJDcCIHmuObWT/3TysxvZEPcl201t5DHST/86QgcK","7771957828","3");

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
) ENGINE=InnoDB AUTO_INCREMENT=301 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO Inventario VALUES ("24","2","18","49");
INSERT INTO Inventario VALUES ("25","2","19","3");
INSERT INTO Inventario VALUES ("26","2","20","53");
INSERT INTO Inventario VALUES ("27","2","21","78");
INSERT INTO Inventario VALUES ("28","2","22","41");
INSERT INTO Inventario VALUES ("29","2","23","0");
INSERT INTO Inventario VALUES ("30","2","24","0");
INSERT INTO Inventario VALUES ("31","3","7","0");
INSERT INTO Inventario VALUES ("32","3","9","0");
INSERT INTO Inventario VALUES ("33","3","11","349");
INSERT INTO Inventario VALUES ("34","3","13","311");
INSERT INTO Inventario VALUES ("35","3","14","279");
INSERT INTO Inventario VALUES ("36","3","15","238");
INSERT INTO Inventario VALUES ("37","3","16","501");
INSERT INTO Inventario VALUES ("38","3","17","577");
INSERT INTO Inventario VALUES ("39","3","18","873");
INSERT INTO Inventario VALUES ("40","3","19","886");
INSERT INTO Inventario VALUES ("41","3","20","3");
INSERT INTO Inventario VALUES ("42","3","21","-3");
INSERT INTO Inventario VALUES ("43","3","22","68");
INSERT INTO Inventario VALUES ("44","3","23","0");
INSERT INTO Inventario VALUES ("45","3","24","0");
INSERT INTO Inventario VALUES ("46","4","7","1310");
INSERT INTO Inventario VALUES ("47","4","9","979");
INSERT INTO Inventario VALUES ("48","4","11","676");
INSERT INTO Inventario VALUES ("49","4","13","351");
INSERT INTO Inventario VALUES ("50","4","14","45");
INSERT INTO Inventario VALUES ("51","4","15","2");
INSERT INTO Inventario VALUES ("52","4","16","157");
INSERT INTO Inventario VALUES ("53","4","17","152");
INSERT INTO Inventario VALUES ("54","4","18","-21");
INSERT INTO Inventario VALUES ("55","4","19","-3");
INSERT INTO Inventario VALUES ("56","4","20","16");
INSERT INTO Inventario VALUES ("57","4","21","-2");
INSERT INTO Inventario VALUES ("58","4","22","63");
INSERT INTO Inventario VALUES ("59","4","23","98");
INSERT INTO Inventario VALUES ("60","4","24","0");
INSERT INTO Inventario VALUES ("61","5","7","88");
INSERT INTO Inventario VALUES ("62","5","9","79");
INSERT INTO Inventario VALUES ("63","5","11","95");
INSERT INTO Inventario VALUES ("64","5","13","0");
INSERT INTO Inventario VALUES ("65","5","14","0");
INSERT INTO Inventario VALUES ("66","5","15","0");
INSERT INTO Inventario VALUES ("67","5","16","1");
INSERT INTO Inventario VALUES ("68","5","17","25");
INSERT INTO Inventario VALUES ("69","5","18","0");
INSERT INTO Inventario VALUES ("70","5","19","0");
INSERT INTO Inventario VALUES ("71","5","20","0");
INSERT INTO Inventario VALUES ("72","5","21","0");
INSERT INTO Inventario VALUES ("73","5","22","0");
INSERT INTO Inventario VALUES ("74","5","23","0");
INSERT INTO Inventario VALUES ("75","5","24","0");
INSERT INTO Inventario VALUES ("76","6","26","277");
INSERT INTO Inventario VALUES ("77","6","27","135");
INSERT INTO Inventario VALUES ("78","6","28","89");
INSERT INTO Inventario VALUES ("79","6","29","78");
INSERT INTO Inventario VALUES ("80","6","30","21");
INSERT INTO Inventario VALUES ("81","6","31","116");
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
INSERT INTO Inventario VALUES ("94","9","26","539");
INSERT INTO Inventario VALUES ("95","9","27","0");
INSERT INTO Inventario VALUES ("96","9","28","363");
INSERT INTO Inventario VALUES ("97","9","29","89");
INSERT INTO Inventario VALUES ("98","9","30","0");
INSERT INTO Inventario VALUES ("99","9","31","0");
INSERT INTO Inventario VALUES ("100","10","1","138");
INSERT INTO Inventario VALUES ("101","10","2","135");
INSERT INTO Inventario VALUES ("102","10","3","313");
INSERT INTO Inventario VALUES ("103","10","4","330");
INSERT INTO Inventario VALUES ("104","10","5","60");
INSERT INTO Inventario VALUES ("105","10","6","105");
INSERT INTO Inventario VALUES ("106","10","7","101");
INSERT INTO Inventario VALUES ("107","10","8","207");
INSERT INTO Inventario VALUES ("108","10","9","62");
INSERT INTO Inventario VALUES ("109","10","10","48");
INSERT INTO Inventario VALUES ("110","10","11","56");
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
INSERT INTO Inventario VALUES ("151","18","32","0");
INSERT INTO Inventario VALUES ("152","19","26","69");
INSERT INTO Inventario VALUES ("153","19","27","150");
INSERT INTO Inventario VALUES ("154","19","28","150");
INSERT INTO Inventario VALUES ("155","19","29","69");
INSERT INTO Inventario VALUES ("156","19","30","0");
INSERT INTO Inventario VALUES ("157","19","31","0");
INSERT INTO Inventario VALUES ("158","20","32","780");
INSERT INTO Inventario VALUES ("159","21","32","85");
INSERT INTO Inventario VALUES ("160","22","32","9");
INSERT INTO Inventario VALUES ("161","23","28","3");
INSERT INTO Inventario VALUES ("162","24","32","0");
INSERT INTO Inventario VALUES ("163","25","32","0");
INSERT INTO Inventario VALUES ("164","26","32","81");
INSERT INTO Inventario VALUES ("165","27","32","0");
INSERT INTO Inventario VALUES ("166","28","32","0");
INSERT INTO Inventario VALUES ("167","29","32","0");
INSERT INTO Inventario VALUES ("168","30","32","0");
INSERT INTO Inventario VALUES ("169","31","32","0");
INSERT INTO Inventario VALUES ("170","32","32","0");
INSERT INTO Inventario VALUES ("171","33","32","59");
INSERT INTO Inventario VALUES ("172","34","32","1201");
INSERT INTO Inventario VALUES ("173","35","32","0");
INSERT INTO Inventario VALUES ("174","36","32","0");
INSERT INTO Inventario VALUES ("175","37","32","630");
INSERT INTO Inventario VALUES ("176","38","32","288");
INSERT INTO Inventario VALUES ("177","39","32","8");
INSERT INTO Inventario VALUES ("178","40","32","57");
INSERT INTO Inventario VALUES ("179","41","32","65");
INSERT INTO Inventario VALUES ("180","42","32","78");
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
INSERT INTO Inventario VALUES ("247","54","13","263");
INSERT INTO Inventario VALUES ("248","54","14","268");
INSERT INTO Inventario VALUES ("249","54","15","140");
INSERT INTO Inventario VALUES ("250","54","16","0");
INSERT INTO Inventario VALUES ("251","54","17","0");
INSERT INTO Inventario VALUES ("252","54","18","0");
INSERT INTO Inventario VALUES ("253","54","19","37");
INSERT INTO Inventario VALUES ("254","54","20","10");
INSERT INTO Inventario VALUES ("255","54","21","0");
INSERT INTO Inventario VALUES ("256","54","22","0");
INSERT INTO Inventario VALUES ("257","54","23","0");
INSERT INTO Inventario VALUES ("258","54","24","0");
INSERT INTO Inventario VALUES ("259","55","26","380");
INSERT INTO Inventario VALUES ("260","55","27","121");
INSERT INTO Inventario VALUES ("261","55","28","29");
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
INSERT INTO Inventario VALUES ("287","59","26","33");
INSERT INTO Inventario VALUES ("288","59","27","2");
INSERT INTO Inventario VALUES ("289","59","28","2");
INSERT INTO Inventario VALUES ("290","59","29","32");
INSERT INTO Inventario VALUES ("291","59","30","0");
INSERT INTO Inventario VALUES ("292","59","31","0");
INSERT INTO Inventario VALUES ("293","60","32","0");
INSERT INTO Inventario VALUES ("294","64","13","40");
INSERT INTO Inventario VALUES ("295","64","14","121");
INSERT INTO Inventario VALUES ("296","64","15","100");
INSERT INTO Inventario VALUES ("297","64","16","99");
INSERT INTO Inventario VALUES ("298","64","17","51");
INSERT INTO Inventario VALUES ("299","5","1","5");
INSERT INTO Inventario VALUES ("300","5","2","15");

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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO EntradaE VALUES ("17","2024-12-12 13:14:03","","","6","FLORALY","EQUIPO ALMACEN","SUETER","Creada");
INSERT INTO EntradaE VALUES ("18","2024-12-12 17:00:46","","","6","FLORALY","EQUIPO ALMACEN","sueter","Creada");
INSERT INTO EntradaE VALUES ("19","2024-12-17 12:04:33","","","6","FLORALY","EQUIPO ALMACEN","Entrega de sueter","Creada");
INSERT INTO EntradaE VALUES ("20","2024-12-26 08:25:10","","","6","FLORALY","EQUIPO ALMACEN","SUETER AEROPUERTO","Creada");
INSERT INTO EntradaE VALUES ("21","2024-12-26 08:26:36","","","6","FLORALY","EQUIPO ALMACEN","SUETER AEROPUERTO","Creada");
INSERT INTO EntradaE VALUES ("22","2024-12-30 15:26:01","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","ENTREGA DE 200 PARES DE BOTAS","Creada");
INSERT INTO EntradaE VALUES ("23","2024-12-30 15:30:11","","","6","FLORALY","EQUIPO ALMACEN","ENTREGA DE UNIFORMES","Creada");
INSERT INTO EntradaE VALUES ("24","2024-12-30 15:31:13","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","ENTREGA DE BOTAS","Creada");
INSERT INTO EntradaE VALUES ("25","2024-12-30 15:32:52","","","6","FLORALY","EQUIPO ALMACEN","PANTALON COMANDO","Creada");
INSERT INTO EntradaE VALUES ("26","2024-12-30 15:34:03","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","BOTAS TACTICA","Creada");
INSERT INTO EntradaE VALUES ("27","2024-12-30 15:35:50","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","BOTAS TACTICA","Creada");
INSERT INTO EntradaE VALUES ("28","2024-12-30 15:36:33","","","6","FLORALY","EQUIPO ALMACEN","GORRAS","Creada");
INSERT INTO EntradaE VALUES ("29","2024-12-31 13:20:50","","","6","CHARBEL","EQUIPO ALMACEN","6 BULTOS DE CHAMARRA DE 35 PZ\n8 BULTOS DE GORRA DE 50 PZ","Creada");
INSERT INTO EntradaE VALUES ("30","2024-12-31 13:22:47","","","6","FLORALY","EQUIPO ALMACEN","ENTREGA DE FLOR","Creada");
INSERT INTO EntradaE VALUES ("31","2025-01-02 11:27:30","","","6","FLORALY","EQUIPO ALMACEN","entrega de pantalones ","Creada");
INSERT INTO EntradaE VALUES ("32","2025-01-03 09:43:09","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","BOTAS 200 PARES","Creada");
INSERT INTO EntradaE VALUES ("33","2025-01-03 16:53:14","","","6","FLORALY","EQUIPO ALMACEN","ENTREGA DE PANTALON COMANDO Y GORRA","Creada");
INSERT INTO EntradaE VALUES ("34","2025-01-03 17:03:14","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","BOTAS 195 PARES","Creada");
INSERT INTO EntradaE VALUES ("35","2025-01-04 10:50:40","","","6","FLORALY","EQUIPO ALMACEN","pantalon comando","Creada");
INSERT INTO EntradaE VALUES ("36","2025-01-06 10:00:23","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","entrega de botas","Creada");
INSERT INTO EntradaE VALUES ("37","2025-01-06 10:01:17","","","6","FLORALY","EQUIPO ALMACEN","entrega de pantalon talla 36","Creada");

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
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO EntradaD VALUES ("85","17","59","27","34");
INSERT INTO EntradaD VALUES ("86","18","59","27","23");
INSERT INTO EntradaD VALUES ("87","19","59","26","12");
INSERT INTO EntradaD VALUES ("88","19","59","29","31");
INSERT INTO EntradaD VALUES ("89","20","59","26","17");
INSERT INTO EntradaD VALUES ("90","20","59","29","1");
INSERT INTO EntradaD VALUES ("91","21","59","26","4");
INSERT INTO EntradaD VALUES ("92","21","59","27","2");
INSERT INTO EntradaD VALUES ("93","21","59","28","2");
INSERT INTO EntradaD VALUES ("94","22","10","5","60");
INSERT INTO EntradaD VALUES ("95","22","10","6","60");
INSERT INTO EntradaD VALUES ("96","22","10","7","60");
INSERT INTO EntradaD VALUES ("97","22","10","8","10");
INSERT INTO EntradaD VALUES ("98","22","10","4","10");
INSERT INTO EntradaD VALUES ("99","23","3","11","2");
INSERT INTO EntradaD VALUES ("100","23","3","13","3");
INSERT INTO EntradaD VALUES ("101","23","3","14","47");
INSERT INTO EntradaD VALUES ("102","23","3","15","2");
INSERT INTO EntradaD VALUES ("103","23","3","17","1");
INSERT INTO EntradaD VALUES ("104","23","3","21","14");
INSERT INTO EntradaD VALUES ("105","23","4","14","26");
INSERT INTO EntradaD VALUES ("106","23","64","14","6");
INSERT INTO EntradaD VALUES ("107","23","64","15","3");
INSERT INTO EntradaD VALUES ("108","23","64","16","75");
INSERT INTO EntradaD VALUES ("109","23","64","17","51");
INSERT INTO EntradaD VALUES ("110","24","10","6","150");
INSERT INTO EntradaD VALUES ("111","25","4","14","10");
INSERT INTO EntradaD VALUES ("112","25","4","15","59");
INSERT INTO EntradaD VALUES ("113","25","4","16","1");
INSERT INTO EntradaD VALUES ("114","25","4","18","4");
INSERT INTO EntradaD VALUES ("115","26","10","4","40");
INSERT INTO EntradaD VALUES ("116","26","10","7","120");
INSERT INTO EntradaD VALUES ("117","26","10","8","40");
INSERT INTO EntradaD VALUES ("118","27","10","3","35");
INSERT INTO EntradaD VALUES ("119","27","10","4","30");
INSERT INTO EntradaD VALUES ("120","27","10","5","75");
INSERT INTO EntradaD VALUES ("121","27","10","6","40");
INSERT INTO EntradaD VALUES ("122","27","10","8","20");
INSERT INTO EntradaD VALUES ("123","28","20","32","600");
INSERT INTO EntradaD VALUES ("124","29","20","32","400");
INSERT INTO EntradaD VALUES ("125","29","9","29","70");
INSERT INTO EntradaD VALUES ("126","29","9","30","140");
INSERT INTO EntradaD VALUES ("127","30","4","14","16");
INSERT INTO EntradaD VALUES ("128","30","4","13","13");
INSERT INTO EntradaD VALUES ("129","30","4","15","9");
INSERT INTO EntradaD VALUES ("130","30","4","16","2");
INSERT INTO EntradaD VALUES ("131","30","4","17","2");
INSERT INTO EntradaD VALUES ("132","31","4","16","40");
INSERT INTO EntradaD VALUES ("133","32","10","2","15");
INSERT INTO EntradaD VALUES ("134","32","10","3","40");
INSERT INTO EntradaD VALUES ("135","32","10","4","45");
INSERT INTO EntradaD VALUES ("136","32","10","6","20");
INSERT INTO EntradaD VALUES ("137","32","10","7","25");
INSERT INTO EntradaD VALUES ("138","32","10","8","25");
INSERT INTO EntradaD VALUES ("139","32","10","9","30");
INSERT INTO EntradaD VALUES ("140","33","4","15","51");
INSERT INTO EntradaD VALUES ("141","33","4","17","51");
INSERT INTO EntradaD VALUES ("142","33","4","20","3");
INSERT INTO EntradaD VALUES ("143","33","20","32","780");
INSERT INTO EntradaD VALUES ("144","34","5","1","5");
INSERT INTO EntradaD VALUES ("145","34","5","2","15");
INSERT INTO EntradaD VALUES ("146","34","10","3","25");
INSERT INTO EntradaD VALUES ("147","34","10","4","30");
INSERT INTO EntradaD VALUES ("148","34","10","5","30");
INSERT INTO EntradaD VALUES ("149","34","10","6","50");
INSERT INTO EntradaD VALUES ("150","34","10","7","25");
INSERT INTO EntradaD VALUES ("151","34","10","8","10");
INSERT INTO EntradaD VALUES ("152","34","10","10","5");
INSERT INTO EntradaD VALUES ("153","35","4","13","64");
INSERT INTO EntradaD VALUES ("154","35","4","16","127");
INSERT INTO EntradaD VALUES ("155","35","4","17","102");
INSERT INTO EntradaD VALUES ("156","36","10","2","15");
INSERT INTO EntradaD VALUES ("157","36","10","3","15");
INSERT INTO EntradaD VALUES ("158","36","10","4","25");
INSERT INTO EntradaD VALUES ("159","36","10","5","25");
INSERT INTO EntradaD VALUES ("160","36","10","6","65");
INSERT INTO EntradaD VALUES ("161","36","10","7","20");
INSERT INTO EntradaD VALUES ("162","36","10","8","10");
INSERT INTO EntradaD VALUES ("163","36","10","9","25");
INSERT INTO EntradaD VALUES ("164","37","4","14","52");

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
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO RequisicionE VALUES ("31","23","2024-12-09 00:14:55","2024-12-24 13:29:41","Autorizado","Efrain Hernandez Sanchez","7","53","Plazas de Cobro No. 140 La Carbonera","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("32","23","2024-12-09 00:16:28","2024-12-10 13:07:48","Surtido","Efrain Hernandez Sanchez","7","53","Parador La Carbonera","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez. ","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("33","23","2024-12-09 09:53:54","2024-12-24 13:29:51","Autorizado","Efrain Hernandez Sanchez","7","53","Plazas de Cobro No. 162 Plan de Ayala","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("34","23","2024-12-09 09:57:18","2024-12-10 13:07:28","Surtido","Efrain Hernandez Sanchez","7","53","Residencia de Conservación de la Cuchilla","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("35","23","2024-12-09 10:12:09","2024-12-10 13:06:57","Parcial","Efrain Hernandez Sanchez","7","53","Plazas de Cobro No. 141 Los Chorros","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("36","23","2024-12-09 10:16:19","2024-12-10 13:03:27","Surtido","Efrain Hernandez Sanchez","7","53","Almacen Los Chorros","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("37","23","2024-12-09 10:25:39","2024-12-10 13:03:08","Parcial","Efrain Hernandez Sanchez","7","53","Residencia de Conservación Plan de Ayala","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("38","23","2024-12-09 10:37:09","2024-12-10 13:03:01","Surtido","Efrain Hernandez Sanchez","7","53","Oficinas de la Unidad Regional Saltillo","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("39","23","2024-12-09 10:59:34","2024-12-12 11:00:22","Parcial","Efrain Hernandez Sanchez","7","53","Plazas de Cobro No. 142 Huachichil","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("40","23","2024-12-09 11:11:40","2024-12-10 13:02:42","Parcial","Efrain Hernandez Sanchez","7","53","Plazas de Cobro No. 163 La Cuchilla","","Efrain Hernandez Sanchez","8445410174","HESE8812019Z5","Reposición de uniformes y equipo por desgaste, equipo 29-04-24 y uniformes 05-09-24. Chamarras primera vez.","7","Saltillo ","Misión Cerritos","Misión San Andrés","1067","25016");
INSERT INTO RequisicionE VALUES ("41","31","2024-12-10 11:59:09","2024-12-10 11:59:31","Parcial","Gabriel Reyes Garces","12","58","T2 AICM","1180","Julian Suarez Tovar","5536525342","SUTJ700908S16","Se hace requerimiento por la entrega de botas a elementos con un año laborando","9","VENUSTIANO CARRANZA","AVIACION CIVIL","ROLANDO GARROS","131","9210");
INSERT INTO RequisicionE VALUES ("42","4","2024-12-12 10:04:41","2024-12-12 10:59:56","Parcial","Yvan Islas","1","10","","2","De la Cruz Velázquez Yessenia","9333277968","CUVY840803BH2","Se solicita uniforme para elemento de nuevo ingreso, ya que no tiene uniforme","27","Comalcalco","Ria Jose Ma Pino Suarez 3ra Sección","Loc Pino Suarez","S/N","86640");
INSERT INTO RequisicionE VALUES ("43","25","2024-12-12 10:53:24","2024-12-12 16:13:47","Parcial","Angel Bazan","7","49","pc 59 oaxtepec","50","Angel Bazan","5528169856","","se solicitan uniformes por deterioro, ultima requisición 24-11-23 \n(pasan por ellos), se solicita autorización por cambio de chamarra a tipo cazadora ya que no hay en almacén, lo anterior es para evitar deductivas por parte de CAPUFE ","17","","","","","");
INSERT INTO RequisicionE VALUES ("44","25","2024-12-12 10:56:49","2024-12-12 11:02:02","Parcial","Angel Bazan","7","49","PC 24 TEPOZTLAN","20","Angel Bazan","5528169856","","se solicitan chamarras por deterioro, ultima requisición 12 de noviembre del 2023 y uniformes para nuevos ingresos. (pasan por ellos)se solicita autorización por cambio de chamarra a tipo cazadora ya que no hay en almacén, lo anterior es para evitar ","17","","","","","");
INSERT INTO RequisicionE VALUES ("45","25","2024-12-12 11:19:27","2024-12-12 13:40:26","Parcial","Angel Bazan","7","49","Pc 191 Ixtapaluca","14","Angel Bazan","5528169856","","se solicitan uniformes por deterioro y nuevos ingresos, ultima requisición diciembre del 2023. (Pasan por ellos) se solicita autorización por cambio de chamarra a tipo cazadora ya que no hay en almacén, lo anterior es para evitar deductivas por parte","17","","","","","");
INSERT INTO RequisicionE VALUES ("46","25","2024-12-12 11:20:02","2024-12-12 16:13:15","Surtido","Angel Bazan","7","49","Pc 25 Oacalco","20","Angel Bazan","5528169856","","se solicitan chamarras por deterioro, ultima requisición 22 de noviembre del 2023. (Pasan por ellos) se solicita autorización por cambio de chamarra a tipo cazadora ya que no hay en almacén, lo anterior es para evitar deductivas por parte de CAPUFE","17","","","","","");
INSERT INTO RequisicionE VALUES ("47","25","2024-12-12 11:24:40","2024-12-12 16:12:57","Surtido","Angel Bazan","7","49","Pc 184 Francisco Duran","20","Angel Bazan","5528169856","","se solicitan chamarras por deterioro, ultima requisición 14-01-24, se solicita autorización por cambio de chamarra a tipo cazadora ya que no hay en almacén, lo anterior es para evitar deductivas por parte de CAPUFE pasan por ellas.","17","","","","","");
INSERT INTO RequisicionE VALUES ("48","24","2024-12-12 14:15:49","2024-12-12 16:12:44","Parcial","CRUZ GALARZA JOSE ANGEL","7","50","PC 118, PC 179, CAMP LAS CHOAPAS, PC 45, PC 99, PC 22, PC 63","130","CRUZ GALARZA JOSE ANGEL","9711394041","CUGA900802Q36","SE REQUIEREN UNIFORMES PARA LOS ELEMENTOS DE NUEVO INGRESO, ADEMAS EL REQUERIMIENTO CON FOLIO 17 SE ENVÍO INCOMPLETO","30","VERACRUZ","FRACC LOS TORRENTES AEROPUERTO","AEROPUERTO","1015 B","91698");
INSERT INTO RequisicionE VALUES ("49","25","2024-12-14 10:50:12","2024-12-14 11:18:01","Surtido","Brayan Palacios","7","49","Pc Tlalpan","36","miguel linares","7333359098","","se solicitan radios a cambio por que ya no funcionan y uniformes para nuevos ingresos","9","","","","","");
INSERT INTO RequisicionE VALUES ("50","32","2024-12-14 10:53:25","2024-12-17 11:44:35","Surtido","GABRIEL AYORUS BOLLY CRUZ","10","48","HOSPITAL 2 CHIHUAHUA","50","GABRIEL AYORUS BOLLY CRUZ","5562922857","BOCG9909281R2","VISITA DE LA PRESIDENTA AL HOSPITAL Y SE REQUIERE UNIFORMAR POR COMPLETO A LOS ELEMENTOS.","7","OCURRE CD JUAREZ CASTORES","","","","");
INSERT INTO RequisicionE VALUES ("51","23","2024-12-14 12:11:57","2024-12-18 14:12:49","Parcial","Raúl Gallardo Velazquez","7","52","Campamento de Conservación “Puente Culiacán”","8","Raúl Gallardo Velazquez","55 76 56 58 61","GAVR701101625","Faltante del requerimiento enviado 01/11/2024","25","Culiacan","Centro","Juan José Rios","950","80000");
INSERT INTO RequisicionE VALUES ("52","23","2024-12-14 12:12:32","2024-12-18 14:12:40","Parcial","Raúl Gallardo Velazquez","7","52","Plaza de Cobro No. 10 “Puente Culiacán”","12","Raúl Gallardo Velazquez","55 76 56 58 61","GAVR701101625","Faltante del requerimiento enviado 01/11/2024","25","Culiacan","Centro","Juan José Rios","950","80000");
INSERT INTO RequisicionE VALUES ("53","23","2024-12-14 12:13:06","2024-12-17 11:43:38","Parcial","Raúl Gallardo Velazquez","7","52","Plaza de Cobro No. 11 “Puente Sinaloa”","12","Raúl Gallardo Velazquez","55 76 56 58 61","GAVR701101625","Faltante del requerimiento enviado 01/11/2024","25","Culiacan","Centro","Juan José Rios","950","80000");
INSERT INTO RequisicionE VALUES ("54","31","2024-12-14 12:15:30","2024-12-17 11:43:13","Surtido","Gabriel Reyes Garces","12","58","T2 AICM","1180","Gabriel Reyes Garces","5559549606","","se hace requerimiento por la entrega de uniformes a elementos con un año laborando","9","Venustiano Carranza, CDMX","Aviación Civil ","Rolando Garros","131 piso 1","15740");
INSERT INTO RequisicionE VALUES ("55","31","2024-12-17 11:58:37","2024-12-17 12:21:10","Surtido","Gabriel Reyes Garces","12","58","T2 AICM","1180","Gabriel Reyes Garces","5559549606","","Se realiza la siguiente requisicion para solicitar 700 piezas de sueteres (divididas en las siguientes tallas 150 chicos, 300 medianos, 200 grandes y 50 extragrandes) para uniformar a nuestros elementos en la temporada invernal.","9","Venustiano Carranza, CDMX","Aviación Civil ","Rolando Garros","131 piso 1","15740");
INSERT INTO RequisicionE VALUES ("56","24","2024-12-19 10:09:45","2024-12-24 13:27:35","Autorizado","RICARDO GARCIA","8","51","CIIDIR MICHOACÁN","8","GARCIA ABARCA CARLOS ARTURO","3532044447","GAAC7704155A","SE REQUIEREN UNIFORMES YA QUE CON LOS CUENTAN ESTÁN DESGASTADOS O ROTOS","16","JIQUILPAN","Fraccionamiento maria isabel","GUILLERMO PRIETO #22","22","59512");
INSERT INTO RequisicionE VALUES ("57","25","2024-12-19 13:29:19","2024-12-24 13:29:16","Parcial","Angel Bazan","7","49","pc 192 ozumba","28","Angel Bazan","5528169856","","se solicitan uniformes por desgaste y nuevos ingresos, ultima requisición de chamarras 21-03-24 (pasan por ellos)","15","","","","","");
INSERT INTO RequisicionE VALUES ("58","25","2024-12-19 13:55:10","2024-12-24 13:28:42","Parcial","Angel Bazan","7","49","pc 71 chalco","40","Angel Bazan","5528169856","","se solicitan uniformes por desgaste y nuevos ingresos, ultima dotación el 21-03-24. (pasan por ellos)","15","","","","","");
INSERT INTO RequisicionE VALUES ("59","23","2024-12-20 13:14:16","2024-12-24 13:27:06","Autorizado","Mario Alberto Garza Ramírez","7","53","Plaza de cobro No. 40 “Puente Nacional Cadereyta”","4","Mario Alberto Garza Ramírez","81 1418 55 64","GARM7810249R1","Reposición de uniformes por desgaste, el último envío fue el 04-07-2024","19","Monterrey","Villa Cumbres","Av. Abraham Lincoln","6412","62578");
INSERT INTO RequisicionE VALUES ("61","30","2024-12-20 13:51:49","2024-12-24 13:26:23","Autorizado","ANTONIO RAMOS","10","46","","394","ANTONIO RAMOS","4443377878","AALR850728NH7","PRIMERA DOTACION ENERO 2025","19","MONTERREY","VILLA CUMBRES","AV ABRAHAM LINCOLN","6412","64116");
INSERT INTO RequisicionE VALUES ("62","28","2024-12-20 13:51:55","2024-12-24 13:26:02","Parcial","Cesar Francisco Cedillo Perez","10","48","COAHUILA","389","Cesar Francisco Cedillo Perez","8135699149","CEPC860225P41","PRIMERA DOTACIÓN DE INICIO DE CONTRATO COAHUILA","7","SALTILLO","VIRREYES OBRERA","JOSE SARMIENTO","755","25022");
INSERT INTO RequisicionE VALUES ("63","29","2024-12-20 13:54:42","2024-12-24 13:25:37","Autorizado","RICARDO AARON PALMA ROMAN","10","47","NAYARIT","135","RICARDO AARON PALMA ROMAN","5578524024","PARA830627S26","PRIMERA ENTREGA DE UNIFORMES 2025","18","TEPIC","FRACCIONAMIENTO JACARANDAS","ROSAS","46","63195");
INSERT INTO RequisicionE VALUES ("64","29","2024-12-20 13:55:11","2025-01-02 12:48:26","Parcial","SERGIO EDUARDO ARELLANO GONZALEZ","10","47","AGUASCALIENTES","151","SERGIO EDUARDO ARELLANO GONZLEZ","44999022224","AEGS990115LU5","PRIMERA ENTREGA DE UNIFORMES 2025","1","AGUASCALIENTES","LA FUENTE","COQUIMBO","202-2","20230");
INSERT INTO RequisicionE VALUES ("65","29","2024-12-20 13:55:21","2024-12-24 13:25:05","Autorizado","EDUARDO AYALA LOPEZ","10","47","ZACATECAS","246","EDUARDO AYALA LOPEZ","7772678964","AEGS990115LU5","PRIMERA ENTREGA DE UNIFORMES 2025","32","ZACATECAS","LA COMARCA","CHIQUE","20","98658");
INSERT INTO RequisicionE VALUES ("66","29","2024-12-20 13:56:07","2025-01-02 12:45:17","Parcial","MARIO ALBERTO FLORES ALEISSA","10","47","JALISCO","633","MARIO ALBERTO FLORES ALEISSA","5563162403","FOAM810606","PRIMERA ENTREGA DE UNIFORMES 2025","14","GUADALAJARA","AMERICANA","CALZADA FEDERALISMO","420-B","44160");
INSERT INTO RequisicionE VALUES ("68","28","2024-12-20 14:38:24","2024-12-24 13:24:36","Parcial","HECTOR ALFONSO LUJAN FLORIANO","10","48","DURANGO","372","HECTOR ALFONSO LUJAN FLORIANO","8713855411","LUFH821030JJ3","PRIMERA DOTACIÓN DE INICIO DE CONTRATO DURANGO\n","10","LERDO, DURANGO","CENTRO","AV. MATAMOROS ","781 INT. 5","35150");
INSERT INTO RequisicionE VALUES ("69","21","2024-12-20 14:42:50","2024-12-24 13:24:28","Parcial","JUAN JOSE VALADEZ DE LA CRUZ","10","45","TODAS","214","JUAN JOSE VALADEZ DE LA CRUZ","6151096830","VACJ911113HZ0","PRIMERA DOTACION DE UNIFORMES Y EQUIPO OPERATIVO, CONTRATO 2025.","3","LA PAZ","PUEBLO NUEVO","5 DE FEBRERO","S/N","23060");
INSERT INTO RequisicionE VALUES ("70","21","2024-12-20 16:16:44","2024-12-24 13:24:20","Parcial","EDGAR ACOSTA ESCAREAGA","10","45","TODAS","488","EDGAR ACOSTA ESCAREAGA","6645205086","AOEE820107JI7","PRIMERA DOTACION ENERO , CONTRATO 2025.","2","MEXICALI","MEXICALI","CASTORES OCURRE","S/N","21399");
INSERT INTO RequisicionE VALUES ("71","21","2024-12-20 17:02:21","2024-12-24 13:22:47","Autorizado","RAUL GALLARDO VELAZQUEZ","10","45","TODOS","370","RAUL GALLARDO VELAZQUEZ","5576565867","GAVR701101625","PRIMERA DOTACION ENERO 2025, CONTRATO 2025","25","CULIACAN","JORGE ALMADA","JOSE RIOS","950 PONIENTE","80200");
INSERT INTO RequisicionE VALUES ("72","21","2024-12-20 17:17:26","2024-12-24 13:24:14","Parcial","KARLA EDITH FONTES NAVARRO","10","45","TODAS","550","KARLA EDITH FONTES NAVARRO","6624508810","FONK860804BJ7","PRIMERA DOTACION ENERO 2025, CONTRATO 2025","26","HERMOSILLO","LAS QUINTAS","AVENIDA QUINTA MAYOR","72","83240");
INSERT INTO RequisicionE VALUES ("73","30","2024-12-20 17:42:49","2024-12-24 13:10:53","Parcial","RONALD HERNANDEZ MARTI","10","46","","419","MANUEL LERMA REYES","5610118007","LERJ960727DT7","PRIMERA DOTACION UNIFORMES ENERO 2025","28","CUIDAD VICTORIA","MANGO Y CIPRES","FRAMBOYANMES","M311258","87170");
INSERT INTO RequisicionE VALUES ("74","25","2024-12-20 17:43:24","2024-12-24 13:25:53","Parcial","Angel Bazan","7","49","la pera-cuautla","12","Angel Bazan","5528169856","","se solicitan uniformes por desgaste y nuevos ingresos, ultimo requerimiento 12-11-23","17","","","","","");
INSERT INTO RequisicionE VALUES ("75","30","2024-12-20 17:57:21","2024-12-24 13:10:38","Autorizado","JUAN CARLOS JAIME","10","46","","223","JUAN CARLOS JAIME","5559547902","JAHJ710602255","PRIMERA DOTACION ENERO 2025","24","SAN LUIS POTOSI","LOS MOLINOS","C MOLINO DEL REY","206","78150");
INSERT INTO RequisicionE VALUES ("76","25","2024-12-20 18:02:13","2024-12-24 13:24:04","Parcial","Angel Bazan","7","49","PC 24 TEPOZTLAN bis","20","Angel Bazan","5528169856","","se solicitan uniformes por desgaste y nuevos ingresos, ultima requisición 21-03-24 (pasan por ellos)","17","","","","","");
INSERT INTO RequisicionE VALUES ("77","33","2024-12-23 13:56:55","2024-12-23 14:43:15","Surtido","felipe segura flores","13","59","","2","felipe segura flores","7773056332","","solicitud de la direccion general de seguridad privada del estado de aguascalientes por MULTISITEMAS URIBE S.A DE C.V","1","","","","","");
INSERT INTO RequisicionE VALUES ("78","31","2024-12-23 17:53:22","2024-12-24 13:28:51","Autorizado","Gabriel Reyes Garces","12","58","T2 AICM","1180","Gabriel Reyes Garces","5559549606","","Se realiza requisición de uniformes conforme a los elementos de nuevo ingreso ","9","Venustiano Carranza, CDMX","Aviación Civil ","Rolando Garros","131 piso 1","15740");
INSERT INTO RequisicionE VALUES ("79","28","2024-12-24 14:01:31","2024-12-24 14:51:28","Parcial","Hector Bolly Gomez","10","48","CHIHUAHUA","554","Hector Bolly Gomez","6564275048","BOGH740518HE4","PRIMERA DOTACIÓN DE INICIO DE CONTRATO CHIHUAHUA\n","6","Chihuahua","Lomas de Universidad","Universidad de Frankfurt 8700 U. de Sorbona","8700","31123");
INSERT INTO RequisicionE VALUES ("80","21","2024-12-26 10:21:33","2024-12-26 11:01:45","Parcial","JUAN JOSE VALADEZ DE LA CRUZ","10","45","TODAS","214","JUAN JOSE VALADEZ DE LA CRUZ","6151096830","VACJ911113HZ0","SE REALIZA EL CAMBIO POR CHAMARRA CAZADORA.","3","LA PAZ","PUEBLO NUEVO","5 DE FEBRERO","S/N","23060");
INSERT INTO RequisicionE VALUES ("81","21","2024-12-26 10:25:36","2024-12-26 11:01:40","Parcial","EDGAR ACOSTA ESCAREAGA","10","45","TODAS","488","EDGAR ACOSTA ESCAREAGA","6645205086","AOEE820107JI7","SE SUSTITUYEN CHAMARRAS CORTAS POR CAZADORAS.","2","MEXICALI","MEXICALI","CASTORES OCURRE","S/N","21399");
INSERT INTO RequisicionE VALUES ("82","21","2024-12-26 10:28:33","2024-12-26 11:01:34","Autorizado","RAUL GALLARDO VELAZQUEZ","10","45","TODAS","370","RAUL GALLARDO VELAZQUEZ","5576565867","GAVR701101625","SE SUSTITUYEN CHAMARRAS CORTAS POR CAZADORA-","25","CULIACAN","JORGE ALMADA","JOSE RIOS","950 PONIENTE","80200");
INSERT INTO RequisicionE VALUES ("83","31","2024-12-27 09:57:34","2024-12-27 11:33:48","Autorizado","Gabriel Reyes Garces","12","58","T2 AICM","1180","Gabriel Reyes Garces","5559549606","","Se realiza requisición de uniformes conforme a los elementos de nuevo ingreso.","9","Venustiano Carranza, CDMX","Aviación Civil ","Rolando Garros","131 piso 1","15740");
INSERT INTO RequisicionE VALUES ("84","30","2024-12-27 11:17:26","2024-12-27 11:33:40","Parcial","RONALD HERNANDEZ MARTI","10","46","","419","MANUEL LERMA REYES","5610118007","LERJ960727DT7","ajuste chamarras primera dotacion","28","CUIDAD VICTORIA","ma","FRAMBOYANMES","M311258","87170");
INSERT INTO RequisicionE VALUES ("85","30","2024-12-27 11:20:43","2024-12-27 11:33:33","Autorizado","JUAN CARLOS JAIME","10","46","","223","JUAN CARLOS JAIME","5559547902","JAHJ710602255","modificacion chamarras primera dotacion","24","SAN LUIS POTOSI","LOS MOLINOS","C MOLINO DEL REY","206","78150");
INSERT INTO RequisicionE VALUES ("86","30","2024-12-27 11:23:31","2025-01-02 12:47:23","Autorizado","ANTONIO RAMOS","10","46","","394","ANTONIO RAMOS","4443377878","AALR850728NH7","modificacion chamarras primera dotacion","19","MONTERREY","VILLA CUMBRES","AV ABRAHAM LINCOLN","6412","64116");
INSERT INTO RequisicionE VALUES ("87","21","2024-12-27 11:58:19","2024-12-31 08:36:13","Autorizado","JUAN JOSE VALADEZ DE LA CRUZ","10","45","TODAS","214","JUAN JOSE VALADEZ DE LA CRUZ","6151096830","VACJ911113HZ0","COMPLEMENTO DE PEDIDO YA QUE NO SE ENVIO POR FALTA DE INVENTARIO EN ALMACEN","3","LA PAZ","PUEBLO NUEVO","5 DE FEBRERO","S/N","23060");
INSERT INTO RequisicionE VALUES ("88","21","2024-12-27 12:10:33","2024-12-31 08:36:02","Autorizado","EDGAR ACOSTA ESCAREAGA","10","45","TODAS","488","EDGAR ACOSTA ESCAREAGA","6645205086","AOEE820107JI7","PENDIENTE DE ENVIO POR FALTA DE INVENTARIO EN ALMACEN.","2","MEXICALI","MEXICALI","CASTORES OCURRE","S/N","21399");
INSERT INTO RequisicionE VALUES ("89","24","2024-12-31 11:17:28","2025-01-02 12:47:39","Autorizado","GABRIELA EVANS","8","51","CVDR Unidad Cajeme","2","GABRIELA EVANS","55 5954 6596","EAFG680730HQ6","SE REQUIEREN UNIFORMES YA QUE SE ENCUENTRAN ROTOS Y DESGASTADOS","26","CD Obregón","primero de mayo","Mártires de cananea","1323","85098");
INSERT INTO RequisicionE VALUES ("90","29","2025-01-02 12:48:53","2025-01-02 12:50:55","Autorizado","EDUARDO AYALA LOPEZ","10","47","ZACATECAS","246","EDUARDO AYALA LOPEZ","7772678964","AEGS990115LU5","PRIMERA ENTREGA DE UNIFORMES 2025 (CAMBIO DE MODELO)","32","ZACATECAS","LA COMARCA","CHIQUE","20","98658");
INSERT INTO RequisicionE VALUES ("91","29","2025-01-02 12:49:00","2025-01-02 12:50:50","Parcial","MARIO ALBERTO FLORES ALEISSA","10","47","JALISCO","633","MARIO ALBERTO FLORES ALEISSA","5563162403","FOAM810606","PRIMERA ENTREGA DE UNIFORMES 2025 (CAMBIO MODELO)","14","GUADALAJARA","AMERICANA","CALZADA FEDERALISMO","420-B","44160");
INSERT INTO RequisicionE VALUES ("92","29","2025-01-02 12:49:06","2025-01-03 11:05:14","Parcial","SERGIO EDUARDO ARELLANO GONZALEZ","10","47","AGUASCALIENTES","151","SERGIO EDUARDO ARELLANO GONZLEZ","44999022224","AEGS990115LU5","PRIMERA ENTREGA DE UNIFORMES 2025 (CAMBIO DE MODELO)","1","AGUASCALIENTES","LA FUENTE","COQUIMBO","202-2","20230");
INSERT INTO RequisicionE VALUES ("93","29","2025-01-02 16:25:38","2025-01-04 09:49:12","Autorizado","SERGIO EDUARDO ARELLANO GONZALEZ","10","47","AGUASCALIENTES","151","SERGIO EDUARDO ARELLANO GONZLEZ","44999022224","AEGS990115LU5","CAMBIO DE TALLA DE LA PRIMERA ENTREGA DEL 2025 POR FALTA DE EXISTENCIA EN EL ALMACEN","1","AGUASCALIENTES","LA FUENTE","COQUIMBO","202-2","20230");
INSERT INTO RequisicionE VALUES ("94","29","2025-01-02 16:25:54","2025-01-03 11:05:05","Autorizado","MARIO ALBERTO FLORES ALEISSA","10","47","JALISCO","633","MARIO ALBERTO FLORES ALEISSA","5563162403","FOAM810606","CAMBIO DE TALLAS PRIMERA ENTREGA 2025 POR NO  TENER EN EXISTENCIA EN EL AMACÉN","14","GUADALAJARA","AMERICANA","CALZADA FEDERALISMO","420-B","44160");
INSERT INTO RequisicionE VALUES ("95","29","2025-01-02 16:29:14","2025-01-03 11:04:58","Autorizado","AARON RICARDO PALMA ROMN","10","47","NAYARIT","135","AARON RICARDO PALMA ROMAN","5578524024","PARA830627S26","CAMBIO DE TALLAS EN LA PRIMERA ENTREGA DE JUNIFORMES 2025 POR FALTA DE EXISTENCIA EN EL ALMACÉN","18","TEPIC","FRACCIONAMIENTO JACARANDAS","ROSAS","46","63195");
INSERT INTO RequisicionE VALUES ("96","29","2025-01-02 16:31:55","2025-01-03 11:04:50","Autorizado","EDUARDO AYALA LOPEZ","10","47","ZACATECAS","246","EDUARDO AYALA LOPEZ","7772678964","AEGS990115LU5","CAMBIO DE TALLAS EN LA PRIMERA ENTREGA DE UNIFORMES 2025 POR FALTA DE EXISTENCIA EN EL ALMACÉN","32","ZACATECAS","LA COMARCA","CHIQUE","20","98658");
INSERT INTO RequisicionE VALUES ("97","30","2025-01-03 17:24:58","2025-01-03 17:39:04","Parcial","Ximena torres","10","46","oficinas centrales IMSS CDMX","10","Ximena Torres","55 6415 7119","","uniformes para elementos de cctv oficinas centrales IMSS","28","","","","","");
INSERT INTO RequisicionE VALUES ("98","30","2025-01-04 09:47:46","2025-01-04 09:49:01","Surtido","Ximena torres","10","46","oficinas centrales IMSS CDMX","10","Ximena Torres","55 6415 7119","","ajuste de talla chamarras pedido anterior","28","","","","","");
INSERT INTO RequisicionE VALUES ("99","25","2025-01-06 12:42:52","","Pendiente","Angel Bazan Gutierrez","7","49","oficinas centrales","30","Angel Bazan Gutierrez","5528169856","","se solicitan uniformes por bajas de fin de año","17","","","","","");
INSERT INTO RequisicionE VALUES ("100","25","2025-01-06 12:47:49","","Pendiente","Angel Bazan Gutierrez","7","49","unidar regional cuernavaca","10","Angel Bazan Gutierrez","5528169856","","se solicitan uniformes por bajas de fin de año","17","","","","","");
INSERT INTO RequisicionE VALUES ("101","25","2025-01-06 13:53:34","","Pendiente","Angel Bazan Gutierrez","7","49","PC 107 Emiliano Zapata","16","Angel Bazan Gutierrez","5528169856","","se solicitan uniformes por bajas de fin de año","17","","","","","");
INSERT INTO RequisicionE VALUES ("102","23","2025-01-06 13:59:20","","Pendiente","Carlos Daniel Delgado Leal","7","53","Pte. Internacional Ojinaga, Blvd. Libre Comercio S/N, Cd. Ojinaga Chihuahua C.P. 32881","4","Carlos Daniel Delgado Leal","56 1522 0762","DELG930726AV1","Reposición de uniformes y equipo por desgaste y por rotación de personal, último envío de uniformes 15-10-24 y equipo 29-04-24","6","Aldama","Centro","17 entre Coronado y Morelos","406","32910");

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
) ENGINE=InnoDB AUTO_INCREMENT=1197 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO RequisicionD VALUES ("320","48","3","16","25");
INSERT INTO RequisicionD VALUES ("321","48","3","18","20");
INSERT INTO RequisicionD VALUES ("322","48","3","19","5");
INSERT INTO RequisicionD VALUES ("323","48","4","15","25");
INSERT INTO RequisicionD VALUES ("324","48","4","17","20");
INSERT INTO RequisicionD VALUES ("325","48","4","20","5");
INSERT INTO RequisicionD VALUES ("326","48","10","4","5");
INSERT INTO RequisicionD VALUES ("327","48","10","5","5");
INSERT INTO RequisicionD VALUES ("328","48","10","7","15");
INSERT INTO RequisicionD VALUES ("329","48","10","8","15");
INSERT INTO RequisicionD VALUES ("330","48","10","9","2");
INSERT INTO RequisicionD VALUES ("331","48","37","32","10");
INSERT INTO RequisicionD VALUES ("332","48","20","32","50");
INSERT INTO RequisicionD VALUES ("333","48","23","28","15");
INSERT INTO RequisicionD VALUES ("334","48","18","32","30");
INSERT INTO RequisicionD VALUES ("335","49","37","32","10");
INSERT INTO RequisicionD VALUES ("336","49","3","15","4");
INSERT INTO RequisicionD VALUES ("337","49","3","16","2");
INSERT INTO RequisicionD VALUES ("338","49","4","16","2");
INSERT INTO RequisicionD VALUES ("339","49","4","15","2");
INSERT INTO RequisicionD VALUES ("340","50","4","11","4");
INSERT INTO RequisicionD VALUES ("341","50","4","13","4");
INSERT INTO RequisicionD VALUES ("342","50","4","14","4");
INSERT INTO RequisicionD VALUES ("343","50","2","18","4");
INSERT INTO RequisicionD VALUES ("344","50","2","20","4");
INSERT INTO RequisicionD VALUES ("345","50","2","21","4");
INSERT INTO RequisicionD VALUES ("346","51","9","29","4");
INSERT INTO RequisicionD VALUES ("347","51","20","32","8");
INSERT INTO RequisicionD VALUES ("348","51","18","32","8");
INSERT INTO RequisicionD VALUES ("349","51","30","32","8");
INSERT INTO RequisicionD VALUES ("350","52","20","32","12");
INSERT INTO RequisicionD VALUES ("351","52","18","32","12");
INSERT INTO RequisicionD VALUES ("352","52","30","32","12");
INSERT INTO RequisicionD VALUES ("353","52","9","29","12");
INSERT INTO RequisicionD VALUES ("354","53","20","32","12");
INSERT INTO RequisicionD VALUES ("355","53","18","32","12");
INSERT INTO RequisicionD VALUES ("356","53","30","32","12");
INSERT INTO RequisicionD VALUES ("357","53","9","28","6");
INSERT INTO RequisicionD VALUES ("358","54","54","13","5");
INSERT INTO RequisicionD VALUES ("359","54","54","14","5");
INSERT INTO RequisicionD VALUES ("360","54","54","15","10");
INSERT INTO RequisicionD VALUES ("361","54","10","2","1");
INSERT INTO RequisicionD VALUES ("362","54","10","3","4");
INSERT INTO RequisicionD VALUES ("363","54","10","4","2");
INSERT INTO RequisicionD VALUES ("364","54","10","5","3");
INSERT INTO RequisicionD VALUES ("365","54","10","6","1");
INSERT INTO RequisicionD VALUES ("366","54","10","1","1");
INSERT INTO RequisicionD VALUES ("367","54","10","7","1");
INSERT INTO RequisicionD VALUES ("368","55","59","26","125");
INSERT INTO RequisicionD VALUES ("369","55","59","27","199");
INSERT INTO RequisicionD VALUES ("370","55","59","28","199");
INSERT INTO RequisicionD VALUES ("371","55","59","29","36");
INSERT INTO RequisicionD VALUES ("372","56","1","14","3");
INSERT INTO RequisicionD VALUES ("373","56","1","15","2");
INSERT INTO RequisicionD VALUES ("374","56","1","16","1");
INSERT INTO RequisicionD VALUES ("375","56","1","17","2");
INSERT INTO RequisicionD VALUES ("376","56","4","13","1");
INSERT INTO RequisicionD VALUES ("377","56","4","14","4");
INSERT INTO RequisicionD VALUES ("378","56","4","16","2");
INSERT INTO RequisicionD VALUES ("379","56","4","18","1");
INSERT INTO RequisicionD VALUES ("380","56","10","3","1");
INSERT INTO RequisicionD VALUES ("381","56","10","5","3");
INSERT INTO RequisicionD VALUES ("382","56","10","6","2");
INSERT INTO RequisicionD VALUES ("383","56","10","7","2");
INSERT INTO RequisicionD VALUES ("384","56","8","25","8");
INSERT INTO RequisicionD VALUES ("385","56","20","32","8");
INSERT INTO RequisicionD VALUES ("386","56","23","29","6");
INSERT INTO RequisicionD VALUES ("387","56","23","28","2");
INSERT INTO RequisicionD VALUES ("388","56","31","32","4");
INSERT INTO RequisicionD VALUES ("389","57","9","27","10");
INSERT INTO RequisicionD VALUES ("390","57","9","29","5");
INSERT INTO RequisicionD VALUES ("391","57","9","28","5");
INSERT INTO RequisicionD VALUES ("392","57","3","11","10");
INSERT INTO RequisicionD VALUES ("393","57","3","15","7");
INSERT INTO RequisicionD VALUES ("394","57","4","11","10");
INSERT INTO RequisicionD VALUES ("395","57","4","14","7");
INSERT INTO RequisicionD VALUES ("396","57","24","32","1");
INSERT INTO RequisicionD VALUES ("397","57","20","32","20");
INSERT INTO RequisicionD VALUES ("398","57","21","32","14");
INSERT INTO RequisicionD VALUES ("399","57","33","32","1");
INSERT INTO RequisicionD VALUES ("400","57","55","28","14");
INSERT INTO RequisicionD VALUES ("401","57","37","32","6");
INSERT INTO RequisicionD VALUES ("402","58","3","14","15");
INSERT INTO RequisicionD VALUES ("403","58","3","16","15");
INSERT INTO RequisicionD VALUES ("404","58","4","14","20");
INSERT INTO RequisicionD VALUES ("405","58","4","15","10");
INSERT INTO RequisicionD VALUES ("406","58","9","28","15");
INSERT INTO RequisicionD VALUES ("407","58","9","27","15");
INSERT INTO RequisicionD VALUES ("408","58","20","32","30");
INSERT INTO RequisicionD VALUES ("409","58","22","32","10");
INSERT INTO RequisicionD VALUES ("410","58","30","32","5");
INSERT INTO RequisicionD VALUES ("411","58","41","32","1");
INSERT INTO RequisicionD VALUES ("412","58","40","32","1");
INSERT INTO RequisicionD VALUES ("413","58","33","32","2");
INSERT INTO RequisicionD VALUES ("414","58","3","13","2");
INSERT INTO RequisicionD VALUES ("415","58","4","13","2");
INSERT INTO RequisicionD VALUES ("416","58","9","26","2");
INSERT INTO RequisicionD VALUES ("417","58","55","28","10");
INSERT INTO RequisicionD VALUES ("418","59","1","17","2");
INSERT INTO RequisicionD VALUES ("419","59","1","21","2");
INSERT INTO RequisicionD VALUES ("420","59","10","6","1");
INSERT INTO RequisicionD VALUES ("421","59","4","16","2");
INSERT INTO RequisicionD VALUES ("422","59","4","19","1");
INSERT INTO RequisicionD VALUES ("423","59","4","21","1");
INSERT INTO RequisicionD VALUES ("424","59","9","29","3");
INSERT INTO RequisicionD VALUES ("455","61","3","14","95");
INSERT INTO RequisicionD VALUES ("456","61","3","15","103");
INSERT INTO RequisicionD VALUES ("457","61","3","17","150");
INSERT INTO RequisicionD VALUES ("458","61","3","18","46");
INSERT INTO RequisicionD VALUES ("459","61","4","14","95");
INSERT INTO RequisicionD VALUES ("460","61","4","15","103");
INSERT INTO RequisicionD VALUES ("461","61","4","17","150");
INSERT INTO RequisicionD VALUES ("462","61","4","18","46");
INSERT INTO RequisicionD VALUES ("463","61","10","3","80");
INSERT INTO RequisicionD VALUES ("464","61","10","5","39");
INSERT INTO RequisicionD VALUES ("465","61","10","6","110");
INSERT INTO RequisicionD VALUES ("466","61","10","7","110");
INSERT INTO RequisicionD VALUES ("467","61","10","8","40");
INSERT INTO RequisicionD VALUES ("468","61","10","9","15");
INSERT INTO RequisicionD VALUES ("469","61","8","28","180");
INSERT INTO RequisicionD VALUES ("470","61","8","29","50");
INSERT INTO RequisicionD VALUES ("471","61","8","27","110");
INSERT INTO RequisicionD VALUES ("472","61","20","32","394");
INSERT INTO RequisicionD VALUES ("473","61","22","32","394");
INSERT INTO RequisicionD VALUES ("474","61","27","32","394");
INSERT INTO RequisicionD VALUES ("475","61","25","32","394");
INSERT INTO RequisicionD VALUES ("476","61","30","32","394");
INSERT INTO RequisicionD VALUES ("477","61","36","32","176");
INSERT INTO RequisicionD VALUES ("478","61","31","32","137");
INSERT INTO RequisicionD VALUES ("479","61","24","32","394");
INSERT INTO RequisicionD VALUES ("480","62","3","9","10");
INSERT INTO RequisicionD VALUES ("481","62","3","11","40");
INSERT INTO RequisicionD VALUES ("482","62","3","13","50");
INSERT INTO RequisicionD VALUES ("483","62","3","14","50");
INSERT INTO RequisicionD VALUES ("484","62","3","15","50");
INSERT INTO RequisicionD VALUES ("485","62","3","16","35");
INSERT INTO RequisicionD VALUES ("486","62","3","17","39");
INSERT INTO RequisicionD VALUES ("487","62","3","18","45");
INSERT INTO RequisicionD VALUES ("488","62","3","19","35");
INSERT INTO RequisicionD VALUES ("489","62","3","20","25");
INSERT INTO RequisicionD VALUES ("490","62","3","21","10");
INSERT INTO RequisicionD VALUES ("491","62","4","11","40");
INSERT INTO RequisicionD VALUES ("492","62","4","13","50");
INSERT INTO RequisicionD VALUES ("493","62","4","14","50");
INSERT INTO RequisicionD VALUES ("494","62","4","9","10");
INSERT INTO RequisicionD VALUES ("495","62","4","15","50");
INSERT INTO RequisicionD VALUES ("496","62","4","16","35");
INSERT INTO RequisicionD VALUES ("497","62","4","17","39");
INSERT INTO RequisicionD VALUES ("498","62","4","18","45");
INSERT INTO RequisicionD VALUES ("499","62","4","19","35");
INSERT INTO RequisicionD VALUES ("500","62","4","20","25");
INSERT INTO RequisicionD VALUES ("501","62","4","21","10");
INSERT INTO RequisicionD VALUES ("502","62","10","3","60");
INSERT INTO RequisicionD VALUES ("503","62","10","4","60");
INSERT INTO RequisicionD VALUES ("504","62","10","5","60");
INSERT INTO RequisicionD VALUES ("505","62","10","6","60");
INSERT INTO RequisicionD VALUES ("506","62","10","7","70");
INSERT INTO RequisicionD VALUES ("507","62","10","8","50");
INSERT INTO RequisicionD VALUES ("508","62","10","9","29");
INSERT INTO RequisicionD VALUES ("509","62","23","30","389");
INSERT INTO RequisicionD VALUES ("510","62","9","27","80");
INSERT INTO RequisicionD VALUES ("511","62","9","28","140");
INSERT INTO RequisicionD VALUES ("512","62","9","29","119");
INSERT INTO RequisicionD VALUES ("513","62","9","30","50");
INSERT INTO RequisicionD VALUES ("514","62","20","32","389");
INSERT INTO RequisicionD VALUES ("515","62","27","32","389");
INSERT INTO RequisicionD VALUES ("516","62","24","32","389");
INSERT INTO RequisicionD VALUES ("517","62","31","32","152");
INSERT INTO RequisicionD VALUES ("518","62","36","32","140");
INSERT INTO RequisicionD VALUES ("519","62","25","32","389");
INSERT INTO RequisicionD VALUES ("520","62","30","32","389");
INSERT INTO RequisicionD VALUES ("521","63","4","7","4");
INSERT INTO RequisicionD VALUES ("522","63","4","9","8");
INSERT INTO RequisicionD VALUES ("523","63","4","11","8");
INSERT INTO RequisicionD VALUES ("524","63","4","13","8");
INSERT INTO RequisicionD VALUES ("525","63","4","14","18");
INSERT INTO RequisicionD VALUES ("526","63","4","15","22");
INSERT INTO RequisicionD VALUES ("527","63","4","16","22");
INSERT INTO RequisicionD VALUES ("528","63","4","17","13");
INSERT INTO RequisicionD VALUES ("529","63","4","18","13");
INSERT INTO RequisicionD VALUES ("530","63","4","19","13");
INSERT INTO RequisicionD VALUES ("531","63","4","21","8");
INSERT INTO RequisicionD VALUES ("532","63","3","7","4");
INSERT INTO RequisicionD VALUES ("533","63","3","9","8");
INSERT INTO RequisicionD VALUES ("534","63","3","11","8");
INSERT INTO RequisicionD VALUES ("535","63","3","13","8");
INSERT INTO RequisicionD VALUES ("536","63","3","14","18");
INSERT INTO RequisicionD VALUES ("537","63","3","15","25");
INSERT INTO RequisicionD VALUES ("538","63","3","16","22");
INSERT INTO RequisicionD VALUES ("539","63","3","17","16");
INSERT INTO RequisicionD VALUES ("540","63","3","18","12");
INSERT INTO RequisicionD VALUES ("541","63","3","19","12");
INSERT INTO RequisicionD VALUES ("542","63","3","21","4");
INSERT INTO RequisicionD VALUES ("543","63","25","32","50");
INSERT INTO RequisicionD VALUES ("544","63","23","28","20");
INSERT INTO RequisicionD VALUES ("545","63","31","32","30");
INSERT INTO RequisicionD VALUES ("546","63","20","32","135");
INSERT INTO RequisicionD VALUES ("547","63","10","2","3");
INSERT INTO RequisicionD VALUES ("548","63","10","3","6");
INSERT INTO RequisicionD VALUES ("549","63","10","4","12");
INSERT INTO RequisicionD VALUES ("550","63","10","5","30");
INSERT INTO RequisicionD VALUES ("551","63","10","6","40");
INSERT INTO RequisicionD VALUES ("552","63","10","7","30");
INSERT INTO RequisicionD VALUES ("553","63","10","8","8");
INSERT INTO RequisicionD VALUES ("554","63","10","9","8");
INSERT INTO RequisicionD VALUES ("555","63","24","32","10");
INSERT INTO RequisicionD VALUES ("556","63","56","32","10");
INSERT INTO RequisicionD VALUES ("557","63","30","32","50");
INSERT INTO RequisicionD VALUES ("558","63","36","32","30");
INSERT INTO RequisicionD VALUES ("559","64","4","7","5");
INSERT INTO RequisicionD VALUES ("560","64","4","9","4");
INSERT INTO RequisicionD VALUES ("561","64","4","11","15");
INSERT INTO RequisicionD VALUES ("562","64","4","13","29");
INSERT INTO RequisicionD VALUES ("563","64","4","14","41");
INSERT INTO RequisicionD VALUES ("564","64","4","15","18");
INSERT INTO RequisicionD VALUES ("565","64","4","17","9");
INSERT INTO RequisicionD VALUES ("566","64","4","16","17");
INSERT INTO RequisicionD VALUES ("567","64","4","18","6");
INSERT INTO RequisicionD VALUES ("568","64","4","19","3");
INSERT INTO RequisicionD VALUES ("569","64","4","20","4");
INSERT INTO RequisicionD VALUES ("570","64","4","21","3");
INSERT INTO RequisicionD VALUES ("571","64","4","22","2");
INSERT INTO RequisicionD VALUES ("572","64","3","9","2");
INSERT INTO RequisicionD VALUES ("573","64","3","11","14");
INSERT INTO RequisicionD VALUES ("574","64","3","13","14");
INSERT INTO RequisicionD VALUES ("575","64","3","14","25");
INSERT INTO RequisicionD VALUES ("576","64","3","15","28");
INSERT INTO RequisicionD VALUES ("577","64","3","16","27");
INSERT INTO RequisicionD VALUES ("578","64","3","17","21");
INSERT INTO RequisicionD VALUES ("579","64","3","18","11");
INSERT INTO RequisicionD VALUES ("580","64","3","19","4");
INSERT INTO RequisicionD VALUES ("581","64","3","20","3");
INSERT INTO RequisicionD VALUES ("582","64","3","21","4");
INSERT INTO RequisicionD VALUES ("583","64","3","22","3");
INSERT INTO RequisicionD VALUES ("584","64","25","32","151");
INSERT INTO RequisicionD VALUES ("585","64","8","26","8");
INSERT INTO RequisicionD VALUES ("586","64","8","27","29");
INSERT INTO RequisicionD VALUES ("587","64","8","28","47");
INSERT INTO RequisicionD VALUES ("588","64","8","29","49");
INSERT INTO RequisicionD VALUES ("589","64","8","30","14");
INSERT INTO RequisicionD VALUES ("590","64","8","31","4");
INSERT INTO RequisicionD VALUES ("591","64","20","32","151");
INSERT INTO RequisicionD VALUES ("592","64","10","1","3");
INSERT INTO RequisicionD VALUES ("593","64","10","2","9");
INSERT INTO RequisicionD VALUES ("594","64","10","3","20");
INSERT INTO RequisicionD VALUES ("595","64","10","4","25");
INSERT INTO RequisicionD VALUES ("596","64","10","5","33");
INSERT INTO RequisicionD VALUES ("597","64","10","6","29");
INSERT INTO RequisicionD VALUES ("598","64","10","7","23");
INSERT INTO RequisicionD VALUES ("599","64","10","8","6");
INSERT INTO RequisicionD VALUES ("600","64","10","9","3");
INSERT INTO RequisicionD VALUES ("601","64","22","32","151");
INSERT INTO RequisicionD VALUES ("602","64","24","32","151");
INSERT INTO RequisicionD VALUES ("603","64","56","32","151");
INSERT INTO RequisicionD VALUES ("604","64","30","32","151");
INSERT INTO RequisicionD VALUES ("605","64","31","32","58");
INSERT INTO RequisicionD VALUES ("606","64","27","32","151");
INSERT INTO RequisicionD VALUES ("607","64","36","32","65");
INSERT INTO RequisicionD VALUES ("608","65","4","9","5");
INSERT INTO RequisicionD VALUES ("609","65","4","11","25");
INSERT INTO RequisicionD VALUES ("610","65","4","13","45");
INSERT INTO RequisicionD VALUES ("611","65","4","14","45");
INSERT INTO RequisicionD VALUES ("612","65","4","15","45");
INSERT INTO RequisicionD VALUES ("613","65","4","16","34");
INSERT INTO RequisicionD VALUES ("614","65","4","17","15");
INSERT INTO RequisicionD VALUES ("615","65","4","18","15");
INSERT INTO RequisicionD VALUES ("616","65","4","20","10");
INSERT INTO RequisicionD VALUES ("617","65","4","21","5");
INSERT INTO RequisicionD VALUES ("618","65","4","22","2");
INSERT INTO RequisicionD VALUES ("619","65","3","9","5");
INSERT INTO RequisicionD VALUES ("620","65","3","11","20");
INSERT INTO RequisicionD VALUES ("621","65","3","13","45");
INSERT INTO RequisicionD VALUES ("622","65","3","14","45");
INSERT INTO RequisicionD VALUES ("623","65","3","15","45");
INSERT INTO RequisicionD VALUES ("624","65","3","16","26");
INSERT INTO RequisicionD VALUES ("625","65","3","17","20");
INSERT INTO RequisicionD VALUES ("626","65","3","18","15");
INSERT INTO RequisicionD VALUES ("627","65","3","19","10");
INSERT INTO RequisicionD VALUES ("628","65","3","20","5");
INSERT INTO RequisicionD VALUES ("629","65","3","21","5");
INSERT INTO RequisicionD VALUES ("630","65","3","23","5");
INSERT INTO RequisicionD VALUES ("631","65","25","32","237");
INSERT INTO RequisicionD VALUES ("632","65","22","32","80");
INSERT INTO RequisicionD VALUES ("633","65","23","28","40");
INSERT INTO RequisicionD VALUES ("634","65","8","26","50");
INSERT INTO RequisicionD VALUES ("635","65","8","27","90");
INSERT INTO RequisicionD VALUES ("636","65","8","28","60");
INSERT INTO RequisicionD VALUES ("637","65","8","29","30");
INSERT INTO RequisicionD VALUES ("638","65","8","30","5");
INSERT INTO RequisicionD VALUES ("639","65","8","31","2");
INSERT INTO RequisicionD VALUES ("640","65","20","32","237");
INSERT INTO RequisicionD VALUES ("641","65","10","2","7");
INSERT INTO RequisicionD VALUES ("642","65","10","3","40");
INSERT INTO RequisicionD VALUES ("643","65","10","4","50");
INSERT INTO RequisicionD VALUES ("644","65","10","5","60");
INSERT INTO RequisicionD VALUES ("645","65","10","6","40");
INSERT INTO RequisicionD VALUES ("646","65","10","7","20");
INSERT INTO RequisicionD VALUES ("647","65","10","8","17");
INSERT INTO RequisicionD VALUES ("648","65","10","9","3");
INSERT INTO RequisicionD VALUES ("649","65","24","32","120");
INSERT INTO RequisicionD VALUES ("650","65","56","32","120");
INSERT INTO RequisicionD VALUES ("651","65","30","32","120");
INSERT INTO RequisicionD VALUES ("652","65","31","32","64");
INSERT INTO RequisicionD VALUES ("653","65","36","32","62");
INSERT INTO RequisicionD VALUES ("654","65","27","32","237");
INSERT INTO RequisicionD VALUES ("655","66","4","7","20");
INSERT INTO RequisicionD VALUES ("656","66","4","9","40");
INSERT INTO RequisicionD VALUES ("657","66","4","11","70");
INSERT INTO RequisicionD VALUES ("658","66","4","13","120");
INSERT INTO RequisicionD VALUES ("659","66","4","14","90");
INSERT INTO RequisicionD VALUES ("660","66","4","15","90");
INSERT INTO RequisicionD VALUES ("661","66","4","16","60");
INSERT INTO RequisicionD VALUES ("662","66","4","17","25");
INSERT INTO RequisicionD VALUES ("663","66","4","18","40");
INSERT INTO RequisicionD VALUES ("664","66","4","19","25");
INSERT INTO RequisicionD VALUES ("665","66","4","20","18");
INSERT INTO RequisicionD VALUES ("666","66","4","21","18");
INSERT INTO RequisicionD VALUES ("667","66","4","22","15");
INSERT INTO RequisicionD VALUES ("668","66","4","23","3");
INSERT INTO RequisicionD VALUES ("669","66","3","7","65");
INSERT INTO RequisicionD VALUES ("670","66","3","9","55");
INSERT INTO RequisicionD VALUES ("671","66","3","11","75");
INSERT INTO RequisicionD VALUES ("672","66","3","13","90");
INSERT INTO RequisicionD VALUES ("673","66","3","14","90");
INSERT INTO RequisicionD VALUES ("674","66","3","15","85");
INSERT INTO RequisicionD VALUES ("675","66","3","16","65");
INSERT INTO RequisicionD VALUES ("676","66","3","17","45");
INSERT INTO RequisicionD VALUES ("677","66","3","18","20");
INSERT INTO RequisicionD VALUES ("678","66","3","19","15");
INSERT INTO RequisicionD VALUES ("679","66","3","20","13");
INSERT INTO RequisicionD VALUES ("680","66","3","21","13");
INSERT INTO RequisicionD VALUES ("681","66","3","22","3");
INSERT INTO RequisicionD VALUES ("682","66","25","32","633");
INSERT INTO RequisicionD VALUES ("683","66","22","32","400");
INSERT INTO RequisicionD VALUES ("684","66","23","28","80");
INSERT INTO RequisicionD VALUES ("685","66","8","26","90");
INSERT INTO RequisicionD VALUES ("686","66","8","27","184");
INSERT INTO RequisicionD VALUES ("687","66","8","28","184");
INSERT INTO RequisicionD VALUES ("688","66","8","29","95");
INSERT INTO RequisicionD VALUES ("689","66","8","30","80");
INSERT INTO RequisicionD VALUES ("690","66","20","32","633");
INSERT INTO RequisicionD VALUES ("691","66","10","1","10");
INSERT INTO RequisicionD VALUES ("692","66","10","2","80");
INSERT INTO RequisicionD VALUES ("693","66","10","3","70");
INSERT INTO RequisicionD VALUES ("694","66","10","4","70");
INSERT INTO RequisicionD VALUES ("695","66","10","5","130");
INSERT INTO RequisicionD VALUES ("696","66","10","6","153");
INSERT INTO RequisicionD VALUES ("697","66","10","7","70");
INSERT INTO RequisicionD VALUES ("698","66","10","8","30");
INSERT INTO RequisicionD VALUES ("699","66","10","9","20");
INSERT INTO RequisicionD VALUES ("700","66","24","32","300");
INSERT INTO RequisicionD VALUES ("701","66","56","32","633");
INSERT INTO RequisicionD VALUES ("702","66","30","32","633");
INSERT INTO RequisicionD VALUES ("703","66","31","32","200");
INSERT INTO RequisicionD VALUES ("704","66","27","32","633");
INSERT INTO RequisicionD VALUES ("705","66","36","32","206");
INSERT INTO RequisicionD VALUES ("727","68","3","9","6");
INSERT INTO RequisicionD VALUES ("728","68","3","11","8");
INSERT INTO RequisicionD VALUES ("729","68","3","13","29");
INSERT INTO RequisicionD VALUES ("730","68","3","14","37");
INSERT INTO RequisicionD VALUES ("731","68","3","15","75");
INSERT INTO RequisicionD VALUES ("732","68","3","16","84");
INSERT INTO RequisicionD VALUES ("733","68","3","17","65");
INSERT INTO RequisicionD VALUES ("734","68","3","18","30");
INSERT INTO RequisicionD VALUES ("735","68","3","19","14");
INSERT INTO RequisicionD VALUES ("736","68","3","20","10");
INSERT INTO RequisicionD VALUES ("737","68","3","21","20");
INSERT INTO RequisicionD VALUES ("738","68","4","9","4");
INSERT INTO RequisicionD VALUES ("739","68","4","11","22");
INSERT INTO RequisicionD VALUES ("740","68","4","13","46");
INSERT INTO RequisicionD VALUES ("741","68","4","14","75");
INSERT INTO RequisicionD VALUES ("742","68","4","15","77");
INSERT INTO RequisicionD VALUES ("743","68","4","16","65");
INSERT INTO RequisicionD VALUES ("744","68","4","17","31");
INSERT INTO RequisicionD VALUES ("745","68","4","18","23");
INSERT INTO RequisicionD VALUES ("746","68","4","19","9");
INSERT INTO RequisicionD VALUES ("747","68","4","20","5");
INSERT INTO RequisicionD VALUES ("748","68","4","21","15");
INSERT INTO RequisicionD VALUES ("749","68","10","2","7");
INSERT INTO RequisicionD VALUES ("750","68","10","3","32");
INSERT INTO RequisicionD VALUES ("751","68","10","4","34");
INSERT INTO RequisicionD VALUES ("752","68","10","5","62");
INSERT INTO RequisicionD VALUES ("753","68","10","6","89");
INSERT INTO RequisicionD VALUES ("754","68","10","7","87");
INSERT INTO RequisicionD VALUES ("755","68","10","8","44");
INSERT INTO RequisicionD VALUES ("756","68","9","27","94");
INSERT INTO RequisicionD VALUES ("757","68","9","28","120");
INSERT INTO RequisicionD VALUES ("758","68","9","29","128");
INSERT INTO RequisicionD VALUES ("759","68","9","30","30");
INSERT INTO RequisicionD VALUES ("760","68","10","9","11");
INSERT INTO RequisicionD VALUES ("761","68","10","10","6");
INSERT INTO RequisicionD VALUES ("762","68","20","32","372");
INSERT INTO RequisicionD VALUES ("763","68","23","29","372");
INSERT INTO RequisicionD VALUES ("764","68","27","32","372");
INSERT INTO RequisicionD VALUES ("765","68","24","32","372");
INSERT INTO RequisicionD VALUES ("766","68","31","32","144");
INSERT INTO RequisicionD VALUES ("767","68","25","32","372");
INSERT INTO RequisicionD VALUES ("768","68","30","32","372");
INSERT INTO RequisicionD VALUES ("769","68","36","32","151");
INSERT INTO RequisicionD VALUES ("770","69","4","13","25");
INSERT INTO RequisicionD VALUES ("771","69","4","14","25");
INSERT INTO RequisicionD VALUES ("772","69","4","15","25");
INSERT INTO RequisicionD VALUES ("773","69","4","16","25");
INSERT INTO RequisicionD VALUES ("774","69","4","17","25");
INSERT INTO RequisicionD VALUES ("775","69","4","18","25");
INSERT INTO RequisicionD VALUES ("776","69","4","19","25");
INSERT INTO RequisicionD VALUES ("777","69","4","20","25");
INSERT INTO RequisicionD VALUES ("778","69","4","21","10");
INSERT INTO RequisicionD VALUES ("779","69","10","6","20");
INSERT INTO RequisicionD VALUES ("780","69","10","5","20");
INSERT INTO RequisicionD VALUES ("781","69","10","7","20");
INSERT INTO RequisicionD VALUES ("782","69","10","8","20");
INSERT INTO RequisicionD VALUES ("783","69","10","9","20");
INSERT INTO RequisicionD VALUES ("784","69","10","10","20");
INSERT INTO RequisicionD VALUES ("785","69","3","13","25");
INSERT INTO RequisicionD VALUES ("786","69","3","14","25");
INSERT INTO RequisicionD VALUES ("787","69","8","26","50");
INSERT INTO RequisicionD VALUES ("788","69","8","27","50");
INSERT INTO RequisicionD VALUES ("789","69","8","28","50");
INSERT INTO RequisicionD VALUES ("790","69","8","29","50");
INSERT INTO RequisicionD VALUES ("791","69","8","30","10");
INSERT INTO RequisicionD VALUES ("792","69","20","32","200");
INSERT INTO RequisicionD VALUES ("793","69","22","32","150");
INSERT INTO RequisicionD VALUES ("794","69","25","32","150");
INSERT INTO RequisicionD VALUES ("795","69","24","32","100");
INSERT INTO RequisicionD VALUES ("796","69","27","32","214");
INSERT INTO RequisicionD VALUES ("797","69","30","32","100");
INSERT INTO RequisicionD VALUES ("798","69","29","32","100");
INSERT INTO RequisicionD VALUES ("799","69","3","15","25");
INSERT INTO RequisicionD VALUES ("800","69","3","16","50");
INSERT INTO RequisicionD VALUES ("801","69","3","17","25");
INSERT INTO RequisicionD VALUES ("802","69","3","18","25");
INSERT INTO RequisicionD VALUES ("803","69","3","19","25");
INSERT INTO RequisicionD VALUES ("804","69","3","20","25");
INSERT INTO RequisicionD VALUES ("805","69","3","21","10");
INSERT INTO RequisicionD VALUES ("806","70","4","13","100");
INSERT INTO RequisicionD VALUES ("807","70","4","14","110");
INSERT INTO RequisicionD VALUES ("808","70","4","15","100");
INSERT INTO RequisicionD VALUES ("809","70","4","16","50");
INSERT INTO RequisicionD VALUES ("810","70","4","17","50");
INSERT INTO RequisicionD VALUES ("811","70","4","18","20");
INSERT INTO RequisicionD VALUES ("812","70","4","19","20");
INSERT INTO RequisicionD VALUES ("813","70","4","21","15");
INSERT INTO RequisicionD VALUES ("814","70","4","22","5");
INSERT INTO RequisicionD VALUES ("815","70","3","14","40");
INSERT INTO RequisicionD VALUES ("816","70","3","15","100");
INSERT INTO RequisicionD VALUES ("817","70","3","16","100");
INSERT INTO RequisicionD VALUES ("818","70","3","17","50");
INSERT INTO RequisicionD VALUES ("819","70","3","18","50");
INSERT INTO RequisicionD VALUES ("820","70","3","19","50");
INSERT INTO RequisicionD VALUES ("821","70","3","20","50");
INSERT INTO RequisicionD VALUES ("822","70","3","21","15");
INSERT INTO RequisicionD VALUES ("823","70","3","22","15");
INSERT INTO RequisicionD VALUES ("824","70","10","3","30");
INSERT INTO RequisicionD VALUES ("825","70","10","4","30");
INSERT INTO RequisicionD VALUES ("826","70","10","5","50");
INSERT INTO RequisicionD VALUES ("827","70","10","6","50");
INSERT INTO RequisicionD VALUES ("828","70","10","7","50");
INSERT INTO RequisicionD VALUES ("829","70","10","8","50");
INSERT INTO RequisicionD VALUES ("830","70","10","9","50");
INSERT INTO RequisicionD VALUES ("831","70","10","10","10");
INSERT INTO RequisicionD VALUES ("832","70","8","26","50");
INSERT INTO RequisicionD VALUES ("833","70","8","27","50");
INSERT INTO RequisicionD VALUES ("834","70","8","28","50");
INSERT INTO RequisicionD VALUES ("835","70","8","30","50");
INSERT INTO RequisicionD VALUES ("836","70","8","31","20");
INSERT INTO RequisicionD VALUES ("837","70","8","29","50");
INSERT INTO RequisicionD VALUES ("838","70","20","32","488");
INSERT INTO RequisicionD VALUES ("839","70","22","32","100");
INSERT INTO RequisicionD VALUES ("840","70","25","32","200");
INSERT INTO RequisicionD VALUES ("841","70","24","32","20");
INSERT INTO RequisicionD VALUES ("842","70","27","32","0");
INSERT INTO RequisicionD VALUES ("843","70","30","32","50");
INSERT INTO RequisicionD VALUES ("844","70","29","32","90");
INSERT INTO RequisicionD VALUES ("845","71","4","9","20");
INSERT INTO RequisicionD VALUES ("846","71","4","11","30");
INSERT INTO RequisicionD VALUES ("847","71","4","13","80");
INSERT INTO RequisicionD VALUES ("848","71","4","14","80");
INSERT INTO RequisicionD VALUES ("849","71","4","15","20");
INSERT INTO RequisicionD VALUES ("850","71","4","16","50");
INSERT INTO RequisicionD VALUES ("851","71","4","17","40");
INSERT INTO RequisicionD VALUES ("852","71","4","19","30");
INSERT INTO RequisicionD VALUES ("853","71","4","20","10");
INSERT INTO RequisicionD VALUES ("854","71","4","21","10");
INSERT INTO RequisicionD VALUES ("855","71","10","4","20");
INSERT INTO RequisicionD VALUES ("856","71","10","3","20");
INSERT INTO RequisicionD VALUES ("857","71","10","5","20");
INSERT INTO RequisicionD VALUES ("858","71","3","9","20");
INSERT INTO RequisicionD VALUES ("859","71","3","11","30");
INSERT INTO RequisicionD VALUES ("860","71","3","13","80");
INSERT INTO RequisicionD VALUES ("861","71","3","14","80");
INSERT INTO RequisicionD VALUES ("862","71","3","15","20");
INSERT INTO RequisicionD VALUES ("863","71","3","16","50");
INSERT INTO RequisicionD VALUES ("864","71","3","17","40");
INSERT INTO RequisicionD VALUES ("865","71","3","19","30");
INSERT INTO RequisicionD VALUES ("866","71","3","20","10");
INSERT INTO RequisicionD VALUES ("867","71","3","21","10");
INSERT INTO RequisicionD VALUES ("868","71","10","6","50");
INSERT INTO RequisicionD VALUES ("869","71","10","7","50");
INSERT INTO RequisicionD VALUES ("870","71","10","8","50");
INSERT INTO RequisicionD VALUES ("871","71","10","9","30");
INSERT INTO RequisicionD VALUES ("872","71","8","26","50");
INSERT INTO RequisicionD VALUES ("873","71","8","27","50");
INSERT INTO RequisicionD VALUES ("874","71","8","28","100");
INSERT INTO RequisicionD VALUES ("875","71","8","29","50");
INSERT INTO RequisicionD VALUES ("876","71","8","30","50");
INSERT INTO RequisicionD VALUES ("877","71","20","32","350");
INSERT INTO RequisicionD VALUES ("878","71","22","32","300");
INSERT INTO RequisicionD VALUES ("879","71","24","32","50");
INSERT INTO RequisicionD VALUES ("880","71","25","32","300");
INSERT INTO RequisicionD VALUES ("881","71","27","32","350");
INSERT INTO RequisicionD VALUES ("882","71","30","32","50");
INSERT INTO RequisicionD VALUES ("883","71","29","32","100");
INSERT INTO RequisicionD VALUES ("884","72","4","11","60");
INSERT INTO RequisicionD VALUES ("885","72","4","13","60");
INSERT INTO RequisicionD VALUES ("886","72","4","14","80");
INSERT INTO RequisicionD VALUES ("887","72","4","15","80");
INSERT INTO RequisicionD VALUES ("888","72","4","16","50");
INSERT INTO RequisicionD VALUES ("889","72","4","17","60");
INSERT INTO RequisicionD VALUES ("890","72","4","19","40");
INSERT INTO RequisicionD VALUES ("891","72","4","20","40");
INSERT INTO RequisicionD VALUES ("892","72","4","21","30");
INSERT INTO RequisicionD VALUES ("893","72","4","22","25");
INSERT INTO RequisicionD VALUES ("894","72","4","18","45");
INSERT INTO RequisicionD VALUES ("895","72","3","13","70");
INSERT INTO RequisicionD VALUES ("896","72","3","14","60");
INSERT INTO RequisicionD VALUES ("897","72","3","15","70");
INSERT INTO RequisicionD VALUES ("898","72","3","16","70");
INSERT INTO RequisicionD VALUES ("899","72","3","17","70");
INSERT INTO RequisicionD VALUES ("900","72","3","18","70");
INSERT INTO RequisicionD VALUES ("901","72","3","19","40");
INSERT INTO RequisicionD VALUES ("902","72","3","20","70");
INSERT INTO RequisicionD VALUES ("903","72","3","21","20");
INSERT INTO RequisicionD VALUES ("904","72","3","22","20");
INSERT INTO RequisicionD VALUES ("905","72","10","3","20");
INSERT INTO RequisicionD VALUES ("906","72","10","4","20");
INSERT INTO RequisicionD VALUES ("907","72","10","5","50");
INSERT INTO RequisicionD VALUES ("908","72","10","6","50");
INSERT INTO RequisicionD VALUES ("909","72","10","7","50");
INSERT INTO RequisicionD VALUES ("910","72","10","8","50");
INSERT INTO RequisicionD VALUES ("911","72","10","9","20");
INSERT INTO RequisicionD VALUES ("912","72","9","26","50");
INSERT INTO RequisicionD VALUES ("913","72","9","27","50");
INSERT INTO RequisicionD VALUES ("914","72","9","28","50");
INSERT INTO RequisicionD VALUES ("915","72","9","29","50");
INSERT INTO RequisicionD VALUES ("916","72","9","30","50");
INSERT INTO RequisicionD VALUES ("917","72","9","31","10");
INSERT INTO RequisicionD VALUES ("918","72","20","32","500");
INSERT INTO RequisicionD VALUES ("919","72","22","32","300");
INSERT INTO RequisicionD VALUES ("920","72","25","32","300");
INSERT INTO RequisicionD VALUES ("921","72","24","32","50");
INSERT INTO RequisicionD VALUES ("922","72","27","32","500");
INSERT INTO RequisicionD VALUES ("923","72","30","32","100");
INSERT INTO RequisicionD VALUES ("924","72","29","32","100");
INSERT INTO RequisicionD VALUES ("925","73","3","11","4");
INSERT INTO RequisicionD VALUES ("926","73","3","13","22");
INSERT INTO RequisicionD VALUES ("927","73","3","14","84");
INSERT INTO RequisicionD VALUES ("928","73","3","15","80");
INSERT INTO RequisicionD VALUES ("929","73","3","17","64");
INSERT INTO RequisicionD VALUES ("930","73","3","18","27");
INSERT INTO RequisicionD VALUES ("931","73","3","19","22");
INSERT INTO RequisicionD VALUES ("932","73","3","20","10");
INSERT INTO RequisicionD VALUES ("933","73","4","11","35");
INSERT INTO RequisicionD VALUES ("934","73","3","16","79");
INSERT INTO RequisicionD VALUES ("935","73","3","21","24");
INSERT INTO RequisicionD VALUES ("936","73","4","13","87");
INSERT INTO RequisicionD VALUES ("937","73","4","14","97");
INSERT INTO RequisicionD VALUES ("938","73","4","15","70");
INSERT INTO RequisicionD VALUES ("939","73","4","16","47");
INSERT INTO RequisicionD VALUES ("940","73","4","17","40");
INSERT INTO RequisicionD VALUES ("941","73","4","18","10");
INSERT INTO RequisicionD VALUES ("942","73","4","19","13");
INSERT INTO RequisicionD VALUES ("943","73","4","20","10");
INSERT INTO RequisicionD VALUES ("944","73","4","21","10");
INSERT INTO RequisicionD VALUES ("945","73","8","27","219");
INSERT INTO RequisicionD VALUES ("946","73","8","28","157");
INSERT INTO RequisicionD VALUES ("947","73","20","32","419");
INSERT INTO RequisicionD VALUES ("948","73","22","32","419");
INSERT INTO RequisicionD VALUES ("949","73","27","32","419");
INSERT INTO RequisicionD VALUES ("950","73","31","32","173");
INSERT INTO RequisicionD VALUES ("951","73","24","32","419");
INSERT INTO RequisicionD VALUES ("952","73","36","32","143");
INSERT INTO RequisicionD VALUES ("953","73","25","32","419");
INSERT INTO RequisicionD VALUES ("954","73","30","32","419");
INSERT INTO RequisicionD VALUES ("955","73","8","29","43");
INSERT INTO RequisicionD VALUES ("956","73","10","3","31");
INSERT INTO RequisicionD VALUES ("957","73","10","4","10");
INSERT INTO RequisicionD VALUES ("958","73","10","5","40");
INSERT INTO RequisicionD VALUES ("959","73","10","6","200");
INSERT INTO RequisicionD VALUES ("960","73","10","7","100");
INSERT INTO RequisicionD VALUES ("961","73","10","8","38");
INSERT INTO RequisicionD VALUES ("962","74","9","28","12");
INSERT INTO RequisicionD VALUES ("963","74","55","28","6");
INSERT INTO RequisicionD VALUES ("964","74","40","32","1");
INSERT INTO RequisicionD VALUES ("965","74","41","32","1");
INSERT INTO RequisicionD VALUES ("966","74","20","32","12");
INSERT INTO RequisicionD VALUES ("967","75","3","11","10");
INSERT INTO RequisicionD VALUES ("968","75","3","13","10");
INSERT INTO RequisicionD VALUES ("969","75","3","14","34");
INSERT INTO RequisicionD VALUES ("970","75","3","15","74");
INSERT INTO RequisicionD VALUES ("971","75","3","16","50");
INSERT INTO RequisicionD VALUES ("972","75","3","17","26");
INSERT INTO RequisicionD VALUES ("973","75","3","19","3");
INSERT INTO RequisicionD VALUES ("974","75","3","18","6");
INSERT INTO RequisicionD VALUES ("975","75","3","20","6");
INSERT INTO RequisicionD VALUES ("976","75","3","21","3");
INSERT INTO RequisicionD VALUES ("977","75","3","22","1");
INSERT INTO RequisicionD VALUES ("978","75","4","11","10");
INSERT INTO RequisicionD VALUES ("979","75","4","13","10");
INSERT INTO RequisicionD VALUES ("980","75","4","14","34");
INSERT INTO RequisicionD VALUES ("981","75","4","15","74");
INSERT INTO RequisicionD VALUES ("982","75","4","16","50");
INSERT INTO RequisicionD VALUES ("983","75","4","17","26");
INSERT INTO RequisicionD VALUES ("984","75","4","18","6");
INSERT INTO RequisicionD VALUES ("985","75","4","19","3");
INSERT INTO RequisicionD VALUES ("986","75","4","20","6");
INSERT INTO RequisicionD VALUES ("987","75","4","21","3");
INSERT INTO RequisicionD VALUES ("988","75","4","22","1");
INSERT INTO RequisicionD VALUES ("989","75","10","3","15");
INSERT INTO RequisicionD VALUES ("990","75","10","4","15");
INSERT INTO RequisicionD VALUES ("991","75","10","5","15");
INSERT INTO RequisicionD VALUES ("992","75","10","6","124");
INSERT INTO RequisicionD VALUES ("993","75","10","7","35");
INSERT INTO RequisicionD VALUES ("994","75","10","8","17");
INSERT INTO RequisicionD VALUES ("995","75","10","9","2");
INSERT INTO RequisicionD VALUES ("996","75","8","27","54");
INSERT INTO RequisicionD VALUES ("997","75","8","28","150");
INSERT INTO RequisicionD VALUES ("998","75","8","29","20");
INSERT INTO RequisicionD VALUES ("999","75","20","32","223");
INSERT INTO RequisicionD VALUES ("1000","75","22","32","223");
INSERT INTO RequisicionD VALUES ("1001","75","27","32","223");
INSERT INTO RequisicionD VALUES ("1002","75","31","32","76");
INSERT INTO RequisicionD VALUES ("1003","75","24","32","223");
INSERT INTO RequisicionD VALUES ("1004","75","36","32","45");
INSERT INTO RequisicionD VALUES ("1005","75","25","32","223");
INSERT INTO RequisicionD VALUES ("1006","75","30","32","223");
INSERT INTO RequisicionD VALUES ("1007","76","9","27","6");
INSERT INTO RequisicionD VALUES ("1008","76","9","28","5");
INSERT INTO RequisicionD VALUES ("1009","76","20","32","12");
INSERT INTO RequisicionD VALUES ("1010","76","55","28","10");
INSERT INTO RequisicionD VALUES ("1011","76","10","5","1");
INSERT INTO RequisicionD VALUES ("1012","76","40","32","1");
INSERT INTO RequisicionD VALUES ("1013","76","41","32","1");
INSERT INTO RequisicionD VALUES ("1014","76","33","32","1");
INSERT INTO RequisicionD VALUES ("1015","77","64","13","2");
INSERT INTO RequisicionD VALUES ("1016","77","4","13","2");
INSERT INTO RequisicionD VALUES ("1017","77","10","6","1");
INSERT INTO RequisicionD VALUES ("1018","77","10","5","1");
INSERT INTO RequisicionD VALUES ("1019","78","10","2","2");
INSERT INTO RequisicionD VALUES ("1020","78","10","3","3");
INSERT INTO RequisicionD VALUES ("1021","78","10","4","3");
INSERT INTO RequisicionD VALUES ("1022","78","10","5","1");
INSERT INTO RequisicionD VALUES ("1023","78","10","6","4");
INSERT INTO RequisicionD VALUES ("1024","78","10","7","2");
INSERT INTO RequisicionD VALUES ("1025","78","54","11","10");
INSERT INTO RequisicionD VALUES ("1026","78","54","14","10");
INSERT INTO RequisicionD VALUES ("1027","78","54","13","15");
INSERT INTO RequisicionD VALUES ("1028","78","57","15","20");
INSERT INTO RequisicionD VALUES ("1029","79","3","11","15");
INSERT INTO RequisicionD VALUES ("1030","79","3","13","96");
INSERT INTO RequisicionD VALUES ("1031","79","3","14","109");
INSERT INTO RequisicionD VALUES ("1032","79","3","15","86");
INSERT INTO RequisicionD VALUES ("1033","79","3","16","70");
INSERT INTO RequisicionD VALUES ("1034","79","3","17","68");
INSERT INTO RequisicionD VALUES ("1035","79","3","18","46");
INSERT INTO RequisicionD VALUES ("1036","79","3","19","26");
INSERT INTO RequisicionD VALUES ("1037","79","3","20","15");
INSERT INTO RequisicionD VALUES ("1038","79","3","21","14");
INSERT INTO RequisicionD VALUES ("1039","79","3","22","9");
INSERT INTO RequisicionD VALUES ("1040","79","4","7","33");
INSERT INTO RequisicionD VALUES ("1041","79","4","9","35");
INSERT INTO RequisicionD VALUES ("1042","79","4","11","65");
INSERT INTO RequisicionD VALUES ("1043","79","4","13","115");
INSERT INTO RequisicionD VALUES ("1044","79","4","14","100");
INSERT INTO RequisicionD VALUES ("1045","79","4","15","90");
INSERT INTO RequisicionD VALUES ("1046","79","4","16","50");
INSERT INTO RequisicionD VALUES ("1047","79","4","17","33");
INSERT INTO RequisicionD VALUES ("1048","79","4","18","12");
INSERT INTO RequisicionD VALUES ("1049","79","4","19","10");
INSERT INTO RequisicionD VALUES ("1050","79","4","20","4");
INSERT INTO RequisicionD VALUES ("1051","79","4","21","3");
INSERT INTO RequisicionD VALUES ("1052","79","4","22","4");
INSERT INTO RequisicionD VALUES ("1053","79","9","26","60");
INSERT INTO RequisicionD VALUES ("1054","79","9","27","120");
INSERT INTO RequisicionD VALUES ("1055","79","9","28","207");
INSERT INTO RequisicionD VALUES ("1056","79","9","29","90");
INSERT INTO RequisicionD VALUES ("1057","79","9","30","50");
INSERT INTO RequisicionD VALUES ("1058","79","9","31","27");
INSERT INTO RequisicionD VALUES ("1059","79","10","2","19");
INSERT INTO RequisicionD VALUES ("1060","79","10","3","50");
INSERT INTO RequisicionD VALUES ("1061","79","10","4","62");
INSERT INTO RequisicionD VALUES ("1062","79","10","5","72");
INSERT INTO RequisicionD VALUES ("1063","79","10","6","135");
INSERT INTO RequisicionD VALUES ("1064","79","10","7","135");
INSERT INTO RequisicionD VALUES ("1065","79","10","8","60");
INSERT INTO RequisicionD VALUES ("1066","79","10","9","15");
INSERT INTO RequisicionD VALUES ("1067","79","10","10","3");
INSERT INTO RequisicionD VALUES ("1068","79","10","11","3");
INSERT INTO RequisicionD VALUES ("1069","79","20","32","554");
INSERT INTO RequisicionD VALUES ("1070","79","23","29","554");
INSERT INTO RequisicionD VALUES ("1071","79","27","32","554");
INSERT INTO RequisicionD VALUES ("1072","79","24","32","554");
INSERT INTO RequisicionD VALUES ("1073","79","31","32","207");
INSERT INTO RequisicionD VALUES ("1074","79","36","32","203");
INSERT INTO RequisicionD VALUES ("1075","79","25","32","554");
INSERT INTO RequisicionD VALUES ("1076","79","30","32","554");
INSERT INTO RequisicionD VALUES ("1077","80","9","26","50");
INSERT INTO RequisicionD VALUES ("1078","80","9","27","50");
INSERT INTO RequisicionD VALUES ("1079","80","9","28","50");
INSERT INTO RequisicionD VALUES ("1080","80","9","29","50");
INSERT INTO RequisicionD VALUES ("1081","80","9","30","10");
INSERT INTO RequisicionD VALUES ("1082","81","9","26","50");
INSERT INTO RequisicionD VALUES ("1083","81","9","28","50");
INSERT INTO RequisicionD VALUES ("1084","81","9","30","50");
INSERT INTO RequisicionD VALUES ("1085","81","9","31","50");
INSERT INTO RequisicionD VALUES ("1086","81","9","29","50");
INSERT INTO RequisicionD VALUES ("1087","81","9","27","50");
INSERT INTO RequisicionD VALUES ("1088","82","9","26","50");
INSERT INTO RequisicionD VALUES ("1089","82","9","27","50");
INSERT INTO RequisicionD VALUES ("1090","82","9","28","50");
INSERT INTO RequisicionD VALUES ("1091","82","9","29","50");
INSERT INTO RequisicionD VALUES ("1092","82","9","30","50");
INSERT INTO RequisicionD VALUES ("1093","83","54","11","15");
INSERT INTO RequisicionD VALUES ("1094","83","54","13","15");
INSERT INTO RequisicionD VALUES ("1095","83","54","9","5");
INSERT INTO RequisicionD VALUES ("1096","83","10","2","1");
INSERT INTO RequisicionD VALUES ("1097","83","10","3","3");
INSERT INTO RequisicionD VALUES ("1098","83","10","4","4");
INSERT INTO RequisicionD VALUES ("1099","83","10","5","1");
INSERT INTO RequisicionD VALUES ("1100","83","10","6","3");
INSERT INTO RequisicionD VALUES ("1101","83","10","7","3");
INSERT INTO RequisicionD VALUES ("1102","83","54","15","5");
INSERT INTO RequisicionD VALUES ("1103","84","9","27","219");
INSERT INTO RequisicionD VALUES ("1104","84","9","28","157");
INSERT INTO RequisicionD VALUES ("1105","84","9","29","43");
INSERT INTO RequisicionD VALUES ("1106","85","9","27","54");
INSERT INTO RequisicionD VALUES ("1107","85","9","28","150");
INSERT INTO RequisicionD VALUES ("1108","85","9","29","20");
INSERT INTO RequisicionD VALUES ("1109","86","9","28","180");
INSERT INTO RequisicionD VALUES ("1110","86","9","29","50");
INSERT INTO RequisicionD VALUES ("1111","86","9","27","110");
INSERT INTO RequisicionD VALUES ("1112","87","9","30","10");
INSERT INTO RequisicionD VALUES ("1113","87","20","32","200");
INSERT INTO RequisicionD VALUES ("1114","87","24","32","100");
INSERT INTO RequisicionD VALUES ("1115","87","25","32","150");
INSERT INTO RequisicionD VALUES ("1116","87","27","32","214");
INSERT INTO RequisicionD VALUES ("1117","87","30","32","100");
INSERT INTO RequisicionD VALUES ("1118","87","31","32","70");
INSERT INTO RequisicionD VALUES ("1119","87","36","32","40");
INSERT INTO RequisicionD VALUES ("1120","88","9","30","50");
INSERT INTO RequisicionD VALUES ("1121","88","9","31","50");
INSERT INTO RequisicionD VALUES ("1122","88","20","32","488");
INSERT INTO RequisicionD VALUES ("1123","88","24","32","40");
INSERT INTO RequisicionD VALUES ("1124","88","25","32","200");
INSERT INTO RequisicionD VALUES ("1125","88","27","32","400");
INSERT INTO RequisicionD VALUES ("1126","88","30","32","50");
INSERT INTO RequisicionD VALUES ("1127","88","36","32","40");
INSERT INTO RequisicionD VALUES ("1128","88","31","32","70");
INSERT INTO RequisicionD VALUES ("1129","89","1","15","1");
INSERT INTO RequisicionD VALUES ("1130","89","1","18","1");
INSERT INTO RequisicionD VALUES ("1131","89","4","11","1");
INSERT INTO RequisicionD VALUES ("1132","89","4","15","1");
INSERT INTO RequisicionD VALUES ("1133","89","10","4","1");
INSERT INTO RequisicionD VALUES ("1134","89","10","7","1");
INSERT INTO RequisicionD VALUES ("1135","89","20","32","2");
INSERT INTO RequisicionD VALUES ("1136","89","8","28","2");
INSERT INTO RequisicionD VALUES ("1137","90","9","26","50");
INSERT INTO RequisicionD VALUES ("1138","90","9","27","90");
INSERT INTO RequisicionD VALUES ("1139","90","9","28","60");
INSERT INTO RequisicionD VALUES ("1140","90","9","29","30");
INSERT INTO RequisicionD VALUES ("1141","90","9","30","5");
INSERT INTO RequisicionD VALUES ("1142","90","9","31","2");
INSERT INTO RequisicionD VALUES ("1143","91","9","26","90");
INSERT INTO RequisicionD VALUES ("1144","91","9","27","184");
INSERT INTO RequisicionD VALUES ("1145","91","9","28","184");
INSERT INTO RequisicionD VALUES ("1146","91","9","29","95");
INSERT INTO RequisicionD VALUES ("1147","91","9","30","80");
INSERT INTO RequisicionD VALUES ("1148","92","9","26","8");
INSERT INTO RequisicionD VALUES ("1149","92","9","27","29");
INSERT INTO RequisicionD VALUES ("1150","92","9","28","47");
INSERT INTO RequisicionD VALUES ("1151","92","9","29","49");
INSERT INTO RequisicionD VALUES ("1152","92","9","30","14");
INSERT INTO RequisicionD VALUES ("1153","92","9","31","4");
INSERT INTO RequisicionD VALUES ("1154","93","3","11","2");
INSERT INTO RequisicionD VALUES ("1155","94","3","11","120");
INSERT INTO RequisicionD VALUES ("1156","95","3","11","12");
INSERT INTO RequisicionD VALUES ("1157","96","3","11","5");
INSERT INTO RequisicionD VALUES ("1158","97","3","13","5");
INSERT INTO RequisicionD VALUES ("1159","97","3","14","2");
INSERT INTO RequisicionD VALUES ("1160","97","3","11","3");
INSERT INTO RequisicionD VALUES ("1161","97","4","11","3");
INSERT INTO RequisicionD VALUES ("1162","97","4","13","5");
INSERT INTO RequisicionD VALUES ("1163","97","4","14","2");
INSERT INTO RequisicionD VALUES ("1164","97","10","4","5");
INSERT INTO RequisicionD VALUES ("1165","97","10","5","5");
INSERT INTO RequisicionD VALUES ("1166","97","9","27","10");
INSERT INTO RequisicionD VALUES ("1167","98","9","28","10");
INSERT INTO RequisicionD VALUES ("1168","99","3","13","1");
INSERT INTO RequisicionD VALUES ("1169","99","3","14","2");
INSERT INTO RequisicionD VALUES ("1170","99","4","16","1");
INSERT INTO RequisicionD VALUES ("1171","99","10","8","1");
INSERT INTO RequisicionD VALUES ("1172","99","4","14","1");
INSERT INTO RequisicionD VALUES ("1173","99","4","11","1");
INSERT INTO RequisicionD VALUES ("1174","100","4","13","1");
INSERT INTO RequisicionD VALUES ("1175","100","9","27","5");
INSERT INTO RequisicionD VALUES ("1176","100","10","3","1");
INSERT INTO RequisicionD VALUES ("1177","100","20","32","5");
INSERT INTO RequisicionD VALUES ("1178","101","22","32","3");
INSERT INTO RequisicionD VALUES ("1179","101","20","32","3");
INSERT INTO RequisicionD VALUES ("1180","101","10","5","1");
INSERT INTO RequisicionD VALUES ("1181","101","10","6","1");
INSERT INTO RequisicionD VALUES ("1182","101","10","8","1");
INSERT INTO RequisicionD VALUES ("1183","102","4","13","4");
INSERT INTO RequisicionD VALUES ("1184","102","1","13","1");
INSERT INTO RequisicionD VALUES ("1185","102","1","17","3");
INSERT INTO RequisicionD VALUES ("1186","102","9","28","4");
INSERT INTO RequisicionD VALUES ("1187","102","10","7","2");
INSERT INTO RequisicionD VALUES ("1188","102","10","8","1");
INSERT INTO RequisicionD VALUES ("1189","102","10","4","1");
INSERT INTO RequisicionD VALUES ("1190","102","20","32","4");
INSERT INTO RequisicionD VALUES ("1191","102","29","32","2");
INSERT INTO RequisicionD VALUES ("1192","102","22","32","2");
INSERT INTO RequisicionD VALUES ("1193","102","21","32","2");
INSERT INTO RequisicionD VALUES ("1194","102","17","32","2");
INSERT INTO RequisicionD VALUES ("1195","102","37","32","2");
INSERT INTO RequisicionD VALUES ("1196","102","31","32","2");

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
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Borrador_RequisicionE`
INSERT INTO Borrador_RequisicionE VALUES ("14","","2024-12-04 13:58:18","Borrador","Martha Guadalupe Santiago Barron","7","52","Campamento de Conservación, \"San Jose del Cabo","","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO Borrador_RequisicionE VALUES ("56","","2024-12-14 10:44:46","Borrador","Brayan Palacios","7","49","Pc Tlalpan","18","Brayan Palacios","5610383109","","se solicitan radios a cambio, por alto aforo vacacional ya que dejaron de funcionar y uniformes para nuevos ingresos","9","","","","","");
INSERT INTO Borrador_RequisicionE VALUES ("85","","2024-12-20 17:04:40","Borrador","Angel Bazan","7","49","la pera-cuautla","12","Angel Bazan","5528169856","","se solicitan uniformes por desgaste y nuevos ingresos, ultima requisición 12-01-23 (pasan por ellos)","17","","","","","");
INSERT INTO Borrador_RequisicionE VALUES ("103","","2024-12-27 11:48:46","Borrador","JUAN JOSE VALADEZ DE LA CRUZ","10","45","TODAS","214","JUAN JOSE VALADEZ DE LA CRUZ","6151096830","VACJ911113HZ0","NO SE ENVIO POR FALTA DE INVENTARIO EN ALMACEN","3","LA PAZ","PUEBLO NUEVO","5 DE FEBRERO","S/N","23060");
INSERT INTO Borrador_RequisicionE VALUES ("111","","2025-01-03 17:12:16","Borrador","Ximena torres","10","46","oficinas centrales IMSS CDMX","10","Ximena Torres","55 6415 7119","","elementos de cctv para oficinas centrales IMSS","28","","","","","");

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
) ENGINE=InnoDB AUTO_INCREMENT=2912 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table `Borrador_RequisicionD`
INSERT INTO Borrador_RequisicionD VALUES ("60","14","9","29","2");
INSERT INTO Borrador_RequisicionD VALUES ("61","14","3","15","2");
INSERT INTO Borrador_RequisicionD VALUES ("62","14","37","32","1");
INSERT INTO Borrador_RequisicionD VALUES ("63","14","30","32","5");
INSERT INTO Borrador_RequisicionD VALUES ("64","14","10","6","1");
INSERT INTO Borrador_RequisicionD VALUES ("556","56","37","32","10");
INSERT INTO Borrador_RequisicionD VALUES ("557","56","3","15","2");
INSERT INTO Borrador_RequisicionD VALUES ("558","56","4","15","2");
INSERT INTO Borrador_RequisicionD VALUES ("559","56","3","16","2");
INSERT INTO Borrador_RequisicionD VALUES ("560","56","4","16","2");
INSERT INTO Borrador_RequisicionD VALUES ("2203","85","20","32","12");
INSERT INTO Borrador_RequisicionD VALUES ("2204","85","9","28","12");
INSERT INTO Borrador_RequisicionD VALUES ("2205","85","55","28","6");
INSERT INTO Borrador_RequisicionD VALUES ("2206","85","40","32","2");
INSERT INTO Borrador_RequisicionD VALUES ("2207","85","41","32","2");
INSERT INTO Borrador_RequisicionD VALUES ("2803","103","31","32","70");
INSERT INTO Borrador_RequisicionD VALUES ("2804","103","36","32","40");
INSERT INTO Borrador_RequisicionD VALUES ("2805","103","20","32","200");
INSERT INTO Borrador_RequisicionD VALUES ("2806","103","9","31","10");
INSERT INTO Borrador_RequisicionD VALUES ("2807","103","24","32","100");
INSERT INTO Borrador_RequisicionD VALUES ("2808","103","25","32","300");
INSERT INTO Borrador_RequisicionD VALUES ("2809","103","30","32","100");
INSERT INTO Borrador_RequisicionD VALUES ("2862","111","3","11","2");

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
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO Salida_E VALUES ("23","32","6","2024-12-12 13:15:34");
INSERT INTO Salida_E VALUES ("24","34","6","2024-12-12 13:16:03");
INSERT INTO Salida_E VALUES ("25","35","6","2024-12-12 13:17:18");
INSERT INTO Salida_E VALUES ("26","36","6","2024-12-12 13:17:58");
INSERT INTO Salida_E VALUES ("27","37","6","2024-12-12 13:18:41");
INSERT INTO Salida_E VALUES ("28","38","6","2024-12-12 13:19:58");
INSERT INTO Salida_E VALUES ("29","39","6","2024-12-12 13:27:13");
INSERT INTO Salida_E VALUES ("30","40","6","2024-12-12 13:28:35");
INSERT INTO Salida_E VALUES ("31","42","6","2024-12-12 16:48:43");
INSERT INTO Salida_E VALUES ("32","45","6","2024-12-13 16:49:18");
INSERT INTO Salida_E VALUES ("33","48","6","2024-12-13 17:01:11");
INSERT INTO Salida_E VALUES ("34","50","6","2024-12-17 11:48:16");
INSERT INTO Salida_E VALUES ("35","49","6","2024-12-17 11:48:52");
INSERT INTO Salida_E VALUES ("36","43","6","2024-12-17 11:57:57");
INSERT INTO Salida_E VALUES ("37","44","6","2024-12-17 11:59:50");
INSERT INTO Salida_E VALUES ("38","46","6","2024-12-17 12:00:21");
INSERT INTO Salida_E VALUES ("39","47","6","2024-12-17 12:00:50");
INSERT INTO Salida_E VALUES ("40","54","6","2024-12-17 12:54:36");
INSERT INTO Salida_E VALUES ("41","55","6","2024-12-17 12:55:02");
INSERT INTO Salida_E VALUES ("42","51","6","2024-12-20 09:13:20");
INSERT INTO Salida_E VALUES ("43","52","6","2024-12-20 09:13:36");
INSERT INTO Salida_E VALUES ("44","53","6","2024-12-20 09:13:47");
INSERT INTO Salida_E VALUES ("45","69","6","2024-12-27 10:29:33");
INSERT INTO Salida_E VALUES ("46","80","6","2024-12-27 10:30:28");
INSERT INTO Salida_E VALUES ("47","70","6","2024-12-27 10:44:00");
INSERT INTO Salida_E VALUES ("48","81","6","2024-12-27 10:47:54");
INSERT INTO Salida_E VALUES ("49","57","6","2024-12-27 10:49:28");
INSERT INTO Salida_E VALUES ("50","58","6","2024-12-27 10:51:11");
INSERT INTO Salida_E VALUES ("51","74","6","2024-12-27 10:52:56");
INSERT INTO Salida_E VALUES ("52","76","6","2024-12-27 10:53:48");
INSERT INTO Salida_E VALUES ("53","62","6","2024-12-27 10:58:54");
INSERT INTO Salida_E VALUES ("54","68","6","2024-12-30 15:47:01");
INSERT INTO Salida_E VALUES ("55","79","6","2024-12-30 16:00:37");
INSERT INTO Salida_E VALUES ("56","79","6","2024-12-30 16:02:49");
INSERT INTO Salida_E VALUES ("57","73","6","2024-12-30 16:28:56");
INSERT INTO Salida_E VALUES ("58","84","6","2024-12-31 12:33:37");
INSERT INTO Salida_E VALUES ("59","77","6","2024-12-31 12:36:55");
INSERT INTO Salida_E VALUES ("60","72","6","2024-12-31 13:18:58");
INSERT INTO Salida_E VALUES ("61","72","6","2024-12-31 13:24:38");
INSERT INTO Salida_E VALUES ("62","66","6","2025-01-02 14:26:53");
INSERT INTO Salida_E VALUES ("63","91","6","2025-01-02 14:28:50");
INSERT INTO Salida_E VALUES ("64","66","6","2025-01-03 09:46:29");
INSERT INTO Salida_E VALUES ("65","64","6","2025-01-03 15:02:11");
INSERT INTO Salida_E VALUES ("66","92","6","2025-01-03 15:02:49");
INSERT INTO Salida_E VALUES ("67","97","6","2025-01-04 10:38:57");
INSERT INTO Salida_E VALUES ("68","98","6","2025-01-04 10:39:26");

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
) ENGINE=InnoDB AUTO_INCREMENT=871 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
INSERT INTO Salida_D VALUES ("112","23","9","27","1");
INSERT INTO Salida_D VALUES ("113","23","9","28","2");
INSERT INTO Salida_D VALUES ("114","23","9","29","1");
INSERT INTO Salida_D VALUES ("115","24","9","27","2");
INSERT INTO Salida_D VALUES ("116","24","9","28","2");
INSERT INTO Salida_D VALUES ("117","25","9","25","0");
INSERT INTO Salida_D VALUES ("118","25","9","26","2");
INSERT INTO Salida_D VALUES ("119","25","9","28","7");
INSERT INTO Salida_D VALUES ("120","25","9","29","1");
INSERT INTO Salida_D VALUES ("121","25","9","31","0");
INSERT INTO Salida_D VALUES ("122","26","9","26","1");
INSERT INTO Salida_D VALUES ("123","26","9","27","1");
INSERT INTO Salida_D VALUES ("124","26","9","28","2");
INSERT INTO Salida_D VALUES ("125","26","22","32","2");
INSERT INTO Salida_D VALUES ("126","26","37","32","2");
INSERT INTO Salida_D VALUES ("127","27","3","17","1");
INSERT INTO Salida_D VALUES ("128","27","4","15","1");
INSERT INTO Salida_D VALUES ("129","27","9","27","2");
INSERT INTO Salida_D VALUES ("130","27","9","28","1");
INSERT INTO Salida_D VALUES ("131","27","9","29","1");
INSERT INTO Salida_D VALUES ("132","27","20","32","0");
INSERT INTO Salida_D VALUES ("133","27","22","32","1");
INSERT INTO Salida_D VALUES ("134","27","37","32","1");
INSERT INTO Salida_D VALUES ("135","28","3","16","1");
INSERT INTO Salida_D VALUES ("136","28","3","19","1");
INSERT INTO Salida_D VALUES ("137","28","4","13","1");
INSERT INTO Salida_D VALUES ("138","28","4","16","1");
INSERT INTO Salida_D VALUES ("139","28","9","27","3");
INSERT INTO Salida_D VALUES ("140","28","9","28","2");
INSERT INTO Salida_D VALUES ("141","28","9","29","1");
INSERT INTO Salida_D VALUES ("142","28","22","32","3");
INSERT INTO Salida_D VALUES ("143","28","37","32","3");
INSERT INTO Salida_D VALUES ("144","29","3","16","1");
INSERT INTO Salida_D VALUES ("145","29","4","14","1");
INSERT INTO Salida_D VALUES ("146","29","9","28","3");
INSERT INTO Salida_D VALUES ("147","29","9","29","1");
INSERT INTO Salida_D VALUES ("148","29","20","32","0");
INSERT INTO Salida_D VALUES ("149","29","22","32","2");
INSERT INTO Salida_D VALUES ("150","29","37","32","1");
INSERT INTO Salida_D VALUES ("151","30","3","13","2");
INSERT INTO Salida_D VALUES ("152","30","3","14","2");
INSERT INTO Salida_D VALUES ("153","30","3","16","1");
INSERT INTO Salida_D VALUES ("154","30","4","11","1");
INSERT INTO Salida_D VALUES ("155","30","4","13","1");
INSERT INTO Salida_D VALUES ("156","30","4","14","1");
INSERT INTO Salida_D VALUES ("157","30","4","15","2");
INSERT INTO Salida_D VALUES ("158","30","9","26","6");
INSERT INTO Salida_D VALUES ("159","30","9","27","7");
INSERT INTO Salida_D VALUES ("160","30","9","28","7");
INSERT INTO Salida_D VALUES ("161","30","9","29","4");
INSERT INTO Salida_D VALUES ("162","30","20","32","0");
INSERT INTO Salida_D VALUES ("163","30","22","32","5");
INSERT INTO Salida_D VALUES ("164","30","37","32","5");
INSERT INTO Salida_D VALUES ("165","31","3","11","2");
INSERT INTO Salida_D VALUES ("166","31","4","9","1");
INSERT INTO Salida_D VALUES ("167","31","8","28","0");
INSERT INTO Salida_D VALUES ("168","31","10","3","1");
INSERT INTO Salida_D VALUES ("169","31","20","32","0");
INSERT INTO Salida_D VALUES ("170","31","21","32","1");
INSERT INTO Salida_D VALUES ("171","31","22","32","1");
INSERT INTO Salida_D VALUES ("172","31","24","32","0");
INSERT INTO Salida_D VALUES ("173","32","3","13","4");
INSERT INTO Salida_D VALUES ("174","32","3","14","6");
INSERT INTO Salida_D VALUES ("175","32","3","15","4");
INSERT INTO Salida_D VALUES ("176","32","4","13","6");
INSERT INTO Salida_D VALUES ("177","32","4","14","4");
INSERT INTO Salida_D VALUES ("178","32","4","15","2");
INSERT INTO Salida_D VALUES ("179","32","9","27","7");
INSERT INTO Salida_D VALUES ("180","32","9","28","5");
INSERT INTO Salida_D VALUES ("181","32","9","29","2");
INSERT INTO Salida_D VALUES ("182","32","10","2","1");
INSERT INTO Salida_D VALUES ("183","32","10","3","1");
INSERT INTO Salida_D VALUES ("184","32","10","5","2");
INSERT INTO Salida_D VALUES ("185","32","20","32","0");
INSERT INTO Salida_D VALUES ("186","32","22","32","5");
INSERT INTO Salida_D VALUES ("187","32","40","32","2");
INSERT INTO Salida_D VALUES ("188","32","41","32","2");
INSERT INTO Salida_D VALUES ("189","33","3","16","25");
INSERT INTO Salida_D VALUES ("190","33","3","18","20");
INSERT INTO Salida_D VALUES ("191","33","3","19","5");
INSERT INTO Salida_D VALUES ("192","33","4","15","25");
INSERT INTO Salida_D VALUES ("193","33","4","17","20");
INSERT INTO Salida_D VALUES ("194","33","4","20","5");
INSERT INTO Salida_D VALUES ("195","33","10","4","5");
INSERT INTO Salida_D VALUES ("196","33","10","5","5");
INSERT INTO Salida_D VALUES ("197","33","10","7","15");
INSERT INTO Salida_D VALUES ("198","33","10","8","15");
INSERT INTO Salida_D VALUES ("199","33","10","9","2");
INSERT INTO Salida_D VALUES ("200","33","18","32","0");
INSERT INTO Salida_D VALUES ("201","33","20","32","0");
INSERT INTO Salida_D VALUES ("202","33","23","28","15");
INSERT INTO Salida_D VALUES ("203","33","37","32","10");
INSERT INTO Salida_D VALUES ("204","34","2","18","4");
INSERT INTO Salida_D VALUES ("205","34","2","20","4");
INSERT INTO Salida_D VALUES ("206","34","2","21","4");
INSERT INTO Salida_D VALUES ("207","34","4","11","4");
INSERT INTO Salida_D VALUES ("208","34","4","13","4");
INSERT INTO Salida_D VALUES ("209","34","4","14","4");
INSERT INTO Salida_D VALUES ("210","35","3","15","4");
INSERT INTO Salida_D VALUES ("211","35","3","16","2");
INSERT INTO Salida_D VALUES ("212","35","4","15","2");
INSERT INTO Salida_D VALUES ("213","35","4","16","2");
INSERT INTO Salida_D VALUES ("214","35","37","32","10");
INSERT INTO Salida_D VALUES ("215","36","3","13","10");
INSERT INTO Salida_D VALUES ("216","36","3","15","10");
INSERT INTO Salida_D VALUES ("217","36","3","16","15");
INSERT INTO Salida_D VALUES ("218","36","4","13","5");
INSERT INTO Salida_D VALUES ("219","36","4","14","15");
INSERT INTO Salida_D VALUES ("220","36","4","15","15");
INSERT INTO Salida_D VALUES ("221","36","9","26","10");
INSERT INTO Salida_D VALUES ("222","36","9","27","15");
INSERT INTO Salida_D VALUES ("223","36","9","28","15");
INSERT INTO Salida_D VALUES ("224","36","18","32","0");
INSERT INTO Salida_D VALUES ("225","36","20","32","0");
INSERT INTO Salida_D VALUES ("226","37","3","15","1");
INSERT INTO Salida_D VALUES ("227","37","3","21","1");
INSERT INTO Salida_D VALUES ("228","37","4","11","1");
INSERT INTO Salida_D VALUES ("229","37","4","15","1");
INSERT INTO Salida_D VALUES ("230","37","9","28","20");
INSERT INTO Salida_D VALUES ("231","37","20","32","0");
INSERT INTO Salida_D VALUES ("232","38","9","26","2");
INSERT INTO Salida_D VALUES ("233","38","9","27","11");
INSERT INTO Salida_D VALUES ("234","38","9","28","6");
INSERT INTO Salida_D VALUES ("235","38","9","29","1");
INSERT INTO Salida_D VALUES ("236","39","9","29","20");
INSERT INTO Salida_D VALUES ("237","39","40","32","2");
INSERT INTO Salida_D VALUES ("238","39","42","32","2");
INSERT INTO Salida_D VALUES ("239","40","10","1","1");
INSERT INTO Salida_D VALUES ("240","40","10","2","1");
INSERT INTO Salida_D VALUES ("241","40","10","3","4");
INSERT INTO Salida_D VALUES ("242","40","10","4","2");
INSERT INTO Salida_D VALUES ("243","40","10","5","3");
INSERT INTO Salida_D VALUES ("244","40","10","6","1");
INSERT INTO Salida_D VALUES ("245","40","10","7","1");
INSERT INTO Salida_D VALUES ("246","40","54","13","5");
INSERT INTO Salida_D VALUES ("247","40","54","14","5");
INSERT INTO Salida_D VALUES ("248","40","54","15","10");
INSERT INTO Salida_D VALUES ("249","41","59","26","125");
INSERT INTO Salida_D VALUES ("250","41","59","27","199");
INSERT INTO Salida_D VALUES ("251","41","59","28","199");
INSERT INTO Salida_D VALUES ("252","41","59","29","36");
INSERT INTO Salida_D VALUES ("253","42","9","29","4");
INSERT INTO Salida_D VALUES ("254","42","18","32","0");
INSERT INTO Salida_D VALUES ("255","42","20","32","0");
INSERT INTO Salida_D VALUES ("256","42","30","32","0");
INSERT INTO Salida_D VALUES ("257","43","9","29","12");
INSERT INTO Salida_D VALUES ("258","43","18","32","0");
INSERT INTO Salida_D VALUES ("259","43","20","32","0");
INSERT INTO Salida_D VALUES ("260","43","30","32","0");
INSERT INTO Salida_D VALUES ("261","44","9","28","6");
INSERT INTO Salida_D VALUES ("262","44","18","32","0");
INSERT INTO Salida_D VALUES ("263","44","20","32","0");
INSERT INTO Salida_D VALUES ("264","44","30","32","0");
INSERT INTO Salida_D VALUES ("265","45","3","13","25");
INSERT INTO Salida_D VALUES ("266","45","3","14","25");
INSERT INTO Salida_D VALUES ("267","45","3","15","25");
INSERT INTO Salida_D VALUES ("268","45","3","16","50");
INSERT INTO Salida_D VALUES ("269","45","3","17","25");
INSERT INTO Salida_D VALUES ("270","45","3","18","25");
INSERT INTO Salida_D VALUES ("271","45","3","19","25");
INSERT INTO Salida_D VALUES ("272","45","3","20","25");
INSERT INTO Salida_D VALUES ("273","45","3","21","10");
INSERT INTO Salida_D VALUES ("274","45","4","13","25");
INSERT INTO Salida_D VALUES ("275","45","4","14","25");
INSERT INTO Salida_D VALUES ("276","45","4","15","25");
INSERT INTO Salida_D VALUES ("277","45","4","16","25");
INSERT INTO Salida_D VALUES ("278","45","4","17","25");
INSERT INTO Salida_D VALUES ("279","45","4","18","25");
INSERT INTO Salida_D VALUES ("280","45","4","19","25");
INSERT INTO Salida_D VALUES ("281","45","4","20","25");
INSERT INTO Salida_D VALUES ("282","45","4","21","10");
INSERT INTO Salida_D VALUES ("283","45","8","26","50");
INSERT INTO Salida_D VALUES ("284","45","8","27","0");
INSERT INTO Salida_D VALUES ("285","45","8","28","0");
INSERT INTO Salida_D VALUES ("286","45","8","29","0");
INSERT INTO Salida_D VALUES ("287","45","8","30","0");
INSERT INTO Salida_D VALUES ("288","45","10","5","20");
INSERT INTO Salida_D VALUES ("289","45","10","6","20");
INSERT INTO Salida_D VALUES ("290","45","10","7","20");
INSERT INTO Salida_D VALUES ("291","45","10","8","20");
INSERT INTO Salida_D VALUES ("292","45","10","9","20");
INSERT INTO Salida_D VALUES ("293","45","10","10","20");
INSERT INTO Salida_D VALUES ("294","45","20","32","0");
INSERT INTO Salida_D VALUES ("295","45","22","32","150");
INSERT INTO Salida_D VALUES ("296","45","24","32","0");
INSERT INTO Salida_D VALUES ("297","45","25","32","0");
INSERT INTO Salida_D VALUES ("298","45","27","32","0");
INSERT INTO Salida_D VALUES ("299","45","29","32","16");
INSERT INTO Salida_D VALUES ("300","45","30","32","0");
INSERT INTO Salida_D VALUES ("301","46","9","26","50");
INSERT INTO Salida_D VALUES ("302","46","9","27","50");
INSERT INTO Salida_D VALUES ("303","46","9","28","50");
INSERT INTO Salida_D VALUES ("304","46","9","29","50");
INSERT INTO Salida_D VALUES ("305","46","9","30","0");
INSERT INTO Salida_D VALUES ("306","47","3","14","40");
INSERT INTO Salida_D VALUES ("307","47","3","15","100");
INSERT INTO Salida_D VALUES ("308","47","3","16","100");
INSERT INTO Salida_D VALUES ("309","47","3","17","50");
INSERT INTO Salida_D VALUES ("310","47","3","18","50");
INSERT INTO Salida_D VALUES ("311","47","3","19","50");
INSERT INTO Salida_D VALUES ("312","47","3","20","50");
INSERT INTO Salida_D VALUES ("313","47","3","21","15");
INSERT INTO Salida_D VALUES ("314","47","3","22","15");
INSERT INTO Salida_D VALUES ("315","47","4","13","100");
INSERT INTO Salida_D VALUES ("316","47","4","14","110");
INSERT INTO Salida_D VALUES ("317","47","4","15","100");
INSERT INTO Salida_D VALUES ("318","47","4","16","50");
INSERT INTO Salida_D VALUES ("319","47","4","17","50");
INSERT INTO Salida_D VALUES ("320","47","4","18","20");
INSERT INTO Salida_D VALUES ("321","47","4","19","20");
INSERT INTO Salida_D VALUES ("322","47","4","21","15");
INSERT INTO Salida_D VALUES ("323","47","4","22","5");
INSERT INTO Salida_D VALUES ("324","47","8","26","0");
INSERT INTO Salida_D VALUES ("325","47","8","27","0");
INSERT INTO Salida_D VALUES ("326","47","8","28","0");
INSERT INTO Salida_D VALUES ("327","47","8","29","0");
INSERT INTO Salida_D VALUES ("328","47","8","30","0");
INSERT INTO Salida_D VALUES ("329","47","8","31","0");
INSERT INTO Salida_D VALUES ("330","47","10","3","30");
INSERT INTO Salida_D VALUES ("331","47","10","4","30");
INSERT INTO Salida_D VALUES ("332","47","10","5","50");
INSERT INTO Salida_D VALUES ("333","47","10","6","50");
INSERT INTO Salida_D VALUES ("334","47","10","7","50");
INSERT INTO Salida_D VALUES ("335","47","10","8","50");
INSERT INTO Salida_D VALUES ("336","47","10","9","50");
INSERT INTO Salida_D VALUES ("337","47","10","10","10");
INSERT INTO Salida_D VALUES ("338","47","20","32","0");
INSERT INTO Salida_D VALUES ("339","47","22","32","100");
INSERT INTO Salida_D VALUES ("340","47","24","32","0");
INSERT INTO Salida_D VALUES ("341","47","25","32","0");
INSERT INTO Salida_D VALUES ("342","47","27","32","400");
INSERT INTO Salida_D VALUES ("343","47","29","32","0");
INSERT INTO Salida_D VALUES ("344","47","30","32","0");
INSERT INTO Salida_D VALUES ("345","48","9","26","50");
INSERT INTO Salida_D VALUES ("346","48","9","27","50");
INSERT INTO Salida_D VALUES ("347","48","9","28","50");
INSERT INTO Salida_D VALUES ("348","48","9","29","50");
INSERT INTO Salida_D VALUES ("349","48","9","30","0");
INSERT INTO Salida_D VALUES ("350","48","9","31","0");
INSERT INTO Salida_D VALUES ("351","49","3","11","10");
INSERT INTO Salida_D VALUES ("352","49","3","15","7");
INSERT INTO Salida_D VALUES ("353","49","4","11","10");
INSERT INTO Salida_D VALUES ("354","49","4","14","7");
INSERT INTO Salida_D VALUES ("355","49","9","27","10");
INSERT INTO Salida_D VALUES ("356","49","9","28","5");
INSERT INTO Salida_D VALUES ("357","49","9","29","5");
INSERT INTO Salida_D VALUES ("358","49","20","32","0");
INSERT INTO Salida_D VALUES ("359","49","21","32","0");
INSERT INTO Salida_D VALUES ("360","49","24","32","0");
INSERT INTO Salida_D VALUES ("361","49","33","32","1");
INSERT INTO Salida_D VALUES ("362","49","37","32","1");
INSERT INTO Salida_D VALUES ("363","49","55","28","1");
INSERT INTO Salida_D VALUES ("364","50","3","13","2");
INSERT INTO Salida_D VALUES ("365","50","3","14","15");
INSERT INTO Salida_D VALUES ("366","50","3","16","15");
INSERT INTO Salida_D VALUES ("367","50","4","13","2");
INSERT INTO Salida_D VALUES ("368","50","4","14","20");
INSERT INTO Salida_D VALUES ("369","50","4","15","10");
INSERT INTO Salida_D VALUES ("370","50","9","26","2");
INSERT INTO Salida_D VALUES ("371","50","9","27","15");
INSERT INTO Salida_D VALUES ("372","50","9","28","15");
INSERT INTO Salida_D VALUES ("373","50","20","32","0");
INSERT INTO Salida_D VALUES ("374","50","22","32","10");
INSERT INTO Salida_D VALUES ("375","50","30","32","0");
INSERT INTO Salida_D VALUES ("376","50","33","32","2");
INSERT INTO Salida_D VALUES ("377","50","40","32","1");
INSERT INTO Salida_D VALUES ("378","50","41","32","1");
INSERT INTO Salida_D VALUES ("379","50","55","28","10");
INSERT INTO Salida_D VALUES ("380","51","9","28","12");
INSERT INTO Salida_D VALUES ("381","51","20","32","0");
INSERT INTO Salida_D VALUES ("382","51","40","32","1");
INSERT INTO Salida_D VALUES ("383","51","41","32","1");
INSERT INTO Salida_D VALUES ("384","51","55","28","6");
INSERT INTO Salida_D VALUES ("385","52","9","27","6");
INSERT INTO Salida_D VALUES ("386","52","9","28","5");
INSERT INTO Salida_D VALUES ("387","52","10","5","1");
INSERT INTO Salida_D VALUES ("388","52","20","32","0");
INSERT INTO Salida_D VALUES ("389","52","33","32","1");
INSERT INTO Salida_D VALUES ("390","52","40","32","1");
INSERT INTO Salida_D VALUES ("391","52","41","32","1");
INSERT INTO Salida_D VALUES ("392","52","55","28","10");
INSERT INTO Salida_D VALUES ("393","53","3","9","0");
INSERT INTO Salida_D VALUES ("394","53","3","11","40");
INSERT INTO Salida_D VALUES ("395","53","3","13","50");
INSERT INTO Salida_D VALUES ("396","53","3","14","50");
INSERT INTO Salida_D VALUES ("397","53","3","15","50");
INSERT INTO Salida_D VALUES ("398","53","3","16","35");
INSERT INTO Salida_D VALUES ("399","53","3","17","39");
INSERT INTO Salida_D VALUES ("400","53","3","18","45");
INSERT INTO Salida_D VALUES ("401","53","3","19","35");
INSERT INTO Salida_D VALUES ("402","53","3","20","25");
INSERT INTO Salida_D VALUES ("403","53","3","21","10");
INSERT INTO Salida_D VALUES ("404","53","4","9","10");
INSERT INTO Salida_D VALUES ("405","53","4","11","40");
INSERT INTO Salida_D VALUES ("406","53","4","13","50");
INSERT INTO Salida_D VALUES ("407","53","4","14","50");
INSERT INTO Salida_D VALUES ("408","53","4","15","50");
INSERT INTO Salida_D VALUES ("409","53","4","16","35");
INSERT INTO Salida_D VALUES ("410","53","4","17","39");
INSERT INTO Salida_D VALUES ("411","53","4","18","45");
INSERT INTO Salida_D VALUES ("412","53","4","19","35");
INSERT INTO Salida_D VALUES ("413","53","4","20","25");
INSERT INTO Salida_D VALUES ("414","53","4","21","10");
INSERT INTO Salida_D VALUES ("415","53","9","27","80");
INSERT INTO Salida_D VALUES ("416","53","9","28","140");
INSERT INTO Salida_D VALUES ("417","53","9","29","119");
INSERT INTO Salida_D VALUES ("418","53","9","30","0");
INSERT INTO Salida_D VALUES ("419","53","10","3","60");
INSERT INTO Salida_D VALUES ("420","53","10","4","60");
INSERT INTO Salida_D VALUES ("421","53","10","5","60");
INSERT INTO Salida_D VALUES ("422","53","10","6","60");
INSERT INTO Salida_D VALUES ("423","53","10","7","70");
INSERT INTO Salida_D VALUES ("424","53","10","8","50");
INSERT INTO Salida_D VALUES ("425","53","10","9","29");
INSERT INTO Salida_D VALUES ("426","53","20","32","0");
INSERT INTO Salida_D VALUES ("427","53","23","30","0");
INSERT INTO Salida_D VALUES ("428","53","24","32","0");
INSERT INTO Salida_D VALUES ("429","53","25","32","0");
INSERT INTO Salida_D VALUES ("430","53","27","32","0");
INSERT INTO Salida_D VALUES ("431","53","30","32","0");
INSERT INTO Salida_D VALUES ("432","53","31","32","0");
INSERT INTO Salida_D VALUES ("433","53","36","32","0");
INSERT INTO Salida_D VALUES ("434","54","3","9","0");
INSERT INTO Salida_D VALUES ("435","54","3","11","8");
INSERT INTO Salida_D VALUES ("436","54","3","13","29");
INSERT INTO Salida_D VALUES ("437","54","3","14","37");
INSERT INTO Salida_D VALUES ("438","54","3","15","75");
INSERT INTO Salida_D VALUES ("439","54","3","16","84");
INSERT INTO Salida_D VALUES ("440","54","3","17","65");
INSERT INTO Salida_D VALUES ("441","54","3","18","30");
INSERT INTO Salida_D VALUES ("442","54","3","19","14");
INSERT INTO Salida_D VALUES ("443","54","3","20","10");
INSERT INTO Salida_D VALUES ("444","54","3","21","20");
INSERT INTO Salida_D VALUES ("445","54","4","9","4");
INSERT INTO Salida_D VALUES ("446","54","4","11","22");
INSERT INTO Salida_D VALUES ("447","54","4","13","46");
INSERT INTO Salida_D VALUES ("448","54","4","14","75");
INSERT INTO Salida_D VALUES ("449","54","4","15","77");
INSERT INTO Salida_D VALUES ("450","54","4","16","65");
INSERT INTO Salida_D VALUES ("451","54","4","17","31");
INSERT INTO Salida_D VALUES ("452","54","4","18","23");
INSERT INTO Salida_D VALUES ("453","54","4","19","9");
INSERT INTO Salida_D VALUES ("454","54","4","20","5");
INSERT INTO Salida_D VALUES ("455","54","4","21","15");
INSERT INTO Salida_D VALUES ("456","54","9","27","94");
INSERT INTO Salida_D VALUES ("457","54","9","28","120");
INSERT INTO Salida_D VALUES ("458","54","9","29","128");
INSERT INTO Salida_D VALUES ("459","54","9","30","0");
INSERT INTO Salida_D VALUES ("460","54","10","2","7");
INSERT INTO Salida_D VALUES ("461","54","10","3","32");
INSERT INTO Salida_D VALUES ("462","54","10","4","34");
INSERT INTO Salida_D VALUES ("463","54","10","5","62");
INSERT INTO Salida_D VALUES ("464","54","10","6","89");
INSERT INTO Salida_D VALUES ("465","54","10","7","87");
INSERT INTO Salida_D VALUES ("466","54","10","8","44");
INSERT INTO Salida_D VALUES ("467","54","10","9","11");
INSERT INTO Salida_D VALUES ("468","54","10","10","6");
INSERT INTO Salida_D VALUES ("469","54","20","32","0");
INSERT INTO Salida_D VALUES ("470","54","23","29","0");
INSERT INTO Salida_D VALUES ("471","54","24","32","0");
INSERT INTO Salida_D VALUES ("472","54","25","32","0");
INSERT INTO Salida_D VALUES ("473","54","27","32","0");
INSERT INTO Salida_D VALUES ("474","54","30","32","0");
INSERT INTO Salida_D VALUES ("475","54","31","32","0");
INSERT INTO Salida_D VALUES ("476","54","36","32","0");
INSERT INTO Salida_D VALUES ("477","55","3","11","15");
INSERT INTO Salida_D VALUES ("478","55","3","13","96");
INSERT INTO Salida_D VALUES ("479","55","3","14","109");
INSERT INTO Salida_D VALUES ("480","55","3","15","86");
INSERT INTO Salida_D VALUES ("481","55","3","16","70");
INSERT INTO Salida_D VALUES ("482","55","3","17","68");
INSERT INTO Salida_D VALUES ("483","55","3","18","46");
INSERT INTO Salida_D VALUES ("484","55","3","19","26");
INSERT INTO Salida_D VALUES ("485","55","3","20","15");
INSERT INTO Salida_D VALUES ("486","55","3","21","0");
INSERT INTO Salida_D VALUES ("487","55","3","22","9");
INSERT INTO Salida_D VALUES ("488","55","4","7","33");
INSERT INTO Salida_D VALUES ("489","55","4","9","35");
INSERT INTO Salida_D VALUES ("490","55","4","11","65");
INSERT INTO Salida_D VALUES ("491","55","4","13","115");
INSERT INTO Salida_D VALUES ("492","55","4","14","100");
INSERT INTO Salida_D VALUES ("493","55","4","15","90");
INSERT INTO Salida_D VALUES ("494","55","4","16","50");
INSERT INTO Salida_D VALUES ("495","55","4","17","0");
INSERT INTO Salida_D VALUES ("496","55","4","18","12");
INSERT INTO Salida_D VALUES ("497","55","4","19","0");
INSERT INTO Salida_D VALUES ("498","55","4","20","4");
INSERT INTO Salida_D VALUES ("499","55","4","21","3");
INSERT INTO Salida_D VALUES ("500","55","4","22","4");
INSERT INTO Salida_D VALUES ("501","55","9","26","0");
INSERT INTO Salida_D VALUES ("502","55","9","27","120");
INSERT INTO Salida_D VALUES ("503","55","9","28","207");
INSERT INTO Salida_D VALUES ("504","55","9","29","90");
INSERT INTO Salida_D VALUES ("505","55","9","30","0");
INSERT INTO Salida_D VALUES ("506","55","9","31","0");
INSERT INTO Salida_D VALUES ("507","55","10","2","19");
INSERT INTO Salida_D VALUES ("508","55","10","3","50");
INSERT INTO Salida_D VALUES ("509","55","10","4","62");
INSERT INTO Salida_D VALUES ("510","55","10","5","72");
INSERT INTO Salida_D VALUES ("511","55","10","6","135");
INSERT INTO Salida_D VALUES ("512","55","10","7","135");
INSERT INTO Salida_D VALUES ("513","55","10","8","60");
INSERT INTO Salida_D VALUES ("514","55","10","9","15");
INSERT INTO Salida_D VALUES ("515","55","10","10","3");
INSERT INTO Salida_D VALUES ("516","55","10","11","3");
INSERT INTO Salida_D VALUES ("517","55","20","32","300");
INSERT INTO Salida_D VALUES ("518","55","23","29","0");
INSERT INTO Salida_D VALUES ("519","55","24","32","0");
INSERT INTO Salida_D VALUES ("520","55","25","32","0");
INSERT INTO Salida_D VALUES ("521","55","27","32","0");
INSERT INTO Salida_D VALUES ("522","55","30","32","0");
INSERT INTO Salida_D VALUES ("523","55","31","32","0");
INSERT INTO Salida_D VALUES ("524","55","36","32","0");
INSERT INTO Salida_D VALUES ("525","56","3","11","0");
INSERT INTO Salida_D VALUES ("526","56","3","13","0");
INSERT INTO Salida_D VALUES ("527","56","3","14","0");
INSERT INTO Salida_D VALUES ("528","56","3","15","0");
INSERT INTO Salida_D VALUES ("529","56","3","16","0");
INSERT INTO Salida_D VALUES ("530","56","3","17","0");
INSERT INTO Salida_D VALUES ("531","56","3","18","0");
INSERT INTO Salida_D VALUES ("532","56","3","19","0");
INSERT INTO Salida_D VALUES ("533","56","3","20","0");
INSERT INTO Salida_D VALUES ("534","56","3","21","0");
INSERT INTO Salida_D VALUES ("535","56","3","22","0");
INSERT INTO Salida_D VALUES ("536","56","4","7","0");
INSERT INTO Salida_D VALUES ("537","56","4","9","0");
INSERT INTO Salida_D VALUES ("538","56","4","11","0");
INSERT INTO Salida_D VALUES ("539","56","4","13","0");
INSERT INTO Salida_D VALUES ("540","56","4","14","0");
INSERT INTO Salida_D VALUES ("541","56","4","15","0");
INSERT INTO Salida_D VALUES ("542","56","4","16","0");
INSERT INTO Salida_D VALUES ("543","56","4","17","0");
INSERT INTO Salida_D VALUES ("544","56","4","18","0");
INSERT INTO Salida_D VALUES ("545","56","4","19","0");
INSERT INTO Salida_D VALUES ("546","56","4","20","0");
INSERT INTO Salida_D VALUES ("547","56","4","21","0");
INSERT INTO Salida_D VALUES ("548","56","4","22","0");
INSERT INTO Salida_D VALUES ("549","56","9","26","60");
INSERT INTO Salida_D VALUES ("550","56","9","27","0");
INSERT INTO Salida_D VALUES ("551","56","9","28","0");
INSERT INTO Salida_D VALUES ("552","56","9","29","0");
INSERT INTO Salida_D VALUES ("553","56","9","30","0");
INSERT INTO Salida_D VALUES ("554","56","9","31","0");
INSERT INTO Salida_D VALUES ("555","56","10","2","0");
INSERT INTO Salida_D VALUES ("556","56","10","3","0");
INSERT INTO Salida_D VALUES ("557","56","10","4","0");
INSERT INTO Salida_D VALUES ("558","56","10","5","0");
INSERT INTO Salida_D VALUES ("559","56","10","6","0");
INSERT INTO Salida_D VALUES ("560","56","10","7","0");
INSERT INTO Salida_D VALUES ("561","56","10","8","0");
INSERT INTO Salida_D VALUES ("562","56","10","9","0");
INSERT INTO Salida_D VALUES ("563","56","10","10","0");
INSERT INTO Salida_D VALUES ("564","56","10","11","0");
INSERT INTO Salida_D VALUES ("565","56","20","32","0");
INSERT INTO Salida_D VALUES ("566","56","23","29","0");
INSERT INTO Salida_D VALUES ("567","56","24","32","0");
INSERT INTO Salida_D VALUES ("568","56","25","32","0");
INSERT INTO Salida_D VALUES ("569","56","27","32","0");
INSERT INTO Salida_D VALUES ("570","56","30","32","0");
INSERT INTO Salida_D VALUES ("571","56","31","32","0");
INSERT INTO Salida_D VALUES ("572","56","36","32","0");
INSERT INTO Salida_D VALUES ("573","57","3","11","4");
INSERT INTO Salida_D VALUES ("574","57","3","13","22");
INSERT INTO Salida_D VALUES ("575","57","3","14","84");
INSERT INTO Salida_D VALUES ("576","57","3","15","80");
INSERT INTO Salida_D VALUES ("577","57","3","16","79");
INSERT INTO Salida_D VALUES ("578","57","3","17","64");
INSERT INTO Salida_D VALUES ("579","57","3","18","27");
INSERT INTO Salida_D VALUES ("580","57","3","19","22");
INSERT INTO Salida_D VALUES ("581","57","3","20","10");
INSERT INTO Salida_D VALUES ("582","57","3","21","0");
INSERT INTO Salida_D VALUES ("583","57","4","11","35");
INSERT INTO Salida_D VALUES ("584","57","4","13","87");
INSERT INTO Salida_D VALUES ("585","57","4","14","97");
INSERT INTO Salida_D VALUES ("586","57","4","15","70");
INSERT INTO Salida_D VALUES ("587","57","4","16","47");
INSERT INTO Salida_D VALUES ("588","57","4","17","36");
INSERT INTO Salida_D VALUES ("589","57","4","18","10");
INSERT INTO Salida_D VALUES ("590","57","4","19","0");
INSERT INTO Salida_D VALUES ("591","57","4","20","10");
INSERT INTO Salida_D VALUES ("592","57","4","21","10");
INSERT INTO Salida_D VALUES ("593","57","8","27","0");
INSERT INTO Salida_D VALUES ("594","57","8","28","0");
INSERT INTO Salida_D VALUES ("595","57","8","29","0");
INSERT INTO Salida_D VALUES ("596","57","10","3","31");
INSERT INTO Salida_D VALUES ("597","57","10","4","10");
INSERT INTO Salida_D VALUES ("598","57","10","5","40");
INSERT INTO Salida_D VALUES ("599","57","10","6","200");
INSERT INTO Salida_D VALUES ("600","57","10","7","100");
INSERT INTO Salida_D VALUES ("601","57","10","8","38");
INSERT INTO Salida_D VALUES ("602","57","20","32","300");
INSERT INTO Salida_D VALUES ("603","57","22","32","200");
INSERT INTO Salida_D VALUES ("604","57","24","32","0");
INSERT INTO Salida_D VALUES ("605","57","25","32","0");
INSERT INTO Salida_D VALUES ("606","57","27","32","0");
INSERT INTO Salida_D VALUES ("607","57","30","32","0");
INSERT INTO Salida_D VALUES ("608","57","31","32","0");
INSERT INTO Salida_D VALUES ("609","57","36","32","0");
INSERT INTO Salida_D VALUES ("610","58","9","27","36");
INSERT INTO Salida_D VALUES ("611","58","9","28","157");
INSERT INTO Salida_D VALUES ("612","58","9","29","43");
INSERT INTO Salida_D VALUES ("613","59","4","13","2");
INSERT INTO Salida_D VALUES ("614","59","10","5","1");
INSERT INTO Salida_D VALUES ("615","59","10","6","1");
INSERT INTO Salida_D VALUES ("616","59","64","13","2");
INSERT INTO Salida_D VALUES ("617","60","3","13","70");
INSERT INTO Salida_D VALUES ("618","60","3","14","60");
INSERT INTO Salida_D VALUES ("619","60","3","15","70");
INSERT INTO Salida_D VALUES ("620","60","3","16","70");
INSERT INTO Salida_D VALUES ("621","60","3","17","70");
INSERT INTO Salida_D VALUES ("622","60","3","18","70");
INSERT INTO Salida_D VALUES ("623","60","3","19","40");
INSERT INTO Salida_D VALUES ("624","60","3","20","70");
INSERT INTO Salida_D VALUES ("625","60","3","21","14");
INSERT INTO Salida_D VALUES ("626","60","3","22","20");
INSERT INTO Salida_D VALUES ("627","60","4","11","60");
INSERT INTO Salida_D VALUES ("628","60","4","13","60");
INSERT INTO Salida_D VALUES ("629","60","4","14","80");
INSERT INTO Salida_D VALUES ("630","60","4","15","63");
INSERT INTO Salida_D VALUES ("631","60","4","16","40");
INSERT INTO Salida_D VALUES ("632","60","4","17","0");
INSERT INTO Salida_D VALUES ("633","60","4","18","39");
INSERT INTO Salida_D VALUES ("634","60","4","19","0");
INSERT INTO Salida_D VALUES ("635","60","4","20","40");
INSERT INTO Salida_D VALUES ("636","60","4","21","30");
INSERT INTO Salida_D VALUES ("637","60","4","22","25");
INSERT INTO Salida_D VALUES ("638","60","9","26","50");
INSERT INTO Salida_D VALUES ("639","60","9","27","0");
INSERT INTO Salida_D VALUES ("640","60","9","28","50");
INSERT INTO Salida_D VALUES ("641","60","9","29","50");
INSERT INTO Salida_D VALUES ("642","60","9","30","0");
INSERT INTO Salida_D VALUES ("643","60","9","31","0");
INSERT INTO Salida_D VALUES ("644","60","10","3","20");
INSERT INTO Salida_D VALUES ("645","60","10","4","20");
INSERT INTO Salida_D VALUES ("646","60","10","5","50");
INSERT INTO Salida_D VALUES ("647","60","10","6","50");
INSERT INTO Salida_D VALUES ("648","60","10","7","20");
INSERT INTO Salida_D VALUES ("649","60","10","8","50");
INSERT INTO Salida_D VALUES ("650","60","10","9","8");
INSERT INTO Salida_D VALUES ("651","60","20","32","0");
INSERT INTO Salida_D VALUES ("652","60","22","32","0");
INSERT INTO Salida_D VALUES ("653","60","24","32","0");
INSERT INTO Salida_D VALUES ("654","60","25","32","0");
INSERT INTO Salida_D VALUES ("655","60","27","32","0");
INSERT INTO Salida_D VALUES ("656","60","29","32","0");
INSERT INTO Salida_D VALUES ("657","60","30","32","0");
INSERT INTO Salida_D VALUES ("658","61","3","13","0");
INSERT INTO Salida_D VALUES ("659","61","3","14","0");
INSERT INTO Salida_D VALUES ("660","61","3","15","0");
INSERT INTO Salida_D VALUES ("661","61","3","16","0");
INSERT INTO Salida_D VALUES ("662","61","3","17","0");
INSERT INTO Salida_D VALUES ("663","61","3","18","0");
INSERT INTO Salida_D VALUES ("664","61","3","19","0");
INSERT INTO Salida_D VALUES ("665","61","3","20","0");
INSERT INTO Salida_D VALUES ("666","61","3","21","0");
INSERT INTO Salida_D VALUES ("667","61","3","22","0");
INSERT INTO Salida_D VALUES ("668","61","4","11","0");
INSERT INTO Salida_D VALUES ("669","61","4","13","0");
INSERT INTO Salida_D VALUES ("670","61","4","14","0");
INSERT INTO Salida_D VALUES ("671","61","4","15","0");
INSERT INTO Salida_D VALUES ("672","61","4","16","0");
INSERT INTO Salida_D VALUES ("673","61","4","17","0");
INSERT INTO Salida_D VALUES ("674","61","4","18","0");
INSERT INTO Salida_D VALUES ("675","61","4","19","0");
INSERT INTO Salida_D VALUES ("676","61","4","20","0");
INSERT INTO Salida_D VALUES ("677","61","4","21","0");
INSERT INTO Salida_D VALUES ("678","61","4","22","0");
INSERT INTO Salida_D VALUES ("679","61","9","26","0");
INSERT INTO Salida_D VALUES ("680","61","9","27","0");
INSERT INTO Salida_D VALUES ("681","61","9","28","0");
INSERT INTO Salida_D VALUES ("682","61","9","29","0");
INSERT INTO Salida_D VALUES ("683","61","9","30","50");
INSERT INTO Salida_D VALUES ("684","61","9","31","0");
INSERT INTO Salida_D VALUES ("685","61","10","3","0");
INSERT INTO Salida_D VALUES ("686","61","10","4","0");
INSERT INTO Salida_D VALUES ("687","61","10","5","0");
INSERT INTO Salida_D VALUES ("688","61","10","6","0");
INSERT INTO Salida_D VALUES ("689","61","10","7","0");
INSERT INTO Salida_D VALUES ("690","61","10","8","0");
INSERT INTO Salida_D VALUES ("691","61","10","9","0");
INSERT INTO Salida_D VALUES ("692","61","20","32","400");
INSERT INTO Salida_D VALUES ("693","61","22","32","0");
INSERT INTO Salida_D VALUES ("694","61","24","32","0");
INSERT INTO Salida_D VALUES ("695","61","25","32","0");
INSERT INTO Salida_D VALUES ("696","61","27","32","0");
INSERT INTO Salida_D VALUES ("697","61","29","32","0");
INSERT INTO Salida_D VALUES ("698","61","30","32","0");
INSERT INTO Salida_D VALUES ("699","62","3","7","0");
INSERT INTO Salida_D VALUES ("700","62","3","9","0");
INSERT INTO Salida_D VALUES ("701","62","3","11","75");
INSERT INTO Salida_D VALUES ("702","62","3","13","90");
INSERT INTO Salida_D VALUES ("703","62","3","14","90");
INSERT INTO Salida_D VALUES ("704","62","3","15","85");
INSERT INTO Salida_D VALUES ("705","62","3","16","40");
INSERT INTO Salida_D VALUES ("706","62","3","17","45");
INSERT INTO Salida_D VALUES ("707","62","3","18","20");
INSERT INTO Salida_D VALUES ("708","62","3","19","15");
INSERT INTO Salida_D VALUES ("709","62","3","20","13");
INSERT INTO Salida_D VALUES ("710","62","3","21","0");
INSERT INTO Salida_D VALUES ("711","62","3","22","3");
INSERT INTO Salida_D VALUES ("712","62","4","7","20");
INSERT INTO Salida_D VALUES ("713","62","4","9","40");
INSERT INTO Salida_D VALUES ("714","62","4","11","70");
INSERT INTO Salida_D VALUES ("715","62","4","13","120");
INSERT INTO Salida_D VALUES ("716","62","4","14","90");
INSERT INTO Salida_D VALUES ("717","62","4","15","0");
INSERT INTO Salida_D VALUES ("718","62","4","16","53");
INSERT INTO Salida_D VALUES ("719","62","4","17","0");
INSERT INTO Salida_D VALUES ("720","62","4","18","0");
INSERT INTO Salida_D VALUES ("721","62","4","19","0");
INSERT INTO Salida_D VALUES ("722","62","4","20","6");
INSERT INTO Salida_D VALUES ("723","62","4","21","0");
INSERT INTO Salida_D VALUES ("724","62","4","22","15");
INSERT INTO Salida_D VALUES ("725","62","4","23","3");
INSERT INTO Salida_D VALUES ("726","62","8","26","0");
INSERT INTO Salida_D VALUES ("727","62","8","27","0");
INSERT INTO Salida_D VALUES ("728","62","8","28","0");
INSERT INTO Salida_D VALUES ("729","62","8","29","0");
INSERT INTO Salida_D VALUES ("730","62","8","30","0");
INSERT INTO Salida_D VALUES ("731","62","10","1","10");
INSERT INTO Salida_D VALUES ("732","62","10","2","80");
INSERT INTO Salida_D VALUES ("733","62","10","3","70");
INSERT INTO Salida_D VALUES ("734","62","10","4","70");
INSERT INTO Salida_D VALUES ("735","62","10","5","130");
INSERT INTO Salida_D VALUES ("736","62","10","6","0");
INSERT INTO Salida_D VALUES ("737","62","10","7","0");
INSERT INTO Salida_D VALUES ("738","62","10","8","30");
INSERT INTO Salida_D VALUES ("739","62","10","9","0");
INSERT INTO Salida_D VALUES ("740","62","20","32","0");
INSERT INTO Salida_D VALUES ("741","62","22","32","225");
INSERT INTO Salida_D VALUES ("742","62","23","28","0");
INSERT INTO Salida_D VALUES ("743","62","24","32","0");
INSERT INTO Salida_D VALUES ("744","62","25","32","0");
INSERT INTO Salida_D VALUES ("745","62","27","32","8");
INSERT INTO Salida_D VALUES ("746","62","30","32","0");
INSERT INTO Salida_D VALUES ("747","62","31","32","95");
INSERT INTO Salida_D VALUES ("748","62","36","32","81");
INSERT INTO Salida_D VALUES ("749","62","56","32","0");
INSERT INTO Salida_D VALUES ("750","63","9","26","90");
INSERT INTO Salida_D VALUES ("751","63","9","27","0");
INSERT INTO Salida_D VALUES ("752","63","9","28","184");
INSERT INTO Salida_D VALUES ("753","63","9","29","95");
INSERT INTO Salida_D VALUES ("754","63","9","30","80");
INSERT INTO Salida_D VALUES ("755","64","3","7","0");
INSERT INTO Salida_D VALUES ("756","64","3","9","0");
INSERT INTO Salida_D VALUES ("757","64","3","11","0");
INSERT INTO Salida_D VALUES ("758","64","3","13","0");
INSERT INTO Salida_D VALUES ("759","64","3","14","0");
INSERT INTO Salida_D VALUES ("760","64","3","15","0");
INSERT INTO Salida_D VALUES ("761","64","3","16","25");
INSERT INTO Salida_D VALUES ("762","64","3","17","0");
INSERT INTO Salida_D VALUES ("763","64","3","18","0");
INSERT INTO Salida_D VALUES ("764","64","3","19","0");
INSERT INTO Salida_D VALUES ("765","64","3","20","0");
INSERT INTO Salida_D VALUES ("766","64","3","21","0");
INSERT INTO Salida_D VALUES ("767","64","3","22","0");
INSERT INTO Salida_D VALUES ("768","64","4","7","0");
INSERT INTO Salida_D VALUES ("769","64","4","9","0");
INSERT INTO Salida_D VALUES ("770","64","4","11","0");
INSERT INTO Salida_D VALUES ("771","64","4","13","0");
INSERT INTO Salida_D VALUES ("772","64","4","14","0");
INSERT INTO Salida_D VALUES ("773","64","4","15","0");
INSERT INTO Salida_D VALUES ("774","64","4","16","0");
INSERT INTO Salida_D VALUES ("775","64","4","17","0");
INSERT INTO Salida_D VALUES ("776","64","4","18","0");
INSERT INTO Salida_D VALUES ("777","64","4","19","0");
INSERT INTO Salida_D VALUES ("778","64","4","20","0");
INSERT INTO Salida_D VALUES ("779","64","4","21","0");
INSERT INTO Salida_D VALUES ("780","64","4","22","0");
INSERT INTO Salida_D VALUES ("781","64","4","23","0");
INSERT INTO Salida_D VALUES ("782","64","8","26","0");
INSERT INTO Salida_D VALUES ("783","64","8","27","0");
INSERT INTO Salida_D VALUES ("784","64","8","28","0");
INSERT INTO Salida_D VALUES ("785","64","8","29","0");
INSERT INTO Salida_D VALUES ("786","64","8","30","0");
INSERT INTO Salida_D VALUES ("787","64","10","1","0");
INSERT INTO Salida_D VALUES ("788","64","10","2","0");
INSERT INTO Salida_D VALUES ("789","64","10","3","0");
INSERT INTO Salida_D VALUES ("790","64","10","4","0");
INSERT INTO Salida_D VALUES ("791","64","10","5","0");
INSERT INTO Salida_D VALUES ("792","64","10","6","20");
INSERT INTO Salida_D VALUES ("793","64","10","7","25");
INSERT INTO Salida_D VALUES ("794","64","10","8","0");
INSERT INTO Salida_D VALUES ("795","64","10","9","20");
INSERT INTO Salida_D VALUES ("796","64","20","32","0");
INSERT INTO Salida_D VALUES ("797","64","22","32","0");
INSERT INTO Salida_D VALUES ("798","64","23","28","0");
INSERT INTO Salida_D VALUES ("799","64","24","32","0");
INSERT INTO Salida_D VALUES ("800","64","25","32","0");
INSERT INTO Salida_D VALUES ("801","64","27","32","0");
INSERT INTO Salida_D VALUES ("802","64","30","32","0");
INSERT INTO Salida_D VALUES ("803","64","31","32","0");
INSERT INTO Salida_D VALUES ("804","64","36","32","0");
INSERT INTO Salida_D VALUES ("805","64","56","32","0");
INSERT INTO Salida_D VALUES ("806","65","3","9","0");
INSERT INTO Salida_D VALUES ("807","65","3","11","14");
INSERT INTO Salida_D VALUES ("808","65","3","13","14");
INSERT INTO Salida_D VALUES ("809","65","3","14","25");
INSERT INTO Salida_D VALUES ("810","65","3","15","28");
INSERT INTO Salida_D VALUES ("811","65","3","16","27");
INSERT INTO Salida_D VALUES ("812","65","3","17","21");
INSERT INTO Salida_D VALUES ("813","65","3","18","11");
INSERT INTO Salida_D VALUES ("814","65","3","19","4");
INSERT INTO Salida_D VALUES ("815","65","3","20","2");
INSERT INTO Salida_D VALUES ("816","65","3","21","0");
INSERT INTO Salida_D VALUES ("817","65","3","22","3");
INSERT INTO Salida_D VALUES ("818","65","4","7","5");
INSERT INTO Salida_D VALUES ("819","65","4","9","4");
INSERT INTO Salida_D VALUES ("820","65","4","11","15");
INSERT INTO Salida_D VALUES ("821","65","4","13","29");
INSERT INTO Salida_D VALUES ("822","65","4","14","0");
INSERT INTO Salida_D VALUES ("823","65","4","15","0");
INSERT INTO Salida_D VALUES ("824","65","4","16","0");
INSERT INTO Salida_D VALUES ("825","65","4","17","0");
INSERT INTO Salida_D VALUES ("826","65","4","18","0");
INSERT INTO Salida_D VALUES ("827","65","4","19","0");
INSERT INTO Salida_D VALUES ("828","65","4","20","0");
INSERT INTO Salida_D VALUES ("829","65","4","21","0");
INSERT INTO Salida_D VALUES ("830","65","4","22","2");
INSERT INTO Salida_D VALUES ("831","65","8","26","0");
INSERT INTO Salida_D VALUES ("832","65","8","27","0");
INSERT INTO Salida_D VALUES ("833","65","8","28","0");
INSERT INTO Salida_D VALUES ("834","65","8","29","0");
INSERT INTO Salida_D VALUES ("835","65","8","30","0");
INSERT INTO Salida_D VALUES ("836","65","8","31","0");
INSERT INTO Salida_D VALUES ("837","65","10","1","3");
INSERT INTO Salida_D VALUES ("838","65","10","2","9");
INSERT INTO Salida_D VALUES ("839","65","10","3","20");
INSERT INTO Salida_D VALUES ("840","65","10","4","25");
INSERT INTO Salida_D VALUES ("841","65","10","5","33");
INSERT INTO Salida_D VALUES ("842","65","10","6","14");
INSERT INTO Salida_D VALUES ("843","65","10","7","0");
INSERT INTO Salida_D VALUES ("844","65","10","8","6");
INSERT INTO Salida_D VALUES ("845","65","10","9","3");
INSERT INTO Salida_D VALUES ("846","65","20","32","0");
INSERT INTO Salida_D VALUES ("847","65","22","32","0");
INSERT INTO Salida_D VALUES ("848","65","24","32","0");
INSERT INTO Salida_D VALUES ("849","65","25","32","0");
INSERT INTO Salida_D VALUES ("850","65","27","32","0");
INSERT INTO Salida_D VALUES ("851","65","30","32","0");
INSERT INTO Salida_D VALUES ("852","65","31","32","0");
INSERT INTO Salida_D VALUES ("853","65","36","32","0");
INSERT INTO Salida_D VALUES ("854","65","56","32","0");
INSERT INTO Salida_D VALUES ("855","66","9","26","8");
INSERT INTO Salida_D VALUES ("856","66","9","27","0");
INSERT INTO Salida_D VALUES ("857","66","9","28","47");
INSERT INTO Salida_D VALUES ("858","66","9","29","49");
INSERT INTO Salida_D VALUES ("859","66","9","30","10");
INSERT INTO Salida_D VALUES ("860","66","9","31","0");
INSERT INTO Salida_D VALUES ("861","67","3","11","3");
INSERT INTO Salida_D VALUES ("862","67","3","13","5");
INSERT INTO Salida_D VALUES ("863","67","3","14","2");
INSERT INTO Salida_D VALUES ("864","67","4","11","3");
INSERT INTO Salida_D VALUES ("865","67","4","13","5");
INSERT INTO Salida_D VALUES ("866","67","4","14","0");
INSERT INTO Salida_D VALUES ("867","67","9","27","0");
INSERT INTO Salida_D VALUES ("868","67","10","4","5");
INSERT INTO Salida_D VALUES ("869","67","10","5","5");
INSERT INTO Salida_D VALUES ("870","68","9","28","10");

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

