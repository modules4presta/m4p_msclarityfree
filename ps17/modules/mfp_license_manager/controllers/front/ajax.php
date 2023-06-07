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
                }
                else
                echo $this->getProductDetails($modules_id[0]);
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
            $productImageLink = $product->getCoverWs();

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

