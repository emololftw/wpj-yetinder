SET NAMES utf8mb4;

INSERT INTO `yetis` (`id`, `nickname`, `height`, `weight`, `address`, `gender`, `roll_dice`, `rate`, `born_at`, `created_at`) VALUES
(1,	'Jarin',	174,	81,	'U Sněžky 11',	1,	1,	8,	'2023-07-25',	'2023-07-23'),
(2,	'Víťa',	205,	85,	'Sněhová 123',	1,	3,	16,	'1995-04-15',	'2023-07-24'),
(3,	'Jiřina',	210,	100,	'Ledová 45',	0,	6,	19,	'1990-09-05',	'2023-07-24'),
(4,	'Zima',	215,	90,	'Sopka 78',	0,	2,	13,	'2000-12-20',	'2023-07-24'),
(5,	'Bořek',	230,	110,	'Horská 56',	1,	4,	15,	'1985-08-10',	'2023-07-24'),
(6,	'Alenka',	210,	95,	'Srnčí 32',	0,	5,	15,	'1998-03-25',	'2023-07-24'),
(7,	'Radim',	225,	105,	'Ledovcová 11',	1,	3,	16,	'1993-06-12',	'2023-07-25'),
(8,	'Magda',	220,	95,	'Sopka 98',	0,	6,	17,	'1991-11-30',	'2023-07-25'),
(9,	'Kamil',	205,	88,	'Sopouch 76',	1,	2,	13,	'1999-01-22',	'2023-07-25'),
(10,	'Dana',	210,	102,	'Sněžná 57',	0,	4,	16,	'1987-07-17',	'2023-07-25'),
(11,	'František',	240,	120,	'Ledová 34',	1,	5,	14,	'1996-02-08',	'2023-07-26'),
(12,	'Dáša',	208,	92,	'Sopouch 89',	0,	3,	15,	'1994-05-10',	'2023-07-26'),
(13,	'Radka',	217,	98,	'Horská 66',	0,	6,	16,	'1992-10-01',	'2023-07-26'),
(14,	'Jaroslava',	205,	86,	'Sněhurková 22',	0,	2,	13,	'2001-03-18',	'2023-07-26'),
(15,	'Václav',	210,	100,	'Srnčí 43',	1,	4,	15,	'1986-09-28',	'2023-07-26'),
(16,	'Ivana',	230,	112,	'Horská 19',	0,	5,	13,	'1997-04-05',	'2023-07-26'),
(17,	'Eliška',	209,	94,	'Srnčí 54',	0,	3,	17,	'1994-08-21',	'2023-07-25'),
(18,	'Erik',	211,	96,	'Sněžná 87',	1,	6,	17,	'1992-12-07',	'2023-07-25'),
(19,	'Věra',	205,	87,	'Ledovcová 76',	0,	2,	13,	'2000-02-14',	'2023-07-25'),
(20,	'Tereza',	220,	104,	'Horská 33',	0,	4,	16,	'1988-06-25',	'2023-07-25'),
(21,	'Luděk',	225,	98,	'Sněžná 12',	1,	5,	14,	'1996-01-03',	'2023-07-26');

INSERT INTO `yetis_rating` (`yeti_id`, `address`, `is_positive`, `rated_at`) VALUES
(2,	'172.18.0.1',	0,	'2023-07-24'),
(1,	'172.18.0.1',	0,	'2023-07-24'),
(17,	'172.18.0.1',	1,	'2023-07-24'),
(6,	'172.18.0.1',	0,	'2023-07-26'),
(11,	'172.18.0.1',	1,	'2023-07-25'),
(3,	'172.18.0.1',	1,	'2023-07-26'),
(19,	'172.18.0.1',	0,	'2023-07-27'),
(8,	'172.18.0.1',	1,	'2023-07-25'),
(9,	'172.18.0.1',	0,	'2023-07-25'),
(10,	'172.18.0.1',	0,	'2023-07-26'),
(19,	'172.18.0.1',	1,	'2023-07-26'),
(14,	'172.18.0.1',	0,	'2023-07-26'),
(15,	'172.18.0.1',	1,	'2023-07-25'),
(12,	'172.18.0.1',	0,	'2023-07-26'),
(6,	'172.18.0.1',	0,	'2023-07-26');
