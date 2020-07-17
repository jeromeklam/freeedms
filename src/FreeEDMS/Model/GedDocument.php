<?php
namespace FreeEDMS\Model;

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
            ->setDocFrom($this->getDocTs())
        ;

        return $this;
    }
}
