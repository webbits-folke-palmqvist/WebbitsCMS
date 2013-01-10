--
-- Tabellstruktur `message`
--

CREATE TABLE `message` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `from_name` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `datetime` int(64) NOT NULL,
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `message`
--

INSERT INTO `message` (`id`, `from_name`, `from_email`, `content`, `datetime`, `viewed`, `deleted`) VALUES
(1, 'Webbits', 'info@webbits.nu', '<p>Hejsan!</p>\n<p>Hoppas du gillar ditt CMS som vi p&aring; webbits har gjort!</p>', 1357502448, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumpning av Data i tabell `pages`
--

INSERT INTO `pages` (`id`, `name`, `content`, `datetime`, `deleted`) VALUES
(1, 'Hem', '<p>Du kan &auml;ndra denna text genom att g&aring; in p&aring; adminpanelen.</p>', 1357764486, 0),
(2, '404', '<p>Sidan du f&ouml;rs&ouml;kte g&aring; in p&aring; hittades inte.</p>', 0, 0),
(3, 'Kontakt', '<p>Du kan &auml;ndra denna text genom att g&aring; in p&aring; adminpanelen.</p>', 1357514382, 0);

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
