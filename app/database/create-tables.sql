CREATE TABLE IF NOT EXISTS `daily_candlesticks_fo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `symbol` varchar(10) NOT NULL,
  `series` char(2) NOT NULL,
  `open` decimal(8,2) unsigned NOT NULL,
  `high` decimal(8,2) unsigned NOT NULL,
  `low` decimal(8,2) unsigned NOT NULL,
  `close` decimal(8,2) unsigned NOT NULL,
  `last` decimal(8,2) unsigned NOT NULL,
  `prevclose` decimal(8,2) unsigned NOT NULL,
  `tottrdqty` bigint(20) unsigned NOT NULL,
  `tottrdval` bigint(20) unsigned NOT NULL,
  `timestamp` date NOT NULL,
  `totaltrades` mediumint(8) unsigned NOT NULL,
  `isin` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`),
  KEY `symbol` (`symbol`),
  KEY `isin` (`isin`),
  KEY `series` (`series`) 
);

CREATE TABLE IF NOT EXISTS `trading_holidays` (
  `market` varchar(10) NOT NULL,
  `holidaydate` date NOT NULL,
  PRIMARY KEY (market, holidaydate)
);

CREATE TABLE IF NOT EXISTS `daily_candlesticks_fo_calculations` (
  `symbol` varchar(10) NOT NULL,
  `market` varchar(10) NOT NULL DEFAULT 'NSE',
  `recorddate` date NOT NULL,
  `change` decimal(8,2) unsigned,
  `change_percent` decimal(8,2) unsigned,
  `volavg50` decimal(8,2) unsigned,
  `ma20` decimal(8,2) unsigned ,
  `ma50` decimal(8,2) unsigned ,
   
   PRIMARY KEY (symbol,market, recorddate)
);

