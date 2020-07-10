<?php
namespace FreeEDMS\Console;

/**
 * FreeFW commands
 *
 * @author jeromeklam
 */
class FreeFW
{

    /**
     * Retourne une liste de commandes au format FreeFW
     *
     * @return \FreeFW\Console\CommandCollection
     */
    public static function getCommands()
    {
        $commands = new \FreeFW\Console\CommandCollection();
        $paths    = [];
        $paths[]  = __DIR__ . '/../resource/commands/v1/commands.php';
        foreach ($paths as $idx => $onePath) {
            if (is_file($onePath)) {
                $myCommands = @include($onePath);
                if (is_array($myCommands)) {
                    foreach ($myCommands as $idx => $oneCommand) {

                    }
                }
            }
        }
        return $commands;
    }
}
