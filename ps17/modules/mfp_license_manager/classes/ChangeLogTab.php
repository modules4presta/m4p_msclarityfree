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

class ChangeLogTab extends ObjectModel {

    const TABLE_NAME = 'mfp_license_manager_change_log';


    /** @var int id category */
    public $id;

    /** @var int id module */
    public $module_id;

    /** @var string varsion */
    public $version;

    /** @var string content */
    public $content;

    /** @var string date */
    public $date;



    /** @see ObjectModel::$definition */
    public static $definition = array(
        'table' => self::TABLE_NAME,
        'primary' => 'id',
        'fields' => array(
            'id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
            'module_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
            'version' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'content' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'date' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
        )
    );





}