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



if (!defined('_PS_VERSION_')) {
    exit;
}

class m4p_download_only_register extends Module
{


    public function __construct()
    {
        $this->name = 'm4p_download_only_register';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Modules4Presta';
        $this->need_instance = 0;
        $this->_path = _PS_MODULE_DIR_.$this->name;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => '8.1.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Download only register');
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


        $this->registerAllHooks(["displayHeader","displayOverrideTemplate"]);
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


    public function uninstall()
    {
        // Deletes module tables
        

        (new ManageSql())->uninstallQueries();
        if (!parent::uninstall()) {
            return false;
        }
        return true;

    }
    public function hookDisplayOverrideTemplate(array $params)
    {

        $isLogged = $this->context->customer->isLogged();
        $registerLink = $this->context->link->getPageLink('authentication');
        $productId = (int)Tools::getValue('id_product');

        $product = new Product($productId);

        $isFreeProduct = ($product->price == 0) ? true : false;

        $virtualFileLink = '';
        if ($isFreeProduct) {

                $file = ProductDownloadCore::getIdFromIdProduct($productId);


                $productDownload = new ProductDownload($file);
                $virtualFileLink = $productDownload->checkWritableDir();

//                echo $virtualFileLink

        }

        $this->context->smarty->assign(array(
            'is_logged' => $isLogged,
            'register_link' => $registerLink,
            'is_free_product' => $isFreeProduct,
            'virtual_file_link' => $virtualFileLink,
        ));

//        return $this->display(__FILE__, 'product_registration_button.tpl');
    }

    public function hookDisplayHeader()
    {
        $link = new Link;
        $parameters_ads_module = array("action" => "ajax");
        $ajax_get_ads = $link->getModuleLink('mfp_license_manager', 'ajax', $parameters_ads_module);
        $this->context->controller->addJS($this->_path . 'views/js/main.js');
        $this->context->controller->addCSS($this->_path . 'views/css/main.css');
        $this->registerHook("displayAdditionalCustomerAddressFields");


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