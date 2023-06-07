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

require_once __DIR__.'/classes/ModulesForPrestaMarketing.php';
require_once __DIR__.'/classes/ModulesForPrestaConnector.php';
require_once __DIR__.'/classes/RegisterInPanelTab.php';
require_once __DIR__.'/classes/ManageSql.php';


if (!defined('_PS_VERSION_')) {
    exit;
}

class mfp_license_manager extends Module
{


    public function __construct()
    {
        $this->name = 'mfp_license_manager';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Modules for Presta';
        $this->need_instance = 0;
        $this->_path = _PS_MODULE_DIR_.$this->name;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => '8.1.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('License manager');
        $this->description = $this->l('License manager');

//        $this->confirmUninstall = $this->confirmUninstall();

        if (!Configuration::get('SELECT ADD')) {
            $this->warning = $this->l('No name provided');
        }
    }
    public static function getPrefixDb() {

        return _DB_PREFIX_;
    }

    public function install()
    {

        if (!parent::install()) {
            return false;
        }
        if(!$this->registerHook('displayHeader')) return false;

        (new ManageSql())->installQuaries();

        $licenses_tab = new CustomMenuTab('Licencje modułów', 'mfp_license_manager', 999);
        $licenses_tab->addTab();
        $licenses_tab->addSubTab('Klienci z licencją', 'AdminModuleLicense', 1);
        $licenses_tab->addSubTab('Changelog', 'AdminChangelog', 2);
        $licenses_tab->addSubTab('Reklamy dla modułów', 'AdminAdsForModules', 2);

        $this->registerAllHooks(["displayHeader","actionOrderStatusUpdate"]);
        return true;
    }

    public function registerAllHooks($hooksArr){

        if(is_array($hooksArr)){
            foreach ($hooksArr as $hook){
                if(!$this->registerHook($hook)) return false;
            }
        }
        else
            return false;
    }

    public function confirmUninstall()
    {
        $this->context->smarty->assign(array(
            'module_display_name' => $this->displayName
        ));

        return  $this->display(__FILE__, 'views/templates/admin/uninstall_popup.tpl');
    }
    public function uninstall()
    {
        // Deletes module tables
        

        (new ManageSql())->uninstallQueries();
        if (!parent::uninstall()) {
            return false;
        }
        return true;

    }


    public function getContent()
    {
    }

    public function hookDisplayHeader()
    {

        $this->context->controller->addJS($this->_path . 'views/js/main.js');
        $this->context->controller->addCSS($this->_path . 'views/css/main.css');
        $this->registerHook("displayAdditionalCustomerAddressFields");


    }
    public function hookActionOrderStatusUpdate($params)

    {
        $orderId = $params['id_order'];
        $order = new Order($orderId);

        // Check if the order contains the product you're interested in
        $productId = 'ID Twojego produktu';
        if (!$order->hasProduct($productId)) {
            return;
        }

        // Get the customer ID and domain from the order
        $customer_id = $order->id_customer;
        $module_id = $productId;
        $domain = '';
        foreach ($order->getCartProducts() as $cartProduct) {
            if ($cartProduct['id_product'] == $productId) {
                $productAttributeId = $cartProduct['id_product_attribute'];
                $productAttribute = new ProductAttribute($productAttributeId);
                $domain = $productAttribute->domain;
                break;
            }
        }

        // Insert the customer and domain into the database
        $prefix_table = 'Nazwa Twojej tabeli';
        Db::getInstance()->insert($prefix_table . '_clients', array(
            'client_id' => $customer_id,
        ));
        Db::getInstance()->insert($prefix_table . '_clients_domains', array(
            'client_id' => $customer_id,
            'domain' => pSQL($domain),
            'module_id' => $module_id,
        ));
//
//        $orderDetail = $this->getOrderValue($params["id_order"]);
//        $database = Db::getInstance();

    }
    public function hookDisplayAdditionalCustomerAddressFields($params)
    {
        $this->context->smarty->assign(array(
            'additional_info_label' => $this->l('Additional information'),
        ));
        var_dump("dasdasdasdas");
        return $this->display(__FILE__, 'views/templates/hooks/displayCustomerAddressForm.tpl');
    }



}