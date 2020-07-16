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
     * dirname de la ged en mode local !
     * @var string
     */
    protected $dirname_ged = null;

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

        $this->dirname_ged = $this->getAppConfig()->get('ged:dirname', null);

        if ($this->dirname_ged === false || $this->dirname_ged === '' || $this->dirname_ged == null) {
            $this->dirname_ged = null;
        } else if (!is_dir($this->dirname_ged)) {
            $this->dirname_ged = null;
        } else {
            $this->dirname_ged = rtrim(str_replace('\\', '/',  $this->dirname_ged), '/');
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

        if (!$this->verifyGed($this)) {
        } else if (!$this->verifyDocFilename($this)) {
        } else if (!$this->verifyDocContentFile($this)) {
        } else {
            $filename       = false;
            $doc_extern_id  = false;

            for ($i=0; $i<=8; $i++) { // on essaye 8 fois de créer un nom de fichier unique sur le disque
                $doc_extern_id = md5(uniqid(microtime(true),true));
                $filename = $this->dirname_ged . '/' . $doc_extern_id;

                if (!is_file($filename)) { // si le fichier n'existe pas on sort
                    break;
                }

                $filename = false;
                usleep(100);
            }

            if ($filename === false) {
                $this->addError(
                    FECST::ERROR_GED_IMPOSSIBLE_TO_GET_EXTERNID,
                    FECST::ERROR_GED_IMPOSSIBLE_TO_GET_EXTERNID_TEXT,
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );
            } else {
                if (@file_put_contents($filename, $this->content_file) === false) {
                    $this->addError(
                        FECST::ERROR_GED_UNABLE_TO_ARCHIVE_FILE,
                        FECST::ERROR_GED_UNABLE_TO_ARCHIVE_FILE_TEXT,
                        \FreeFW\Core\Error::TYPE_ERROR
                    );
                } else {
                    $this->setDocExternId($doc_extern_id);

                    /**
                     * @var \FreeEDMS\Model\GedDocument $ged
                     */
                    $ged= \FreeFW\DI\DI::get('FreeEDMS::Model::GedDocument');
                    $ged
                        ->setDocExternId($this->getDocExternId())
                        ->setDocFilename($this->getDocFilename())
                        ->setDocDesc($this->getDocDesc())
                    ;

                    if (!$ged->create()) {
                        $this->addError(
                            FECST::ERROR_GED_NOT_DELETE_FILE,
                            sprintf(FECST::ERROR_GED_NOT_DELETE_FILE_TEXT,$this->doc_extern_id),
                            \FreeFW\Core\Error::TYPE_PRECONDITION
                            );

                        if ($ged->hasError()) {
                            $this->addErrors($ged->hasError());
                        }
                    } else {
                        $this->_debug(__METHOD__, 'end');
                        return true;
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
    public function removeFile($p_file_must_exists = true)
    {
        $this->_debug(__METHOD__, 'start');

        if (!$this->verifyGed()) {
        } else if (!$this->verifyDocExternId()) {
        } else {
            $filename = $this->dirname_ged . '/' . $this->doc_extern_id;

            if (!is_file($filename) && $p_file_must_exists) { // si le fichier n'existe pas on sort
                $this->addError(
                    FECST::ERROR_GED_EXTERNID_NOT_FILE,
                    sprintf(FECST::ERROR_GED_EXTERNID_NOT_FILE_TEXT,$this->doc_extern_id),
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );
            } else {
                /**
                 * @var \FreeEDMS\Model\GedDocument $ged
                 */
                $ged = \FreeEDMS\Model\GedDocument::find(
                    [
                        'doc_extern_id' => $this->doc_extern_id
                    ]
                );

                if (!$ged && $p_file_must_exists) {
                    $this->addError(
                        FECST::ERROR_GED_EXTERNID_NOT_FOUND,
                        sprintf(FECST::ERROR_GED_EXTERNID_NOT_FOUND_TEXT,$this->doc_extern_id),
                        \FreeFW\Core\Error::TYPE_PRECONDITION
                    );
                } else {
                    /**
                     * @var \FreeEDMS\Model\GedDocument $ged
                     */
                    $ged = \FreeEDMS\Model\GedDocument::delete(
                        [
                            'doc_extern_id' => $this->doc_extern_id
                        ]
                    );

                    if (!$ged) {
                        $this->addError(
                            FECST::ERROR_GED_NOT_DELETE_FILE,
                            sprintf(FECST::ERROR_GED_NOT_DELETE_FILE_TEXT,$this->doc_extern_id),
                            \FreeFW\Core\Error::TYPE_PRECONDITION
                        );

                        if ($ged->hasError()) {
                            $this->addErrors($ged->hasError());
                        }
                    } else {
                        if (@unlink($filename)===true || !$p_file_must_exists) {
                            $this->_debug(__METHOD__, 'end');
                            return true;
                        }

                        $this->logger->critical(sprintf(FECST::ERROR_GED_NOT_DELETE_FILE_TEXT,$this->doc_extern_id));

                        $this->addError(
                            FECST::ERROR_GED_NOT_REMOVE_FILE,
                            FECST::ERROR_GED_NOT_REMOVE_FILE_TEXT,
                            \FreeFW\Core\Error::TYPE_PRECONDITION
                        );
                    }
                }
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
            $ged = \FreeEDMS\Model\GedDocument::find(
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

//                if ($ged->hasError()) {
//                    $this->addErrors($ged->hasError());
//                }
            } else {
                $filename = $this->dirname_ged . '/' . $this->doc_extern_id;

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
        }

        $this->_debug(__METHOD__, 'end with error');
        return false;
    }

    /**
     * Contrôle s'il existe une ged
     * @return boolean
     */
    public function verifyGed() {
        if (!is_dir($this->dirname_ged)) { // si ce n'est pas un répertoire on ne fait rien !
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
        if ($this->getDocFilename() === '' || $this->getDocFilename() == null) {
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
        if ($this->getDocExternId() === '' || $this->getDocExternId() == null) {
            $this->addError(
                FECST::ERROR_GED_EXTERNID_IS_MANDATORY,
                FECST::ERROR_GED_EXTERNID_IS_MANDATORY_TEXT,
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
     * Récupère le contenu du fichier à traiter
     * @param string $p_value vers le contenu du fichier
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