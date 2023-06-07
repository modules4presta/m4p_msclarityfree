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


    /** @var int id  */
    public $id;

    /** @var int id module */
    public $module_id;

    /** @var string id module 1 */
    public $module_id_1;
    /** @var string id module 2 */
    public $module_id_2;
    /** @var string id module 3 */
    public $module_id_3;
    /** @var string id module 4 */
    public $module_id_4;


    /** @see ObjectModel::$definition */
    public static $definition = array(
        'table' => self::TABLE_NAME,
        'primary' => 'id',
        'fields' => array(
            'id' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'module_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
            'module_id_1' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'module_id_2' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'module_id_3' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'module_id_4' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
        )
    );





}