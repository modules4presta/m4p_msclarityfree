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
require_once dirname(__FILE__) . '/../../classes/AdsForModules.php';
class AdminAdsForModulesController extends ModuleAdminControllerCore
{



    /** @var int id category */
    public $id;

    /** @var int id module */
    public $module_id;

    /** @var string id module 4 */
    public $module_id_4;

    /** @var string id module 3 */
    public $module_id_3;

    /** @var string id module 2 */
    public $module_id_2;

    /** @var string id module 1 */
    public $module_id_1;



    const TABLE_NAME = 'mfp_license_manager_ads_modules';

    public function __construct()
    {

        $this->context = Context::getContext();
        $this->table = 'mfp_license_manager_ads_modules';
        $this->identifier = 'id';
        $this->className = 'AdsForModules';
        $this->_defaultOrderBy = 'module_id';
        $this->lang = false;
        $this->bootstrap = true;
//        $this->explicitSelect = true;

        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->bulk_actions = array('delete' => array(
            'text' => 'Delete selected',
            'confirm' => 'Delete selected items?'
        ),);


        $this->fields_list = array(
            'id' => array('title' => 'ID', 'align' => 'center', 'width' => 25),
            'module_id' => array('title' => 'Moduł z reklamami', 'align' => 'center', 'width' => 25,  'callback' => 'getModuleName'),


        );

        $this->toolbar_btn[] = array(
            'href' => $this->context->link->getAdminLink('mfp_license_manager'),
            'title' => 'Back',
            'imgclass' => 'back',
            'desc' => 'Back ',
        );




        parent::__construct();
    }
    public function getModuleName($moduleId)
    {
        $module = new Product($moduleId);
        if ($module) {
            return $module->name[Context::getContext()->language->id];
        }
        else {
            return $moduleId;
        }

    }
    public function renderForm()
    {
//
        $this->initToolbar();




        $this->fields_form = array(
            'legend' => array('title' => 'Nowa reklama',),
            'input' => array(

                array(
                    'type' => 'select',
                    'label' => $this->l('Moduł polecany 1'),
                    'name' => 'module_id_1',
                    'required' => true,
                    'size' => 10,
                    'setWidth'=> 450,
                    'options' => array(
                        'query' => $options = $this->getAllModules(),
                        'id' => 'id_option',
                        'name' => 'name',
                    ),

                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Moduł polecany 2'),
                    'name' => 'module_id_2',
                    'required' => true,
                    'size' => 10,
                    'setWidth'=> 450,
                    'options' => array(
                        'query' => $options = $this->getAllModules(),
                        'id' => 'id_option',
                        'name' => 'name',
                    ),

                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Moduł polecany 3'),
                    'name' => 'module_id_3',
                    'required' => true,
                    'size' => 10,
                    'setWidth'=> 450,
                    'options' => array(
                        'query' => $options = $this->getAllModules(),
                        'id' => 'id_option',
                        'name' => 'name',
                    ),

                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Moduł polecany 4'),
                    'name' => 'module_id_4',
                    'required' => true,
                    'size' => 10,
                    'setWidth'=> 450,
                    'options' => array(
                        'query' => $options = $this->getAllModules(),
                        'id' => 'id_option',
                        'name' => 'name',
                    ),

                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Moduł dla którego wyświetli się reklama'),
                    'name' => 'module_id',
                    'required' => true,
                    'size' => 10,
                    'setWidth'=> 450,
                    'options' => array(
                        'query' => $options = $this->getAllModules(1),
                        'id' => 'id_option',
                        'name' => 'name',
                    ),

                ),

            ),
            'submit' => array('title' => ' Zapisz ', 'class' => 'btn btn-default button')
        );


        return parent::renderForm();
    }

    public function getAllModules($main = null) {
        $prods = Product::getProducts(Context::getContext()->language->id,0,NULL,'id_product','ASC');
        $result = [];
        if($main){
            $result[] = [
                "id_option" => 0,
                "name" => 'Wszystkie'
            ];
        }

        foreach($prods as $prod) {
            $result[] = [
                "id_option" => $prod["id_product"],
                "name" => $prod["name"]
            ];
        }

        return $result;
    }
}