<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 20:58
 */

namespace A12\Interfaces\Request;


use Garden\Cli\Args;

interface RequestInterface
{
    const ARG_PAIR_DELIMITER        = ' ';
    const ARG_VALUE_DELIMITER       = '=';
    //
    const FLAG_FORCE_EXECUTING      = 'force';
    const FLAG_CONFIRM_EXECUTING    = 'confirm';
    const FLAG_SILENT_EXECUTING     = 'silent';
    const FLAG_VERBOSE_EXECUTING    = 'verbose';
    const FLAG_HELP                 = 'help';
    //
    const KEY_ID                    = 'id';
    const KEY_CLI                   = 'cli';
    
    public function hasAttribute($key): bool;
    public function getAttribute($key);
    public function setAttribute($key, $value) : RequestInterface;
    // ------- ------- ------- ------- ------- ------- -------
    public function cliArgs() : Args;
    public function getCommand();
    public function getArg($index, $default = null);
    public function getOpt($index, $default = null);
    // ------- ------- ------- ------- ------- ------- -------
    public function isForceMode();
    public function isSilentMode();
    public function isVerboseMode();
    // ------- ------- ------- ------- ------- ------- -------
    public function dump(): array;
}