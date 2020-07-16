<?php
namespace FreeEDMS\Model\StorageModel;

/**
 * Cause
 *
 * @author jeromeklam
 */
abstract class Base extends \FreeFW\Core\StorageModel
{

    /**
     * Add to queue, websocket, ?
     *
     * @return boolean
     */
    public function forwardStorageEvent()
    {
        return true;
    }
}
