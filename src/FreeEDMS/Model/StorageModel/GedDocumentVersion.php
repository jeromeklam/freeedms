<?php
namespace FreeEDMS\Model\StorageModel;

use \FreeFW\Constants as FFCST;
use \FreeEDMS\Constants as FECST;

/**
 * Ged Document Version
 */
abstract class GedDocumentVersion extends \FreeEDMS\Model\StorageModel\Base
{

    /**
     * Field properties as static arrays
     * @var array
     */
    protected static $PRP_DVER_ID = [
        FFCST::PROPERTY_PRIVATE => 'dver_id',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_BIGINT,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED, FFCST::OPTION_PK],
        FFCST::PROPERTY_COMMENT => 'Identifiant PK',
        FFCST::PROPERTY_SAMPLE  => 123,
    ];

    protected static $PRP_DOC_ID = [
        FFCST::PROPERTY_PRIVATE => 'doc_id',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_BIGINT,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_FK],
        FFCST::PROPERTY_COMMENT => 'Identifiant PK',
        FFCST::PROPERTY_SAMPLE  => 123,
        FFCST::PROPERTY_FK      => ['document' =>
            [
                FFCST::FOREIGN_MODEL => 'FreeEDMS::Model::GedDocument',
                FFCST::FOREIGN_FIELD => 'doc_id',
                FFCST::FOREIGN_TYPE  => \FreeFW\Model\Query::JOIN_LEFT
            ]
        ],
    ];

    protected static $PRP_DVER_TYPE = [
        FFCST::PROPERTY_PRIVATE => 'dver_type',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_MAX     => 20,
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DVER_FILENAME = [
        FFCST::PROPERTY_PRIVATE => 'dver_filename',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED],
        FFCST::PROPERTY_COMMENT => 'Nom du fichier',
        FFCST::PROPERTY_MAX     => 260,
        FFCST::PROPERTY_SAMPLE  => 'C:\\REP1\\REP2\\Je suis un fichier.txt',
    ];

    protected static $PRP_DVER_PARENT_ID = [
        FFCST::PROPERTY_PRIVATE => 'dver_parent_id',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_BIGINT,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_FK],
        FFCST::PROPERTY_COMMENT => 'L\'identifiant du fichier parent',
        FFCST::PROPERTY_SAMPLE  => 123,
        FFCST::PROPERTY_FK      => ['parent' =>
            [
                FFCST::FOREIGN_MODEL => 'FreeEDMS::Model::GedDocumentVersion',
                FFCST::FOREIGN_FIELD => 'dver_id',
                FFCST::FOREIGN_TYPE  => \FreeFW\Model\Query::JOIN_LEFT
            ]
        ]
    ];

    protected static $PRP_DVER_MINE = [
        FFCST::PROPERTY_PRIVATE => 'dver_mine',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_MAX     => 80,
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DVER_STATUS = [
        FFCST::PROPERTY_PRIVATE => 'dver_status',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_MAX     => 80,
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DVER_MD5 = [
        FFCST::PROPERTY_PRIVATE => 'dver_md5',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_MAX     => 80,
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DVER_STORAGE = [
        FFCST::PROPERTY_PRIVATE => 'dver_storage',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_MAX     => 80,
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DVER_LOCAL = [
        FFCST::PROPERTY_PRIVATE => 'dver_local',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_MAX     => 512,
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DVER_CLOUD = [
        FFCST::PROPERTY_PRIVATE => 'dver_cloud',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_MAX     => 512,
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DVER_TS = [
        FFCST::PROPERTY_PRIVATE => 'dver_ts',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_DATETIMETZ,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DVER_TO = [
        FFCST::PROPERTY_PRIVATE => 'dver_to',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_DATETIMETZ,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    protected static $PRP_DVER_FROM = [
        FFCST::PROPERTY_PRIVATE => 'dver_from',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_DATETIMETZ,
        FFCST::PROPERTY_OPTIONS => [],
        FFCST::PROPERTY_COMMENT => '',
        FFCST::PROPERTY_SAMPLE  => '',
    ];

    /**
     * Get properties
     * @return array[]
     */
    public static function getProperties()
    {
        return [
            'dver_id'           => self::$PRP_DVER_ID,
            'doc_id'            => self::$PRP_DOC_ID,
            'dver_type'         => self::$PRP_DVER_TYPE,
            'dver_filename'     => self::$PRP_DVER_FILENAME,
            'dver_parent_id'    => self::$PRP_DVER_PARENT_ID,
            'dver_mine'         => self::$PRP_DVER_MINE,
            'dver_status'       => self::$PRP_DVER_STATUS,
            'dver_md5'          => self::$PRP_DVER_MD5,
            'dver_storage'      => self::$PRP_DVER_STORAGE,
            'dver_local'        => self::$PRP_DVER_LOCAL,
            'dver_cloud'        => self::$PRP_DVER_CLOUD,
            'dver_ts'           => self::$PRP_DVER_TS,
            'dver_to'           => self::$PRP_DVER_TO,
            'dver_from'         => self::$PRP_DVER_FROM,
        ];
    }

    /**
     * Set object source
     * @return string
     */
    public static function getSource()
    {
        return 'ged_document_version';
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
        return [];
    }

    /**
     * Get One To many relationShips
     * @return array
     */
    public function getRelationships()
    {
        return [];
    }
}
