-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2024 a las 17:05:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `plataforma`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `admin_id` int(11) NOT NULL,
  `admin_nombre` varchar(255) NOT NULL,
  `admin_apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`admin_id`, `admin_nombre`, `admin_apellidos`, `email`, `password`, `reset_token`) VALUES
(123, 'Axel', 'Bernal Resendiz', 'abernalrdev@gmail.com', '$2y$10$5A3HjyVO5eT5U2Zp.YMRau0JaVcMsomntN3cCdeMo5UyhEkQZaqXK', 1),
(76745, 'fds', 'fsf', 'leicaj3@gmail.com', '$2y$10$VC5XcVk7T/F6v8Vli9ovuugdOSLi9y2MzXt5BD1xAgrZllMlbRz/W', 0),
(1234345, 'isa2', 'hdz', 'leicaj5@gmail.com', '$2y$10$9mVCjVNJBLIBa.tgMKd0LOEBL.71sn/wBjqhaAlO37dhjVxnL7cKq', 29),
(1456676, 'Karina', 'Perez Hernandez', 'karina@gmail.com', '$2y$10$VC5XcVk7T/F6v8Vli9ovuugdOSLi9y2MzXt5BD1xAgrZllMlbRz/W', 0),
(4324513, 'isai', 'hdez', 'leicaj4@gmail.com', '$2y$10$VC5XcVk7T/F6v8Vli9ovuugdOSLi9y2MzXt5BD1xAgrZllMlbRz/W', 496);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `alumno_id` int(11) NOT NULL,
  `alumno_nombre` varchar(255) NOT NULL,
  `alumno_apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` int(20) NOT NULL,
  `estado` enum('activa','deshabilitada','pendiente') NOT NULL DEFAULT 'activa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`alumno_id`, `alumno_nombre`, `alumno_apellidos`, `email`, `password`, `reset_token`, `estado`) VALUES
(1, 'Axel', 'Bernal Resendiz', 'bernal12312@gmail.com', '$2y$10$7.In9hfR9S40r5FJRismL.1S40od/3RBb00a0FBKHoAAIdc./BUP2', 0, 'activa'),
(2, 'Juan', 'Bernal Resendiz', 'fanny@gmail.com', '$2y$10$MQRR8ginNrRNPoArCdAfqeX.nYCJskdscLEiFCsPIHfluE9p7RnxW', 0, 'activa'),
(3, 'Isai', 'Hernadez', 'LEICAJ1@GMAIL.COm', '$2y$10$eXjWErlXjSY7wc9N3H5ahenJpHdAjCHAHDFsy1AbImmWDNTROQuz6', 0, 'activa'),
(4, 'Axel', 'Bernal Resendiz', 'cuenta.axelbr1@gmail.com', '$2y$10$HNSx.vU7W6GxDC7OWlKKeOaaUcjHyEaQOg2Kcw34.zy9kgABXZYKi', 0, 'activa'),
(5, 'Veronica ', 'Perez Hernandez', 'tecla@gmail.com', '$2y$10$RngKzIG0EG9YmtkryNNqe.bHJVmb1no43ap6nfMyXkd/9xxd4rmZm', 0, 'activa'),
(6, 'Juan', 'Bernal Resendiz', 'tecl4a@gmail.com', '$2y$10$iuLjDO2.JdXvJR9mMjxHZeI4SUfHBUH7Z5B8H/fnrv0dxVNlov2VO', 0, 'activa'),
(7, 'Juan', 'Perez Hernandez', 'veronica@gmail.com', '$2y$10$AJP92.bjmQC2BKfjWu9sp.hS4BcH.xHY8max0aTtoEqU4bnzuJd0G', 0, 'pendiente'),
(8, 'Juan', 'Bernal Resendiz', 'bernal123512@gmail.com', '$2y$10$M0FjVX9dE6pVOQErP3dq6OYeCgk8Foc947oMKPUUwqWVk1Nchzhb.', 0, 'activa'),
(9, 'Juan', 'Perez Hernandez', 'rodo@gmail.com', '$2y$10$qvgvY4nwMaVDKrXz2ZF7j.dL/REYM3ko9MsapgIe0quv7J3k9.ObK', 0, 'activa'),
(12456, 'Axel', 'Bernal Resendiz', 'a@a', '$2y$10$K0D4CRE85eikVD/7Ttt5y.Ehn1aS5WBmpPHYuqoaCvll8UyuTgMnS', 0, 'activa'),
(21457897, 'Axel', 'Bernal Resendiz', 'b@b', '$2y$10$TvCKSbHrCyt/rJXNsJteX.CsxIhggAvfvHa/TURn4zpnKJYIRjrsG', 0, 'activa'),
(2021635458, 'Axel', 'Bernal Resendiz', 'axel@gmail.com', '$2y$10$9HrZYDHsRHzODL/B6u7qEe2f0D52hCk.WaeVzbbn8dz4S/RyJYyd2', 0, 'activa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(30) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `enlace` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`, `enlace`) VALUES
(19, '5CM2', '5cm7 whats'),
(21, 'dsad', 'dsad'),
(22, '5CM4', 'http://localhost/preguntas/Plataforma-Isai/'),
(25, '47C1', 'Wassdsad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales_apoyo`
--

CREATE TABLE `materiales_apoyo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `contenido` longtext DEFAULT NULL,
  `tipo_material` enum('Video','Página web','Documento','Texto','Otro') NOT NULL,
  `id_tema` int(11) DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `materiales_apoyo`
--

INSERT INTO `materiales_apoyo` (`id`, `nombre`, `contenido`, `tipo_material`, `id_tema`, `id_materia`) VALUES
(1, 'SUCESIONES', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/FGoSqeFl5zg?si=BCUhq-OP0DQnQDoL\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'Video', 1, 1),
(2, 'Operaciones con polinomios: suma, resta, multiplicación y división', 'https://www.superprof.es/apuntes/escolar/matematicas/algebra/polinomios/suma-de-polinomios.html#:~:text=18%E2%82%AC-,Suma%20de%20polinomios,en%20los%20t%C3%A9rminos%20a%20sumar.', 'Página web', 2, 1),
(3, 'Ejercicios de cálculo de derivadas', 'https://www.matematicasonline.es/pdf/ejercicios/1%C2%BABach%20Cienc/Ejercicios%20de%20derivadas2.pdf', 'Documento', 5, 1),
(4, 'Circunferencia ', '<p>La circunferencia (o círculo) se representa en un sistema de coordenadas cartesianas mediante una ecuación cuadrática. La ecuación estándar de una circunferencia con centro en (h,k) y radio r es:</p><p><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"26px\"><msup><mrow><mo>(</mo><mi>x</mi><mo>−</mo><mi>h</mi><mo>)</mo></mrow><mn>2</mn></msup><mo>+</mo><msup><mrow><mo>(</mo><mi>y</mi><mo>−</mo><mi>k</mi><mo>)</mo></mrow><mn>2</mn></msup><mo>=</mo><msup><mi>r</mi><mn>2</mn></msup></mstyle></math></p><p>Donde:</p><ul><li>(h,k) es el centro de la circunferencia.</li><li>r es el radio de la circunferencia.</li></ul>', 'Texto', 4, 1),
(26, 'Derivadas parciales', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/XKgfHOaXhqs?si=OJqlVQE3gMGsb4X_\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'Video', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `icono` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `nombre`, `icono`) VALUES
(1, 'CALCULO DIFERENCIAL E INTEGRAL', '<ion-icon name=\"calculator\"></ion-icon>'),
(2, 'ELECTRICIDAD Y MAGNETISMO\n', '<ion-icon name=\"logo-electron\"></ion-icon>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `opcion_a` varchar(255) NOT NULL,
  `opcion_b` varchar(255) NOT NULL,
  `opcion_c` varchar(255) NOT NULL,
  `opcion_d` varchar(255) NOT NULL,
  `respuesta_correcta` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `materia_id`, `pregunta`, `imagen`, `opcion_a`, `opcion_b`, `opcion_c`, `opcion_d`, `respuesta_correcta`) VALUES
(2, 2, '<p>¿Cuál es la unidad de la constante&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><semantics><mrow><mi>a</mi></mrow><annotation encoding=\"application/x-tex\">a</annotation></semantics></math>a en la ecuación de velocidad&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><semantics><mrow><mi>v</mi><mo>=</mo><mi>a</mi><msup><mi>t</mi><mn>2</mn></msup><mo>+</mo><mi>b</mi><msup><mi>t</mi><mn>3</mn></msup></mrow><annotation encoding=\"application/x-tex\">v = at^2 + bt^3</annotation></semantics></math>?</p>', NULL, 'ms²', 's³/m', 'm/s²', 'm/s³', '3'),
(3, 2, '<p>Si un cable de 1 mm de diámetro lleva una corriente de 1.5 A, ¿cuál es su rapidez de arrastre?</p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><semantics><mrow><mn>0.6</mn><mo>×</mo><mn>1</mn><msup><mn>0</mn><mrow><mo>−</mo><mn>4</mn></mrow></msup><mtext> </mtext><mtext>m/s</mtext></mrow><annotation encoding=\"application/x-tex\">0.6 \\times 10^{-4} ', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><semantics><mrow><mn>1.0</mn><mo>×</mo><mn>1</mn><msup><mn>0</mn><mrow><mo>−</mo><mn>4</mn></mrow></msup><mtext> </mtext><mtext>m/s</mtext></mrow><annotation encoding=\"application/x-tex\">1.0 \\times 10^{-4} ', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><semantics><mrow><mn>1.4</mn><mo>×</mo><mn>1</mn><msup><mn>0</mn><mrow><mo>−</mo><mn>4</mn></mrow></msup><mtext> </mtext><mtext>m/s</mtext></mrow><annotation encoding=\"application/x-tex\">1.4 \\times 10^{-4} ', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><semantics><mrow><mn>2.5</mn><mo>×</mo><mn>1</mn><msup><mn>0</mn><mrow><mo>−</mo><mn>4</mn></mrow></msup><mtext> </mtext><mtext>m/s</mtext></mrow><annotation encoding=\"application/x-tex\">2.5 \\times 10^{-4} ', '2'),
(4, 2, '<p>¿Qué indica la ecuación&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><semantics><mrow><mi>F</mi><mo>=</mo><mi>q</mi><mo stretchy=\"false\">(</mo><mi>E</mi><mo>+</mo><mi>v</mi><mo>×</mo><mi>B</mi><mo stretchy=\"false\">)</mo></mrow><annotation encoding=\"application/x-tex\">F = q(E + v \\times B)</annotation></semantics></math>&nbsp;en física?</p>', NULL, 'Ley de Newton', 'Fuerza en presencia de campos eléctricos y magnéticos', 'Ley de Ohm', 'Fuerza gravitacional', '2'),
(5, 2, '<p>Una batería con FEM de 1.5 V cae a 0 V con una corriente de 2.4 A. ¿Cuál es su resistencia interna?</p>', NULL, '0.725Ω', '0.625Ω', '0.590Ω', '0.525Ω', '2'),
(6, 2, '<p>¿Cuál es la energía consumida por un foco de 50 W encendido por 2 horas?</p>', NULL, '360 J', '360000 J', '3600 J', '36000 J', '2'),
(7, 2, '<p>Si una celda electroquímica genera electricidad por reacción redox, ¿cómo se llama si no es reversible?</p>', NULL, 'Celda primaria', 'Celda secundaria', 'Celda concentrada', 'Celda electrolítica', '1'),
(8, 2, '<p>¿Qué fenómeno es característico de la propagación de ondas cuando se encuentran con un obstáculo?</p>', NULL, 'Reflexión', 'Difracción', 'Refracción', 'Polarización', '2'),
(9, 2, '<p>¿Cuál es la longitud de onda de una onda con frecuencia de 250 Hz y velocidad de 160 m/s?</p>', NULL, '0.64 m', '1.25 m', '2.5 m', '3.5 m', '1'),
(10, 2, '<p>¿Qué representa la intensidad de sonido medida en decibeles?</p>', NULL, 'Tiempo de la onda', 'Frecuencia de la onda', 'Nivel de presión sonora', 'Amplitud de onda', '3'),
(11, 2, '<p>Determinar el tiempo total de un viaje en coche si este recorre una distancia de 170 km y desarrolla, en los primeros 140 km, una velocidad media de 70 km/h, en tanto que en los últimos 30 km presenta una velocidad media de 50 km/h.</p>', NULL, '15 h', '26 h', '30 h', '35 h', '2'),
(12, 2, '<p>Determinar la altura que alcanza una bala de cañon, si esta se dispara hacia arriba a una velocidad de 50 m/s. Considerar g=9.81m/<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><msup><mi>S</mi><mn>2</mn></msup></math></p>', NULL, '9.8 m', '45.0 m', '127.42 m', '200.0 m', '3'),
(13, 2, '<p>¿Cómo se define la conductividad de un material?</p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>σ</mi><mo>=</mo><mn>1</mn><mo>/</mo><mi>F</mi></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>σ</mi><mo>=</mo><mn>1</mn><mo>/</mo><mi>E</mi></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>σ</mi><mo>=</mo><mn>1</mn><mo>/</mo><mi>p</mi></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>σ</mi><mo>=</mo><mn>1</mn><mo>/</mo><mi>R</mi></math>', '3'),
(14, 2, '<p>En una celda electroquímica secundaria, ¿cuál es un ejemplo típico?</p>', NULL, 'Pila alcalina', 'Batería de ácido-plomo', 'Pila de mercurio', 'Celda de combustible', '2'),
(15, 2, '<p>¿Qué es lo que define el periodo en una onda?</p>', NULL, 'Altura de onda', 'Tiempo de un ciclo completo', 'Frecuencia', 'Longitud de onda', '2'),
(16, 2, '<p>¿Cuál será la ley que relaciona la fuerza ejercida entre dos masas?</p>', NULL, 'Ley de Gravitación de Newton', 'Ley de Coulomb', 'Ley de Lenz', 'Ley de Faraday', '1'),
(17, 2, '<p>¿Cómo se calcula el flujo eléctrico sobre una superficie?</p>', NULL, 'Producto de campo magnético y área', 'Producto de área y campo eléctrico perpendicular', 'Producto de área y campo paralelo', 'Producto de densidad y volumen', '2'),
(18, 2, '<p>La diferencia de potencial en dos puntos depende de:</p>', NULL, 'Corriente y resistencia', 'Fuerza y distancia', 'Campo eléctrico y carga', 'Energía y frecuencia', '1'),
(19, 2, '<p>¿Cuál es la función de la Ley de Gauss en electrostática?</p>', NULL, 'Calcula campo magnético', 'Determina el flujo eléctrico', 'Estima la fuerza de atracción', 'Establece la frecuencia de onda', '2'),
(20, 2, '<p>¿Qué es el parámetro que mide la distancia entre puntos idénticos de una onda?</p>', NULL, 'Periodo', 'Amplitud', 'Longitud de onda', 'Frecuencia', '3'),
(21, 2, '<p>¿Qué calcula la Ley de Ohm en un circuito? de las siguientes opciónes</p>', NULL, 'Energía', 'Potencia', 'Resistencia', 'Frecuencia', '3'),
(22, 2, '<p>¿Qué fenómeno ocurre cuando una onda pasa por una abertura estrecha?</p>', NULL, 'Reflexión', 'Difracción', 'Refracción', 'Absorción', '2'),
(23, 2, '<p>¿Qué ley determina la dirección de la corriente inducida en un circuito?</p>', NULL, 'Ley de Gauss', 'Ley de Lenz', 'Ley de Faraday', 'Ley de Ampere', '2'),
(24, 2, '<p>¿Cuál es la velocidad de propagación de una onda con frecuencia 500 Hz y longitud de 2 m?</p>', NULL, '100 m/s', '1000 m/s', '200 m/s', '50 m/s', '2'),
(25, 2, '<p>¿Qué fenómeno corresponde a la separación de colores por un prisma?</p>', NULL, 'Reflexión', 'Absorción', 'Dispersión', 'Interferencia', '3'),
(26, 2, '<p>¿Cómo se relaciona la energía cinética con la velocidad en un objeto?</p>', NULL, 'Directamente con velocidad', 'Cuadrado de la velocidad', 'Inversamente con masa', 'Directamente con altura', '2'),
(27, 2, '<p>¿Qué mide la frecuencia en una onda?</p>', NULL, 'a) Cantidad de ciclos por segundo', 'b) Altura de onda', 'c) Longitud de onda', 'd) Tiempo de un ciclo', '1'),
(28, 2, '<p>El experimento de ______ permitió demostrar la conexión entre los fenómenos eléctricos y magnéticos, mediante la colocación de una brújula cerca de una corriente eléctrica.</p>', NULL, 'Faraday', 'Oersted', 'Lorentz', 'Lenz', '2'),
(29, 2, '<p>Una celda electroquímica se forma con dos conductores llamados electrodos que están sumergidos en una solución ______ cuya finalidad es producir electricidad mediante una reacción redox espontánea y se considera que es una celda electroquímica _______ si la reacción no es reversible.</p>', NULL, 'concentrada - secundaria', 'electrolítica - secundaria', 'electrolítica - primaria', 'diluida - primaria', '3'),
(30, 2, '<p>Es uno de los que son llamados “problemas típicos” de rotación:</p>', NULL, 'cuerpos circundantes', 'cuerpos rodantes', 'estocásticos', 'polímeros', '2'),
(31, 2, '<p>¿Qué propiedad permite la transmisión de electricidad en metales?</p>', NULL, 'Conductividad', 'Inductancia', 'Resistencia', 'Capacitancia', '2'),
(37, 1, '<p>La integral&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mo>∫</mo><mn>2</mn><mi>x</mi><mo>³</mo><mo>d</mo><mi>x</mi></mstyle></math>es:</p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mfrac><mrow><mn>6</mn><msup><mi>x</mi><mn>2</mn></msup></mrow><mn>3</mn></mfrac><mo>&nbsp;</mo><mo>+</mo><mo>&nbsp;</mo><mi>C</mi></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mfrac><msup><mi>x</mi><mn>3</mn></msup><mn>3</mn></mfrac><mo>&nbsp;</mo><mo>+</mo><mo>&nbsp;</mo><mi>C</mi></mstyle></math>&nbsp;', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mfrac><msup><mi>x</mi><mn>4</mn></msup><mn>2</mn></mfrac><mo>&nbsp;</mo><mo>+</mo><mo>&nbsp;</mo><mi>C</mi></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mn>2</mn><msup><mi>x</mi><mn>4</mn></msup><mo>+</mo><mi>C</mi></mstyle></math>', '3'),
(39, 1, '<p>En la siguiente integral se usa una identidad trigonométrica, identificar cuál es:&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mn>3</mn><mo>∫</mo><mfrac><mrow><mi>cos</mi><mo>&nbsp;</mo><mo>(</mo><mo>&nbsp;</mo><mi>x</mi><mo>&nbsp;</mo><mo>)</mo></mrow><mrow><mi>s</mi><mi>e</mi><mi>n</mi><mo>&nbsp;</mo><mo>(</mo><mo>&nbsp;</mo><mi>x</mi><mo>&nbsp;</mo><mo>)</mo></mrow></mfrac><mo>&nbsp;</mo><mo>=</mo><mo> </mo><mn>3</mn><mo>&nbsp;</mo><mo>∫</mo><mo>&nbsp;</mo><mi>_</mi><mi>_</mi><mi>_</mi><mi>_</mi><mi>_</mi><mi>_</mi><mi>_</mi><mi>_</mi><mo>&nbsp;</mo><mi>d</mi><mi>x</mi></mstyle></math></p>', NULL, 'tan( x )', 'cot( x )', 'sec( x )', 'csc( x )', '2'),
(41, 1, '<p>La derivada de&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mi>y</mi><mo>&nbsp;</mo><mo>=</mo><mo> </mo><msqrt><msqrt><mi>x</mi></msqrt></msqrt></mstyle></math>&nbsp;es</p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mfrac><mn>1</mn><mrow><mn>4</mn><mroot><msup><mi>x</mi><mn>3</mn></msup><mn>4</mn></mroot></mrow></mfrac></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mn>4</mn><mroot><msup><mi>x</mi><mn>3</mn></msup><mn>4</mn></mroot></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mn>3</mn><mroot><msup><mi>x</mi><mn>4</mn></msup><mn>3</mn></mroot></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mroot><msup><mi>x</mi><mn>4</mn></msup><mn>3</mn></mroot></mstyle></math>', '1'),
(42, 1, '<p>Hallar el siguiente límite&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><munder><mi>lim</mi><mrow><mi>x</mi><mo>→</mo><mn>5</mn></mrow></munder><mfrac><mrow><msup><mi>x</mi><mn>2</mn></msup><mo>-</mo><mn>25</mn></mrow><mrow><mi>x</mi><mo>-</mo><mn>5</mn></mrow></mfrac></mstyle></math></p>', NULL, '-10', '-5', '5', '10', '4'),
(43, 1, '<p>Calcular&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><munder><mi>lim</mi><mrow><mi>x</mi><mo>→</mo><mn>3</mn></mrow></munder><mo>&nbsp;</mo><mi>h</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo> </mo><mi>s</mi><mi>i</mi><mo>&nbsp;</mo><mi>h</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>&nbsp;</mo><mo>=</mo><mo> </mo><mfrac><mrow><mn>3</mn><mi>x</mi><mo>+</mo><mn>9</mn></mrow><mrow><msup><mi>x</mi><mn>2</mn></msup><mo>-</mo><mn>9</mn></mrow></mfrac></mstyle></math></p>', NULL, '2', '½', '-½', '-2', '3'),
(45, 1, '<p>Determinar el siguiente límite&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><munder><mi>lim</mi><mrow><mi>x</mi><mo>→</mo><mn>2</mn></mrow></munder><mfrac><mrow><mn>2</mn><msup><mi>x</mi><mn>2</mn></msup><mo>-</mo><mn>3</mn><mi>x</mi><mo>-</mo><mn>2</mn></mrow><mrow><mi>x</mi><mo>-</mo><mn>2</mn></mrow></mfrac></mstyle></math></p>', NULL, '2', '4', '5', '6', '3'),
(46, 1, '<p>Encuentra la derivada de&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mi>f</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>&nbsp;</mo><mo>=</mo><mo> </mo><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup><mo>-</mo><mn>5</mn><mi>x</mi><mo>+</mo><mn>7</mn></mstyle></math></p>', NULL, '6x-5', '6x+5', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mn>9</mn><msup><mi>x</mi><mn>2</mn></msup><mo>-</mo><mn>5</mn></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mn>6</mn><msup><mi>x</mi><mn>2</mn></msup><mo>-</mo><mn>5</mn><mi>x</mi></mstyle></math>', '1'),
(47, 1, '<p>Calcula f′(x) para f(x) = sin( x ) + cos( x )&nbsp;</p>', NULL, 'cos(x)−sin(x)', '-sin(x)+cos(x)', 'cos(x)+sin(x)', '-cos(x)+sin(x)', '2'),
(48, 1, '<p>Si&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mi>f</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>=</mo><mo>(</mo><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup><mo>)</mo><mo>(</mo><mi>sin</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>)</mo></mstyle></math>, ¿cuál es f′(x)?</p>', NULL, '6x sin( x )', '6x sin(x) +&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup></mstyle></math>&nbsp;cos(x)', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup></mstyle></math>&nbsp;cos(x)', '6x cos(x) -&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup></mstyle></math>&nbsp;sin(x)', '2'),
(49, 1, '<p>Determina f\'(x) para f(x) =&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><msup><mi>x</mi><mn>2</mn></msup><mrow><mn>1</mn><mo>+</mo><mi>x</mi></mrow></mfrac></mstyle></math></p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mn>1</mn><mrow><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>5</mn></mrow></mfrac></mstyle></math>', 'ln(6x+5)', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mrow><mn>6</mn><mi>x</mi></mrow><mrow><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>5</mn></mrow></mfrac></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mrow><mn>6</mn><mi>x</mi></mrow><mn>5</mn></mfrac></mstyle></math>', '3'),
(50, 1, '<p>Encuentra los puntos críticos de&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mi>f</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>=</mo><msup><mi>x</mi><mn>3</mn></msup><mo>−</mo><mn>6</mn><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>9</mn><mi>x</mi></mstyle></math></p>', NULL, 'x=1,3', 'x=0,2', 'x=2,3', 'x=1,2', '4'),
(51, 1, '<p>Si&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"24px\"><mi>s</mi><mo>(</mo><mi>t</mi><mo>)</mo><mo>=</mo><mn>4</mn><msup><mi>t</mi><mn>3</mn></msup><mo>−</mo><mn>6</mn><msup><mi>t</mi><mn>2</mn></msup><mo>+</mo><mn>2</mn><mi>t</mi></mstyle></math>, calcula la velocidad instantánea en t=2.</p>', NULL, '40', '32', '20', '12', '1'),
(52, 1, '<p>Determina si f(x)=∣x∣ es derivable en x=0.</p>', NULL, 'Sí', 'No', 'Derivable solo para x&gt;0', 'No es continua, por lo que no es derivable', '2'),
(54, 1, '<p>Encuentra&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mo>∫</mo><mo>(</mo><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup><mo>−</mo><mn>5</mn><mi>x</mi><mo>+</mo><mn>7</mn><mo>)</mo><mtext> </mtext><mi>d</mi><mi>x</mi></mstyle></math></p>', NULL, '&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>x</mi><mn>3</mn></msup><mo>−</mo><mn>2.5</mn><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>7</mn><mi>x</mi><mo>+</mo><mi>C</mi></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>x</mi><mn>3</mn></msup><mo>−</mo><mn>5</mn><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>7</mn><mo>+</mo><mi>C</mi></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>x</mi><mn>3</mn></msup><mo>−</mo><mn>5</mn><mi>x</mi><mo>+</mo><mi>C</mi></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>3</mn><msup><mi>x</mi><mn>3</mn></msup><mo>−</mo><mn>5</mn><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>7</mn><mi>x</mi><mo>+</mo><mi>C</mi></mstyle></math>', '1'),
(55, 1, '<p>Resuelve&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mo>∫</mo><mo>(</mo><mi>sin</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>+</mo><mi>cos</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>)</mo><mi>d</mi><mi>x</mi></mstyle></math></p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mo>−</mo><mi>cos</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>+</mo><mi>sin</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>+</mo><mi>C</mi></mstyle></math>', 'cos(x) - sin(x) + C', '-cos(x) - sin(x) + C', 'sin(x) - cos(x) + C', '1'),
(57, 1, '<p>Calcula&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msubsup><mo>∫</mo><mn>0</mn><mn>2</mn></msubsup><mo>(</mo><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup><mo>−</mo><mn>4</mn><mi>x</mi><mo>+</mo><mn>1</mn><mo>)</mo><mtext> </mtext><mi>d</mi><mi>x</mi></mstyle></math></p>', NULL, '-2', '4', '6', '8', '3'),
(58, 1, '<p>Encuentra el área entre las curvas&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mi>y</mi><mo>=</mo><msup><mi>x</mi><mn>2</mn></msup></mstyle></math>&nbsp;y&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mi>y</mi><mo>=</mo><mn>4</mn><mi>x</mi><mo>−</mo><msup><mi>x</mi><mn>2</mn></msup></mstyle></math>.</p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mn>32</mn><mn>3</mn></mfrac></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mn>64</mn><mn>3</mn></mfrac></mstyle></math>', '16', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mn>48</mn><mn>3</mn></mfrac></mstyle></math>', '1'),
(59, 1, '<p>Evalúa&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msubsup><mo>∫</mo><mn>1</mn><mi mathvariant=\"normal\">∞</mi></msubsup><mfrac><mn>1</mn><msup><mi>x</mi><mn>2</mn></msup></mfrac><mtext> </mtext><mi>d</mi><mi>x</mi></mstyle></math>.</p>', NULL, '1', '0.5', '2', 'Diverge', '2'),
(61, 1, '<p><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msubsup><mo>∫</mo><mn>0</mn><mn>2</mn></msubsup><mo>(</mo><msup><mi>x</mi><mn>2</mn></msup><mo>−</mo><mn>4</mn><mi>x</mi><mo>+</mo><mn>3</mn><mo>)</mo><mi>d</mi><mi>x</mi></mstyle></math></p>', NULL, '-2', '-1', '0', '1', '1'),
(62, 1, '<p><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msubsup><mo>∫</mo><mn>0</mn><mrow><mi>π</mi><mi mathvariant=\"normal\">/</mi><mn>2</mn></mrow></msubsup><mi>sin</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>&nbsp;</mo><mi>d</mi><mi>x</mi></mstyle></math></p>', NULL, '0.5', '1', 'π', 'π/4', '2'),
(63, 1, '<p>Encuentra la derivada de&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mi>f</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>&nbsp;</mo><mo>=</mo><mo>&nbsp;</mo><mn>5</mn><msup><mi>x</mi><mn>3</mn></msup><mo>&nbsp;</mo><mo>-</mo><mo>&nbsp;</mo><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>2</mn><mi>x</mi><mo>-</mo><mn>4</mn></mstyle></math></p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>15</mn><msup><mi>x</mi><mn>2</mn></msup><mo>-</mo><mn>6</mn><mi>x</mi><mo>+</mo><mn>2</mn></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>15</mn><msup><mi>x</mi><mn>3</mn></msup><mo>-</mo><mn>6</mn><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>2</mn></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>5</mn><msup><mi>x</mi><mn>2</mn></msup><mo>-</mo><mn>3</mn><mi>x</mi><mo>+</mo><mn>2</mn></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>3</mn><msup><mi>x</mi><mn>3</mn></msup><mo>-</mo><mn>2</mn><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>1</mn></mstyle></math>', '1'),
(64, 1, '<p>¿Cuál es la derivada de g(x) = sin(x)*cos(x)</p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>cos</mi><mn>2</mn></msup><mo>(</mo><mi>x</mi><mo>)</mo></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mo>-</mo><msup><mi>sin</mi><mn>2</mn></msup><mo>(</mo><mi>x</mi><mo>)</mo></mstyle></math>', 'cos(2x)', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>cos</mi><mn>2</mn></msup><mo>(</mo><mi>x</mi><mo>)</mo><mo>-</mo><msup><mi>sin</mi><mn>2</mn></msup><mo>(</mo><mi>x</mi><mo>)</mo></mstyle></math>', '3'),
(65, 1, '<p>Si&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mi>h</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>&nbsp;</mo><mo>=</mo><mo> </mo><msup><mi>e</mi><mrow><mn>2</mn><mi>x</mi></mrow></msup></mstyle></math>, ¿cuál es h\'(x)?</p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>2</mn><msup><mi>e</mi><mrow><mn>2</mn><mi>x</mi></mrow></msup></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>e</mi><mrow><mn>2</mn><mi>x</mi></mrow></msup></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>e</mi><msup><mi>x</mi><mn>2</mn></msup></msup></mstyle></math>', '2x<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>e</mi><mrow><mn>2</mn><mi>x</mi></mrow></msup></mstyle></math>', '1'),
(66, 1, '<p>La derivada de f(x) = ln(<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>x</mi><mn>2</mn></msup></mstyle></math>+1) es:</p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mrow><mn>2</mn><mi>x</mi></mrow><mrow><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>1</mn></mrow></mfrac></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mn>1</mn><mrow><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>1</mn></mrow></mfrac></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mi>x</mi><mrow><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>1</mn></mrow></mfrac></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mn>1</mn><mi>x</mi></mfrac></mstyle></math>', '1'),
(67, 1, '<p>Encuentra la derivada de&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mi>f</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>&nbsp;</mo><mo>=</mo><mo>&nbsp;</mo><msup><mi>x</mi><mn>4</mn></msup><mo>-</mo><mn>6</mn><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>47</mn></mstyle></math></p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>4</mn><msup><mi>x</mi><mn>3</mn></msup><mo>-</mo><mn>6</mn><mi>x</mi><mo>+</mo><mn>5</mn></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>4</mn><msup><mi>x</mi><mn>3</mn></msup><mo>-</mo><mn>12</mn><mi>x</mi></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>x</mi><mn>4</mn></msup><mo>-</mo><mn>12</mn><mi>x</mi><mo>+</mo><mn>47</mn></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>x</mi><mn>3</mn></msup><mo>-</mo><mn>6</mn><mi>x</mi><mo>+</mo><mn>47</mn></mstyle></math>', '2'),
(68, 1, '<p>¿Cuál es la integral indefinida de&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mi>f</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>=</mo><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup></mstyle></math>?</p>', NULL, '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mn>3</mn><msup><mi>x</mi><mn>3</mn></msup><mo>+</mo><mi>C</mi></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>x</mi><mn>3</mn></msup><mo>+</mo><mn>3</mn></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mfrac><mrow><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup></mrow><mn>2</mn></mfrac><mo>+</mo><mi>C</mi></mstyle></math>', '<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><msup><mi>x</mi><mn>3</mn></msup><mo>+</mo><mi>C</mi></mstyle></math>', '4'),
(69, 1, '<p>Encuentra el valor de la integral definida de g(x)=4x en el intervalo [0,2]</p>', NULL, '4', '6', '8', '12', '3'),
(70, 1, '<p>Calcula la integral definida de&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mi>f</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>=</mo><mn>3</mn><msup><mi>x</mi><mn>2</mn></msup></mstyle></math>en el intervalo [1,3]:</p>', NULL, '25', '24', '26', '28', '2'),
(71, 1, '<p>Encuentra el valor de la integral definida de&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mi>g</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>=</mo><mi>x</mi><msup><mi>e</mi><mi>x</mi></msup></mstyle></math>&nbsp;en el intervalo [0,1]:</p>', NULL, 'e-2', 'e-1', 'e', 'e+1', '1'),
(72, 1, '<p>Calcula la integral definida de&nbsp;<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mstyle mathsize=\"22px\"><mi>h</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>=</mo><mfrac><mn>1</mn><mrow><msup><mi>x</mi><mn>2</mn></msup><mo>+</mo><mn>1</mn></mrow></mfrac></mstyle></math>&nbsp;en el intervalo [0,1]</p>', NULL, '1', 'π/2', 'ln(2)', 'π/4', '4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados`
--

CREATE TABLE `resultados` (
  `id` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `resultado` decimal(5,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `resultados`
--

INSERT INTO `resultados` (`id`, `id_materia`, `id_alumno`, `resultado`, `fecha`) VALUES
(7, 1, 3, 30.00, '2024-08-21 17:16:38'),
(8, 2, 3, 50.00, '2024-11-13 03:49:16'),
(15, 1, 1, 30.00, '2024-08-21 18:29:20'),
(16, 2, 1, 33.33, '2024-08-21 18:29:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id_tema` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `id_materia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id_tema`, `nombre`, `id_materia`) VALUES
(1, 'Pensamiento Matemático', 1),
(2, 'Álgebra', 1),
(3, 'Geometría y Trigonometría', 1),
(4, 'Geometría Analítica', 1),
(5, 'Cálculo Diferencial', 1),
(6, 'Cálculo Integral', 1),
(7, 'Probabilidad y Estadística', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`alumno_id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materiales_apoyo`
--
ALTER TABLE `materiales_apoyo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Indices de la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_alumno` (`id_alumno`);

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id_tema`),
  ADD KEY `id_materia` (`id_materia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `materiales_apoyo`
--
ALTER TABLE `materiales_apoyo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `resultados`
--
ALTER TABLE `resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `materiales_apoyo`
--
ALTER TABLE `materiales_apoyo`
  ADD CONSTRAINT `materiales_apoyo_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id_tema`),
  ADD CONSTRAINT `materiales_apoyo_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `resultados_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resultados_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`alumno_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `temas`
--
ALTER TABLE `temas`
  ADD CONSTRAINT `temas_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
