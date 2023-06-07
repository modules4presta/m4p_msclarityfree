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

class AdsForModules extends ObjectModel {

    const TABLE_NAME = 'mfp_license_manager_ads_modules';


    /** @var int id category */
    public $id;

    /** @var int id module */
    public $module_id;

    /** @var string content */
    public $content;





    /** @see ObjectModel::$definition */
    public static $definition = array(
        'table' => self::TABLE_NAME,
        'primary' => 'id',
        'fields' => array(
            'id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
            'module_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
            'content' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
        )
    );





}