<?php
namespace FreeEDMS;

/**
 * Constantes générales
 */
class Constants
{

    /**
     * Regex
     * @var string
     */
    const PARAM_REGEX = '[0-9A-Za-z_\-\.\@\%]*';

    /**
     * équivalent du PATHINFO
     * @var string
     */
    const GED_FULLNAME      = 'fullname';
    const GED_COMPLETENAME  = 'fullname_with_ged';
    const GED_PATHINFO      = 'pathinfo';
    const GED_DIRNAME       = 'dirname';
    const GED_BASENAME      = 'basename';
    const GED_EXTENSION     = 'extension';
    const GED_FILENAME      = 'filename';

    /**
     * Errors types
     * @var int
     */
    const ERROR_GED_NOT_INSTALLED                   = 760001;
    const ERROR_GED_EXTERNID_EXISTS                 = 760002;
    const ERROR_GED_FILENAME_IS_MANDATORY           = 760003;
    const ERROR_GED_FIELD_IS_MANDATORY              = 760004;
    const ERROR_GED_EXTERNID_NOT_FILE               = 760005;
    const ERROR_GED_UNABLE_TO_ARCHIVE_FILE          = 760006;
//  const ERROR_GED_                                = 760007;
    const ERROR_GED_NOT_DELETE_FILE                 = 760008;
    const ERROR_GED_CONTENTFILE_IS_MANDATORY        = 760009;
    const ERROR_GED_NOT_REMOVE_FILE                 = 760010;
    const ERROR_GED_FILE_NOT_FOUND                  = 760011;
    const ERROR_GED_GET_CONTENT_FILE                = 760012;
    const ERROR_GED_EXTERNID_NOT_FOUND              = 760013;
    const ERROR_GED_NOT_INSERT_FILE                 = 760014;

    /**
     * Textes errors
     * @var string
     */
    const ERROR_GED_NOT_INSTALLED_TEXT                   = 'ged not installed !';
    const ERROR_GED_EXTERNID_EXISTS_TEXT                 = 'extern id %s already exists !';
    const ERROR_GED_FILENAME_IS_MANDATORY_TEXT           = 'filename is mandatory for ged !';
    const ERROR_GED_FIELD_IS_MANDATORY_TEXT              = '%s is mandatory for ged !';
    const ERROR_GED_EXTERNID_NOT_FILE_TEXT               = 'extern id %s is not a file for ged !';
    const ERROR_GED_UNABLE_TO_ARCHIVE_FILE_TEXT          = 'unable to archive file in ged !';
//  const ERROR_GED_ _TEXT                               =
    const ERROR_GED_NOT_DELETE_FILE_TEXT                 = 'unable to delete file from ged !';
    const ERROR_GED_CONTENTFILE_IS_MANDATORY_TEXT        = 'content file can\'t be empty for ged !';
    const ERROR_GED_NOT_REMOVE_FILE_TEXT                 = 'impossible to remove the file %s from ged !';
    const ERROR_GED_FILE_NOT_FOUND_TEXT                  = 'file %s not found in ged !';
    const ERROR_GED_GET_CONTENT_FILE_TEXT                = 'error while get content file in ged !';
    const ERROR_GED_EXTERNID_NOT_FOUND_TEXT              = 'extern id %s not found in ged !';
    const ERROR_GED_NOT_INSERT_FILE_TEXT                 = 'impossible to insert file in ged !';
}