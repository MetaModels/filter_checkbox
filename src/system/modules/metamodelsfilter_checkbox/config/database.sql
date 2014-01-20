-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------

--
-- Table `tl_metamodel_filtersetting`
--

CREATE TABLE `tl_metamodel_filtersetting` (
  `ynfield` char(1) NOT NULL default '1',
  `ynmode` varchar(8) NOT NULL default 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;