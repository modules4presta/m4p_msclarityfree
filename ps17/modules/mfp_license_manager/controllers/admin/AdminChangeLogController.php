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
require_once dirname(__FILE__) . '/../../classes/ChangeLogTab.php';
class AdminChangeLogController extends ModuleAdminControllerCore
{



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


    const TABLE_NAME = 'mfp_license_manager_change_log';

    public function __construct()
    {

        $this->context = Context::getContext();
        $this->table = 'mfp_license_manager_change_log';
        $this->identifier = 'id';
        $this->className = 'ChangeLogTab';
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

        $this->_select = 'id';
        $this->fields_list = array(
            'id' => array('title' => 'ID', 'align' => 'center', 'width' => 25),
            'module_id' => array('title' => 'id modułu', 'align' => 'center', 'width' => 25),
            'version' => array('title' => 'Wersja', 'align' => 'center', 'width' => 60 ),
            // 'content' => array('title' => 'Tekst', 'align' => 'center', 'width' => 60 ),
            'date' => array('title' => 'data ostatniego update', 'align' => 'center', 'width' => 60 ),

        );

        $this->toolbar_btn[] = array(
            'href' => $this->context->link->getAdminLink('mfp_license_manager'),
            'title' => 'Back',
            'imgclass' => 'back',
            'desc' => 'Back ',
        );




        parent::__construct();
    }

    public function renderForm()
    {
//
        $this->initToolbar();




        $this->fields_form = array(
            'legend' => array('title' => 'Nowa Wersja opis',),
            'input' => array(

                array(
                    'type' => 'text',
                    'label' => $this->l('Opis zmian'),
                    'name' => 'content',
                    'required' => true,
                    'size' => 50
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Data wydania wersji'),
                    'name' => 'date',
                    'required' => true,
                    'size' => 50
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Moduł'),
                    'name' => 'module_id',
                    'required' => true,
                    'size' => 20,
                    'setWidth'=> 250,
                    'options' => array(
                        'query' => $options = $this->getAllModules(),
                        'id' => 'id_option',
                        'name' => 'name',
                    ),

                ),

            ),
            'submit' => array('title' => ' Zapisz ', 'class' => 'btn btn-default button')
        );


        return parent::renderForm();
    }

    public function getAllModules() {
        $prods = Product::getProducts(Context::getContext()->language->id,0,NULL,'id_product','ASC');
        $result = [];
        foreach($prods as $prod) {
            $result[] = [
                "id_option" => $prod["id_product"],
                "name" => $prod["name"]
            ];
        }

        return $result;
    }
}