<?php
namespace FreeEDMS\Model;

use \FreeEDMS\Constants as FECST;

/**
 * Model
  */
class GedDocumentVersion extends \FreeEDMS\Model\Base\GedDocumentVersion
{
    /**
     * Behaviour
     */
    use \FreeEDMS\Model\Behaviour\GedDocument;

    /**
     * {@inheritDoc}
     * @see \FreeFW\Core\Model::init()
     */
    public function init()
    {
        $this
            ->setDverTs(\FreeFW\Tools\Date::getCurrentTimestamp())
            ->setDverTo($this->getDverTs())
            ->setDverFrom(null)
            ->setDverParentId(0)
        ;

        return $this;
    }

    /**
     * Validation
     *
     * @return void
     */
    public function validate()
    {
        parent::validate();

        if (!$this->hasErrors()) {
            if (empty($this->getDverLocal())) {
                $this->addError(
                    FECST::ERROR_GED_FIELD_IS_MANDATORY,
                    sprintf(FECST::ERROR_GED_FIELD_IS_MANDATORY_TEXT,'dver_local'),
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );
            }
        }
    }

    /**
     *
     * @return boolean
     */
    public function beforeCreate()
    {
        /**
         *
         * @var \FreeEDMS\Model\GedDocument $ged
         */

        $ged = \FreeFW\DI\DI::get('FreeEDMS::Model::GedDocument');

        $ged
            ->setDocExternId($this->getDocExternId())
            ->setDocFilename($this->getDocFilename())
            ->setDocDesc($this->getDocDesc())
            ->setDocOrigTheme($this->getDocOrigTheme())
            ->setDocOrigType($this->getDocOrigType())
            ->setDocOrigAnyid($this->getDocOrigAnyid())
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
            $this->setDocId($ged->getDocId());
            return true;
        }

        return false;
    }

    /**
     *
     * @return boolean
     */
    public function afterCreate()
    {
        return true;
    }
}
