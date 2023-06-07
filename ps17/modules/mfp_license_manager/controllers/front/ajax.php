<?php



class mfp_license_managerAjaxModuleFrontController extends ModuleFrontController
{

    public $prefix_table = 'mfp_license_manager';

    public function initContent()
    {


        if(Tools::getIsset("action")){
            $action = Tools::getValue('action');
            if($action == 'getAdsForModul'){
                $module_name = Tools::getValue('modulename');
                $module_id = $this->getProductByName($module_name);
                $modules_id = Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.$this->prefix_table.'_ads_modules` WHERE `module_id`='.pSQL($module_id));

                header('Content-Type: application/json; charset=utf-8');
                if(empty($modules_id)){
                    $modules_id = Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.$this->prefix_table.'_ads_modules` WHERE `module_id`=0 OR NULL');
                    echo $this->getProductDetails($modules_id[0]);
                    die();
                }
                else
                echo $this->getProductDetails($modules_id[0]);
                die();
            }
            if($action == 'checkmodule') {
                $module_name = Tools::getValue('modulename');
                $module_id = $this->getProductByName($module_name);
                $referer =parse_url($_SERVER['HTTP_REFERER']);
                $existClient = Db::getInstance()->getValue("SELECT client_id FROM `"._DB_PREFIX_.$this->prefix_table."_clients_domains` WHERE `module_id`=".pSQL($module_id)." AND domain='".pSQL($referer)."';");
                header('Content-Type: application/json; charset=utf-8');
                echo json_decode($existClient);
                die();
            }
        }
    }

    private function getProductByName($name) {
        $id = Db::getInstance()->getValue("SELECT id_product FROM `"._DB_PREFIX_."product_lang` WHERE name='".pSQL($name)."';");
        return $id;
    }

    private function getProductDetails($productIds) {
        $products = [];

        foreach ($productIds as $productId) {
            $product = new Product($productId);

            $productName = $product->name;
            $productPrice = $product->getPrice();
            $productLink = $product->getLink();

            $image = Image::getCover($productId);
            $product = new Product($productId, false, Context::getContext()->language->id);
            $link = new Link; // because getImageLink is not static function
            $productImageLink = $link->getImageLink($product->link_rewrite, $image['id_image'], 'home_default');
            $productDetails = array(
                'name' => $productName,
                'price' => $productPrice,
                'link' => $productLink,
                'image_link' => $productImageLink
            );

            $products[] = $productDetails;
        }

        return json_encode($products);
    }
}

