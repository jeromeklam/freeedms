<?php
namespace FreeEDMS\Model\StorageModel;

use \FreeFW\Constants as FFCST;
use \FreeEDMS\Constants as FECST;

/**
 * Ged Document
 */
abstract class GedDocument extends \FreeEDMS\Model\StorageModel\Base
{

    /**
     * Field properties as static arrays
     * @var array
     */
    protected static $PRP_DOC_ID = [
        FFCST::PROPERTY_PRIVATE => 'doc_id',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_BIGINT,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED, FFCST::OPTION_PK],
        FFCST::PROPERTY_COMMENT => 'Identifiant PK',
        FFCST::PROPERTY_SAMPLE  => 123,
    ];

    protected static $PRP_BRK_ID = [
        FFCST::PROPERTY_PRIVATE => 'brk_id',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_BIGINT,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED, FFCST::OPTION_BROKER],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_SAMPLE  => 123,
    ];

    protected static $PRP_DOC_EXTERN_ID = [
        FFCST::PROPERTY_PRIVATE => 'doc_extern_id',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED],
        FFCST::PROPERTY_COMMENT => 'Identifiant extern du fichier sur disque',
        FFCST::PROPERTY_MAX     => 120,
        FFCST::PROPERTY_SAMPLE  => '8bcbf4e636f74ad483b725f1223baa3e',
    ];

    protected static $PRP_DOC_FILENAME = [
        FFCST::PROPERTY_PRIVATE => 'doc_filename',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED],
        FFCST::PROPERTY_COMMENT => 'Nom du fichier',
        FFCST::PROPERTY_MAX     => 260,
        FFCST::PROPERTY_SAMPLE  => 'C:\\REP1\\REP2\\Je suis un fichier.txt',
    ];

    protected static $PRP_DOC_TS = [
        FFCST::PROPERTY_PRIVATE => 'doc_ts',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_DATETIMETZ,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DOC_TO = [
        FFCST::PROPERTY_PRIVATE => 'doc_to',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_DATETIMETZ,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DOC_FROM = [
        FFCST::PROPERTY_PRIVATE => 'doc_from',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_DATETIMETZ,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DOC_DESC = [
        FFCST::PROPERTY_PRIVATE => 'doc_desc',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_TEXT,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => 'Description du fichier',
//      FFCST::PROPERTY_MAX     => 2000,
        FFCST::PROPERTY_SAMPLE  => 'je suis utile à...',
    ];

    protected static $PRP_DOC_ORIG_THEME = [
        FFCST::PROPERTY_PRIVATE => 'doc_orig_theme',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_TEXT,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_MAX     => 20,
        FFCST::PROPERTY_SAMPLE  => 'THEME',
    ];

    protected static $PRP_DOC_ORIG_TYPE = [
        FFCST::PROPERTY_PRIVATE => 'doc_orig_type',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_TEXT,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_MAX     => 20,
        FFCST::PROPERTY_SAMPLE  => 'TYPE',
    ];

    protected static $PRP_DOC_ORIG_ANYID = [
        FFCST::PROPERTY_PRIVATE => 'doc_orig_anyid',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_TEXT,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => 'identifiant unique de la source',
        FFCST::PROPERTY_MAX     => 80,
        FFCST::PROPERTY_SAMPLE  => 'DVER_FILE_VERSION_0123456789',
    ];

    /**
     * Get properties
     * @return array[]
     */
    public static function getProperties()
    {
        return [
            'doc_id'            => self::$PRP_DOC_ID,
            'brk_id'            => self::$PRP_BRK_ID,
            'doc_extern_id'     => self::$PRP_DOC_EXTERN_ID,
            'doc_filename'      => self::$PRP_DOC_FILENAME,
            'doc_ts'            => self::$PRP_DOC_TS,
            'doc_to'            => self::$PRP_DOC_TO,
            'doc_from'          => self::$PRP_DOC_FROM,
            'doc_desc'          => self::$PRP_DOC_DESC,
            'doc_orig_theme'    => self::$PRP_DOC_ORIG_THEME,
            'doc_orig_type'     => self::$PRP_DOC_ORIG_TYPE,
            'doc_orig_anyid'    => self::$PRP_DOC_ORIG_ANYID,
        ];
    }

    /**
     * Set object source
     * @return string
     */
    public static function getSource()
    {
        return 'ged_document';
    }

    /**
     * Get object short description
     * @return string
     */
    public static function getSourceComments()
    {
        return 'Ajout d\'un fichier dans la ged';
    }

    /**
     * Get autocomplete field
     * @return string
     */
    public static function getAutocompleteField()
    {
        return '';
    }

    /**
     * Get uniq indexes
     * @return array[]
     */
    public static function getUniqIndexes()
    {
        return [
            'doc_extern_id' => [
                FFCST::INDEX_FIELDS => 'doc_extern_id',
                FFCST::INDEX_EXISTS => FECST::ERROR_GED_EXTERNID_EXISTS
            ],
        ];
    }

    /**
     * Get One To many relationShips
     * @return array
     */
    public function getRelationships()
    {
        return [
            'document_versions' => [
                FFCST::REL_MODEL   => 'FreeEDMS::Model::GedDocumentVersion',
                FFCST::REL_FIELD   => 'doc_id',
                FFCST::REL_TYPE    => \FreeFW\Model\Query::JOIN_LEFT,
                FFCST::REL_COMMENT => '',
//              FFCST::REL_REMOVE  => FFCST::REL_REMOVE_CASCADE
            ]
        ];
    }
}
