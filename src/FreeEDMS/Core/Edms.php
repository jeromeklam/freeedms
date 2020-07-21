<?php
namespace FreeEDMS\Core;

use \FreeEDMS\Constants as FECST;

/**
 *
 */
class Edms implements
    \Psr\Log\LoggerAwareInterface,
    \FreeFW\Interfaces\ConfigAwareTraitInterface
{

    /**
     * comportements
     */
    use \Psr\Log\LoggerAwareTrait;
    use \FreeFW\Behaviour\ConfigAwareTrait;
//  use \FreeFW\Behaviour\EventManagerAwareTrait;
    use \FreeFW\Behaviour\ErrorTrait;
    use \FreeEDMS\Model\Behaviour\GedDocument;

    /**
     * dirname de la ged
     * @var string
     */
    static $dirname_ged = null;

    /**
     * content_file est un pointeur vers le contenu du fichier à traiter
     * @var <b>pointer string</b>
     */
    protected $content_file = null;

    /**
     *
     * @param \FreeFW\Application\Config $p_config
     * @param \Psr\Log\AbstractLogger $p_logger
     */
    public function __construct(
        \FreeFW\Application\Config $p_config = null,
        \Psr\Log\AbstractLogger $p_logger = null
    ) {
        if ($p_config) {
            $this->setAppConfig($p_config);
        } else {
            $this->setAppConfig(\FreeFW\DI\DI::getShared('config'));
        }

        if ($p_logger) {
            $this->setLogger($p_logger);
        } else {
            $this->setLogger(\FreeFW\DI\DI::getShared('logger'));
        }

        self::$dirname_ged = $this->getAppConfig()->get('ged:dirname', null);

        if (self::$dirname_ged === false || self::$dirname_ged === '' || self::$dirname_ged == null) {
            self::$dirname_ged = null;
        } else if (!is_dir(self::$dirname_ged)) {
            self::$dirname_ged = null;
        } else {
            self::$dirname_ged = rtrim(str_replace('\\', '/',  self::$dirname_ged), '/') . '/';
        }
    }

    /**
     * @desc Ajoute un fichier à la ged.
     * <br>Si aucune erreur alors doc_extern_id contient le nom du fichier stocké dans le ged.
     * @return boolean
     */
    public function addFile()
    {
        $this->_debug(__METHOD__, 'start');

        if (!$this->verifyGed()) {
        } else if (!$this->verifyDocFilename($this)) {
        } else if (!$this->verifyDocContentFile($this)) {
        } else if (!$this->verifyDocOrigs($this)) {
        } else {
            $doc_extern_id = $this->getDocOrigTheme()
                . '_' . $this->getDocOrigType()
                . '_' . $this->getDocOrigAnyid()
            ;

            if (!$this->verifyFilename($doc_extern_id)) {
                $this->addError(
                    FECST::ERROR_GED_EXTERNID_NOT_FILE,
                    sprintf(FECST::ERROR_GED_EXTERNID_NOT_FILE_TEXT,$doc_extern_id),
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );
            } else {
                $path_in_ged = str_replace('-', '/', \FreeFW\Tools\Date::getCurrentDate());

                if (\FreeFW\Tools\Dir::mkpath(self::$dirname_ged . $path_in_ged) === false) {
                    $this->addError(
                        FECST::ERROR_GED_UNABLE_TO_ARCHIVE_FILE,
                        FECST::ERROR_GED_UNABLE_TO_ARCHIVE_FILE_TEXT,
                        \FreeFW\Core\Error::TYPE_ERROR
                    );
                } else {
                    $this->setGedFilename($path_in_ged . '/' . $doc_extern_id,self::$dirname_ged);

                    if (is_file($this->getGedFilename())) {
                        $this->addError(
                            FECST::ERROR_GED_EXTERNID_EXISTS,
                            sprintf(FECST::ERROR_GED_EXTERNID_EXISTS_TEXT,$doc_extern_id),
                            \FreeFW\Core\Error::TYPE_PRECONDITION
                        );
                    } else if (@file_put_contents($this->getGedFilename(), $this->content_file) === false) {
                        $this->addError(
                            FECST::ERROR_GED_UNABLE_TO_ARCHIVE_FILE,
                            FECST::ERROR_GED_UNABLE_TO_ARCHIVE_FILE_TEXT,
                            \FreeFW\Core\Error::TYPE_ERROR
                        );
                    } else {
                        $this->setDocExternId($doc_extern_id);

                        /**
                         * @var \FreeEDMS\Model\GedDocumentVersion $ged
                         */
                        $ged = \FreeFW\DI\DI::get('FreeEDMS::Model::GedDocumentVersion');
                        $ged
                            ->setDocExternId($this->getDocExternId())
                            ->setDocFilename($this->getDocFilename())
                            ->setDocDesc($this->getDocDesc())
                            ->setDocOrigTheme($this->getDocOrigTheme())
                            ->setDocOrigType($this->getDocOrigType())
                            ->setDocOrigAnyid($this->getDocOrigAnyid())
                            ->setDverFilename($this->getDocFilename())
                            ->setDverLocal($this->getGedFilename())
                        ;

                        if (!$ged->create()) {
                            $this->addError(
                                FECST::ERROR_GED_NOT_INSERT_FILE,
                                FECST::ERROR_GED_NOT_INSERT_FILE_TEXT,
                                \FreeFW\Core\Error::TYPE_PRECONDITION
                            );

                            if ($ged->hasErrors()) {
                                $this->addErrors($ged->getErrors());
                            }
                        } else {
                            $this->_debug(__METHOD__, 'end');
                            return true;
                        }
                    }
                }
            }
        }

        $this->_debug(__METHOD__, 'end with error');
        return false;
    }

    /**
     * @desc Supprime un fichier de la ged. On commence par supprimer le fichier de la base de données de la ged.
     * <br>Puis c'est le fichier physique est supprimé si <b>AUCUNE</b> erreur n'a été trouvée.
     * <br>Pour effectuer une suppression, <b>doc_extern_id DOIT exister</b> dans ged_document en tant que donnée et physiquement.
     * <br>Si on ne veut pas tenir de cette contrainte, il faut que $p_file_must_exists soit à false.
     * @param boolean $p_file_must_exists false si l'existance du doc_extern_id n'est pas essentiel à la suppression
     * @return boolean
     */
    public function removeFile()
    {
        $this->_debug(__METHOD__, 'start');

        if (!$this->verifyGed()) {
        } else if (!$this->verifyDocExternId()) {
        } else {
            /**
             * @var \FreeEDMS\Model\GedDocument $ged
             */
            $ged = \FreeEDMS\Model\GedDocument::findFirst(
                [
                    'doc_extern_id' => $this->doc_extern_id
                ]
            );

            if (!$ged) {
                $this->addError(
                    FECST::ERROR_GED_EXTERNID_NOT_FOUND,
                    sprintf(FECST::ERROR_GED_EXTERNID_NOT_FOUND_TEXT,$this->doc_extern_id),
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );
            }

            if (!$this->hasErrors()) {
                /**
                 * @var \FreeEDMS\Model\GedDocumentVersion $ged_ver
                 */
                $ged_ver = \FreeEDMS\Model\GedDocumentVersion::findFirst(
                    [
                        'doc_id' => $ged->getDocId(),
                        'dver_parent_id' => 0
                    ]
                );

                if (!$ged_ver) {
                    $this->addError(
                        FECST::ERROR_GED_EXTERNID_NOT_FOUND,
                        sprintf(FECST::ERROR_GED_EXTERNID_NOT_FOUND_TEXT,$this->doc_extern_id),
                        \FreeFW\Core\Error::TYPE_PRECONDITION
                    );
                }
            }

            if (!$this->hasErrors()) {
                /**
                 * @var \FreeEDMS\Model\GedDocumentVersion $ged_ver
                 */
                $del_ged_ver = \FreeEDMS\Model\GedDocumentVersion::delete(
                    [
                        'dver_id' => $ged_ver->getDverId(),
                    ]
                );

                if (!$del_ged_ver) {
                    $this->addError(
                        FECST::ERROR_GED_NOT_DELETE_FILE,
                        FECST::ERROR_GED_NOT_DELETE_FILE_TEXT,
                        \FreeFW\Core\Error::TYPE_PRECONDITION
                    );

                    if ($del_ged_ver->hasErrors()) {
                        $this->addErrors($del_ged_ver->getErrors());
                    }
                }
            }

            if (!$this->hasErrors()) {
                if ($ged_ver->getDverParentId() == 0) {
                    /**
                     * @var \FreeEDMS\Model\GedDocument $ged
                     */
                    $del_ged = \FreeEDMS\Model\GedDocument::delete(
                        [
                            'doc_id' => $ged->getDocId(),
                        ]
                    );

                    if (!$del_ged) {
                        $this->addError(
                            FECST::ERROR_GED_NOT_DELETE_FILE,
                            FECST::ERROR_GED_NOT_DELETE_FILE_TEXT,
                            \FreeFW\Core\Error::TYPE_PRECONDITION
                        );

                        if ($del_ged->hasErrors()) {
                            $this->addErrors($del_ged->getErrors());
                        }
                    }
                } else {
                    // le parent_id devient le courant ?
                }
            }

            if (!$this->hasErrors()) {
                $filename = $ged_ver->getDverLocal();

                if (!is_file($filename)) { // si le fichier n'est pas un fichier, on ne fait rien !
                    return true;
                } else if (@unlink($filename)===true) {
                    $this->_debug(__METHOD__, 'end');
                    return true;
                }

                $this->logger->critical(sprintf(FECST::ERROR_GED_NOT_REMOVE_FILE_TEXT,$this->doc_extern_id));

                $this->addError(
                    FECST::ERROR_GED_NOT_REMOVE_FILE,
                    sprintf(FECST::ERROR_GED_NOT_REMOVE_FILE_TEXT,$this->doc_extern_id),
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );
            }
        }

        $this->_debug(__METHOD__, 'end with error');
        return false;
    }

    /**
     */
    public function getFile(string $p_doc_extern_id)
    {
        $this->_debug(__METHOD__, 'start');

        if (!$this->verifyGed($this)) {
        } else if (!$this->setDocExternId($p_doc_extern_id)->verifyDocExternId()) {
        } else {
            /**
             * @var \FreeEDMS\Model\GedDocument $ged
             */
            $ged = \FreeEDMS\Model\GedDocument::findFirst(
                [
                    'doc_extern_id' => $this->doc_extern_id
                ]
            );

            if (!$ged) {
                $this->addError(
                    FECST::ERROR_GED_EXTERNID_NOT_FOUND,
                    sprintf(FECST::ERROR_GED_EXTERNID_NOT_FOUND_TEXT,$this->doc_extern_id),
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );

//              if ($ged->(hasErrors)) {
//                  $this->addErrors($ged->getErrors());
//              }

                return false;
            }

            /**
             * @var \FreeEDMS\Model\GedDocumentVersion $ged_ver
             */
            $ged_ver = \FreeEDMS\Model\GedDocumentVersion::findFirst(
                [
                    'doc_id' => $ged->getDocId(),
                    'dver_parent_id' => 0
                ]
            );

            if (!$ged_ver) {
                $this->addError(
                    FECST::ERROR_GED_EXTERNID_NOT_FOUND,
                    sprintf(FECST::ERROR_GED_EXTERNID_NOT_FOUND_TEXT,$this->doc_extern_id),
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );

//              if ($ged->(hasErrors)) {
//                  $this->addErrors($ged_ver->getErrors());
//              }

                return false;
            }

            $filename = $ged_ver->getDverLocal();

            if (!is_file($filename)) {
                $this->addError(
                    FECST::ERROR_GED_EXTERNID_NOT_FILE,
                    sprintf(FECST::ERROR_GED_EXTERNID_NOT_FILE_TEXT,$this->doc_extern_id),
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );
            } else {
                $this->content_file = @file_get_contents($filename);

                if ($this->content_file === false) {
                    $this->content_file = null;

                    $this->addError(
                        FECST::ERROR_GED_GET_CONTENT_FILE,
                        FECST::ERROR_GED_GET_CONTENT_FILE_TEXT,
                        \FreeFW\Core\Error::TYPE_PRECONDITION,
                    );
                } else {
                    $this->_debug(__METHOD__, 'end');
                    return true;
                }
            }
        }

        $this->_debug(__METHOD__, 'end with error');
        return false;
    }

    /**
     * Contrôle s'il existe une ged
     * @return boolean
     */
    public function verifyGed() {
        if (!is_dir(rtrim(self::$dirname_ged,'/'))) { // si ce n'est pas un répertoire on ne fait rien !
            $this->addError(
                FECST::ERROR_GED_NOT_INSTALLED,
                FECST::ERROR_GED_NOT_INSTALLED_TEXT,
                \FreeFW\Core\Error::TYPE_PRECONDITION
            );

            return false;
        }

        return true;
    }

    /**
     * Contrôle si le filename est correct
     * @return boolean
     */
    public function verifyDocFilename() {
        if (empty($this->getDocFilename())) {
            $this->addError(
                FECST::ERROR_GED_FILENAME_IS_MANDATORY,
                FECST::ERROR_GED_FILENAME_IS_MANDATORY_TEXT,
                \FreeFW\Core\Error::TYPE_PRECONDITION
            );
        }

        return true;
    }

    /**
     * Contrôle si l'extern_id est correct
     * @return boolean
     */
    public function verifyDocExternId() {
        if (empty($this->getDocExternId())) {
            $this->addError(
                FECST::ERROR_GED_FIELD_IS_MANDATORY,
                sprintf(FECST::ERROR_GED_FIELD_IS_MANDATORY_TEXT,'extern id'),
                \FreeFW\Core\Error::TYPE_PRECONDITION
            );

            return false;
        }

        return true;
    }

    /**
     * Contrôle si l'extern_id est correct
     * @return boolean
     */
    public function verifyDocOrigs() {
        if (empty($this->getDocOrigTheme()) || empty($this->getDocOrigType()) || empty($this->getDocOrigAnyid())) {
            $this->addError(
                FECST::ERROR_GED_FIELD_IS_MANDATORY,
                sprintf(FECST::ERROR_GED_FIELD_IS_MANDATORY_TEXT,'field orig'),
                \FreeFW\Core\Error::TYPE_PRECONDITION
            );

            return false;
        }

        return true;
    }

    /**
     * Contrôle si le contenu du fichier est correct
     * @return boolean
     */
    public function verifyDocContentFile() {
        if ($this->getContentFile() === '' || $this->getContentFile() == null) {
            $this->addError(
                FECST::ERROR_GED_CONTENTFILE_IS_MANDATORY,
                FECST::ERROR_GED_CONTENTFILE_IS_MANDATORY_TEXT,
                \FreeFW\Core\Error::TYPE_PRECONDITION
            );

            return false;
        }

        return true;
    }

    /**
     * Contrôle si le nom du fichier est correct. On interdit :
     * <br> - un nom sans nom !
     * <br> - un nom > 120c
     * <br> - oun nom contenant un ':' (sinon celui-ci est créé de taille 0 et devient inéffaçable)
     * @param string $p_value nom du fichier à contrôler
     * @return boolean
     */
    public function verifyFilename($p_value) {
        if (empty($p_value) || strlen($p_value) > 120 || strpos($p_value,':')) {
            return false;
        }

        return true;
    }

    /**
     * Récupère le contenu du fichier à traiter
     * @param <b>pointer string</b> $p_value vers le contenu du fichier
     * @return \FreeEDMS\Core\Edms
     */
    public function setContentFile(&$p_value)
    {
        $this->content_file = $p_value;
        return $this;
    }
    /**
     * @return <b>pointer string</b>
     */
    public function getContentFile()
    {
        return $this->content_file;
    }

    /**
     * laisse une trace...
     *
     * @param string $p_who correspond à la méthode qui est en cours
     * @param string $p_message correspond au message qu'on désire tracer !
     * @param array $p_context
     */
    protected function _debug(string $p_who, string $p_message, array $p_context = array())
     {
        $this->logger->debug(
            str_replace(array('\\', '::'), array('.', '.'), $p_who)
            . '.' . $p_message,
            $p_context
        );
    }
}

/*
$filename = self::$dirname_ged . $this->doc_extern_id;

if (!is_file($filename) && $p_file_must_exists) { // si le fichier n'existe pas on sort
    $this->addError(
        FECST::ERROR_GED_EXTERNID_NOT_FILE,
        sprintf(FECST::ERROR_GED_EXTERNID_NOT_FILE_TEXT,$this->doc_extern_id),
        \FreeFW\Core\Error::TYPE_PRECONDITION
        );
} else {

*/