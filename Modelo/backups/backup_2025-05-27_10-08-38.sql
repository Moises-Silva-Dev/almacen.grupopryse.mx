-- Respaldo de la base de datos `grupova9_Pryse`
-- Fecha de creación: 2025-05-27 10:08:38
-- Host: localhost
-- Usuario: root
-- Password: 

SET FOREIGN_KEY_CHECKS=0;

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
) ENGINE=InnoDB AUTO_INCREMENT=4488 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `BComentariosMod` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`BIDRequisicionE`),
  KEY `BIdUsuario` (`BIdUsuario`),
  KEY `BIdCuenta` (`BIdCuenta`),
  KEY `BIdRegion` (`BIdRegion`),
  KEY `BIdEstado` (`BIdEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `ccategorias`
CREATE TABLE `ccategorias` (
  `IdCCate` int(11) NOT NULL AUTO_INCREMENT,
  `Descrp` varchar(100) NOT NULL,
  PRIMARY KEY (`IdCCate`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- Estructura de la tabla `ctallas`
CREATE TABLE `ctallas` (
  `IdCTallas` int(11) NOT NULL AUTO_INCREMENT,
  `IdCTipTal` int(11) NOT NULL,
  `Talla` varchar(100) NOT NULL,
  PRIMARY KEY (`IdCTallas`),
  KEY `IdCTipTal` (`IdCTipTal`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `ctipotallas`
CREATE TABLE `ctipotallas` (
  `IdCTipTall` int(11) NOT NULL AUTO_INCREMENT,
  `Descrip` varchar(50) NOT NULL,
  PRIMARY KEY (`IdCTipTall`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `cuenta`
CREATE TABLE `cuenta` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCuenta` varchar(250) NOT NULL,
  `NroElemetos` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `cuenta_region`
CREATE TABLE `cuenta_region` (
  `IDRegCu` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Cuentas` int(11) DEFAULT NULL,
  `ID_Regiones` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDRegCu`),
  KEY `ID_Cuentas` (`ID_Cuentas`),
  KEY `ID_Regiones` (`ID_Regiones`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  KEY `IdTalla` (`IdTalla`)
) ENGINE=InnoDB AUTO_INCREMENT=353 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  KEY `Usuario_Creacion` (`Usuario_Creacion`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `estado_region`
CREATE TABLE `estado_region` (
  `IDEstReg` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Regiones` int(11) DEFAULT NULL,
  `ID_Estados` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDEstReg`),
  KEY `ID_Regiones` (`ID_Regiones`),
  KEY `ID_Estados` (`ID_Estados`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `estados`
CREATE TABLE `estados` (
  `Id_Estado` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_estado` varchar(100) NOT NULL,
  PRIMARY KEY (`Id_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `extras`
CREATE TABLE `extras` (
  `ID_Extra` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Person` int(11) DEFAULT NULL,
  `Tipo_sangre` varchar(3) DEFAULT NULL,
  `Factor_rh` varchar(3) DEFAULT NULL,
  `Lentes` varchar(3) DEFAULT NULL,
  `Estatura` decimal(4,2) DEFAULT NULL,
  `Peso` decimal(5,2) DEFAULT NULL,
  `Complexion` varchar(20) DEFAULT NULL,
  `Alergias` varchar(50) DEFAULT NULL,
  `Nombre_SOS` varchar(50) DEFAULT NULL,
  `Parentesco_SOS` varchar(50) DEFAULT NULL,
  `ContactoTel_SOS` varchar(11) DEFAULT NULL,
  `Altaimss` varchar(50) DEFAULT NULL,
  `Padecimientos` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_Extra`),
  KEY `extras_personas_img_FK` (`ID_Person`),
  CONSTRAINT `extras_personas_img_FK` FOREIGN KEY (`ID_Person`) REFERENCES `persona_img` (`ID_Persona`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

CREATE TABLE `inventario` (
  `IdInv` int(11) NOT NULL AUTO_INCREMENT,
  `IdCPro` int(11) DEFAULT NULL,
  `IdCTal` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT 0,
  PRIMARY KEY (`IdInv`),
  KEY `IdCPro` (`IdCPro`),
  KEY `IdCTal` (`IdCTal`)
) ENGINE=InnoDB AUTO_INCREMENT=306 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `persona_cuenta`
CREATE TABLE `persona_cuenta` (
  `ID_PerCuent` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Personas` int(11) DEFAULT NULL,
  `ID_Cuentas` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_PerCuent`),
  KEY `personas_FK` (`ID_Personas`),
  KEY `cuentas_FK` (`ID_Cuentas`),
  CONSTRAINT `cuentas_FK` FOREIGN KEY (`ID_Cuentas`) REFERENCES `cuenta` (`ID`),
  CONSTRAINT `personas_FK` FOREIGN KEY (`ID_Personas`) REFERENCES `persona_img` (`ID_Persona`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

CREATE TABLE `persona_img` (
  `ID_Persona` int(11) NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(100) DEFAULT NULL,
  `Ap_paterno` varchar(50) DEFAULT NULL,
  `Ap_materno` varchar(50) DEFAULT NULL,
  `Fecha_nacimiento` date DEFAULT NULL,
  `Estado_nacimiento` varchar(50) DEFAULT NULL,
  `Municipio_nacimiento` varchar(50) DEFAULT NULL,
  `Sexo` char(1) DEFAULT NULL,
  `Telefono` char(11) DEFAULT NULL,
  `Estado_civil` varchar(20) DEFAULT NULL,
  `Escolaridad_maxima` varchar(50) DEFAULT NULL,
  `Escuela` varchar(100) DEFAULT NULL,
  `Especialidad` varchar(100) DEFAULT NULL,
  `Rfc` varchar(13) DEFAULT NULL,
  `Elector` varchar(20) DEFAULT NULL,
  `Cartilla` varchar(20) DEFAULT NULL,
  `Curp` varchar(18) DEFAULT NULL,
  `Noolvides_el_matricula` varchar(100) DEFAULT NULL,
  `Imagen_frente` varchar(255) DEFAULT NULL,
  `Imagen_izquierda` varchar(255) DEFAULT NULL,
  `Imagen_derecha` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_Persona`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Datos de la tabla `persona_img`

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
  KEY `IdCTipTal` (`IdCTipTal`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `recluta`
CREATE TABLE `recluta` (
  `ID_Recluta` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) DEFAULT NULL,
  `AP_Paterno` varchar(200) DEFAULT NULL,
  `AP_Materno` varchar(200) DEFAULT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `Origen_Vacante` varchar(200) DEFAULT NULL,
  `Fecha_Envio` date DEFAULT NULL,
  `Transferido` varchar(200) DEFAULT NULL,
  `Estado` varchar(200) DEFAULT NULL,
  `Municipio` varchar(200) DEFAULT NULL,
  `Centro_Trabajo` varchar(200) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Servicio` varchar(200) DEFAULT NULL,
  `Escolaridad` varchar(200) DEFAULT NULL,
  `Edad` int(11) DEFAULT NULL,
  `Transferido_A` varchar(200) DEFAULT NULL,
  `Estatus` varchar(200) DEFAULT NULL,
  `Observaciones` varchar(200) DEFAULT NULL,
  `Fecha_Registro` datetime DEFAULT NULL,
  `Reclutador` varchar(200) DEFAULT NULL,
  `Nombre_Vacante` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID_Recluta`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Estructura de la tabla `regiones`
CREATE TABLE `regiones` (
  `ID_Region` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Region` varchar(250) NOT NULL,
  `Fch_Registro` datetime NOT NULL,
  PRIMARY KEY (`ID_Region`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  KEY `IdTalla` (`IdTalla`)
) ENGINE=InnoDB AUTO_INCREMENT=2337 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  KEY `IdEstado` (`IdEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  KEY `Id` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1756 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `salida_e`
CREATE TABLE `salida_e` (
  `Id_SalE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ReqE` int(11) DEFAULT NULL,
  `ID_Usuario_Salida` int(11) DEFAULT NULL,
  `FchSalidad` datetime NOT NULL,
  PRIMARY KEY (`Id_SalE`),
  KEY `ID_ReqE` (`ID_ReqE`),
  KEY `ID_Usuario_Salida` (`ID_Usuario_Salida`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `tipo_usuarios`
CREATE TABLE `tipo_usuarios` (
  `ID` int(11) NOT NULL,
  `Tipo_Usuario` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  KEY `ID_Tipo_Usuario` (`ID_Tipo_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de la tabla `usuario_cuenta`
CREATE TABLE `usuario_cuenta` (
  `Id_UsuCue` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Usuarios` int(11) DEFAULT NULL,
  `ID_Cuenta` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_UsuCue`),
  KEY `ID_Usuarios` (`ID_Usuarios`),
  KEY `ID_Cuenta` (`ID_Cuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
