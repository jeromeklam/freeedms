ALTER TABLE `ged_document` CHANGE `doc_extern_id` `doc_extern_id` VARCHAR(120) NOT NULL DEFAULT '';
ALTER TABLE `ged_document` ADD `doc_orig_theme` VARCHAR(20);
ALTER TABLE `ged_document` ADD `doc_orig_type` VARCHAR(20);
ALTER TABLE `ged_document` ADD `doc_orig_anyid` VARCHAR(80);

CREATE TABLE `ged_document_version` (
  `dver_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `doc_id` BIGINT(20) UNSIGNED NOT NULL,
  `dver_type` VARCHAR(20),
  `dver_filename` VARCHAR(260) NOT NULL DEFAULT '',
  `dver_mine` VARCHAR(80),
  `dver_status` VARCHAR(80),
  `dver_md5` VARCHAR(80),
  `dver_ts` TIMESTAMP NULL DEFAULT NULL,
  `dver_to` TIMESTAMP NULL DEFAULT NULL,
  `dver_from` TIMESTAMP NULL DEFAULT NULL,
  `dver_parent_id` BIGINT(20),
  `dver_storage` VARCHAR(80),
  `dver_local` VARCHAR(512),
  `dver_cloud` VARCHAR(512),
  PRIMARY KEY (`dver_id`),
  KEY `fk_dver_doc_parentid` (`doc_id`, `dver_parent_id`),
  CONSTRAINT `fk_dver_doc_parentid` FOREIGN KEY (`doc_id`) REFERENCES `ged_document` (`doc_id`)
);
