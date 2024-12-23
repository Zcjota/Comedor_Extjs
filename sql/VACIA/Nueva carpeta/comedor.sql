/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : comedor

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 23/12/2024 12:58:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cargo
-- ----------------------------
DROP TABLE IF EXISTS `cargo`;
CREATE TABLE `cargo`  (
  `COD_CARGO` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_CARGO`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cargo
-- ----------------------------
INSERT INTO `cargo` VALUES (1, 'ADMINISTRADOR', 0);

-- ----------------------------
-- Table structure for centro_de_costo
-- ----------------------------
DROP TABLE IF EXISTS `centro_de_costo`;
CREATE TABLE `centro_de_costo`  (
  `COD_CENTRO` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `COD_SUBCENTRO` int NOT NULL,
  `COD_UNIDAD` int NOT NULL,
  `codigo_base` int NULL DEFAULT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_CENTRO`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of centro_de_costo
-- ----------------------------
INSERT INTO `centro_de_costo` VALUES (1, 'AC-ADMINISTRACION GENERAL', 1, 1, NULL, 1);

-- ----------------------------
-- Table structure for codigotrabajador_personal
-- ----------------------------
DROP TABLE IF EXISTS `codigotrabajador_personal`;
CREATE TABLE `codigotrabajador_personal`  (
  `COD_PERSONAL` int NOT NULL,
  `CODIGO_TRABAJADOR` int NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_PERSONAL`, `CODIGO_TRABAJADOR`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Records of codigotrabajador_personal
-- ----------------------------
INSERT INTO `codigotrabajador_personal` VALUES (1, 1, 1);

-- ----------------------------
-- Table structure for descanso
-- ----------------------------
DROP TABLE IF EXISTS `descanso`;
CREATE TABLE `descanso`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `COD_PERSONA` int NOT NULL,
  `GESTION` int NOT NULL,
  `MES` int NOT NULL,
  `DIA` int NOT NULL,
  `VALIDADOR` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_alta` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `idusuario_alta` int NOT NULL,
  `idusuario_baja` int NULL DEFAULT NULL,
  `fecha_baja` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idcronograma_licencia` int NULL DEFAULT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of descanso
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_perfil
-- ----------------------------
DROP TABLE IF EXISTS `detalle_perfil`;
CREATE TABLE `detalle_perfil`  (
  `COD_SUB_MENU` int NOT NULL,
  `COD_TIPOU` int NOT NULL,
  `ROL` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_SUB_MENU`, `COD_TIPOU`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 20 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of detalle_perfil
-- ----------------------------
INSERT INTO `detalle_perfil` VALUES (1, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (2, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (3, 2, '00000', 0);
INSERT INTO `detalle_perfil` VALUES (4, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (5, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (6, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (7, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (8, 2, '00000', 0);
INSERT INTO `detalle_perfil` VALUES (9, 2, '00000', 0);
INSERT INTO `detalle_perfil` VALUES (10, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (11, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (12, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (13, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (14, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (15, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (16, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (17, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (18, 2, '00000', 1);
INSERT INTO `detalle_perfil` VALUES (19, 2, '00000', 1);

-- ----------------------------
-- Table structure for flujo_aprobador
-- ----------------------------
DROP TABLE IF EXISTS `flujo_aprobador`;
CREATE TABLE `flujo_aprobador`  (
  `COD_PERSONAL` int NOT NULL,
  `COD_USUARIO` int NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_PERSONAL`, `COD_USUARIO`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Records of flujo_aprobador
-- ----------------------------

-- ----------------------------
-- Table structure for grupo
-- ----------------------------
DROP TABLE IF EXISTS `grupo`;
CREATE TABLE `grupo`  (
  `COD_GRUPO` int NOT NULL AUTO_INCREMENT,
  `NOMBRE_GRUPO` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_GRUPO`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of grupo
-- ----------------------------
INSERT INTO `grupo` VALUES (1, 'GRUPO A ', 1);

-- ----------------------------
-- Table structure for historico_justificacion
-- ----------------------------
DROP TABLE IF EXISTS `historico_justificacion`;
CREATE TABLE `historico_justificacion`  (
  `COD_HISTORICO` int NOT NULL AUTO_INCREMENT,
  `idjustificacion` int NULL DEFAULT NULL,
  `MOTIVO` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `MOTIVO_HE` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MOTIVO_APROBADOR` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FECHA_APROBACION` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FECHA` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `COD_PERSONAL` int NOT NULL,
  `FECHA_HORARIO` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `USUARIO_HORARIO` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FECHA_CAMBIOJUSTIFICACION` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `USUARIO_CAMBIOJUSTIFICACION` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FECHA_HORAS_EXTRAS` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `USUARIO_HE` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FECHA_APROBAR_HE` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `USUARIO_APROBACION` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_HISTORICO`) USING BTREE,
  INDEX `COD_PERSONAL`(`COD_PERSONAL`) USING BTREE,
  INDEX `FECHA`(`FECHA`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of historico_justificacion
-- ----------------------------

-- ----------------------------
-- Table structure for horario
-- ----------------------------
DROP TABLE IF EXISTS `horario`;
CREATE TABLE `horario`  (
  `COD_HORARIO` int NOT NULL AUTO_INCREMENT,
  `NOMBRE_HORARIO` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TOLERANCIA_ENTRADA` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TOLERANCIA_SALIDA` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `INICIO_ENTRADAH` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `INICIO_ENTRADAM` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FINAL_ENTRADAH` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FINAL_ENTRADAM` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `INICIO_SALIDAH` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `INICIO_SALIDAM` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FINAL_SALIDAH` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FINAL_SALIDAM` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `INICIO_MARCACION_ENTRADAH` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `INICIO_MARCACION_ENTRADAM` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TERM_MARCACION_ENTRADAH` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TERM_MARCACION_ENTRADAM` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `INICIO_MARCACION_SALIDAH` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `INICIO_MARCACION_SALIDAM` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TERM_MARCACION_SALIDAH` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TERM_MARCACION_SALIDAM` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `COD_TIPOHORARIO` tinyint(1) NOT NULL,
  `COD_HORARIOPERSONA` int NOT NULL,
  `TOLERANCIA_SEMAFORO` int NOT NULL,
  `idusuario_alta` int NULL DEFAULT NULL,
  `fecha_alta` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idusuario_update` int NULL DEFAULT NULL,
  `fecha_update` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idusuario_baja` int NULL DEFAULT NULL,
  `fecha_baja` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_HORARIO`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of horario
-- ----------------------------

-- ----------------------------
-- Table structure for horario_comedor
-- ----------------------------
DROP TABLE IF EXISTS `horario_comedor`;
CREATE TABLE `horario_comedor`  (
  `CODIGO` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(300) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `HORARIO` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `HORARIO_SALIDA` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACTIVO` tinyint NOT NULL,
  PRIMARY KEY (`CODIGO`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of horario_comedor
-- ----------------------------
INSERT INTO `horario_comedor` VALUES (1, 'ALMUERZO', '11:00', '14:30', 1);
INSERT INTO `horario_comedor` VALUES (2, 'REFRIGERIO', '06:00', '10:59', 1);
INSERT INTO `horario_comedor` VALUES (3, 'CENA', '18:30', '23:59', 1);
INSERT INTO `horario_comedor` VALUES (4, 'REFRIGERIO', '14:31', '18:29', 1);
INSERT INTO `horario_comedor` VALUES (5, 'CENA 2', '00:00', '05:00', 0);

-- ----------------------------
-- Table structure for horario_grupo
-- ----------------------------
DROP TABLE IF EXISTS `horario_grupo`;
CREATE TABLE `horario_grupo`  (
  `COD_GRUPO` int NOT NULL,
  `CODHORARIO` int NOT NULL,
  `GESTION` int NOT NULL,
  `MES` int NOT NULL,
  `DIA` int NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_GRUPO`, `CODHORARIO`, `GESTION`, `MES`, `DIA`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Records of horario_grupo
-- ----------------------------

-- ----------------------------
-- Table structure for horario_turno
-- ----------------------------
DROP TABLE IF EXISTS `horario_turno`;
CREATE TABLE `horario_turno`  (
  `COD_HORARIO` int NOT NULL,
  `COD_TURNO` int NOT NULL,
  `COD_DIA` int NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_HORARIO`, `COD_TURNO`, `COD_DIA`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Records of horario_turno
-- ----------------------------
INSERT INTO `horario_turno` VALUES (1, 4, 1, 1);
INSERT INTO `horario_turno` VALUES (1, 4, 2, 1);
INSERT INTO `horario_turno` VALUES (1, 4, 4, 1);
INSERT INTO `horario_turno` VALUES (1, 4, 3, 1);
INSERT INTO `horario_turno` VALUES (1, 4, 5, 1);
INSERT INTO `horario_turno` VALUES (2, 5, 1, 1);
INSERT INTO `horario_turno` VALUES (2, 5, 2, 1);
INSERT INTO `horario_turno` VALUES (2, 5, 3, 1);
INSERT INTO `horario_turno` VALUES (2, 5, 4, 1);
INSERT INTO `horario_turno` VALUES (2, 5, 5, 1);
INSERT INTO `horario_turno` VALUES (2, 5, 6, 1);
INSERT INTO `horario_turno` VALUES (2, 5, 7, 1);

-- ----------------------------
-- Table structure for licencias
-- ----------------------------
DROP TABLE IF EXISTS `licencias`;
CREATE TABLE `licencias`  (
  `COD_PERSONA` int NOT NULL,
  `COD_TIPO_LICENCIA` int NOT NULL,
  `GESTION` int NOT NULL,
  `MES` int NOT NULL,
  `DIA` int NOT NULL,
  `VALIDADOR` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_alta` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `idusuario_alta` int NOT NULL,
  `memo` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idcentro` int NOT NULL,
  `idcargo` int NOT NULL,
  `idusuario_baja` int NULL DEFAULT NULL,
  `fecha_baja` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idcronograma_licencia` int NULL DEFAULT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_PERSONA`, `COD_TIPO_LICENCIA`, `GESTION`, `MES`, `DIA`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of licencias
-- ----------------------------

-- ----------------------------
-- Table structure for marcacion
-- ----------------------------
DROP TABLE IF EXISTS `marcacion`;
CREATE TABLE `marcacion`  (
  `COD_MARCACION` bigint NOT NULL AUTO_INCREMENT,
  `COD_PERSONAL` int NOT NULL,
  `HORA` int NOT NULL,
  `MINUTO` int NOT NULL,
  `SEGUNDO` int NOT NULL,
  `GESTION` int NOT NULL,
  `MES` int NOT NULL,
  `DIA` int NOT NULL,
  `COD_RELOJ` int NOT NULL,
  `MARCACION_EDITADA` int NOT NULL,
  `TIPO_MARCACION` int NOT NULL,
  `FECHA_MARCACION` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CODUSUARIO` int NOT NULL,
  `idmarcacionmovil` int NULL DEFAULT NULL,
  `idhistorico_subir_marcacion` int NOT NULL,
  `nombre_personal` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `idmarcacion_externa` int NULL DEFAULT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  `idmarcacion` bigint NULL DEFAULT NULL,
  PRIMARY KEY (`COD_MARCACION`, `COD_PERSONAL`) USING BTREE,
  INDEX `DIA`(`DIA`) USING BTREE,
  INDEX `MES`(`MES`) USING BTREE,
  INDEX `HORA`(`HORA`) USING BTREE,
  INDEX `COD_RELOJ`(`COD_RELOJ`) USING BTREE,
  INDEX `GESTION`(`GESTION`) USING BTREE,
  INDEX `COD_PERSONAL`(`COD_PERSONAL`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of marcacion
-- ----------------------------

-- ----------------------------
-- Table structure for marcacion_comedor
-- ----------------------------
DROP TABLE IF EXISTS `marcacion_comedor`;
CREATE TABLE `marcacion_comedor`  (
  `COD_MARCACION` int NOT NULL AUTO_INCREMENT,
  `CODIGO` int NOT NULL,
  `NOMBRE` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `GESTION` int NOT NULL,
  `MES` int NOT NULL,
  `DIA` int NOT NULL,
  `HORA` int NOT NULL,
  `MINUTO` int NOT NULL,
  `SEGUNDO` int NOT NULL,
  `ACTIVO` int NOT NULL,
  PRIMARY KEY (`COD_MARCACION`, `CODIGO`, `GESTION`, `MES`, `DIA`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of marcacion_comedor
-- ----------------------------

-- ----------------------------
-- Table structure for marcacion_valida
-- ----------------------------
DROP TABLE IF EXISTS `marcacion_valida`;
CREATE TABLE `marcacion_valida`  (
  `COD_PERSONAL` int NOT NULL,
  `GESTION` int NOT NULL,
  `MES` int NOT NULL,
  `DIA` int NOT NULL,
  `COD_HORARIO` int NOT NULL,
  `HIE` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `HIS` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `HFE` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `HFS` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `COD_CARGO` int NOT NULL,
  `COD_CENTRO` int NOT NULL,
  `RETRASO` tinyint(1) NOT NULL,
  `FALTA` tinyint NOT NULL,
  `VALIDADOR` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `HEN` varchar(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `HEF` varchar(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `HED` varchar(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `VALIDADORHE` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `RECARGO_NOCTURNO` varchar(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `APROBADOR` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `BANDERA` tinyint(1) NOT NULL,
  `MIN_JUSTIFICADOS` int NOT NULL,
  `MARCACION_ESPEJO` int NOT NULL,
  `HE1E` int NOT NULL,
  `HS1E` int NOT NULL,
  `HE2E` int NOT NULL,
  `HS2E` int NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_PERSONAL`, `GESTION`, `MES`, `DIA`) USING BTREE,
  INDEX `COD_PERSONAL`(`COD_PERSONAL`) USING BTREE,
  INDEX `GESTION`(`GESTION`) USING BTREE,
  INDEX `MES`(`MES`) USING BTREE,
  INDEX `DIA`(`DIA`) USING BTREE,
  INDEX `COD_HORARIO`(`COD_HORARIO`) USING BTREE,
  INDEX `COD_CARGO`(`COD_CARGO`) USING BTREE,
  INDEX `COD_CENTRO`(`COD_CENTRO`) USING BTREE,
  INDEX `VALIDADORHE`(`VALIDADORHE`) USING BTREE,
  INDEX `HIE`(`HIE`) USING BTREE,
  INDEX `HFS`(`HFS`) USING BTREE,
  INDEX `HIS`(`HIS`) USING BTREE,
  INDEX `HFE`(`HFE`) USING BTREE,
  INDEX `HEN`(`HEN`) USING BTREE,
  INDEX `HEF`(`HEF`) USING BTREE,
  INDEX `HED`(`HED`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of marcacion_valida
-- ----------------------------

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `COD_MENU` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ORDEN` int NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  `ICON` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`COD_MENU`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 'Parametros', 1, 1, 'MAN');
INSERT INTO `menu` VALUES (2, 'Datos del Personal', 2, 1, 'MAN');
INSERT INTO `menu` VALUES (3, 'Adm. de Usuarios', 3, 1, 'MAN');
INSERT INTO `menu` VALUES (4, 'Control de Asistencia', 4, 0, 'MAN');
INSERT INTO `menu` VALUES (5, 'Control Comedor', 5, 1, 'MAN');

-- ----------------------------
-- Table structure for nivel
-- ----------------------------
DROP TABLE IF EXISTS `nivel`;
CREATE TABLE `nivel`  (
  `COD_NIVEL` int NOT NULL AUTO_INCREMENT,
  `NOMBRE_NIVEL` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CATEGORIA` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MINIMO` int NOT NULL,
  `MIDPOINT` int NOT NULL,
  `MAXIMO` int NOT NULL,
  `idusuario_alta` int NULL DEFAULT NULL,
  `fecha_alta` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idusuario_update` int NULL DEFAULT NULL,
  `fecha_update` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `idusuario_baja` int NULL DEFAULT NULL,
  `fecha_baja` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_NIVEL`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of nivel
-- ----------------------------
INSERT INTO `nivel` VALUES (1, '1', 'JUNIORS / AYUDANTES / OP. PROD D-C', 0, 3125, 0, NULL, NULL, 34, '2024-07-18 12:13:02', NULL, NULL, 1);

-- ----------------------------
-- Table structure for personal
-- ----------------------------
DROP TABLE IF EXISTS `personal`;
CREATE TABLE `personal`  (
  `COD_PERSONAL` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NOMBRE2` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `AP_PATERNO` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `AP_MATERNO` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CI` int NOT NULL,
  `EXTENSION` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `FECHA_NACIMIENTO` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `GENERO` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TELEFONO1` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `CELULAR1` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `DIRECCION` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `COD_CENTRO` int NOT NULL,
  `COD_CARGO` int NOT NULL,
  `FECHA_INGRESO` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL COMMENT '0:inactivo, 1:activo, 2:eliminado permanentemente',
  `NRO_TRABAJADOR` int NULL DEFAULT NULL,
  `SALDO_VACACIONES` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`COD_PERSONAL`) USING BTREE,
  UNIQUE INDEX `NRO_TRABAJADOR`(`NRO_TRABAJADOR`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal
-- ----------------------------
INSERT INTO `personal` VALUES (1, 'JUNIOR', 'JAIME', 'AGUILAR', 'LEAÑOS', 60852098, 'SC', '1998-08-20', 'MASCULINO', '60852098', '60852098', 'CE', 1, 1, '2024-08-20', 1, 1, NULL);

-- ----------------------------
-- Table structure for personal_flujo
-- ----------------------------
DROP TABLE IF EXISTS `personal_flujo`;
CREATE TABLE `personal_flujo`  (
  `COD_PERSONAL` int NOT NULL,
  `COD_USUARIO` int NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_PERSONAL`, `COD_USUARIO`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Records of personal_flujo
-- ----------------------------

-- ----------------------------
-- Table structure for proveedor
-- ----------------------------
DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor`  (
  `_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `representa_legal` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nit` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `direccion` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of proveedor
-- ----------------------------
INSERT INTO `proveedor` VALUES (1, 'J&S PALACIOS CONSTRUCCIONES Y SERVICIOS S.R.L.', 'JORGE PALACIOS', '151426025', 'Z/ B. AMERICANO, C/ AVAROA I Nº S/N', 1);

-- ----------------------------
-- Table structure for reloj
-- ----------------------------
DROP TABLE IF EXISTS `reloj`;
CREATE TABLE `reloj`  (
  `COD_RELOJ` smallint NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `IP` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `OC1` smallint NOT NULL,
  `OC2` smallint NOT NULL,
  `OC3` smallint NOT NULL,
  `OC4` smallint NOT NULL,
  `ESTADO` int NOT NULL,
  `ULTIMA_DESCARGA` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ULTIMA_DESCARGA_BUENA` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_RELOJ`) USING BTREE,
  UNIQUE INDEX `IP`(`IP`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of reloj
-- ----------------------------
INSERT INTO `reloj` VALUES (1, 'SCZ ADM', '192.168.1.215', 192, 168, 1, 215, 1, '2024-12-16 11:20:46', '2024-12-16 11:20:46', 1);

-- ----------------------------
-- Table structure for reloj_comedor
-- ----------------------------
DROP TABLE IF EXISTS `reloj_comedor`;
CREATE TABLE `reloj_comedor`  (
  `COD_RELOJ` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `IP` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `OC1` smallint NOT NULL,
  `OC2` smallint NOT NULL,
  `OC3` smallint NOT NULL,
  `OC4` smallint NOT NULL,
  `ACTIVO` tinyint NOT NULL,
  PRIMARY KEY (`COD_RELOJ`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of reloj_comedor
-- ----------------------------
INSERT INTO `reloj_comedor` VALUES (1, 'COMEDOR', '192.168.1.240', 192, 168, 1, 240, 1);

-- ----------------------------
-- Table structure for subcentro
-- ----------------------------
DROP TABLE IF EXISTS `subcentro`;
CREATE TABLE `subcentro`  (
  `COD_SUBCENTRO` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `COD_SUBCENTRO_BD` int NULL DEFAULT 0,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_SUBCENTRO`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subcentro
-- ----------------------------
INSERT INTO `subcentro` VALUES (1, 'CENTRAL', 0, 0);
INSERT INTO `subcentro` VALUES (2, 'COCHABAMBA', 0, 0);
INSERT INTO `subcentro` VALUES (3, 'LA PAZ', 0, 0);
INSERT INTO `subcentro` VALUES (4, 'SANTA CRUZ', 0, 0);
INSERT INTO `subcentro` VALUES (5, 'SUCRE', 0, 0);

-- ----------------------------
-- Table structure for submenu
-- ----------------------------
DROP TABLE IF EXISTS `submenu`;
CREATE TABLE `submenu`  (
  `COD_SUB_MENU` int NOT NULL AUTO_INCREMENT,
  `COD_MENU` int NOT NULL,
  `DESCRIPCION` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `RUTA` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ORDENS` int NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  `ICON` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`COD_SUB_MENU`) USING BTREE,
  INDEX `COD_MENU`(`COD_MENU`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 20 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of submenu
-- ----------------------------
INSERT INTO `submenu` VALUES (1, 3, 'Usuarios', 'DSlists/DSListadoUsuario_v3.php', 1, 1, 'ISI36');
INSERT INTO `submenu` VALUES (2, 3, 'Perfil *Usuario', 'DSlists/DSListadoTipoU.php', 2, 1, 'ISI37');
INSERT INTO `submenu` VALUES (3, 3, 'Reporte Individual *(Real)', 'DSlists/DSreporteTrabajador.php', 3, 0, 'ISI39');
INSERT INTO `submenu` VALUES (4, 1, 'Cargo', 'DSlists/DSListadoCargo.php', 1, 1, 'ISI22');
INSERT INTO `submenu` VALUES (5, 1, 'Subcentro', 'DSlists/DSListadoSubcentro.php', 2, 1, 'ISI24');
INSERT INTO `submenu` VALUES (6, 1, 'Unidad', 'DSlists/DSListadoUnidad.php', 3, 1, 'ISI23');
INSERT INTO `submenu` VALUES (7, 1, 'Centro *de Costo', 'DSlists/DSListadoCentroCosto.php', 4, 1, 'ISI25');
INSERT INTO `submenu` VALUES (8, 4, 'Reporte General *(Diario)', 'DSlists/DSListadoControlAsistenciaEditada.php', 1, 0, 'ISI43');
INSERT INTO `submenu` VALUES (9, 4, 'Reporte Individual *(Tarjeta)', 'DSlists/DSreporteTrabajadorEditada.php', 2, 0, 'ISI44');
INSERT INTO `submenu` VALUES (10, 5, 'Reloj *Comedor', 'DSlists/DSListadoRelojComedor.php', 1, 1, 'ISI89');
INSERT INTO `submenu` VALUES (11, 5, 'Horario *Comedor', 'DSlists/DSListadoHorarioComedor.php', 2, 1, 'ISI90');
INSERT INTO `submenu` VALUES (12, 5, 'Asignación  *Especial', 'DSlists/DSListadoAsignacionTarjetaPersona.php', 3, 1, 'ISI92');
INSERT INTO `submenu` VALUES (13, 5, 'Reporte *Resumen Comedor', 'DSlists/DSListadoResumenComedor.php', 4, 1, 'ISI96');
INSERT INTO `submenu` VALUES (14, 5, 'Pedido *Comedor', 'DSlists/DSPedidoAlmuerzo.php', 5, 1, 'ISI93');
INSERT INTO `submenu` VALUES (15, 5, 'Reporte *Alimenticio', 'DSlists/DSListadoReporteDeAlimentacion.php', 6, 1, 'ISI97');
INSERT INTO `submenu` VALUES (16, 1, 'Proveedor', 'DSlists/DSListadoProveedor.php', 7, 1, 'ISI91');
INSERT INTO `submenu` VALUES (17, 1, 'Tipo de *Justificación', 'DSlists/DSListadoTipoJustificacion.php', 5, 1, 'ISI26');
INSERT INTO `submenu` VALUES (18, 1, 'Nivel', 'DSlists/DSListadoNivelesJerarquicos.php', 6, 1, 'ISI23');
INSERT INTO `submenu` VALUES (19, 2, 'Personal ', 'DSlists/DSListadoPersonalV2.php', 1, 1, 'ISI05');

-- ----------------------------
-- Table structure for tarjetas_comedor
-- ----------------------------
DROP TABLE IF EXISTS `tarjetas_comedor`;
CREATE TABLE `tarjetas_comedor`  (
  `CODIGO` int NOT NULL,
  `NOMBRE` varchar(300) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `COD_CENTRO` int NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`CODIGO`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tarjetas_comedor
-- ----------------------------

-- ----------------------------
-- Table structure for tipo_comida
-- ----------------------------
DROP TABLE IF EXISTS `tipo_comida`;
CREATE TABLE `tipo_comida`  (
  `COD_PERSONAL` int NOT NULL,
  `COD_TIPO` int NOT NULL COMMENT '1:DIETA',
  `GESTION` int NOT NULL,
  `MES` int NOT NULL,
  `DIA` int NOT NULL,
  `VALIDADOR` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FECHA` datetime NOT NULL,
  `COD_USUARIO` int NOT NULL,
  `FECHA_INICIO` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FECHA_FIN` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACTIVO` int NOT NULL,
  PRIMARY KEY (`COD_PERSONAL`, `GESTION`, `MES`, `DIA`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tipo_comida
-- ----------------------------
INSERT INTO `tipo_comida` VALUES (1, 1, 2024, 12, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2024, 12, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2024, 12, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2024, 12, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2024, 12, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2024, 12, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2024, 12, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2024, 12, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2024, 12, 31, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 1, 31, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 2, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 3, 31, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 4, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:34', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 5, 31, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 6, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 7, 31, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 8, 31, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 9, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 10, 31, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 11, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 1, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 2, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 3, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 4, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 5, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 6, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 7, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 8, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 9, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 10, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 11, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 12, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 13, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 14, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 15, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 16, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 17, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 18, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 19, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 20, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 21, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 22, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 23, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 24, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 25, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 26, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 27, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 28, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 29, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 30, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);
INSERT INTO `tipo_comida` VALUES (1, 1, 2025, 12, 31, 'ADMINISTRADOR .', '2024-12-23 12:46:35', 1, '23/12/2024', '31/12/2025', 1);

-- ----------------------------
-- Table structure for tipo_justificacion
-- ----------------------------
DROP TABLE IF EXISTS `tipo_justificacion`;
CREATE TABLE `tipo_justificacion`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `idusuario_alta` int NULL DEFAULT NULL,
  `fecha_alta` datetime NULL DEFAULT NULL,
  `idusuario_update` int NULL DEFAULT NULL,
  `fecha_update` datetime NULL DEFAULT NULL,
  `idusuario_baja` int NULL DEFAULT NULL,
  `fecha_baja` datetime NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tipo_justificacion
-- ----------------------------
INSERT INTO `tipo_justificacion` VALUES (1, 'DESCANSO', NULL, NULL, 1, '2022-04-06 12:03:39', NULL, NULL, 1);

-- ----------------------------
-- Table structure for tipo_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE `tipo_usuario`  (
  `COD_TIPOU` int NOT NULL AUTO_INCREMENT,
  `NOMB_TIPOU` varchar(90) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_TIPOU`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tipo_usuario
-- ----------------------------
INSERT INTO `tipo_usuario` VALUES (1, 'NINGUNO', 0);
INSERT INTO `tipo_usuario` VALUES (2, 'ADMIN-SYSTEM', 1);
INSERT INTO `tipo_usuario` VALUES (3, 'OPERACIONES', 1);
INSERT INTO `tipo_usuario` VALUES (4, 'CTRL. DE ASISTENCIA', 1);
INSERT INTO `tipo_usuario` VALUES (5, 'COMEDOR', 1);

-- ----------------------------
-- Table structure for unidad
-- ----------------------------
DROP TABLE IF EXISTS `unidad`;
CREATE TABLE `unidad`  (
  `COD_UNIDAD` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `COD_UNIDAD_BD` int NULL DEFAULT 0,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_UNIDAD`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of unidad
-- ----------------------------
INSERT INTO `unidad` VALUES (1, 'ADM Y FIN', 0, 0);
INSERT INTO `unidad` VALUES (2, 'COMEDOR', 0, 0);

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`  (
  `COD_USUARIO` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `AP_PATERNO` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `AP_MATERNO` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `LOGIN` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PASSWORD` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CORREO` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `COD_TIPOU` int NOT NULL DEFAULT 1,
  `COD_PERSONAL` int NOT NULL,
  `BANDERA` tinyint(1) NULL DEFAULT 1,
  `TEMA` int NULL DEFAULT 1,
  `ACTIVO` tinyint(1) NOT NULL,
  PRIMARY KEY (`COD_USUARIO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (1, 'ADMINISTRADOR DE SISTEMA', 'AGUILAR', 'LEAÑOS', 'admin', '123', 'ccallecontreras@gmail.com', 2, 0, 1, 1, 1);

SET FOREIGN_KEY_CHECKS = 1;
