CREATE TABLE `ged_document` (
  `doc_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `brk_id` BIGINT(20) UNSIGNED NOT NULL,
  `doc_extern_id` VARCHAR(80) NOT NULL DEFAULT '',
  `doc_filename` VARCHAR(260) NOT NULL DEFAULT '',
  `doc_ts` TIMESTAMP NULL DEFAULT NULL,
  `doc_to` TIMESTAMP NULL DEFAULT NULL,
  `doc_from` TIMESTAMP NULL DEFAULT NULL,
  `doc_desc` LONGTEXT DEFAULT NULL,
  PRIMARY KEY (`doc_id`),
  KEY `fk_doc_broker` (`brk_id`),
  KEY `fk_doc_extern` (`doc_extern_id`)
);