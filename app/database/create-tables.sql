CREATE DATABASE IF NOT EXISTS stockwatchdb;
USE stockwatchdb;
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
  `open` decimal(8,2) unsigned NOT NULL,
  `high` decimal(8,2) unsigned NOT NULL,
  `low` decimal(8,2) unsigned NOT NULL,
  `close` decimal(8,2) unsigned NOT NULL,
  `prevclose` decimal(8,2) unsigned NOT NULL,
  `volume` bigint(20) unsigned NOT NULL,
  `candle_body` decimal(8,2) unsigned ,
  `candle_height` decimal(8,2) unsigned ,
  `change_value` decimal(8,2) NOT NULL ,
  `change_percent` decimal(8,2) NOT NULL,
  `volavg50` bigint(20) unsigned NOT NULL,
  `ma20` decimal(8,2) unsigned NOT NULL,
  `ma50` decimal(8,2) unsigned NOT NULL,
  `avg_candle_body_50` decimal(8,2) unsigned NOT NULL,
  `avg_candle_height_50` decimal(8,2) unsigned NOT NULL,
   PRIMARY KEY (symbol,market, recorddate)
);



/* SQL for new database design */

/* Creating Data Tables ******************************** START ********************************/

CREATE TABLE IF NOT EXISTS `data_quandl_daily_liquid_options`(
	`recorddate` date NOT NULL,
	`symbol` varchar(256) NOT NULL,
	`open` decimal(12,4) unsigned NOT NULL,
	`high` decimal(12,4) unsigned NOT NULL,
	`low` decimal(12,4) unsigned NOT NULL,
	`close` decimal(12,4) unsigned NOT NULL,
	`volume` bigint(40) unsigned NOT NULL,
	PRIMARY KEY (recorddate,symbol)
);

/* Creating Data Tables ******************************** END ********************************/

/* Creating Watchlist Tables *************************** START ******************************/

CREATE TABLE IF NOT EXISTS `watchlist_liquid_options`(
	`sl_no` int NOT NULL AUTO_INCREMENT,
	`symbol` varchar(256) NOT NULL,
	`company_name` varchar(256),
	PRIMARY KEY (sl_no,symbol)
);
 ALTER TABLE `watchlist_liquid_options` AUTO_INCREMENT = 1;
 
 CREATE TABLE IF NOT EXISTS `watchlist_nifty_500` (
  `company_name` varchar(256) NOT NULL,
  `industry` varchar(256) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `series` varchar(2) NOT NULL,
  `isin` varchar(12) NOT NULL,
  PRIMARY KEY (symbol,series)
);

CREATE TABLE IF NOT EXISTS `watchlist_nifty_fo` (
  `symbol` varchar(10) NOT NULL,
  `series` varchar(2) NOT NULL DEFAULT 'EQ',
   PRIMARY KEY (symbol)
);

/* Creating Watchlist Tables *************************** END *******************************/

/* Creating Calculation Tables *************************** START ******************************/

CREATE TABLE IF NOT EXISTS `calculations_daily_liquid_options` (
  `symbol` varchar(10) NOT NULL,
  `market` varchar(10) NOT NULL DEFAULT 'NSE',
  `recorddate` date NOT NULL,
  `open` decimal(8,2) unsigned NOT NULL,
  `high` decimal(8,2) unsigned NOT NULL,
  `low` decimal(8,2) unsigned NOT NULL,
  `close` decimal(8,2) unsigned NOT NULL,
  `prevclose` decimal(8,2) unsigned NOT NULL,
  `volume` bigint(20) unsigned NOT NULL,
  `candle_body` decimal(8,2) unsigned ,
  `candle_height` decimal(8,2) unsigned ,
  `candle_type` varchar(50),
  `change_value` decimal(8,2) NOT NULL ,
  `change_percent` decimal(8,2) NOT NULL,
  `volavg50` bigint(20) unsigned NOT NULL,
  `ma20` decimal(8,2) unsigned NOT NULL,
  `ma50` decimal(8,2) unsigned NOT NULL,
  `avg_candle_body_50` decimal(8,2) unsigned NOT NULL,
  `avg_candle_height_50` decimal(8,2) unsigned NOT NULL,
   PRIMARY KEY (symbol,market, recorddate)
);

/* Creating Calculation Tables *************************** END ******************************/

