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
class AdminModuleLicenseController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        parent::__construct();


    }

    public function initContent()
    {
        parent::initContent();

        $this->context->smarty->assign(array(
            "modules" => $this->getAllModules(),

        ));
        $this->content = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'mfp_license_manager/views/templates/admin/send_notification_form.tpl');
        return parent::initContent();
    }

    public function postProcess()
    {
        if(Tools::getIsset("send_msg")){
            $module_id = Tools::getValue("module_select");
            $users_from_module = $this->getCustomersByOrderIds($this->getOrdersByProductId($module_id));

            foreach ($users_from_module as $user) {
                $send_to_customer = new Customer($user);



                $this->sendEmail(
                    'newsletter', // nazwa szablonu emaila
                    'Aktualizacja modułu', // temat emaila
                    array(
                        'message' => Tools::getValue("msg"),
                        'firstname' => $send_to_customer->firstname,
                        'lastname' => $send_to_customer->lastname,
                        'shop_url' => 'https://modulesforpresta.com/',
                        'shop_name' => 'Modules For Presta',

                    ), // zmienne dla szablonu emaila
                    $send_to_customer->email, // adres email odbiorcy
                    $send_to_customer->firstname." ".$send_to_customer->lastname // opcjonalnie: imię i nazwisko odbiorcy
                );
            }

        }

    }

    public function getAllModules() {
        return (new Product())->getProducts(Context::getContext()->language->id,0,null,'id_product','ASC');
    }
    public function getOrdersByProductId($productId) {

        $db = Db::getInstance();

        $sql = 'SELECT DISTINCT id_order
                FROM ' . _DB_PREFIX_ . 'order_detail
                WHERE product_id = ' . (int)$productId;

        $results = $db->executeS($sql);
        $orderIds = [];

        foreach ($results as $result) {
            $orderIds[] = $result['id_order'];
        }

        return $orderIds;
    }
    public function getCustomersByOrderIds($orderIds) {
        $db = Db::getInstance();

        $sql = 'SELECT DISTINCT id_customer
            FROM ' . _DB_PREFIX_ . 'orders
            WHERE id_order IN (' . implode(',', array_map('intval', $orderIds)) . ')';

        $results = $db->executeS($sql);

        $customerIds = array();
        foreach ($results as $result) {
            $customerIds[] = $result['id_customer'];

        }

        return $customerIds;
    }

    public function sendEmail($template, $subject, $templateVars, $to, $toName = null) {
        $from = Configuration::get('PS_SHOP_EMAIL');
        $fromName = Configuration::get('PS_SHOP_NAME');
        $idShop = Context::getContext()->shop->id;

        return Mail::send(
            1,
            $template,
            $subject,
            $templateVars,
            $to,
            $toName,
            $from,
            $fromName,
            null,
            null,
            _PS_MAIL_DIR_,
            false,
            $idShop,
            null,
            null,
            null
        );
    }
}