<?php
namespace FreeEDMS\Model\Behaviour;

use \FreeEDMS\Constants as FECST;

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
     * @var array[] doc_filename_pathinfo contient le pathinfo de l'affectation de $doc_filename
     */
    protected $doc_filename_pathinfo = null;
    /**
     * @var string doc_filename_fullname contient le nom complet envoyé à $doc_filename
     */
    protected $doc_filename_fullname = null;

    /**
     * ged_filename
     * @var string ged_filename contient que le nom du fichier utilisé par la ged
     */
    protected $ged_filename = null;
    /**
     * @var array[] ged_filename_pathinfo contient le pathinfo en lien avec $doc_filename stocké dans la ged
     */
    protected $ged_filename_pathinfo = null;
    /**
     * @var string ged_filename_fullname contient le nom complet en lien avec $doc_filename utilisé par la ged
     */
    protected $ged_filename_fullname = null;

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
     * doc_orig_theme
     * @var string
     */
    protected $doc_orig_theme = null;

    /**
     * doc_orig_type
     * @var string
     */
    protected $doc_orig_type = null;

    /**
     * doc_orig_anyid
     * @var string
     */
    protected $doc_orig_anyid = null;

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
        $this->doc_filename_fullname = $p_value;
        $this->doc_filename_pathinfo = pathinfo($p_value);
        $this->doc_filename = $this->getDocFilename();
        return $this;
    }
    /**
     * Get doc_filename
     * @param int $p_option GED_[DIRNAME | <b>BASENAME</b> | EXTENSION | FILENAME | PATHINFO | FULLNAME ]
     * @return mixed false ou pathinfo[] ou un élément suivant le mot clé utilisé
     */
    public function getDocFilename($p_option = FECST::GED_BASENAME)
    {
        switch ($p_option) {
            case FECST::GED_BASENAME :
            case FECST::GED_DIRNAME :
            case FECST::GED_EXTENSION :
            case FECST::GED_FILENAME :
                return $this->doc_filename_pathinfo[$p_option];
                break;

            case FECST::GED_FULLNAME :
                return $this->doc_filename_fullname;
                break;

            case FECST::GED_PATHINFO :
                return $this->doc_filename_pathinfo;
                break;
        }

        return false;
    }
    /**
     * Set ged_filename
     * @param string $p_value fichier avec ou sans chemin du fichier dans la ged
     * @param string $p_dirname_ged racine permettant de contruire un nom complet pour accéder au fichier dans la ged
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setGedFilename($p_value)
    {
        $this->ged_filename_fullname = $p_value;
        $this->ged_filename_pathinfo = pathinfo($p_value);
        $this->ged_filename = $this->getGedFilename(FECST::GED_BASENAME);
        return $this;
    }
    /**
     * Get ged_filename
     *
     * @param int $p_option GED_[DIRNAME | BASENAME | EXTENSION | FILENAME | PATHINFO | FULLNAME | <b>COMPLETENAME</b>]
     * @return mixed false ou pathinfo[] ou un élément suivant le mot clé utilisé
     */
    public function getGedFilename($p_option = FECST::GED_COMPLETENAME)
    {
        switch ($p_option) {
            case FECST::GED_BASENAME :
                return $this->ged_filename;
                break;

            case FECST::GED_DIRNAME :
            case FECST::GED_EXTENSION :
            case FECST::GED_FILENAME :
                return $this->ged_filename_pathinfo[$p_option];
                break;

            case FECST::GED_FULLNAME :
                return $this->ged_filename_fullname;
                break;

            case FECST::GED_COMPLETENAME :
                return \FreeEDMS\Core\Edms::$dirname_ged . $this->ged_filename_fullname;
                break;

            case FECST::GED_PATHINFO :
                return $this->ged_filename_pathinfo;
                break;
        }

        return false;
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

    /**
     * Set doc_orig_theme
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setDocOrigTheme($p_value)
    {
        $this->doc_orig_theme = $p_value;
        return $this;
    }
    /**
     * Get doc_orig_theme
     * @return string
     */
    public function getDocOrigTheme()
    {
        return $this->doc_orig_theme;
    }

    /**
     * Set doc_orig_type
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setDocOrigType($p_value)
    {
        $this->doc_orig_type = $p_value;
        return $this;
    }
    /**
     * Get doc_orig_type
     * @return string
     */
    public function getDocOrigType()
    {
        return $this->doc_orig_type;
    }

    /**
     * Set doc_orig_anyid
     * @param string $p_value
     * @return \FreeEDMS\Model\GedDocument
     */
    public function setDocOrigAnyid($p_value)
    {
        $this->doc_orig_anyid = $p_value;
        return $this;
    }
    /**
     * Get doc_orig_anyid
     * @return string
     */
    public function getDocOrigAnyid()
    {
        return $this->doc_orig_anyid;
    }
}
