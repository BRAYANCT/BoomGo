<?php

use Illuminate\Database\Seeder;

class ProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::insert(\DB::raw(
            "INSERT INTO `provinces` (`id`, `department_id`, `name`) VALUES
				(1, 1, 'CHACHAPOYAS'),
				(2, 1, 'BAGUA'),
				(3, 1, 'BONGARA'),
				(4, 1, 'CONDORCANQUI'),
				(5, 1, 'LUYA'),
				(6, 1, 'RODRIGUEZ DE MENDOZA'),
				(7, 1, 'UTCUBAMBA'),
				(8, 2, 'HUARAZ'),
				(9, 2, 'AIJA'),
				(10, 2, 'ANTONIO RAYMONDI'),
				(11, 2, 'ASUNCION'),
				(12, 2, 'BOLOGNESI'),
				(13, 2, 'CARHUAZ'),
				(14, 2, 'CARLOS FERMIN FITZCARRALD'),
				(15, 2, 'CASMA'),
				(16, 2, 'CORONGO'),
				(17, 2, 'HUARI'),
				(18, 2, 'HUARMEY'),
				(19, 2, 'HUAYLAS'),
				(20, 2, 'MARISCAL LUZURIAGA'),
				(21, 2, 'OCROS'),
				(22, 2, 'PALLASCA'),
				(23, 2, 'POMABAMBA'),
				(24, 2, 'RECUAY'),
				(25, 2, 'SANTA'),
				(26, 2, 'SIHUAS'),
				(27, 2, 'YUNGAY'),
				(28, 3, 'ABANCAY'),
				(29, 3, 'ANDAHUAYLAS'),
				(30, 3, 'ANTABAMBA'),
				(31, 3, 'AYMARAES'),
				(32, 3, 'COTABAMBAS'),
				(33, 3, 'CHINCHEROS'),
				(34, 3, 'GRAU'),
				(35, 4, 'AREQUIPA'),
				(36, 4, 'CAMANA'),
				(37, 4, 'CARAVELI'),
				(38, 4, 'CASTILLA'),
				(39, 4, 'CAYLLOMA'),
				(40, 4, 'CONDESUYOS'),
				(41, 4, 'ISLAY'),
				(42, 4, 'LA UNION'),
				(43, 5, 'HUAMANGA'),
				(44, 5, 'CANGALLO'),
				(45, 5, 'HUANCA SANCOS'),
				(46, 5, 'HUANTA'),
				(47, 5, 'LA MAR'),
				(48, 5, 'LUCANAS'),
				(49, 5, 'PARINACOCHAS'),
				(50, 5, 'PAUCAR DEL SARA SARA'),
				(51, 5, 'SUCRE'),
				(52, 5, 'VICTOR FAJARDO'),
				(53, 5, 'VILCAS HUAMAN'),
				(54, 6, 'CAJAMARCA'),
				(55, 6, 'CAJABAMBA'),
				(56, 6, 'CELENDIN'),
				(57, 6, 'CHOTA '),
				(58, 6, 'CONTUMAZA'),
				(59, 6, 'CUTERVO'),
				(60, 6, 'HUALGAYOC'),
				(61, 6, 'JAEN'),
				(62, 6, 'SAN IGNACIO'),
				(63, 6, 'SAN MARCOS'),
				(64, 6, 'SAN PABLO'),
				(65, 6, 'SANTA CRUZ'),
				(66, 7, 'CALLAO'),
				(67, 8, 'CUSCO'),
				(68, 8, 'ACOMAYO'),
				(69, 8, 'ANTA'),
				(70, 8, 'CALCA'),
				(71, 8, 'CANAS'),
				(72, 8, 'CANCHIS'),
				(73, 8, 'CHUMBIVILCAS'),
				(74, 8, 'ESPINAR'),
				(75, 8, 'LA CONVENCION'),
				(76, 8, 'PARURO'),
				(77, 8, 'PAUCARTAMBO'),
				(78, 8, 'QUISPICANCHI'),
				(79, 8, 'URUBAMBA'),
				(80, 9, 'HUANCAVELICA'),
				(81, 9, 'ACOBAMBA'),
				(82, 9, 'ANGARAES'),
				(83, 9, 'CASTROVIRREYNA'),
				(84, 9, 'CHURCAMPA'),
				(85, 9, 'HUAYTARA'),
				(86, 9, 'TAYACAJA'),
				(87, 10, 'HUANUCO'),
				(88, 10, 'AMBO'),
				(89, 10, 'DOS DE MAYO'),
				(90, 10, 'HUACAYBAMBA'),
				(91, 10, 'HUAMALIES'),
				(92, 10, 'LEONCIO PRADO'),
				(93, 10, 'MARAÑON'),
				(94, 10, 'PACHITEA'),
				(95, 10, 'PUERTO INCA'),
				(96, 10, 'LAURICOCHA'),
				(97, 10, 'YAROWILCA'),
				(98, 11, 'ICA'),
				(99, 11, 'CHINCHA'),
				(100, 11, 'NAZCA'),
				(101, 11, 'PALPA'),
				(102, 11, 'PISCO'),
				(103, 12, 'HUANCAYO'),
				(104, 12, 'CONCEPCION'),
				(105, 12, 'CHANCHAMAYO'),
				(106, 12, 'JAUJA'),
				(107, 12, 'JUNIN'),
				(108, 12, 'SATIPO'),
				(109, 12, 'TARMA'),
				(110, 12, 'YAULI'),
				(111, 12, 'CHUPACA'),
				(112, 13, 'TRUJILLO'),
				(113, 13, 'ASCOPE'),
				(114, 13, 'BOLIVAR'),
				(115, 13, 'CHEPEN'),
				(116, 13, 'JULCAN'),
				(117, 13, 'OTUZCO'),
				(118, 13, 'PACASMAYO'),
				(119, 13, 'PATAZ'),
				(120, 13, 'SANCHEZ CARRION'),
				(121, 13, 'SANTIAGO DE CHUCO'),
				(122, 13, 'GRAN CHIMU'),
				(123, 13, 'VIRU'),
				(124, 14, 'CHICLAYO'),
				(125, 14, 'FERREÑAFE'),
				(126, 14, 'LAMBAYEQUE'),
				(127, 15, 'LIMA'),
				(128, 15, 'BARRANCA'),
				(129, 15, 'CAJATAMBO'),
				(130, 15, 'CANTA'),
				(131, 15, 'CAÑETE'),
				(132, 15, 'HUARAL'),
				(133, 15, 'HUAROCHIRI'),
				(134, 15, 'HUAURA'),
				(135, 15, 'OYON'),
				(136, 15, 'YAUYOS'),
				(137, 16, 'MAYNAS'),
				(138, 16, 'ALTO AMAZONAS'),
				(139, 16, 'LORETO'),
				(140, 16, 'MARISCAL RAMON CASTILLA'),
				(141, 16, 'REQUENA'),
				(142, 16, 'UCAYALI'),
				(143, 17, 'TAMBOPATA'),
				(144, 17, 'MANU'),
				(145, 17, 'TAHUAMANU'),
				(146, 18, 'MARISCAL NIETO'),
				(147, 18, 'GENERAL SANCHEZ CERRO'),
				(148, 18, 'ILO'),
				(149, 19, 'PASCO'),
				(150, 19, 'DANIEL ALCIDES CARRION'),
				(151, 19, 'OXAPAMPA'),
				(152, 20, 'PIURA'),
				(153, 20, 'AYABACA'),
				(154, 20, 'HUANCABAMBA'),
				(155, 20, 'MORROPON'),
				(156, 20, 'PAITA'),
				(157, 20, 'SULLANA'),
				(158, 20, 'TALARA'),
				(159, 20, 'SECHURA'),
				(160, 21, 'PUNO'),
				(161, 21, 'AZANGARO'),
				(162, 21, 'CARABAYA'),
				(163, 21, 'CHUCUITO'),
				(164, 21, 'EL COLLAO'),
				(165, 21, 'HUANCANE'),
				(166, 21, 'LAMPA'),
				(167, 21, 'MELGAR'),
				(168, 21, 'MOHO'),
				(169, 21, 'SAN ANTONIO DE PUTINA'),
				(170, 21, 'SAN ROMAN'),
				(171, 21, 'SANDIA'),
				(172, 21, 'YUNGUYO'),
				(173, 22, 'MOYOBAMBA'),
				(174, 22, 'BELLAVISTA'),
				(175, 22, 'EL DORADO'),
				(176, 22, 'HUALLAGA'),
				(177, 22, 'LAMAS'),
				(178, 22, 'MARISCAL CACERES'),
				(179, 22, 'PICOTA'),
				(180, 22, 'RIOJA'),
				(181, 22, 'SAN MARTIN'),
				(182, 22, 'TOCACHE'),
				(183, 23, 'TACNA'),
				(184, 23, 'CANDARAVE'),
				(185, 23, 'JORGE BASADRE'),
				(186, 23, 'TARATA'),
				(187, 24, 'TUMBES'),
				(188, 24, 'CONTRALMIRANTE VILLAR'),
				(189, 24, 'ZARUMILLA'),
				(190, 25, 'CORONEL PORTILLO'),
				(191, 25, 'ATALAYA'),
				(192, 25, 'PADRE ABAD'),
				(193, 25, 'PURUS');"

        ));
    }
}
