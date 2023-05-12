<?php
/**
 * LICENCE
 *
 * ALL RIGHTS RESERVED.
 * YOU ARE NOT ALLOWED TO COPY/EDIT/SHARE/WHATEVER.
 *
 * IN CASE OF ANY PROBLEM CONTACT AUTHOR.
 *
 *  @author    Jakub Przepióra (kontakt@nice-code.eu)
 *  @copyright nice-code.pl
 *  @license   ALL RIGHTS RESERVED
 */
require_once __DIR__.'/../mfp_msc_clarity.php';

class ManageSqlMSCclarity {

    public $sqlQueries = [];
    public $prefix_table = 'mfp_license_manager';
    public array $DB_tables = ["mfp_license_manager_clients","mfp_license_manager_clients_domains","mfp_license_manager_modules","mfp_license_manager_change_log"];

    public function installQuaries()
    {
        $this->sqlQueries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$this->prefix_table.'_clients` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `client_id` int(10) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';

        $this->sqlQueries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$this->prefix_table.'_clients_domains` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `client_id` int(10) NOT NULL,
				  `domain` VARCHAR(255) NOT NULL,
				  `module_id` int(10) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';


        $this->sqlQueries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$this->prefix_table.'_modules` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `module_name` VARCHAR(255) NOT NULL,
				  `currently_version` VARCHAR(255) NOT NULL,
				  `change_log_id` int(10) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';


        $this->sqlQueries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$this->prefix_table.'_change_log` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `module_id` VARCHAR(255) NOT NULL,
				  `version` VARCHAR(255) NOT NULL,
				  `content` VARCHAR(1000) NOT NULL,
				  `date` VARCHAR(20) NOT NULL,
				  
				  PRIMARY KEY (`id`)
				) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';

        foreach ($this->sqlQueries as $query) {
            if (Db::getInstance()->execute($query) === false) {
                return false;
            }
        }
        return true;
    }

    public function uninstallQueries()
    {


        foreach ($this->DB_tables as $table) {
            if (Db::getInstance()->execute("DROP TABLE IF EXISTS `".mfp_license_manager::getPrefixDb().$table."`;") === false) {
                return false;
            }
        }
        return true;
    }
}