-- Estructura de la tabla `borrador_requisiciond`
CREATE TABLE `borrador_requisiciond` (
  `BId` int(11) NOT NULL AUTO_INCREMENT,
  `BIdReqE` int(11) DEFAULT NULL,
  `BIdCProd` int(11) DEFAULT NULL,
  `BIdTalla` int(11) DEFAULT NULL,
  `BCantidad` int(11) NOT NULL,
  PRIMARY KEY (`BId`),
  KEY `BIdReqE` (`BIdReqE`),
  KEY `BIdCProd` (`BIdCProd`),
  KEY `BIdTalla` (`BIdTalla`),
  CONSTRAINT `Borrador_RequisicionD_ibfk_1` FOREIGN KEY (`BIdReqE`) REFERENCES `borrador_requisicione` (`BIDRequisicionE`),
  CONSTRAINT `Borrador_RequisicionD_ibfk_2` FOREIGN KEY (`BIdCProd`) REFERENCES `producto` (`IdCProducto`),
  CONSTRAINT `Borrador_RequisicionD_ibfk_3` FOREIGN KEY (`BIdTalla`) REFERENCES `ctallas` (`IdCTallas`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `borrador_requisiciond` VALUES ("52","12","1","7","1");
INSERT INTO `borrador_requisiciond` VALUES ("60","14","9","29","2");
INSERT INTO `borrador_requisiciond` VALUES ("61","14","3","15","2");
INSERT INTO `borrador_requisiciond` VALUES ("62","14","37","32","1");
INSERT INTO `borrador_requisiciond` VALUES ("63","14","30","32","5");
INSERT INTO `borrador_requisiciond` VALUES ("64","14","10","6","1");
INSERT INTO `borrador_requisiciond` VALUES ("106","23","1","1","1");
INSERT INTO `borrador_requisiciond` VALUES ("109","27","10","6","4");
INSERT INTO `borrador_requisiciond` VALUES ("110","28","40","32","5");
INSERT INTO `borrador_requisiciond` VALUES ("111","28","41","32","7");
INSERT INTO `borrador_requisiciond` VALUES ("112","28","42","32","4");
INSERT INTO `borrador_requisiciond` VALUES ("119","35","4","16","2");
INSERT INTO `borrador_requisiciond` VALUES ("120","35","4","15","3");
INSERT INTO `borrador_requisiciond` VALUES ("121","35","4","14","3");
INSERT INTO `borrador_requisiciond` VALUES ("122","35","4","13","5");
INSERT INTO `borrador_requisiciond` VALUES ("123","35","3","19","2");
INSERT INTO `borrador_requisiciond` VALUES ("124","35","3","16","4");
INSERT INTO `borrador_requisiciond` VALUES ("125","35","3","15","4");
INSERT INTO `borrador_requisiciond` VALUES ("126","35","3","14","3");
INSERT INTO `borrador_requisiciond` VALUES ("127","35","37","32","3");
INSERT INTO `borrador_requisiciond` VALUES ("128","35","20","32","8");

-- Estructura de la tabla `borrador_requisicione`
CREATE TABLE `borrador_requisicione` (
  `BIDRequisicionE` int(11) NOT NULL AUTO_INCREMENT,
  `BIdUsuario` int(11) DEFAULT NULL,
  `BFchCreacion` datetime NOT NULL,
  `BEstatus` varchar(100) NOT NULL,
  `BSupervisor` varchar(250) NOT NULL,
  `BIdCuenta` int(11) DEFAULT NULL,
  `BIdRegion` int(11) DEFAULT NULL,
  `BCentroTrabajo` varchar(250) DEFAULT NULL,
  `BNroElementos` varchar(100) NOT NULL,
  `BReceptor` varchar(250) NOT NULL,
  `BTelReceptor` varchar(250) NOT NULL,
  `BRfcReceptor` varchar(250) NOT NULL,
  `BJustificacion` varchar(250) DEFAULT NULL,
  `BIdEstado` int(11) DEFAULT NULL,
  `BMpio` varchar(250) DEFAULT NULL,
  `BColonia` varchar(250) DEFAULT NULL,
  `BCalle` varchar(250) DEFAULT NULL,
  `BNro` varchar(250) DEFAULT NULL,
  `BCP` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`BIDRequisicionE`),
  KEY `BIdUsuario` (`BIdUsuario`),
  KEY `BIdCuenta` (`BIdCuenta`),
  KEY `BIdRegion` (`BIdRegion`),
  KEY `BIdEstado` (`BIdEstado`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_1` FOREIGN KEY (`BIdUsuario`) REFERENCES `usuario` (`ID_Usuario`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_2` FOREIGN KEY (`BIdCuenta`) REFERENCES `cuenta` (`ID`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_3` FOREIGN KEY (`BIdRegion`) REFERENCES `regiones` (`ID_Region`),
  CONSTRAINT `Borrador_RequisicionE_ibfk_4` FOREIGN KEY (`BIdEstado`) REFERENCES `estados` (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `borrador_requisicione` VALUES ("12","25","2024-12-04 12:37:31","Borrador","Angel Bazan","7","49","pc 59 oaxtepec","0","Angel Bazan","5528169856","","se solicitan uniformes por deterioro, ultima requisición 24-11-23 \n(pasan por ellos)","17","","","","","");
INSERT INTO `borrador_requisicione` VALUES ("14","","2024-12-04 13:58:18","Borrador","Martha Guadalupe Santiago Barron","7","52","Campamento de Conservación, \"San Jose del Cabo","0","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO `borrador_requisicione` VALUES ("23","22","2024-12-09 17:04:56","Borrador","Prueba","7","52","vfv","0","Martha Guadalupe Santiago Barron","1234567890","Ultrimatrix","gjstjtyjtysj","2","","","","","");
INSERT INTO `borrador_requisicione` VALUES ("25","23","2024-12-10 17:14:42","Modificacion_Solicitada","Martha Guadalupe Santiago Barron","7","52","Plaza de Cobro No. 196 \"San Lucas\"","0","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO `borrador_requisicione` VALUES ("26","23","2024-12-10 17:16:22","Modificacion_Solicitada","Martha Guadalupe Santiago Barron","7","52","Plaza de Cobro No. 197 \"El Mangle\"","0","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO `borrador_requisicione` VALUES ("27","23","2024-12-10 17:17:47","Modificacion_Solicitada","Martha Guadalupe Santiago Barron","7","52","Plaza de Cobro No. 195 ","0","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Solicitud de botas, se le descuentan a los elementos via nomina","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO `borrador_requisicione` VALUES ("28","20","2024-12-10 17:18:20","Modificacion_Solicitada","YADIRA GARCIA PEREZ","9","43","CENTENARIO","0","YADIRA GARCIA PEREZ","777 565 4094","","DOTACION DE LISTAS DE ASISTENCIA, CUADRICULAS Y NOVEDADES","17","","","","","");
INSERT INTO `borrador_requisicione` VALUES ("35","23","2025-01-08 13:11:55","Modificacion_Solicitada","Edgar Ramon Cazares Palacios","7","52","Plaza de Cobro No. 36 \"Ensenada\"","0"," Edgar Ramon Cazares Palacios","6241380989","CAPE8501096KA","Reposición de uniformes y equipo de deterioro, ultimo envío 29/07/2024","2","Ensenada","Maestros","Avenida Ignacio Altamirano","2040","22840");

-- Estructura de la tabla `ccategorias`
CREATE TABLE `ccategorias` (
  `IdCCate` int(11) NOT NULL AUTO_INCREMENT,
  `Descrp` varchar(100) NOT NULL,
  PRIMARY KEY (`IdCCate`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ccategorias` VALUES ("1","Uniformes");
INSERT INTO `ccategorias` VALUES ("2","Equipamiento");
INSERT INTO `ccategorias` VALUES ("3","Accesorios");

-- Estructura de la tabla `cempresas`
CREATE TABLE `cempresas` (
  `IdCEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Empresa` varchar(50) NOT NULL,
  `RazonSocial` varchar(200) NOT NULL,
  `RFC` varchar(50) NOT NULL,
  `RegistroPatronal` varchar(200) NOT NULL,
  `Especif` varchar(100) NOT NULL,
  PRIMARY KEY (`IdCEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cempresas` VALUES ("1","PRYSE","Prueba 1","Prueba 1","M0987654321","Prueba 1");
INSERT INTO `cempresas` VALUES ("2","PRYSE/LIMP","Prueba 2","Prueba 2","C0908070605","Prueba 2");
INSERT INTO `cempresas` VALUES ("3","PROTE","Prueba 3","Prueba 3","Y6968676665","Prueba 3");
INSERT INTO `cempresas` VALUES ("4","VALBON","Prueba 4","Prueba 4","D0000012345","Prueba 4");
INSERT INTO `cempresas` VALUES ("5","PRYSE/AICM","Prueba 5","Prueba 5","E0192837465","Prueba 5");
INSERT INTO `cempresas` VALUES ("6","PRYSE/PROTE","Prueba 6","Prueba 6","E0192837466","Prueba 6");
INSERT INTO `cempresas` VALUES ("7","VALVON","Prueba 7","Prueba 7","E0192837467","Prueba 7");
INSERT INTO `cempresas` VALUES ("8","MULTISISTEMAS URIBE","","","","");

-- Estructura de la tabla `centro_trabajo`
CREATE TABLE `centro_trabajo` (
  `ID_Centro` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Centro` varchar(100) NOT NULL,
  `Num_Empleados` int(11) NOT NULL,
  `Servicios_Ofrecidos` text NOT NULL,
  `Turnos_Trabajo` varchar(50) NOT NULL,
  `Fecha_Creacion` datetime NOT NULL,
  `IDRegion` int(11) DEFAULT NULL,
  `IDEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Centro`),
  KEY `IDRegion` (`IDRegion`),
  KEY `IDEstado` (`IDEstado`),
  CONSTRAINT `Centro_Trabajo_ibfk_1` FOREIGN KEY (`IDRegion`) REFERENCES `regiones` (`ID_Region`),
  CONSTRAINT `Centro_Trabajo_ibfk_2` FOREIGN KEY (`IDEstado`) REFERENCES `estados` (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `centro_trabajo` VALUES ("1","Sistemas PRYSE","10","Servicio Tecnico","24 horas","2024-05-06 15:40:46","1","1");

-- Estructura de la tabla `colaborador`
CREATE TABLE `colaborador` (
  `ID_Colaborador` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Apellido_Paterno` varchar(50) NOT NULL,
  `Apellido_Materno` varchar(50) NOT NULL,
  `CURP` varchar(30) NOT NULL,
  `Correo_Electronico` varchar(100) NOT NULL,
  `Fecha_Alta` datetime NOT NULL,
  `ID_Tipo_Colaborador` int(11) DEFAULT NULL,
  `ID_CentroT` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Colaborador`),
  KEY `ID_Tipo_Colaborador` (`ID_Tipo_Colaborador`),
  KEY `ID_CentroT` (`ID_CentroT`),
  CONSTRAINT `Colaborador_ibfk_1` FOREIGN KEY (`ID_Tipo_Colaborador`) REFERENCES `tipo_colaboradores` (`ID`),
  CONSTRAINT `Colaborador_ibfk_2` FOREIGN KEY (`ID_CentroT`) REFERENCES `centro_trabajo` (`ID_Centro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- Estructura de la tabla `ctallas`
CREATE TABLE `ctallas` (
  `IdCTallas` int(11) NOT NULL AUTO_INCREMENT,
  `IdCTipTal` int(11) NOT NULL,
  `Talla` varchar(100) NOT NULL,
  PRIMARY KEY (`IdCTallas`),
  KEY `IdCTipTal` (`IdCTipTal`),
  CONSTRAINT `CTallas_ibfk_1` FOREIGN KEY (`IdCTipTal`) REFERENCES `ctipotallas` (`IdCTipTall`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ctallas` VALUES ("1","1","22");
INSERT INTO `ctallas` VALUES ("2","1","23");
INSERT INTO `ctallas` VALUES ("3","1","24");
INSERT INTO `ctallas` VALUES ("4","1","25");
INSERT INTO `ctallas` VALUES ("5","1","26");
INSERT INTO `ctallas` VALUES ("6","1","27");
INSERT INTO `ctallas` VALUES ("7","1","28");
INSERT INTO `ctallas` VALUES ("8","1","29");
INSERT INTO `ctallas` VALUES ("9","1","30");
INSERT INTO `ctallas` VALUES ("10","1","31");
INSERT INTO `ctallas` VALUES ("11","1","32");
INSERT INTO `ctallas` VALUES ("12","1","33");
INSERT INTO `ctallas` VALUES ("13","1","34");
INSERT INTO `ctallas` VALUES ("14","1","36");
INSERT INTO `ctallas` VALUES ("15","1","38");
INSERT INTO `ctallas` VALUES ("16","1","40");
INSERT INTO `ctallas` VALUES ("17","1","42");
INSERT INTO `ctallas` VALUES ("18","1","44");
INSERT INTO `ctallas` VALUES ("19","1","46");
INSERT INTO `ctallas` VALUES ("20","1","48");
INSERT INTO `ctallas` VALUES ("21","1","50");
INSERT INTO `ctallas` VALUES ("22","1","52");
INSERT INTO `ctallas` VALUES ("23","1","54");
INSERT INTO `ctallas` VALUES ("24","1","56");
INSERT INTO `ctallas` VALUES ("25","2","XCH");
INSERT INTO `ctallas` VALUES ("26","2","CH");
INSERT INTO `ctallas` VALUES ("27","2","M");
INSERT INTO `ctallas` VALUES ("28","2","GDE");
INSERT INTO `ctallas` VALUES ("29","2","XG");
INSERT INTO `ctallas` VALUES ("30","2","XXG");
INSERT INTO `ctallas` VALUES ("31","2","XXXG");
INSERT INTO `ctallas` VALUES ("32","3","UNITALLA");

-- Estructura de la tabla `ctipotallas`
CREATE TABLE `ctipotallas` (
  `IdCTipTall` int(11) NOT NULL AUTO_INCREMENT,
  `Descrip` varchar(50) NOT NULL,
  PRIMARY KEY (`IdCTipTall`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ctipotallas` VALUES ("1","Numerica");
INSERT INTO `ctipotallas` VALUES ("2","Alfabetica");
INSERT INTO `ctipotallas` VALUES ("3","Unitalla");

-- Estructura de la tabla `cuenta`
CREATE TABLE `cuenta` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCuenta` varchar(250) NOT NULL,
  `NroElemetos` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cuenta` VALUES ("1","CFE","357");
INSERT INTO `cuenta` VALUES ("5","Cuenta Prueba","123");
INSERT INTO `cuenta` VALUES ("6","Cuenta Prueba dos","456");
INSERT INTO `cuenta` VALUES ("7","CAPUFE","1000");
INSERT INTO `cuenta` VALUES ("8","IPN","300");
INSERT INTO `cuenta` VALUES ("9","ISSSTE","700");
INSERT INTO `cuenta` VALUES ("10","IMSS Ordinario","4000");
INSERT INTO `cuenta` VALUES ("11","Cuentas Varias","500");

-- Estructura de la tabla `cuenta_region`
CREATE TABLE `cuenta_region` (
  `IDRegCu` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Cuentas` int(11) DEFAULT NULL,
  `ID_Regiones` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDRegCu`),
  KEY `ID_Cuentas` (`ID_Cuentas`),
  KEY `ID_Regiones` (`ID_Regiones`),
  CONSTRAINT `Cuenta_Region_ibfk_1` FOREIGN KEY (`ID_Cuentas`) REFERENCES `cuenta` (`ID`),
  CONSTRAINT `Cuenta_Region_ibfk_2` FOREIGN KEY (`ID_Regiones`) REFERENCES `regiones` (`ID_Region`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cuenta_region` VALUES ("1","1","2");
INSERT INTO `cuenta_region` VALUES ("3","1","4");
INSERT INTO `cuenta_region` VALUES ("4","1","5");
INSERT INTO `cuenta_region` VALUES ("5","1","6");
INSERT INTO `cuenta_region` VALUES ("6","1","7");
INSERT INTO `cuenta_region` VALUES ("7","1","8");
INSERT INTO `cuenta_region` VALUES ("8","1","9");
INSERT INTO `cuenta_region` VALUES ("9","1","10");
INSERT INTO `cuenta_region` VALUES ("10","1","11");
INSERT INTO `cuenta_region` VALUES ("11","1","12");
INSERT INTO `cuenta_region` VALUES ("12","1","13");
INSERT INTO `cuenta_region` VALUES ("13","1","14");
INSERT INTO `cuenta_region` VALUES ("14","1","15");
INSERT INTO `cuenta_region` VALUES ("15","1","16");
INSERT INTO `cuenta_region` VALUES ("16","1","17");
INSERT INTO `cuenta_region` VALUES ("17","1","18");
INSERT INTO `cuenta_region` VALUES ("18","1","19");
INSERT INTO `cuenta_region` VALUES ("19","1","20");
INSERT INTO `cuenta_region` VALUES ("20","1","21");
INSERT INTO `cuenta_region` VALUES ("21","1","22");
INSERT INTO `cuenta_region` VALUES ("22","1","23");
INSERT INTO `cuenta_region` VALUES ("23","1","24");
INSERT INTO `cuenta_region` VALUES ("24","1","25");
INSERT INTO `cuenta_region` VALUES ("25","1","26");
INSERT INTO `cuenta_region` VALUES ("26","1","27");
INSERT INTO `cuenta_region` VALUES ("27","1","28");
INSERT INTO `cuenta_region` VALUES ("28","1","29");
INSERT INTO `cuenta_region` VALUES ("29","1","30");
INSERT INTO `cuenta_region` VALUES ("30","1","31");
INSERT INTO `cuenta_region` VALUES ("31","1","32");
INSERT INTO `cuenta_region` VALUES ("32","1","33");
INSERT INTO `cuenta_region` VALUES ("33","1","34");
INSERT INTO `cuenta_region` VALUES ("34","1","35");
INSERT INTO `cuenta_region` VALUES ("35","1","36");
INSERT INTO `cuenta_region` VALUES ("36","5","37");
INSERT INTO `cuenta_region` VALUES ("37","5","38");
INSERT INTO `cuenta_region` VALUES ("38","5","39");
INSERT INTO `cuenta_region` VALUES ("39","6","40");
INSERT INTO `cuenta_region` VALUES ("40","9","41");
INSERT INTO `cuenta_region` VALUES ("41","9","42");
INSERT INTO `cuenta_region` VALUES ("42","9","43");
INSERT INTO `cuenta_region` VALUES ("43","9","44");
INSERT INTO `cuenta_region` VALUES ("44","10","45");
INSERT INTO `cuenta_region` VALUES ("45","10","46");
INSERT INTO `cuenta_region` VALUES ("46","10","47");
INSERT INTO `cuenta_region` VALUES ("47","10","48");
INSERT INTO `cuenta_region` VALUES ("48","7","49");
INSERT INTO `cuenta_region` VALUES ("49","7","50");
INSERT INTO `cuenta_region` VALUES ("50","7","51");
INSERT INTO `cuenta_region` VALUES ("51","7","52");
INSERT INTO `cuenta_region` VALUES ("52","7","53");
INSERT INTO `cuenta_region` VALUES ("53","7","54");
INSERT INTO `cuenta_region` VALUES ("55","11","56");
INSERT INTO `cuenta_region` VALUES ("56","11","57");

-- Estructura de la tabla `entradad`
CREATE TABLE `entradad` (
  `IdEntD` int(11) NOT NULL AUTO_INCREMENT,
  `IdEntradaE` int(11) DEFAULT NULL,
  `IdProd` int(11) DEFAULT NULL,
  `IdTalla` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`IdEntD`),
  KEY `IdEntradaE` (`IdEntradaE`),
  KEY `IdProd` (`IdProd`),
  KEY `IdTalla` (`IdTalla`),
  CONSTRAINT `EntradaD_ibfk_1` FOREIGN KEY (`IdEntradaE`) REFERENCES `entradae` (`IdEntE`),
  CONSTRAINT `EntradaD_ibfk_2` FOREIGN KEY (`IdProd`) REFERENCES `producto` (`IdCProducto`),
  CONSTRAINT `EntradaD_ibfk_3` FOREIGN KEY (`IdTalla`) REFERENCES `ctallas` (`IdCTallas`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `entradad` VALUES ("23","5","10","3","30");
INSERT INTO `entradad` VALUES ("24","5","10","1","5");
INSERT INTO `entradad` VALUES ("25","5","10","5","10");
INSERT INTO `entradad` VALUES ("26","5","10","7","45");
INSERT INTO `entradad` VALUES ("27","5","10","8","55");
INSERT INTO `entradad` VALUES ("28","5","10","9","30");
INSERT INTO `entradad` VALUES ("29","5","10","10","5");
INSERT INTO `entradad` VALUES ("30","5","10","11","5");
INSERT INTO `entradad` VALUES ("31","6","10","1","5");
INSERT INTO `entradad` VALUES ("32","6","10","3","30");
INSERT INTO `entradad` VALUES ("33","6","10","5","10");
INSERT INTO `entradad` VALUES ("34","6","10","6","15");
INSERT INTO `entradad` VALUES ("35","6","10","7","45");
INSERT INTO `entradad` VALUES ("36","6","10","8","55");
INSERT INTO `entradad` VALUES ("37","6","10","9","30");
INSERT INTO `entradad` VALUES ("38","6","10","10","5");
INSERT INTO `entradad` VALUES ("39","6","10","11","5");
INSERT INTO `entradad` VALUES ("40","7","9","29","770");
INSERT INTO `entradad` VALUES ("41","8","41","32","70");
INSERT INTO `entradad` VALUES ("42","9","10","3","40");
INSERT INTO `entradad` VALUES ("43","9","10","4","5");
INSERT INTO `entradad` VALUES ("44","9","10","6","10");
INSERT INTO `entradad` VALUES ("45","9","10","7","15");
INSERT INTO `entradad` VALUES ("46","9","10","8","40");
INSERT INTO `entradad` VALUES ("47","9","10","9","10");
INSERT INTO `entradad` VALUES ("48","9","10","11","5");
INSERT INTO `entradad` VALUES ("49","9","10","2","25");
INSERT INTO `entradad` VALUES ("50","10","10","3","25");
INSERT INTO `entradad` VALUES ("51","10","10","4","60");
INSERT INTO `entradad` VALUES ("52","10","10","5","20");
INSERT INTO `entradad` VALUES ("53","10","10","6","5");
INSERT INTO `entradad` VALUES ("54","10","10","7","30");
INSERT INTO `entradad` VALUES ("55","10","10","8","30");
INSERT INTO `entradad` VALUES ("56","10","10","9","20");
INSERT INTO `entradad` VALUES ("57","10","10","11","10");
INSERT INTO `entradad` VALUES ("58","11","64","13","42");
INSERT INTO `entradad` VALUES ("59","11","64","14","115");
INSERT INTO `entradad` VALUES ("60","11","64","15","97");
INSERT INTO `entradad` VALUES ("61","11","64","16","24");

-- Estructura de la tabla `entradae`
CREATE TABLE `entradae` (
  `IdEntE` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha_Creacion` datetime NOT NULL,
  `Fecha_Modificacion` datetime DEFAULT NULL,
  `Nro_Modif` int(11) DEFAULT NULL,
  `Usuario_Creacion` int(11) NOT NULL,
  `Proveedor` varchar(250) NOT NULL,
  `Receptor` varchar(250) NOT NULL,
  `Comentarios` varchar(250) NOT NULL,
  `Estatus` varchar(250) NOT NULL,
  PRIMARY KEY (`IdEntE`),
  KEY `Usuario_Creacion` (`Usuario_Creacion`),
  CONSTRAINT `EntradaE_ibfk_1` FOREIGN KEY (`Usuario_Creacion`) REFERENCES `usuario` (`ID_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `entradae` VALUES ("5","2024-11-28 10:32:46","2024-11-28 10:35:06","1","6","juan carlos de la cruz ","yessica heracleo","entrega personal del proveedor fedex","Modificado");
INSERT INTO `entradae` VALUES ("6","2024-12-02 15:49:19","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","Entrega de 200 pares de bota tactica","Creada");
INSERT INTO `entradae` VALUES ("7","2024-12-02 15:51:31","","","6","CHARBEL","EQUIPO ALMACEN","Entrega de chamarra cazadora, la trajo beto","Creada");
INSERT INTO `entradae` VALUES ("8","2024-12-02 15:57:43","","","6","ARTE GRAFICO","EQUIPO ALMACEN","Entrega de blocks, asistencia diaria","Creada");
INSERT INTO `entradae` VALUES ("9","2024-12-02 16:01:50","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","Primer entrega de nuevo pedido de botas por 2500 pares, entregan 150 pares \n22/11/2024","Creada");
INSERT INTO `entradae` VALUES ("10","2024-12-02 16:04:45","","","6","JUAN CARLOS DE LA CRUZ","EQUIPO ALMACEN","Entrega de botas 200 pares","Creada");
INSERT INTO `entradae` VALUES ("11","2024-12-03 13:27:54","","","6","Floraly","EQUIPO ALMACEN","Entrega de nueva camisa, con logo de multisistemas uribe","Creada");

-- Estructura de la tabla `estado_region`
CREATE TABLE `estado_region` (
  `IDEstReg` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Regiones` int(11) DEFAULT NULL,
  `ID_Estados` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDEstReg`),
  KEY `ID_Regiones` (`ID_Regiones`),
  KEY `ID_Estados` (`ID_Estados`),
  CONSTRAINT `Estado_Region_ibfk_1` FOREIGN KEY (`ID_Regiones`) REFERENCES `regiones` (`ID_Region`),
  CONSTRAINT `Estado_Region_ibfk_2` FOREIGN KEY (`ID_Estados`) REFERENCES `estados` (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `estado_region` VALUES ("1","2","2");
INSERT INTO `estado_region` VALUES ("2","2","16");
INSERT INTO `estado_region` VALUES ("3","2","17");
INSERT INTO `estado_region` VALUES ("4","2","30");
INSERT INTO `estado_region` VALUES ("5","2","31");
INSERT INTO `estado_region` VALUES ("24","4","12");
INSERT INTO `estado_region` VALUES ("25","5","12");
INSERT INTO `estado_region` VALUES ("26","5","16");
INSERT INTO `estado_region` VALUES ("27","6","15");
INSERT INTO `estado_region` VALUES ("28","7","4");
INSERT INTO `estado_region` VALUES ("29","8","4");
INSERT INTO `estado_region` VALUES ("30","9","12");
INSERT INTO `estado_region` VALUES ("31","10","27");
INSERT INTO `estado_region` VALUES ("32","11","30");
INSERT INTO `estado_region` VALUES ("33","12","8");
INSERT INTO `estado_region` VALUES ("34","13","3");
INSERT INTO `estado_region` VALUES ("35","14","30");
INSERT INTO `estado_region` VALUES ("36","15","17");
INSERT INTO `estado_region` VALUES ("37","16","17");
INSERT INTO `estado_region` VALUES ("38","17","2");
INSERT INTO `estado_region` VALUES ("39","18","12");
INSERT INTO `estado_region` VALUES ("40","19","16");
INSERT INTO `estado_region` VALUES ("41","20","3");
INSERT INTO `estado_region` VALUES ("42","21","27");
INSERT INTO `estado_region` VALUES ("43","21","5");
INSERT INTO `estado_region` VALUES ("44","21","4");
INSERT INTO `estado_region` VALUES ("45","22","30");
INSERT INTO `estado_region` VALUES ("46","23","31");
INSERT INTO `estado_region` VALUES ("47","24","17");
INSERT INTO `estado_region` VALUES ("48","25","31");
INSERT INTO `estado_region` VALUES ("49","26","30");
INSERT INTO `estado_region` VALUES ("51","27","30");
INSERT INTO `estado_region` VALUES ("52","27","20");
INSERT INTO `estado_region` VALUES ("53","27","21");
INSERT INTO `estado_region` VALUES ("54","28","30");
INSERT INTO `estado_region` VALUES ("55","28","21");
INSERT INTO `estado_region` VALUES ("56","29","26");
INSERT INTO `estado_region` VALUES ("57","29","2");
INSERT INTO `estado_region` VALUES ("58","30","30");
INSERT INTO `estado_region` VALUES ("59","30","21");
INSERT INTO `estado_region` VALUES ("60","31","31");
INSERT INTO `estado_region` VALUES ("61","32","31");
INSERT INTO `estado_region` VALUES ("62","32","23");
INSERT INTO `estado_region` VALUES ("63","33","15");
INSERT INTO `estado_region` VALUES ("64","34","30");
INSERT INTO `estado_region` VALUES ("65","35","30");
INSERT INTO `estado_region` VALUES ("66","36","12");
INSERT INTO `estado_region` VALUES ("67","37","1");
INSERT INTO `estado_region` VALUES ("68","37","2");
INSERT INTO `estado_region` VALUES ("69","37","3");
INSERT INTO `estado_region` VALUES ("70","38","4");
INSERT INTO `estado_region` VALUES ("71","38","5");
INSERT INTO `estado_region` VALUES ("72","38","6");
INSERT INTO `estado_region` VALUES ("73","39","7");
INSERT INTO `estado_region` VALUES ("74","40","1");
INSERT INTO `estado_region` VALUES ("75","41","26");
INSERT INTO `estado_region` VALUES ("76","42","12");
INSERT INTO `estado_region` VALUES ("77","43","17");
INSERT INTO `estado_region` VALUES ("78","44","2");
INSERT INTO `estado_region` VALUES ("79","45","3");
INSERT INTO `estado_region` VALUES ("80","45","2");
INSERT INTO `estado_region` VALUES ("81","45","26");
INSERT INTO `estado_region` VALUES ("82","45","25");
INSERT INTO `estado_region` VALUES ("83","46","28");
INSERT INTO `estado_region` VALUES ("84","46","19");
INSERT INTO `estado_region` VALUES ("85","46","24");
INSERT INTO `estado_region` VALUES ("86","47","1");
INSERT INTO `estado_region` VALUES ("87","47","14");
INSERT INTO `estado_region` VALUES ("88","47","18");
INSERT INTO `estado_region` VALUES ("89","47","32");
INSERT INTO `estado_region` VALUES ("90","48","10");
INSERT INTO `estado_region` VALUES ("91","48","6");
INSERT INTO `estado_region` VALUES ("92","48","7");
INSERT INTO `estado_region` VALUES ("93","49","17");
INSERT INTO `estado_region` VALUES ("94","49","12");
INSERT INTO `estado_region` VALUES ("95","49","20");
INSERT INTO `estado_region` VALUES ("96","49","21");
INSERT INTO `estado_region` VALUES ("97","49","9");
INSERT INTO `estado_region` VALUES ("98","49","11");
INSERT INTO `estado_region` VALUES ("99","49","15");
INSERT INTO `estado_region` VALUES ("100","50","28");
INSERT INTO `estado_region` VALUES ("101","50","30");
INSERT INTO `estado_region` VALUES ("102","50","27");
INSERT INTO `estado_region` VALUES ("103","50","4");
INSERT INTO `estado_region` VALUES ("104","50","20");
INSERT INTO `estado_region` VALUES ("105","50","5");
INSERT INTO `estado_region` VALUES ("106","51","13");
INSERT INTO `estado_region` VALUES ("107","51","15");
INSERT INTO `estado_region` VALUES ("108","51","28");
INSERT INTO `estado_region` VALUES ("109","51","17");
INSERT INTO `estado_region` VALUES ("110","51","32");
INSERT INTO `estado_region` VALUES ("111","51","2");
INSERT INTO `estado_region` VALUES ("112","51","25");
INSERT INTO `estado_region` VALUES ("113","51","16");
INSERT INTO `estado_region` VALUES ("114","51","26");
INSERT INTO `estado_region` VALUES ("115","51","22");
INSERT INTO `estado_region` VALUES ("116","51","20");
INSERT INTO `estado_region` VALUES ("117","51","5");
INSERT INTO `estado_region` VALUES ("118","51","27");
INSERT INTO `estado_region` VALUES ("119","51","10");
INSERT INTO `estado_region` VALUES ("120","51","11");
INSERT INTO `estado_region` VALUES ("121","51","3");
INSERT INTO `estado_region` VALUES ("122","51","29");
INSERT INTO `estado_region` VALUES ("123","51","30");
INSERT INTO `estado_region` VALUES ("124","51","21");
INSERT INTO `estado_region` VALUES ("125","51","4");
INSERT INTO `estado_region` VALUES ("126","51","23");
INSERT INTO `estado_region` VALUES ("127","51","6");
INSERT INTO `estado_region` VALUES ("128","52","2");
INSERT INTO `estado_region` VALUES ("129","52","3");
INSERT INTO `estado_region` VALUES ("130","52","26");
INSERT INTO `estado_region` VALUES ("131","52","25");
INSERT INTO `estado_region` VALUES ("132","53","6");
INSERT INTO `estado_region` VALUES ("133","53","7");
INSERT INTO `estado_region` VALUES ("134","53","19");
INSERT INTO `estado_region` VALUES ("135","53","28");
INSERT INTO `estado_region` VALUES ("136","53","10");
INSERT INTO `estado_region` VALUES ("137","53","25");
INSERT INTO `estado_region` VALUES ("138","54","15");
INSERT INTO `estado_region` VALUES ("139","54","10");
INSERT INTO `estado_region` VALUES ("140","54","11");
INSERT INTO `estado_region` VALUES ("141","54","14");
INSERT INTO `estado_region` VALUES ("142","54","16");
INSERT INTO `estado_region` VALUES ("143","54","18");
INSERT INTO `estado_region` VALUES ("144","54","22");
INSERT INTO `estado_region` VALUES ("145","54","25");
INSERT INTO `estado_region` VALUES ("146","54","32");
INSERT INTO `estado_region` VALUES ("148","56","12");
INSERT INTO `estado_region` VALUES ("149","56","5");
INSERT INTO `estado_region` VALUES ("150","56","4");
INSERT INTO `estado_region` VALUES ("151","56","23");
INSERT INTO `estado_region` VALUES ("152","56","31");
INSERT INTO `estado_region` VALUES ("153","56","3");
INSERT INTO `estado_region` VALUES ("154","56","20");
INSERT INTO `estado_region` VALUES ("155","56","9");
INSERT INTO `estado_region` VALUES ("156","56","18");
INSERT INTO `estado_region` VALUES ("157","56","14");
INSERT INTO `estado_region` VALUES ("174","57","15");

-- Estructura de la tabla `estados`
CREATE TABLE `estados` (
  `Id_Estado` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_estado` varchar(100) NOT NULL,
  PRIMARY KEY (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `estados` VALUES ("1","Aguascalientes");
INSERT INTO `estados` VALUES ("2","Baja California");
INSERT INTO `estados` VALUES ("3","Baja California Sur");
INSERT INTO `estados` VALUES ("4","Campeche");
INSERT INTO `estados` VALUES ("5","Chiapas");
INSERT INTO `estados` VALUES ("6","Chihuahua");
INSERT INTO `estados` VALUES ("7","Coahuila");
INSERT INTO `estados` VALUES ("8","Colima");
INSERT INTO `estados` VALUES ("9","Ciudad de México (CDMX)");
INSERT INTO `estados` VALUES ("10","Durango");
INSERT INTO `estados` VALUES ("11","Guanajuato");
INSERT INTO `estados` VALUES ("12","Guerrero");
INSERT INTO `estados` VALUES ("13","Hidalgo");
INSERT INTO `estados` VALUES ("14","Jalisco");
INSERT INTO `estados` VALUES ("15","México (Estado de México)");
INSERT INTO `estados` VALUES ("16","Michoacán");
INSERT INTO `estados` VALUES ("17","Morelos");
INSERT INTO `estados` VALUES ("18","Nayarit");
INSERT INTO `estados` VALUES ("19","Nuevo León");
INSERT INTO `estados` VALUES ("20","Oaxaca");
INSERT INTO `estados` VALUES ("21","Puebla");
INSERT INTO `estados` VALUES ("22","Querétaro");
INSERT INTO `estados` VALUES ("23","Quintana Roo");
INSERT INTO `estados` VALUES ("24","San Luis Potosí");
INSERT INTO `estados` VALUES ("25","Sinaloa");
INSERT INTO `estados` VALUES ("26","Sonora");
INSERT INTO `estados` VALUES ("27","Tabasco");
INSERT INTO `estados` VALUES ("28","Tamaulipas");
INSERT INTO `estados` VALUES ("29","Tlaxcala");
INSERT INTO `estados` VALUES ("30","Veracruz");
INSERT INTO `estados` VALUES ("31","Yucatán");
INSERT INTO `estados` VALUES ("32","Zacatecas");

-- Estructura de la tabla `inventario`
CREATE TABLE `inventario` (
  `IdInv` int(11) NOT NULL AUTO_INCREMENT,
  `IdCPro` int(11) DEFAULT NULL,
  `IdCTal` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT 0,
  PRIMARY KEY (`IdInv`),
  KEY `IdCPro` (`IdCPro`),
  KEY `IdCTal` (`IdCTal`),
  CONSTRAINT `Inventario_ibfk_1` FOREIGN KEY (`IdCPro`) REFERENCES `producto` (`IdCProducto`),
  CONSTRAINT `Inventario_ibfk_2` FOREIGN KEY (`IdCTal`) REFERENCES `ctallas` (`IdCTallas`)
) ENGINE=InnoDB AUTO_INCREMENT=298 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `inventario` VALUES ("1","1","7","0");
INSERT INTO `inventario` VALUES ("2","1","9","0");
INSERT INTO `inventario` VALUES ("3","1","11","0");
INSERT INTO `inventario` VALUES ("4","1","13","1");
INSERT INTO `inventario` VALUES ("5","1","14","0");
INSERT INTO `inventario` VALUES ("6","1","15","0");
INSERT INTO `inventario` VALUES ("7","1","16","0");
INSERT INTO `inventario` VALUES ("8","1","17","194");
INSERT INTO `inventario` VALUES ("9","1","18","953");
INSERT INTO `inventario` VALUES ("10","1","19","68");
INSERT INTO `inventario` VALUES ("11","1","20","185");
INSERT INTO `inventario` VALUES ("12","1","21","9");
INSERT INTO `inventario` VALUES ("13","1","22","0");
INSERT INTO `inventario` VALUES ("14","1","23","0");
INSERT INTO `inventario` VALUES ("15","1","24","0");
INSERT INTO `inventario` VALUES ("16","2","7","0");
INSERT INTO `inventario` VALUES ("17","2","9","0");
INSERT INTO `inventario` VALUES ("18","2","11","86");
INSERT INTO `inventario` VALUES ("19","2","13","5");
INSERT INTO `inventario` VALUES ("20","2","14","0");
INSERT INTO `inventario` VALUES ("21","2","15","12");
INSERT INTO `inventario` VALUES ("22","2","16","0");
INSERT INTO `inventario` VALUES ("23","2","17","12");
INSERT INTO `inventario` VALUES ("24","2","18","53");
INSERT INTO `inventario` VALUES ("25","2","19","3");
INSERT INTO `inventario` VALUES ("26","2","20","57");
INSERT INTO `inventario` VALUES ("27","2","21","82");
INSERT INTO `inventario` VALUES ("28","2","22","41");
INSERT INTO `inventario` VALUES ("29","2","23","0");
INSERT INTO `inventario` VALUES ("30","2","24","0");
INSERT INTO `inventario` VALUES ("31","3","7","0");
INSERT INTO `inventario` VALUES ("32","3","9","0");
INSERT INTO `inventario` VALUES ("33","3","11","523");
INSERT INTO `inventario` VALUES ("34","3","13","741");
INSERT INTO `inventario` VALUES ("35","3","14","716");
INSERT INTO `inventario` VALUES ("36","3","15","831");
INSERT INTO `inventario` VALUES ("37","3","16","1143");
INSERT INTO `inventario` VALUES ("38","3","17","1045");
INSERT INTO `inventario` VALUES ("39","3","18","1225");
INSERT INTO `inventario` VALUES ("40","3","19","1105");
INSERT INTO `inventario` VALUES ("41","3","20","171");
INSERT INTO `inventario` VALUES ("42","3","21","0");
INSERT INTO `inventario` VALUES ("43","3","22","93");
INSERT INTO `inventario` VALUES ("44","3","23","0");
INSERT INTO `inventario` VALUES ("45","3","24","0");
INSERT INTO `inventario` VALUES ("46","4","7","1368");
INSERT INTO `inventario` VALUES ("47","4","9","1073");
INSERT INTO `inventario` VALUES ("48","4","11","1013");
INSERT INTO `inventario` VALUES ("49","4","13","917");
INSERT INTO `inventario` VALUES ("50","4","14","619");
INSERT INTO `inventario` VALUES ("51","4","15","435");
INSERT INTO `inventario` VALUES ("52","4","16","365");
INSERT INTO `inventario` VALUES ("53","4","17","202");
INSERT INTO `inventario` VALUES ("54","4","18","155");
INSERT INTO `inventario` VALUES ("55","4","19","89");
INSERT INTO `inventario` VALUES ("56","4","20","133");
INSERT INTO `inventario` VALUES ("57","4","21","94");
INSERT INTO `inventario` VALUES ("58","4","22","114");
INSERT INTO `inventario` VALUES ("59","4","23","101");
INSERT INTO `inventario` VALUES ("60","4","24","0");
INSERT INTO `inventario` VALUES ("61","5","7","93");
INSERT INTO `inventario` VALUES ("62","5","9","84");
INSERT INTO `inventario` VALUES ("63","5","11","95");
INSERT INTO `inventario` VALUES ("64","5","13","0");
INSERT INTO `inventario` VALUES ("65","5","14","0");
INSERT INTO `inventario` VALUES ("66","5","15","0");
INSERT INTO `inventario` VALUES ("67","5","16","1");
INSERT INTO `inventario` VALUES ("68","5","17","33");
INSERT INTO `inventario` VALUES ("69","5","18","0");
INSERT INTO `inventario` VALUES ("70","5","19","0");
INSERT INTO `inventario` VALUES ("71","5","20","0");
INSERT INTO `inventario` VALUES ("72","5","21","0");
INSERT INTO `inventario` VALUES ("73","5","22","0");
INSERT INTO `inventario` VALUES ("74","5","23","0");
INSERT INTO `inventario` VALUES ("75","5","24","0");
INSERT INTO `inventario` VALUES ("76","6","26","292");
INSERT INTO `inventario` VALUES ("77","6","27","155");
INSERT INTO `inventario` VALUES ("78","6","28","89");
INSERT INTO `inventario` VALUES ("79","6","29","78");
INSERT INTO `inventario` VALUES ("80","6","30","21");
INSERT INTO `inventario` VALUES ("81","6","31","126");
INSERT INTO `inventario` VALUES ("82","7","26","102");
INSERT INTO `inventario` VALUES ("83","7","27","109");
INSERT INTO `inventario` VALUES ("84","7","28","66");
INSERT INTO `inventario` VALUES ("85","7","29","36");
INSERT INTO `inventario` VALUES ("86","7","30","0");
INSERT INTO `inventario` VALUES ("87","7","31","0");
INSERT INTO `inventario` VALUES ("88","8","26","17");
INSERT INTO `inventario` VALUES ("89","8","27","0");
INSERT INTO `inventario` VALUES ("90","8","28","0");
INSERT INTO `inventario` VALUES ("91","8","29","0");
INSERT INTO `inventario` VALUES ("92","8","30","0");
INSERT INTO `inventario` VALUES ("93","8","31","1");
INSERT INTO `inventario` VALUES ("94","9","26","802");
INSERT INTO `inventario` VALUES ("95","9","27","585");
INSERT INTO `inventario` VALUES ("96","9","28","1555");
INSERT INTO `inventario` VALUES ("97","9","29","770");
INSERT INTO `inventario` VALUES ("98","9","30","0");
INSERT INTO `inventario` VALUES ("99","9","31","0");
INSERT INTO `inventario` VALUES ("100","10","1","162");
INSERT INTO `inventario` VALUES ("101","10","2","242");
INSERT INTO `inventario` VALUES ("102","10","3","542");
INSERT INTO `inventario` VALUES ("103","10","4","492");
INSERT INTO `inventario` VALUES ("104","10","5","428");
INSERT INTO `inventario` VALUES ("105","10","6","395");
INSERT INTO `inventario` VALUES ("106","10","7","400");
INSERT INTO `inventario` VALUES ("107","10","8","469");
INSERT INTO `inventario` VALUES ("108","10","9","167");
INSERT INTO `inventario` VALUES ("109","10","10","82");
INSERT INTO `inventario` VALUES ("110","10","11","59");
INSERT INTO `inventario` VALUES ("111","10","12","0");
INSERT INTO `inventario` VALUES ("112","11","1","0");
INSERT INTO `inventario` VALUES ("113","11","2","0");
INSERT INTO `inventario` VALUES ("114","11","3","0");
INSERT INTO `inventario` VALUES ("115","11","4","0");
INSERT INTO `inventario` VALUES ("116","11","5","0");
INSERT INTO `inventario` VALUES ("117","11","6","0");
INSERT INTO `inventario` VALUES ("118","11","7","0");
INSERT INTO `inventario` VALUES ("119","11","8","0");
INSERT INTO `inventario` VALUES ("120","11","9","0");
INSERT INTO `inventario` VALUES ("121","11","10","0");
INSERT INTO `inventario` VALUES ("122","11","11","0");
INSERT INTO `inventario` VALUES ("123","11","12","0");
INSERT INTO `inventario` VALUES ("124","12","1","13");
INSERT INTO `inventario` VALUES ("125","12","2","15");
INSERT INTO `inventario` VALUES ("126","12","3","26");
INSERT INTO `inventario` VALUES ("127","12","4","0");
INSERT INTO `inventario` VALUES ("128","12","5","55");
INSERT INTO `inventario` VALUES ("129","12","6","129");
INSERT INTO `inventario` VALUES ("130","12","7","57");
INSERT INTO `inventario` VALUES ("131","12","8","22");
INSERT INTO `inventario` VALUES ("132","12","9","18");
INSERT INTO `inventario` VALUES ("133","12","10","0");
INSERT INTO `inventario` VALUES ("134","12","11","0");
INSERT INTO `inventario` VALUES ("135","12","12","3");
INSERT INTO `inventario` VALUES ("136","13","26","4");
INSERT INTO `inventario` VALUES ("137","13","27","0");
INSERT INTO `inventario` VALUES ("138","13","28","0");
INSERT INTO `inventario` VALUES ("139","13","29","0");
INSERT INTO `inventario` VALUES ("140","13","30","0");
INSERT INTO `inventario` VALUES ("141","13","31","0");
INSERT INTO `inventario` VALUES ("142","14","26","0");
INSERT INTO `inventario` VALUES ("143","14","27","104");
INSERT INTO `inventario` VALUES ("144","14","28","657");
INSERT INTO `inventario` VALUES ("145","14","29","393");
INSERT INTO `inventario` VALUES ("146","14","30","140");
INSERT INTO `inventario` VALUES ("147","14","31","0");
INSERT INTO `inventario` VALUES ("148","15","32","134");
INSERT INTO `inventario` VALUES ("149","16","32","0");
INSERT INTO `inventario` VALUES ("150","17","32","12");
INSERT INTO `inventario` VALUES ("151","18","32","1");
INSERT INTO `inventario` VALUES ("152","19","26","69");
INSERT INTO `inventario` VALUES ("153","19","27","150");
INSERT INTO `inventario` VALUES ("154","19","28","150");
INSERT INTO `inventario` VALUES ("155","19","29","69");
INSERT INTO `inventario` VALUES ("156","19","30","0");
INSERT INTO `inventario` VALUES ("157","19","31","0");
INSERT INTO `inventario` VALUES ("158","20","32","0");
INSERT INTO `inventario` VALUES ("159","21","32","86");
INSERT INTO `inventario` VALUES ("160","22","32","713");
INSERT INTO `inventario` VALUES ("161","23","28","53");
INSERT INTO `inventario` VALUES ("162","24","32","0");
INSERT INTO `inventario` VALUES ("163","25","32","0");
INSERT INTO `inventario` VALUES ("164","26","32","81");
INSERT INTO `inventario` VALUES ("165","27","32","8");
INSERT INTO `inventario` VALUES ("166","28","32","0");
INSERT INTO `inventario` VALUES ("167","29","32","17");
INSERT INTO `inventario` VALUES ("168","30","32","0");
INSERT INTO `inventario` VALUES ("169","31","32","105");
INSERT INTO `inventario` VALUES ("170","32","32","0");
INSERT INTO `inventario` VALUES ("171","33","32","67");
INSERT INTO `inventario` VALUES ("172","34","32","1201");
INSERT INTO `inventario` VALUES ("173","35","32","0");
INSERT INTO `inventario` VALUES ("174","36","32","106");
INSERT INTO `inventario` VALUES ("175","37","32","672");
INSERT INTO `inventario` VALUES ("176","38","32","288");
INSERT INTO `inventario` VALUES ("177","39","32","8");
INSERT INTO `inventario` VALUES ("178","40","32","69");
INSERT INTO `inventario` VALUES ("179","41","32","87");
INSERT INTO `inventario` VALUES ("180","42","32","86");
INSERT INTO `inventario` VALUES ("181","43","7","140");
INSERT INTO `inventario` VALUES ("182","43","9","4");
INSERT INTO `inventario` VALUES ("183","43","11","0");
INSERT INTO `inventario` VALUES ("184","43","13","0");
INSERT INTO `inventario` VALUES ("185","43","14","0");
INSERT INTO `inventario` VALUES ("186","43","15","45");
INSERT INTO `inventario` VALUES ("187","43","16","5");
INSERT INTO `inventario` VALUES ("188","43","17","0");
INSERT INTO `inventario` VALUES ("189","43","18","0");
INSERT INTO `inventario` VALUES ("190","43","19","0");
INSERT INTO `inventario` VALUES ("191","43","20","0");
INSERT INTO `inventario` VALUES ("192","43","21","0");
INSERT INTO `inventario` VALUES ("193","43","22","0");
INSERT INTO `inventario` VALUES ("194","43","23","0");
INSERT INTO `inventario` VALUES ("195","43","24","0");
INSERT INTO `inventario` VALUES ("196","44","7","91");
INSERT INTO `inventario` VALUES ("197","44","9","70");
INSERT INTO `inventario` VALUES ("198","44","11","56");
INSERT INTO `inventario` VALUES ("199","44","13","25");
INSERT INTO `inventario` VALUES ("200","44","14","54");
INSERT INTO `inventario` VALUES ("201","44","15","81");
INSERT INTO `inventario` VALUES ("202","44","16","40");
INSERT INTO `inventario` VALUES ("203","44","17","15");
INSERT INTO `inventario` VALUES ("204","44","18","0");
INSERT INTO `inventario` VALUES ("205","44","19","0");
INSERT INTO `inventario` VALUES ("206","44","20","0");
INSERT INTO `inventario` VALUES ("207","44","21","0");
INSERT INTO `inventario` VALUES ("208","44","22","0");
INSERT INTO `inventario` VALUES ("209","44","23","0");
INSERT INTO `inventario` VALUES ("210","44","24","0");
INSERT INTO `inventario` VALUES ("211","45","26","17");
INSERT INTO `inventario` VALUES ("212","45","27","0");
INSERT INTO `inventario` VALUES ("213","45","28","0");
INSERT INTO `inventario` VALUES ("214","45","29","64");
INSERT INTO `inventario` VALUES ("215","45","30","101");
INSERT INTO `inventario` VALUES ("216","45","31","0");
INSERT INTO `inventario` VALUES ("217","46","7","0");
INSERT INTO `inventario` VALUES ("218","46","9","0");
INSERT INTO `inventario` VALUES ("219","46","11","0");
INSERT INTO `inventario` VALUES ("220","46","13","0");
INSERT INTO `inventario` VALUES ("221","46","14","0");
INSERT INTO `inventario` VALUES ("222","46","15","0");
INSERT INTO `inventario` VALUES ("223","46","16","0");
INSERT INTO `inventario` VALUES ("224","46","17","0");
INSERT INTO `inventario` VALUES ("225","46","18","0");
INSERT INTO `inventario` VALUES ("226","46","19","0");
INSERT INTO `inventario` VALUES ("227","46","20","0");
INSERT INTO `inventario` VALUES ("228","46","21","0");
INSERT INTO `inventario` VALUES ("229","46","22","0");
INSERT INTO `inventario` VALUES ("230","46","23","0");
INSERT INTO `inventario` VALUES ("231","46","24","0");
INSERT INTO `inventario` VALUES ("232","47","26","0");
INSERT INTO `inventario` VALUES ("233","47","27","0");
INSERT INTO `inventario` VALUES ("234","47","28","0");
INSERT INTO `inventario` VALUES ("235","47","29","84");
INSERT INTO `inventario` VALUES ("236","47","30","91");
INSERT INTO `inventario` VALUES ("237","47","31","0");
INSERT INTO `inventario` VALUES ("238","48","32","55");
INSERT INTO `inventario` VALUES ("239","49","32","405");
INSERT INTO `inventario` VALUES ("240","50","32","8");
INSERT INTO `inventario` VALUES ("241","51","32","10");
INSERT INTO `inventario` VALUES ("242","52","32","10");
INSERT INTO `inventario` VALUES ("243","53","32","2000");
INSERT INTO `inventario` VALUES ("244","54","7","346");
INSERT INTO `inventario` VALUES ("245","54","9","296");
INSERT INTO `inventario` VALUES ("246","54","11","277");
INSERT INTO `inventario` VALUES ("247","54","13","293");
INSERT INTO `inventario` VALUES ("248","54","14","313");
INSERT INTO `inventario` VALUES ("249","54","15","175");
INSERT INTO `inventario` VALUES ("250","54","16","0");
INSERT INTO `inventario` VALUES ("251","54","17","0");
INSERT INTO `inventario` VALUES ("252","54","18","0");
INSERT INTO `inventario` VALUES ("253","54","19","42");
INSERT INTO `inventario` VALUES ("254","54","20","10");
INSERT INTO `inventario` VALUES ("255","54","21","0");
INSERT INTO `inventario` VALUES ("256","54","22","0");
INSERT INTO `inventario` VALUES ("257","54","23","0");
INSERT INTO `inventario` VALUES ("258","54","24","0");
INSERT INTO `inventario` VALUES ("259","55","26","395");
INSERT INTO `inventario` VALUES ("260","55","27","251");
INSERT INTO `inventario` VALUES ("261","55","28","141");
INSERT INTO `inventario` VALUES ("262","55","29","162");
INSERT INTO `inventario` VALUES ("263","55","30","0");
INSERT INTO `inventario` VALUES ("264","55","31","0");
INSERT INTO `inventario` VALUES ("265","56","32","0");
INSERT INTO `inventario` VALUES ("266","57","7","0");
INSERT INTO `inventario` VALUES ("267","57","9","0");
INSERT INTO `inventario` VALUES ("268","57","11","0");
INSERT INTO `inventario` VALUES ("269","57","13","0");
INSERT INTO `inventario` VALUES ("270","57","14","502");
INSERT INTO `inventario` VALUES ("271","57","15","300");
INSERT INTO `inventario` VALUES ("272","57","16","436");
INSERT INTO `inventario` VALUES ("273","57","17","243");
INSERT INTO `inventario` VALUES ("274","57","18","163");
INSERT INTO `inventario` VALUES ("275","57","19","42");
INSERT INTO `inventario` VALUES ("276","57","20","56");
INSERT INTO `inventario` VALUES ("277","57","21","0");
INSERT INTO `inventario` VALUES ("278","57","22","0");
INSERT INTO `inventario` VALUES ("279","57","23","0");
INSERT INTO `inventario` VALUES ("280","57","24","0");
INSERT INTO `inventario` VALUES ("281","58","26","0");
INSERT INTO `inventario` VALUES ("282","58","27","5");
INSERT INTO `inventario` VALUES ("283","58","28","0");
INSERT INTO `inventario` VALUES ("284","58","29","0");
INSERT INTO `inventario` VALUES ("285","58","30","0");
INSERT INTO `inventario` VALUES ("286","58","31","0");
INSERT INTO `inventario` VALUES ("287","59","26","0");
INSERT INTO `inventario` VALUES ("288","59","27","0");
INSERT INTO `inventario` VALUES ("289","59","28","0");
INSERT INTO `inventario` VALUES ("290","59","29","0");
INSERT INTO `inventario` VALUES ("291","59","30","0");
INSERT INTO `inventario` VALUES ("292","59","31","0");
INSERT INTO `inventario` VALUES ("293","60","32","0");
INSERT INTO `inventario` VALUES ("294","64","13","42");
INSERT INTO `inventario` VALUES ("295","64","14","115");
INSERT INTO `inventario` VALUES ("296","64","15","97");
INSERT INTO `inventario` VALUES ("297","64","16","24");

-- Estructura de la tabla `producto`
CREATE TABLE `producto` (
  `IdCProducto` int(11) NOT NULL AUTO_INCREMENT,
  `IdCEmp` int(11) DEFAULT NULL,
  `IdCCat` int(11) DEFAULT NULL,
  `IdCTipTal` int(11) DEFAULT NULL,
  `Descripcion` text NOT NULL,
  `Especificacion` text NOT NULL,
  `IMG` varchar(250) NOT NULL,
  `Fecha_Registro` datetime NOT NULL,
  PRIMARY KEY (`IdCProducto`),
  KEY `IdCEmp` (`IdCEmp`),
  KEY `IdCCat` (`IdCCat`),
  KEY `IdCTipTal` (`IdCTipTal`),
  CONSTRAINT `Producto_ibfk_1` FOREIGN KEY (`IdCEmp`) REFERENCES `cempresas` (`IdCEmpresa`),
  CONSTRAINT `Producto_ibfk_2` FOREIGN KEY (`IdCCat`) REFERENCES `ccategorias` (`IdCCate`),
  CONSTRAINT `Producto_ibfk_3` FOREIGN KEY (`IdCTipTal`) REFERENCES `ctipotallas` (`IdCTipTall`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `producto` VALUES ("1","1","1","1","Camisa","Azul, manga corta, PRYSE","../../../img/Productos/product_6661ff4cc36d3.png","2024-06-06 12:26:20");
INSERT INTO `producto` VALUES ("2","1","1","1","Camisa","Blanca, manga larga, bolsas, PRYSE","../../../img/Productos/product_666200e314683.png","2024-06-06 12:33:07");
INSERT INTO `producto` VALUES ("3","1","1","1","Camisa","Blanca, manga corta, PRYSE","../../../img/Productos/product_666201c5f1991.png","2024-06-06 12:36:53");
INSERT INTO `producto` VALUES ("4","1","1","1","Pantalón","Azul marino, comando","../../../img/Productos/product_66620216223f3.png","2024-06-06 12:38:14");
INSERT INTO `producto` VALUES ("5","2","1","1","Pantalón","Azul marino","../../../img/Productos/product_6662025622949.png","2024-06-06 12:39:18");
INSERT INTO `producto` VALUES ("6","1","1","2","Bata","Azul marino, PRYSE","../../../img/Productos/product_666202f922f6c.png","2024-06-06 12:42:01");
INSERT INTO `producto` VALUES ("7","6","1","2","Bata","Azul marino, PROTE","../../../img/Productos/product_666203ffbbc84.png","2024-06-06 12:46:23");
INSERT INTO `producto` VALUES ("8","1","1","2","Chamarra","Azul Marino","../../../img/Productos/product_666204a901995.png","2024-06-06 12:49:13");
INSERT INTO `producto` VALUES ("9","1","1","2","Chamarra","Azul Marino, Cazadora","../../../img/Productos/product_6662055753ba7.png","2024-06-06 12:52:07");
INSERT INTO `producto` VALUES ("10","1","1","1","Botas","Tacticas","../../../img/Productos/product_66620845cd799.png","2024-06-06 13:04:37");
INSERT INTO `producto` VALUES ("11","1","1","1","Botas","Hule","../../../img/Productos/product_6662089919114.png","2024-06-06 13:06:01");
INSERT INTO `producto` VALUES ("12","1","1","1","Botas","Poli Amida","../../../img/Productos/product_666208eadab06.png","2024-06-06 13:07:22");
INSERT INTO `producto` VALUES ("13","1","1","2","Playera","Blanca, Polo","../../../img/Productos/product_6662099306bb1.png","2024-06-06 13:10:11");
INSERT INTO `producto` VALUES ("14","1","1","2","Chaleco","Táctico","../../../img/Productos/product_66620a03b982e.png","2024-06-06 14:17:23");
INSERT INTO `producto` VALUES ("15","1","1","3","Chaleco","Táctico, unitalla","../../../img/Productos/product_666219bdacb43.png","2024-06-06 14:19:09");
INSERT INTO `producto` VALUES ("16","1","1","3","Chaleco","Verde, reflejante","../../../img/Productos/product_66621a0c24dcc.png","2024-06-06 14:20:28");
INSERT INTO `producto` VALUES ("17","1","1","3","Chaleco","Rojo, reflejante","../../../img/Productos/product_66621a5c222e4.png","2024-06-06 14:21:48");
INSERT INTO `producto` VALUES ("18","1","1","3","Chaleco","Naranja, reflejante","../../../img/Productos/product_66621abe6d904.png","2024-06-06 14:23:26");
INSERT INTO `producto` VALUES ("19","1","1","2","Chaleco","Azul marino, PRYSE","../../../img/Productos/product_66621b440fedb.png","2024-06-06 14:25:40");
INSERT INTO `producto` VALUES ("20","1","1","3","Gorra","PRYSE","../../../img/Productos/product_66621b83c9e6e.png","2024-06-06 14:26:43");
INSERT INTO `producto` VALUES ("21","1","2","3","Gas Pimienta","Ninguna.","../../../img/Productos/product_66621bc981126.png","2024-06-06 14:27:53");
INSERT INTO `producto` VALUES ("22","1","2","3","Fornitura","Unitalla","../../../img/Productos/product_66621c37ea1cd.png","2024-06-06 14:29:43");
INSERT INTO `producto` VALUES ("23","1","2","2","Fornitura","Alfabética","../../../img/Productos/product_66621c69e99ba.png","2024-06-06 14:30:33");
INSERT INTO `producto` VALUES ("24","1","2","3","TOLETE","Ninguna.","../../../img/Productos/product_66621cd072d0b.png","2024-06-06 14:32:16");
INSERT INTO `producto` VALUES ("25","1","3","3","Liston","Azulmarino","../../../img/Productos/product_66621d09c459a.png","2024-06-06 14:33:13");
INSERT INTO `producto` VALUES ("26","1","3","3","Liston","Rojo","../../../img/Productos/product_66621d46e629b.png","2024-06-06 14:34:14");
INSERT INTO `producto` VALUES ("27","1","3","3","Silbato","Ninguna.","../../../img/Productos/product_66621d92923cf.png","2024-06-06 14:35:30");
INSERT INTO `producto` VALUES ("28","1","1","3","Corbata","Azul marino","../../../img/Productos/product_66621dc9e9a42.png","2024-06-06 14:36:25");
INSERT INTO `producto` VALUES ("29","1","1","3","Impermeable","Azul marino, PRYSE","../../../img/Productos/product_66621e05038df.png","2024-06-06 14:37:25");
INSERT INTO `producto` VALUES ("30","1","3","3","Broche Fornitura","Ninguna.","../../../img/Productos/product_66621e486c1d2.png","2024-06-06 14:38:32");
INSERT INTO `producto` VALUES ("31","1","2","3","Lampara","Chica","../../../img/Productos/product_66621e9cad865.png","2024-06-06 14:39:56");
INSERT INTO `producto` VALUES ("32","1","2","3","Lampara","Grande","../../../img/Productos/product_66621edbee15f.png","2024-06-06 14:40:59");
INSERT INTO `producto` VALUES ("33","1","3","3","Libro Florete","Ninguna.","../../../img/Productos/product_6662215bbde4d.png","2024-06-06 14:51:39");
INSERT INTO `producto` VALUES ("34","1","3","3","Cubreboca","Azul marino","../../../img/Productos/product_666221a745b36.png","2024-06-06 14:52:55");
INSERT INTO `producto` VALUES ("35","1","3","3","Careta de Mica","Ninguna.","../../../img/Productos/product_666221fea16f8.png","2024-06-06 14:54:22");
INSERT INTO `producto` VALUES ("36","1","2","3","Radio","Steren RAD 510","../../../img/Productos/product_6662226e8b0ef.png","2024-06-06 14:56:58");
INSERT INTO `producto` VALUES ("37","1","2","3","Radio","Steren RAD 010","../../../img/Productos/product_666222fd43f86.png","2024-06-06 14:58:37");
INSERT INTO `producto` VALUES ("38","1","1","3","Overol COVID","Ninguna.","../../../img/Productos/product_6662234547194.png","2024-06-06 14:59:49");
INSERT INTO `producto` VALUES ("39","1","2","3","Garret","Ninguna.","../../../img/Productos/product_666223ae6aa4a.png","2024-06-06 15:01:34");
INSERT INTO `producto` VALUES ("40","1","3","3","BLOCK","Novedades, PROTE & PRYSE","../../../img/Productos/product_666223f96c022.png","2024-06-06 15:02:49");
INSERT INTO `producto` VALUES ("41","1","3","3","BLOCK","Asistencia Diaria, PROTE & PRYSE","../../../img/Productos/product_66622448b85c4.png","2024-06-06 15:04:08");
INSERT INTO `producto` VALUES ("42","1","3","3","BLOCK","Cuadricula, PROTE & PRYSE","../../../img/Productos/product_666224ad17471.png","2024-06-06 15:05:49");
INSERT INTO `producto` VALUES ("43","7","1","1","Overol","Negro, VALVON","../../../img/Productos/product_666224fdc8cf9.png","2024-06-06 15:07:09");
INSERT INTO `producto` VALUES ("44","7","1","1","Pantalón","Negro","../../../img/Productos/product_6662268b9fca3.png","2024-06-06 15:13:47");
INSERT INTO `producto` VALUES ("45","7","1","2","Playera","Negro, polo, VALBON","../../../img/Productos/product_666226ca59198.png","2024-06-06 15:14:50");
INSERT INTO `producto` VALUES ("46","7","1","1","Chamarra","Negro, Talla numérica, VALBON","../../../img/Productos/product_6662274c32e70.png","2024-06-06 15:17:00");
INSERT INTO `producto` VALUES ("47","7","1","2","Chamarra","Negro, Talla alfabética, VALBON","../../../img/Productos/product_66622783c6a06.png","2024-06-06 15:17:55");
INSERT INTO `producto` VALUES ("48","7","1","3","Gorra","Negro, VALVON","../../../img/Productos/product_666227decc2e6.png","2024-06-06 15:19:26");
INSERT INTO `producto` VALUES ("49","7","1","3","Cubreboca","Negro","../../../img/Productos/product_666228599024c.png","2024-06-06 15:21:29");
INSERT INTO `producto` VALUES ("50","7","3","3","BLOCK","Novedades, VALVON","../../../img/Productos/product_6662289fbfc2b.png","2024-06-06 15:22:39");
INSERT INTO `producto` VALUES ("51","7","3","3","BLOCK","Asistencia Diaria, VALVON","../../../img/Productos/product_66622907f2f3a.png","2024-06-06 15:24:23");
INSERT INTO `producto` VALUES ("52","7","3","3","BLOCK","Cuadricula, VALVON","../../../img/Productos/product_666229b00af4d.png","2024-06-06 15:27:12");
INSERT INTO `producto` VALUES ("53","1","3","3","Hoja","Membretada, PRYSE","../../../img/Productos/product_666229f167dbf.png","2024-06-06 15:28:17");
INSERT INTO `producto` VALUES ("54","5","1","1","Pantalón","Azul marino, vestir","../../../img/Productos/product_66622a45adafa.png","2024-06-06 15:29:41");
INSERT INTO `producto` VALUES ("55","5","1","2","Chaleco","Verde, reflejante, PRYSE","../../../img/Productos/product_66622ad2c583e.png","2024-06-06 15:32:02");
INSERT INTO `producto` VALUES ("56","1","3","3","Fajilla","Negro","../../../img/Productos/product_66622b0117349.png","2024-06-06 15:32:49");
INSERT INTO `producto` VALUES ("57","5","1","1","Camisa","Blanca, manga larga, PRYSE","../../../img/Productos/product_66622b2ef2e7f.png","2024-06-06 15:33:34");
INSERT INTO `producto` VALUES ("58","5","1","2","Chaleco","Verde, reflejante, AICM T2, PRYSE","../../../img/Productos/product_66622b4eccf59.png","2024-06-06 15:34:06");
INSERT INTO `producto` VALUES ("59","5","1","2","Sueter","Azul marino, PRYSE","../../../img/Productos/product_66622b732e936.png","2024-06-06 15:34:43");
INSERT INTO `producto` VALUES ("60","1","2","3","Porta Radio","Negro, fornitura","../../../img/Productos/product_66622ba4ce29b.png","2024-06-06 15:35:32");
INSERT INTO `producto` VALUES ("64","8","1","1","CAMISA BLANCA MANGA CORTA ","Nuevo logo de multisistemas Uribe","../../../img/Productos/product_674f59cb6839e.jpeg","2024-12-03 13:19:39");

-- Estructura de la tabla `regiones`
CREATE TABLE `regiones` (
  `ID_Region` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Region` varchar(250) NOT NULL,
  `Fch_Registro` datetime NOT NULL,
  PRIMARY KEY (`ID_Region`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `regiones` VALUES ("1","Centro Sur","2024-07-04 14:15:00");
INSERT INTO `regiones` VALUES ("2","Oficinas Divisionales","2024-08-06 13:40:48");
INSERT INTO `regiones` VALUES ("4","Zona Acapulco","2024-08-06 16:13:32");
INSERT INTO `regiones` VALUES ("5","Zona Altamirano","2024-08-06 16:14:12");
INSERT INTO `regiones` VALUES ("6","Zona Atlacomulco","2024-08-06 16:14:44");
INSERT INTO `regiones` VALUES ("7","Zona Campeche","2024-08-06 16:15:08");
INSERT INTO `regiones` VALUES ("8","Zona Carmen","2024-08-06 16:15:25");
INSERT INTO `regiones` VALUES ("9","Zona Chilpancingo","2024-08-06 16:15:45");
INSERT INTO `regiones` VALUES ("10","Zona Chontalpa","2024-08-06 16:16:01");
INSERT INTO `regiones` VALUES ("11","Zona Coatzacoalcos","2024-08-06 16:16:27");
INSERT INTO `regiones` VALUES ("12","Zona Colima","2024-08-06 16:16:42");
INSERT INTO `regiones` VALUES ("13","Zona Constitución","2024-08-06 16:16:56");
INSERT INTO `regiones` VALUES ("14","Zona Córdoba","2024-08-06 16:17:18");
INSERT INTO `regiones` VALUES ("15","Zona Cuautla","2024-08-06 16:17:36");
INSERT INTO `regiones` VALUES ("16","Zona Cuernavaca","2024-08-06 16:17:55");
INSERT INTO `regiones` VALUES ("17","Zona Ensenada","2024-08-06 16:18:12");
INSERT INTO `regiones` VALUES ("18","Zona Iguala","2024-08-06 16:18:24");
INSERT INTO `regiones` VALUES ("19","Zona Jiquilpan","2024-08-06 16:18:38");
INSERT INTO `regiones` VALUES ("20","Zona Los Cabos","2024-08-06 16:18:50");
INSERT INTO `regiones` VALUES ("21","Zona los Ríos","2024-08-06 16:19:16");
INSERT INTO `regiones` VALUES ("22","Zona Los Tuxtlas","2024-08-06 16:19:29");
INSERT INTO `regiones` VALUES ("23","Zona Mérida","2024-08-06 16:19:40");
INSERT INTO `regiones` VALUES ("24","Zona Morelos","2024-08-06 16:19:52");
INSERT INTO `regiones` VALUES ("25","Zona Motul","2024-08-06 16:20:08");
INSERT INTO `regiones` VALUES ("26","Zona Orizaba","2024-08-06 16:20:19");
INSERT INTO `regiones` VALUES ("27","Zona Papaloapan","2024-08-06 16:21:01");
INSERT INTO `regiones` VALUES ("28","Zona Poza Rica","2024-08-06 16:21:34");
INSERT INTO `regiones` VALUES ("29","Zona San Luis","2024-08-06 16:21:56");
INSERT INTO `regiones` VALUES ("30","Zona Teziutlán","2024-08-06 16:22:16");
INSERT INTO `regiones` VALUES ("31","Zona Ticul","2024-08-06 16:22:29");
INSERT INTO `regiones` VALUES ("32","Zona Tizimín","2024-08-06 16:22:47");
INSERT INTO `regiones` VALUES ("33","Zona Valle de Bravo","2024-08-06 16:23:00");
INSERT INTO `regiones` VALUES ("34","Zona Veracruz","2024-08-06 16:23:18");
INSERT INTO `regiones` VALUES ("35","Zona Xalapa","2024-08-06 16:23:29");
INSERT INTO `regiones` VALUES ("36","Zona Zihuatanejo","2024-08-06 16:23:49");
INSERT INTO `regiones` VALUES ("37","Region prueba uno","2024-09-13 14:31:07");
INSERT INTO `regiones` VALUES ("38","Region prueba dos","2024-09-13 14:31:44");
INSERT INTO `regiones` VALUES ("39","Region prueba tres","2024-09-13 14:33:49");
INSERT INTO `regiones` VALUES ("40","Region prueba uno","2024-09-13 14:41:22");
INSERT INTO `regiones` VALUES ("41","1","2024-11-29 12:50:19");
INSERT INTO `regiones` VALUES ("42","2","2024-11-29 12:50:32");
INSERT INTO `regiones` VALUES ("43","3","2024-11-29 12:50:43");
INSERT INTO `regiones` VALUES ("44","4","2024-11-29 12:50:53");
INSERT INTO `regiones` VALUES ("45","Noroeste","2024-11-29 13:40:33");
INSERT INTO `regiones` VALUES ("46","Noreste","2024-12-02 10:31:05");
INSERT INTO `regiones` VALUES ("47","Occidente","2024-12-02 12:28:15");
INSERT INTO `regiones` VALUES ("48","Norte","2024-12-02 12:29:01");
INSERT INTO `regiones` VALUES ("49","4","2024-12-02 12:38:31");
INSERT INTO `regiones` VALUES ("50","5","2024-12-02 12:50:26");
INSERT INTO `regiones` VALUES ("51","IPN","2024-12-02 12:54:32");
INSERT INTO `regiones` VALUES ("52","1","2024-12-02 12:55:40");
INSERT INTO `regiones` VALUES ("53","2","2024-12-02 12:56:28");
INSERT INTO `regiones` VALUES ("54","3","2024-12-02 12:57:38");
INSERT INTO `regiones` VALUES ("56","Varias 1","2024-12-02 13:15:03");
INSERT INTO `regiones` VALUES ("57","Varias 2","2024-12-02 17:37:05");

-- Estructura de la tabla `requisiciond`
CREATE TABLE `requisiciond` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdReqE` int(11) DEFAULT NULL,
  `IdCProd` int(11) DEFAULT NULL,
  `IdTalla` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `IdReqE` (`IdReqE`),
  KEY `IdCProd` (`IdCProd`),
  KEY `IdTalla` (`IdTalla`),
  CONSTRAINT `RequisicionD_ibfk_1` FOREIGN KEY (`IdReqE`) REFERENCES `requisicione` (`IDRequisicionE`),
  CONSTRAINT `RequisicionD_ibfk_2` FOREIGN KEY (`IdCProd`) REFERENCES `producto` (`IdCProducto`),
  CONSTRAINT `RequisicionD_ibfk_3` FOREIGN KEY (`IdTalla`) REFERENCES `ctallas` (`IdCTallas`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `requisiciond` VALUES ("12","8","4","11","6");
INSERT INTO `requisiciond` VALUES ("13","8","4","13","10");
INSERT INTO `requisiciond` VALUES ("14","8","4","14","10");
INSERT INTO `requisiciond` VALUES ("15","8","4","15","10");
INSERT INTO `requisiciond` VALUES ("16","8","4","16","6");
INSERT INTO `requisiciond` VALUES ("17","8","4","17","4");
INSERT INTO `requisiciond` VALUES ("18","8","4","18","4");
INSERT INTO `requisiciond` VALUES ("19","8","4","19","3");
INSERT INTO `requisiciond` VALUES ("20","8","4","21","2");
INSERT INTO `requisiciond` VALUES ("21","8","3","13","8");
INSERT INTO `requisiciond` VALUES ("22","8","3","14","8");
INSERT INTO `requisiciond` VALUES ("23","8","3","15","10");
INSERT INTO `requisiciond` VALUES ("24","8","3","16","10");
INSERT INTO `requisiciond` VALUES ("25","8","3","17","8");
INSERT INTO `requisiciond` VALUES ("26","8","3","18","4");
INSERT INTO `requisiciond` VALUES ("27","8","3","19","4");
INSERT INTO `requisiciond` VALUES ("28","8","3","21","3");
INSERT INTO `requisiciond` VALUES ("29","8","23","28","35");
INSERT INTO `requisiciond` VALUES ("30","8","20","32","55");
INSERT INTO `requisiciond` VALUES ("31","8","30","32","10");
INSERT INTO `requisiciond` VALUES ("32","8","36","32","25");
INSERT INTO `requisiciond` VALUES ("33","8","31","32","10");
INSERT INTO `requisiciond` VALUES ("37","10","8","29","10");
INSERT INTO `requisiciond` VALUES ("38","10","8","30","20");
INSERT INTO `requisiciond` VALUES ("39","10","8","31","5");
INSERT INTO `requisiciond` VALUES ("40","10","3","16","10");
INSERT INTO `requisiciond` VALUES ("41","10","3","17","10");
INSERT INTO `requisiciond` VALUES ("42","11","11","6","2");
INSERT INTO `requisiciond` VALUES ("43","11","29","32","2");
INSERT INTO `requisiciond` VALUES ("44","12","9","29","3");
INSERT INTO `requisiciond` VALUES ("45","12","9","28","3");
INSERT INTO `requisiciond` VALUES ("46","12","4","14","2");
INSERT INTO `requisiciond` VALUES ("47","12","37","32","1");
INSERT INTO `requisiciond` VALUES ("48","12","30","32","5");
INSERT INTO `requisiciond` VALUES ("49","12","10","8","1");
INSERT INTO `requisiciond` VALUES ("50","12","10","6","1");
INSERT INTO `requisiciond` VALUES ("51","13","3","15","1");
INSERT INTO `requisiciond` VALUES ("52","13","3","16","1");
INSERT INTO `requisiciond` VALUES ("53","13","3","18","1");
INSERT INTO `requisiciond` VALUES ("54","13","4","15","2");
INSERT INTO `requisiciond` VALUES ("55","13","4","18","1");
INSERT INTO `requisiciond` VALUES ("56","13","20","32","4");
INSERT INTO `requisiciond` VALUES ("102","32","9","29","1");
INSERT INTO `requisiciond` VALUES ("103","33","1","11","123");

-- Estructura de la tabla `requisicione`
CREATE TABLE `requisicione` (
  `IDRequisicionE` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) DEFAULT NULL,
  `FchCreacion` datetime NOT NULL,
  `FchAutoriza` datetime DEFAULT NULL,
  `Estatus` varchar(100) NOT NULL,
  `Supervisor` varchar(250) NOT NULL,
  `IdCuenta` int(11) DEFAULT NULL,
  `IdRegion` int(11) DEFAULT NULL,
  `CentroTrabajo` varchar(250) DEFAULT NULL,
  `NroElementos` varchar(100) NOT NULL,
  `Receptor` varchar(250) NOT NULL,
  `TelReceptor` varchar(250) NOT NULL,
  `RfcReceptor` varchar(250) NOT NULL,
  `Justificacion` varchar(250) DEFAULT NULL,
  `IdEstado` int(11) DEFAULT NULL,
  `Mpio` varchar(250) DEFAULT NULL,
  `Colonia` varchar(250) DEFAULT NULL,
  `Calle` varchar(250) DEFAULT NULL,
  `Nro` varchar(250) DEFAULT NULL,
  `CP` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`IDRequisicionE`),
  KEY `IdUsuario` (`IdUsuario`),
  KEY `IdCuenta` (`IdCuenta`),
  KEY `IdRegion` (`IdRegion`),
  KEY `IdEstado` (`IdEstado`),
  CONSTRAINT `RequisicionE_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`ID_Usuario`),
  CONSTRAINT `RequisicionE_ibfk_2` FOREIGN KEY (`IdCuenta`) REFERENCES `cuenta` (`ID`),
  CONSTRAINT `RequisicionE_ibfk_3` FOREIGN KEY (`IdRegion`) REFERENCES `regiones` (`ID_Region`),
  CONSTRAINT `RequisicionE_ibfk_4` FOREIGN KEY (`IdEstado`) REFERENCES `estados` (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `requisicione` VALUES ("8","20","2024-11-29 13:05:40","2024-11-29 13:06:23","Parcial","Gustavo Rascon Evans","9","41","Varios","0","Karla Edith Fontes Navarro","6624508810","FOLK860804BJ7","Doteción de uniformes para nuevo contrato","26","Hermosillo","Nueva Galicia","Nueva Esperanza","41","83245");
INSERT INTO `requisicione` VALUES ("10","21","2024-11-29 13:49:53","2024-11-29 13:52:00","Parcial","Edgar Acosta Escariaga","10","45","Varios","0","Edgar Acosta Escariaga","6645205086","AOEE820107JI7","Solicitud por el jefe de conservación y contratos, para no afectar la penalización en la factura.","2","Castores Ocurre Mexicalli","Castores Ocurre Mexicalli","Castores Ocurre Mexicalli","0","21399");
INSERT INTO `requisicione` VALUES ("11","26","2024-12-04 09:41:37","2025-01-09 09:11:10","Parcial","LEONARDO PATIÑO","11","56","FONATUR ARMADOS","0","LEONARDO PATIÑO","5576887600","","PARA AUDITORIA","9","","","","","");
INSERT INTO `requisicione` VALUES ("12","23","2024-12-04 13:46:42","2024-12-04 13:48:32","Parcial","Martha Guadalupe Santiago Barron","7","52","Plaza de Cobro No. 195 \"Aeropuerto los Cabos\"","0","Martha Guadalupe Santiago Barron","5610368651","SABM8009293V6","Reposición de uniformes y equipo por deterioro, las botas se le descuentan a los elementos por vía nomina, ultima dotación 19/08/2024, chamarras 24/10/2023","3","Los Cabos, B.C.S.","Benito Juarez","Prol 12 de Octubre, Mza 118","lote 13-A","23469");
INSERT INTO `requisicione` VALUES ("13","23","2024-12-04 14:29:54","2024-12-04 14:31:25","Parcial","Edgar Ramon Cazares Palacios","7","52","Campamento de Conservación, \"Ensenada\"","0","Edgar Ramon Cazares Palacios","6241380989","CAPE8501096KA","Reposición de uniformes y equipo por deterioro, ultimo envio 29/07/2024","2","Ensenada","Maestros","Avenida Ignacio Altamirano","2040","22840");
INSERT INTO `requisicione` VALUES ("32","29","2025-01-08 14:13:58","","Pendiente","Martha Guadalupe Santiago Barron","10","45","Zona Los Rios","455","Martha Guadalupe Santiago Barron","1234567890","Ultrimatrix","fg","2","","","","","");
INSERT INTO `requisicione` VALUES ("33","29","2025-01-08 14:18:14","","Pendiente","Martha Guadalupe Santiago Barron","10","47","Pruebajdbedb","455","Martha Guadalupe Santiago Barron","1234567890","SABM8009293V6","hstgjngmsgmsgm","1","","","","","");

-- Estructura de la tabla `respaldo_equipo`
CREATE TABLE `respaldo_equipo` (
  `ID_Equipo` int(11) NOT NULL AUTO_INCREMENT,
  `Marca` varchar(50) NOT NULL,
  `Modelo` varchar(50) NOT NULL,
  `Tipo` varchar(50) NOT NULL,
  `Procesador` varchar(100) DEFAULT NULL,
  `GbRAM` int(11) DEFAULT NULL,
  `Almacenamiento` int(11) NOT NULL,
  `Tipo_Almacenamiento` varchar(50) NOT NULL,
  `ID_Colaboradores` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Equipo`),
  KEY `ID_Colaboradores` (`ID_Colaboradores`),
  CONSTRAINT `Respaldo_Equipo_ibfk_1` FOREIGN KEY (`ID_Colaboradores`) REFERENCES `colaborador` (`ID_Colaborador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- Estructura de la tabla `salida_d`
CREATE TABLE `salida_d` (
  `Id_SalD` int(11) NOT NULL AUTO_INCREMENT,
  `Id` int(11) DEFAULT NULL,
  `IdCProd` int(11) DEFAULT NULL,
  `IdTallas` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`Id_SalD`),
  KEY `IdCProd` (`IdCProd`),
  KEY `IdTallas` (`IdTallas`),
  KEY `Id` (`Id`),
  CONSTRAINT `Salida_D_ibfk_1` FOREIGN KEY (`IdCProd`) REFERENCES `producto` (`IdCProducto`),
  CONSTRAINT `Salida_D_ibfk_2` FOREIGN KEY (`IdTallas`) REFERENCES `ctallas` (`IdCTallas`),
  CONSTRAINT `Salida_D_ibfk_3` FOREIGN KEY (`Id`) REFERENCES `salida_e` (`Id_SalE`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `salida_d` VALUES ("72","22","29","32","1");

-- Estructura de la tabla `salida_e`
CREATE TABLE `salida_e` (
  `Id_SalE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ReqE` int(11) DEFAULT NULL,
  `ID_Usuario_Salida` int(11) DEFAULT NULL,
  `FchSalidad` datetime NOT NULL,
  PRIMARY KEY (`Id_SalE`),
  KEY `ID_ReqE` (`ID_ReqE`),
  KEY `ID_Usuario_Salida` (`ID_Usuario_Salida`),
  CONSTRAINT `Salida_E_ibfk_1` FOREIGN KEY (`ID_ReqE`) REFERENCES `requisicione` (`IDRequisicionE`),
  CONSTRAINT `Salida_E_ibfk_2` FOREIGN KEY (`ID_Usuario_Salida`) REFERENCES `usuario` (`ID_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `salida_e` VALUES ("21","11","1","2025-01-09 13:27:03");
INSERT INTO `salida_e` VALUES ("22","11","1","2025-01-09 14:58:58");

-- Estructura de la tabla `tipo_colaboradores`
CREATE TABLE `tipo_colaboradores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Colaborador` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tipo_colaboradores` VALUES ("1","Supervisor");
INSERT INTO `tipo_colaboradores` VALUES ("2","Coordinador");
INSERT INTO `tipo_colaboradores` VALUES ("3","Ejecutivo");
INSERT INTO `tipo_colaboradores` VALUES ("4","Colaborador");

-- Estructura de la tabla `tipo_usuarios`
CREATE TABLE `tipo_usuarios` (
  `ID` int(11) NOT NULL,
  `Tipo_Usuario` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tipo_usuarios` VALUES ("1","Programador");
INSERT INTO `tipo_usuarios` VALUES ("2","Directivo ");
INSERT INTO `tipo_usuarios` VALUES ("3","Administrador");
INSERT INTO `tipo_usuarios` VALUES ("4","Usuario");
INSERT INTO `tipo_usuarios` VALUES ("5","Almacenista");

-- Estructura de la tabla `usuario`
CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) NOT NULL,
  `Apellido_Paterno` varchar(100) NOT NULL,
  `Apellido_Materno` varchar(100) NOT NULL,
  `NumTel` varchar(20) NOT NULL,
  `Correo_Electronico` varchar(150) NOT NULL,
  `Constrasena` varchar(250) NOT NULL,
  `NumContactoSOS` varchar(20) NOT NULL,
  `ID_Tipo_Usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Usuario`),
  KEY `ID_Tipo_Usuario` (`ID_Tipo_Usuario`),
  CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`ID_Tipo_Usuario`) REFERENCES `tipo_usuarios` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `usuario` VALUES ("1","Moises","Silva","Gonzalez","7774449107","mochito619@gmail.com","$2y$10$H990TbynmXllBVVhzIXbOeEPaiVQr2LzGo6BSbFX9p6KnSEh3NWoe","7771234567","1");
INSERT INTO `usuario` VALUES ("2","Mario","Quintana","Cortes","7771800550","mquintanapryse@gmail.com","$2y$10$.fFb9d1jh5PxvjXrJA2O0uxillnO2eoIpSE1G7MS0Hq/ksxN.8gDK","7771620029","1");
INSERT INTO `usuario` VALUES ("3","Karen","Paterno","Materno","55 5956 6030","karendireccion@gmail.com","$2y$10$tVeaCFitmCNuraOJnRq5o.RztSZ7CbL9h1sRGRENyTdjxUOr3xOOa","7771234567","2");
INSERT INTO `usuario` VALUES ("4","Cibeles","Torres","Henestrosa","55 1798 0299","pryse392@gmail.com","$2y$10$TEzHo3akhwMjPSYsLFfIgemgfpevvxQ2BHhPjVdQGGcRw009rGXN2","55 2888 2483","3");
INSERT INTO `usuario` VALUES ("5","Monserrat","Morales","Gomez","5610371996","monserrat.pryse@gmail.com","$2y$10$4xwlmJP3lvY8g.YqbQEwu.s6Am7Elgo4yb9JhwcW3bWukOvFDltG6","7775607165","4");
INSERT INTO `usuario` VALUES ("6","Yessica","Heracleo","Garcia","56 1036 5116","yesicahg.pryse@gmail.com","$2y$10$8uVPGbfl/a6wwFHZiiqw4OKm9XVmOJLy4YgPR3wpV6z9.O.gGA1w2","7773216137","5");
INSERT INTO `usuario` VALUES ("18","Administrador","Pruebas","Pruebas","1234567891","administrador.prueba@grupopryse.mx","$2y$10$m2E2xN0n/IorWoRb1bO3YucD6nAuXI4idiRAWAmhpYTkU22EzI9Y2","1234567890","3");
INSERT INTO `usuario` VALUES ("19","Isaias","Reyes","Velazquez","7773272756","i.reyes@almacen.grupopryse.mx","$2y$10$QE.HEnMquXGmYKiQRH80GONFmYTempy2xxDIcNuX6JkIu4pen4qqi","7771408330","5");
INSERT INTO `usuario` VALUES ("20","Iris Itzeel","Flores","Jaimez","5610385726","i.flores@grupopryse.mx","$2y$10$2Gu4oRDnWliFU8w3FBqh8OLZ2MndgDEVevaU2TvNMkjF8ciYVU5o6","7773772335","3");
INSERT INTO `usuario` VALUES ("21","Yuliam","Roman","Uribe","56 2609 1728","y.roman@grupopryse.mx","$2y$10$n9vGe5OiiJiY3FmZYEbVuuyVqrHmhbmIodNBatKw/QLnWyw3ZwFDO","56 2609 1728","3");
INSERT INTO `usuario` VALUES ("22","Carolina","Parada","Soria","5591416891","jessica.grupopryse@gmail.com","$2y$10$e6ipFnXskD2rh537uVpWHuG1z.RTWqdRQt9keOHzGHixKAsQRwLMa","5591416891","3");
INSERT INTO `usuario` VALUES ("23","Linda Elizabeth","Arriaga","Ramirez","5559566461","linda.pryse2022@gmail.com","$2y$10$1WS2VRiUr0fKAji/ctIzPOhNbBmnWmLR2BEYXTROSRBOu6.EY3wp6","7621093272","3");
INSERT INTO `usuario` VALUES ("24","Estefanía ","Macedo","Herrera","2294376890","estefania.pryse@gmail.com","$2y$10$/GHhhpzCrSATkxAK1E7BFe22j943n.SsBq0b2dNOExL/DzYB6mEay","5559567942","3");
INSERT INTO `usuario` VALUES ("25","Miguel","Linares","Estrada","7333359098","miguel.linares@grupopryse.mx","$2y$10$1mmSXWfkjf1PyvN8daeq/Op8/ncFu0tgXVrONUdDyiBtVVH0KIZQm","7333359098","3");
INSERT INTO `usuario` VALUES ("26","Isabel","Yañez","Celis","6242459447","isabelcelis.pryse@gmail.com","$2y$10$a1XEnVSKUhuxhobJRZyc8e1PWvaTin2gMKcqAOAQ2du8RZZgLLqLO","6242459447","3");
INSERT INTO `usuario` VALUES ("27","Yenifer","Campuzano","Flores","5563161999","pryse374@gmail.com","$2y$10$1ONwS1sd5ZgqCmmN5QyEbut66/rcFz/BNIX1BRfQVDYHTGWC0/kVO","5563161999","3");
INSERT INTO `usuario` VALUES ("28","Flor de Maria","Cruz","Luis","5615229517","flor.cruz.2024@gmail.com","$2y$10$W1ZxGI0ZXrTmNTxnzrcPU.VEGRqGs18gbxNFodVBBQ.qU05e3ODOC","5615229517","3");
INSERT INTO `usuario` VALUES ("29","Georgina","Meade","Ocaranza","5615234087","gina.meade.ote@gmail.com","$2y$10$QUkx9t1HiG1tJWYYnifNnOd80xrRrg8jLmJ76b.SjiwQ1jSrAHJ0u","5615234087","3");
INSERT INTO `usuario` VALUES ("30","Maria de Lourdes","Armas","Mota","5610121957","l.armas.pryse@gmail.com","$2y$10$VUYTndePeQyhEtAQOnrcPO26MDzaRd9sm2khl05QHnqtnzca4zF8O","5610121957","3");

-- Estructura de la tabla `usuario_cuenta`
CREATE TABLE `usuario_cuenta` (
  `Id_UsuCue` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Usuarios` int(11) DEFAULT NULL,
  `ID_Cuenta` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_UsuCue`),
  KEY `ID_Usuarios` (`ID_Usuarios`),
  KEY `ID_Cuenta` (`ID_Cuenta`),
  CONSTRAINT `Usuario_Cuenta_ibfk_1` FOREIGN KEY (`ID_Usuarios`) REFERENCES `usuario` (`ID_Usuario`),
  CONSTRAINT `Usuario_Cuenta_ibfk_2` FOREIGN KEY (`ID_Cuenta`) REFERENCES `cuenta` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `usuario_cuenta` VALUES ("1","1","");
INSERT INTO `usuario_cuenta` VALUES ("2","2","");
INSERT INTO `usuario_cuenta` VALUES ("3","3","");
INSERT INTO `usuario_cuenta` VALUES ("4","4","1");
INSERT INTO `usuario_cuenta` VALUES ("6","6","");
INSERT INTO `usuario_cuenta` VALUES ("29","18","5");
INSERT INTO `usuario_cuenta` VALUES ("50","5","1");
INSERT INTO `usuario_cuenta` VALUES ("51","19","");
INSERT INTO `usuario_cuenta` VALUES ("52","20","9");
INSERT INTO `usuario_cuenta` VALUES ("53","21","10");
INSERT INTO `usuario_cuenta` VALUES ("54","22","7");
INSERT INTO `usuario_cuenta` VALUES ("55","23","7");
INSERT INTO `usuario_cuenta` VALUES ("56","24","7");
INSERT INTO `usuario_cuenta` VALUES ("57","25","7");
INSERT INTO `usuario_cuenta` VALUES ("58","26","11");
INSERT INTO `usuario_cuenta` VALUES ("59","27","11");
INSERT INTO `usuario_cuenta` VALUES ("60","28","10");
INSERT INTO `usuario_cuenta` VALUES ("61","29","10");
INSERT INTO `usuario_cuenta` VALUES ("62","30","10");

