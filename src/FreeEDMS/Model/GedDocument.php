<?php
namespace FreeEDMS\Model;

use \FreeEDMS\Constants as FECST;

/**
 * Model
  */
class GedDocument extends \FreeEDMS\Model\Base\GedDocument
{

    /**
     * {@inheritDoc}
     * @see \FreeFW\Core\Model::init()
     */
    public function init()
    {
        $this
            ->setDocTs(\FreeFW\Tools\Date::getCurrentTimestamp())
            ->setDocTo($this->getDocTs())
            ->setDocFrom(null)
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
        parent::validate(); // d'abord les validations standards

        if (!$this->hasErrors()) {
            if (empty($this->getDocOrigTheme())) {
                $this->addError(
                    FECST::ERROR_GED_FIELD_IS_MANDATORY,
                    sprintf(FECST::ERROR_GED_FIELD_IS_MANDATORY_TEXT,'theme'),
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );
            }

            if (empty($this->getDocOrigType())) {
                $this->addError(
                    FECST::ERROR_GED_FIELD_IS_MANDATORY,
                    sprintf(FECST::ERROR_GED_FIELD_IS_MANDATORY_TEXT,'type'),
                    \FreeFW\Core\Error::TYPE_PRECONDITION
                );
            }

            if (empty($this->getDocOrigAnyid())) {
                $this->addError(
                    FECST::ERROR_GED_FIELD_IS_MANDATORY,
                    sprintf(FECST::ERROR_GED_FIELD_IS_MANDATORY_TEXT,'Anyid'),
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
        return true;
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
