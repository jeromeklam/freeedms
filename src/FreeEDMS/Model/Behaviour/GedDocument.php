<?php
namespace FreeEDMS\Model\Behaviour;

/**
 * Ged Document
 */
Trait GedDocument
{

    /**
     * doc_id
     * @var int
     */
    protected $doc_id= null;

    /**
     * doc_extern_id
     * @var string contient le nom extern du fichier sur disque
     */
    protected $doc_extern_id = null;

    /**
     * doc_filename
     * @var string doc_filename contient que le nom du fichier avec son extension
     */
    protected $doc_filename = null;
    /**
     * @var array[] doc_filename_pathinfo contient que le pathinfo de l'affectation de $doc_filename
     */
    protected $doc_filename_pathinfo = null;

    /**
     * doc_ts
     * @var mixed
     */
    protected $doc_ts = null;

    /**
     * doc_to
     * @var mixed
     */
    protected $doc_to = null;

    /**
     * doc_from
     * @var mixed
     */
    protected $doc_from = null;

    /**
     * doc_desc
     * @var string
     */
    protected $doc_desc = null;

    /**
     * Set doc_id
     * @param int $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setDocId($p_value)
    {
        $this->doc_id = $p_value;
        return $this;
    }
    /**
     * Get doc_id
     * @return int
     */
    public function getDocId()
    {
        return $this->doc_id;
    }

    /**
     * Set doc_extern_id
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setDocExternId($p_value)
    {
        $this->doc_extern_id = $p_value;
        return $this;
    }
    /**
     * Get doc_extern_id
     * @return string
     */
    public function getDocExternId()
    {
        return $this->doc_extern_id;
    }

    /**
     * Set doc_filename
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setDocFilename($p_value)
    {
        $this->doc_filename_pathinfo = pathinfo($p_value);
        $this->doc_filename = $this->doc_filename_pathinfo['basename'];
        return $this;
    }
    /**
     * Get doc_filename
     * @return string
     */
    public function getDocFilename()
    {
        return $this->doc_filename;
    }
    /**
     * Get pathinfo de doc_filename
     * @return []
     */
    public function getDocFilenamePathinfo()
    {
        return $this->doc_filename_pathinfo;
    }

    /**
     * Set doc_ts
     * @param mixed $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setDocTs($p_value)
    {
        $this->doc_ts = $p_value;
        return $this;
    }
    /**
     * Get doc_ts
     * @return mixed
     */
    public function getDocTs()
    {
        return $this->doc_ts;
    }

    /**
     * Set doc_to
     * @param mixed $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setDocTo($p_value)
    {
        $this->doc_to = $p_value;
        return $this;
    }
    /**
     * Get doc_to
     * @return mixed
     */
    public function getDocTo()
    {
        return $this->doc_to;
    }

    /**
     * Set doc_from
     * @param mixed $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setDocFrom($p_value)
    {
        $this->doc_from = $p_value;
        return $this;
    }
    /**
     * Get doc_from
     * @return mixed
     */
    public function getDocFrom()
    {
        return $this->doc_from;
    }

    /**
     * Set doc_desc
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setDocDesc($p_value)
    {
        $this->doc_desc = $p_value;
        return $this;
    }
    /**
     * Get doc_desc
     * @return string
     */
    public function getDocDesc()
    {
        return $this->doc_desc;
    }
}
