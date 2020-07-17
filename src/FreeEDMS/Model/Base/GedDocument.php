<?php
namespace FreeEDMS\Model\Base;

/**
 * Ged Document
 */
abstract class GedDocument extends \FreeEDMS\Model\StorageModel\GedDocument
{
    /**
     * Behaviour
     */
    use \FreeEDMS\Model\Behaviour\GedDocument;

    /**
     * brk_id
     * @var int
     */
    protected $brk_id = null;

    /**
     * Set brk_id
     * @param int $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setBrkId($p_value)
    {
        $this->brk_id = $p_value;
        return $this;
    }
    /**
     * Get brk_id
     * @return int
     */
    public function getBrkId()
    {
        return $this->brk_id;
    }
}
