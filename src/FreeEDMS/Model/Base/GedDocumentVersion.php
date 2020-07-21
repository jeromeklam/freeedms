<?php
namespace FreeEDMS\Model\Base;

/**
 * Ged Document
 */
abstract class GedDocumentVersion extends \FreeEDMS\Model\StorageModel\GedDocumentVersion
{

    /**
     * dver_id
     * @var int
     */
    protected $dver_id = null;

    /**
     * doc_id
     * @var int
     */
    protected $doc_id = null;

    /**
     * dver_type
     * @var string
     */
    protected $dver_type = null;

    /**
     * dver_filename
     * @var string
     */
    protected $dver_filename = null;

    /**
     * dver_mine
     * @var string
     */
    protected $dver_mine = null;

    /**
     * dver_status
     * @var string
     */
    protected $dver_status = null;

    /**
     * dver_md5
     * @var string
     */
    protected $dver_md5= null;

    /**
     * dver_ts
     * @var mixed
     */
    protected $dver_ts = null;

    /**
     * dver_to
     * @var mixed
     */
    protected $dver_to = null;

    /**
     * dver_from
     * @var mixed
     */
    protected $dver_from = null;

    /**
     * dver_parent_id
     * @var int
     */
    protected $dver_parent_id = null;

    /**
     * dver_storage
     * @var string
     */
    protected $dver_storage = null;

    /**
     * dver_local
     * @var string
     */
    protected $dver_local = null;

    /**
     * dver_cloud
     * @var string
     */
    protected $dver_cloud = null;

    /**
     * Set dver_id
     * @param int $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverId($p_value)
    {
        $this->dver_id = $p_value;
        return $this;
    }
    /**
     * Get dver_id
     * @return int
     */
    public function getDverId()
    {
        return $this->dver_id;
    }

    /**
     * Set doc_id
     * @param int $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
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
     * Set dver_type
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverType($p_value)
    {
        $this->dver_type = $p_value;
        return $this;
    }
    /**
     * Get dver_type
     * @return string
     */
    public function getDverType()
    {
        return $this->dver_type;
    }

    /**
     * Set dver_filename
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverFilename($p_value)
    {
        $this->dver_filename = $p_value;
        return $this;
    }
    /**
     * Get dver_filename
     * @return string
     */
    public function getDverFilename()
    {
        return $this->dver_filename;
    }

    /**
     * Set dver_mine
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverMine($p_value)
    {
        $this->dver_mine = $p_value;
        return $this;
    }
    /**
     * Get dver_mine
     * @return string
     */
    public function getDverMine()
    {
        return $this->dver_mine;
    }

    /**
     * Set dver_status
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverStatus($p_value)
    {
        $this->dver_status = $p_value;
        return $this;
    }
    /**
     * Get dver_status
     * @return string
     */
    public function getDverStatus()
    {
        return $this->dver_status;
    }

    /**
     * Set dver_md5
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverMd5($p_value)
    {
        $this->dver_md5 = $p_value;
        return $this;
    }
    /**
     * Get dver_md5
     * @return string
     */
    public function getDverMd5()
    {
        return $this->dver_md5;
    }

    /**
     * Set dver_ts
     * @param mixed $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverTs($p_value)
    {
        $this->dver_ts = $p_value;
        return $this;
    }
    /**
     * Get dver_ts
     * @return mixed
     */
    public function getDverTs()
    {
        return $this->dver_ts;
    }

    /**
     * Set dver_to
     * @param mixed $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverTo($p_value)
    {
        $this->dver_to = $p_value;
        return $this;
    }
    /**
     * Get dver_to
     * @return mixed
     */
    public function getDverTo()
    {
        return $this->dver_to;
    }

    /**
     * Set dver_from
     * @param mixed $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverFrom($p_value)
    {
        $this->dver_from = $p_value;
        return $this;
    }
    /**
     * Get dver_from
     * @return mixed
     */
    public function getDverFrom()
    {
        return $this->dver_from;
    }

    /**
     * Set dver_parent_id
     * @param int $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverParentId($p_value)
    {
        $this->dver_parent_id = $p_value;
        return $this;
    }
    /**
     * Get dver_parent_id
     * @return string
     */
    public function getDverParentId()
    {
        return $this->dver_parent_id;
    }

    /**
     * Set dver_storage
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverStorage($p_value)
    {
        $this->dver_storage = $p_value;
        return $this;
    }
    /**
     * Get dver_storage
     * @return string
     */
    public function getDverStorage()
    {
        return $this->dver_storage;
    }

    /**
     * Set dver_local
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverLocal($p_value)
    {
        $this->dver_local = $p_value;
        return $this;
    }
    /**
     * Get dver_local
     * @return string
     */
    public function getDverLocal()
    {
        return $this->dver_local;
    }

    /**
     * Set dver_cloud
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocumentVersion
     */
    public function setDverCloud($p_value)
    {
        $this->dver_cloud = $p_value;
        return $this;
    }
    /**
     * Get dver_cloud
     * @return string
     */
    public function getDverCloud()
    {
        return $this->dver_cloud;
    }
}
