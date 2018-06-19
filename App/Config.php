<?php

namespace App;
use App\Models\Language;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{
//    Host db.fairsoft.nl
//    Database md416377db426094
//    Wachtwoord #^27FtEIoEMH5Nne
//    Gebruiker md416377db426094

    /**
     * Database host
     * @var string
     */
    const DB_HOST = '178.251.31.13:3306';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'liannela_fsdb2';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'liannela_superuser';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '6Z0wKRrPyg';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = false;

    /**
     * The default locale
     * @var string
     */
    const DEFAULT_LOCALE = 'nl_NL';
}
