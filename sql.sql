CREATE TABLE `message` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `from_name` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `datetime` int(64) NOT NULL,
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumpning av Data i tabell `message`
--

INSERT INTO `message` (`id`, `from_name`, `from_email`, `content`, `datetime`, `viewed`, `deleted`) VALUES
(1, 'Webbits', 'info@webbits.nu', '<p>Bacon ipsum dolor sit amet fatback meatloaf jowl, sirloin ham tongue chuck. Tri-tip pastrami beef ribs turkey, andouille venison turducken filet mignon drumstick ham short loin capicola spare ribs short ribs. Venison drumstick beef ribs, chicken ribeye bresaola spare ribs shankle flank. Ball tip frankfurter chuck tail, tri-tip pig pastrami beef. Prosciutto swine short loin doner rump shank ham frankfurter. Kielbasa tri-tip flank, bacon corned beef biltong turducken pastrami sirloin shoulder beef filet mignon cow drumstick chicken.</p>', 1357502448, 1, 1),
(2, 'asd', 'asd', '<p>asd</p>', 1357514333, 1, 1),
(3, 'Hejsan', 'Hejsan', '<p>Hejsna</p>', 1357514500, 0, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `pages`
--

CREATE TABLE `pages` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `datetime` int(64) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumpning av Data i tabell `pages`
--

INSERT INTO `pages` (`id`, `name`, `content`, `datetime`, `deleted`) VALUES
(1, 'Hem', '<p>Du kan &auml;ndra denna text genom att g&aring; in p&aring; adminpanelen.</p>', 1357513634, 0),
(2, '404', '<p>Sidan du f&ouml;rs&ouml;kte g&aring; in p&aring; hittades inte.</p>', 0, 0),
(6, 'bajs', '<p>bajs</p>', 1357511000, 1),
(7, 'Jag-testar', '<p>haha</p>', 1357511893, 1),
(8, 'asd', '<p>asd</p>', 1357511955, 1),
(9, 'test', '<p>test</p>', 1357513643, 1),
(10, 'Kontakt', '<p>Du kan &auml;ndra denna text genom att g&aring; in p&aring; adminpanelen.</p>', 1357514382, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE `users` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rank` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `rank`, `deleted`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 9, 0);
