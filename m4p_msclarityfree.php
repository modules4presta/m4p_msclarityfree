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


require_once __DIR__ . '/classes/Modules4PrestaMarketingMSclarity.php';


if (!defined('_PS_VERSION_')) {
    exit;
}

class m4P_msclarityfree extends Module
{


    public function __construct()
    {
        $this->name = 'm4p_msclarityfree';
        $this->tab = 'administration';
        $this->version = '1.0.6';
        $this->author = 'Modules4Presta.io';
        $this->need_instance = 0;
        $this->_path = _PS_MODULE_DIR_.$this->name;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => '8.1.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Integration Microsoft Clarity FREE');
        $this->description = $this->l('Module to connect with Microsoft Clarity ').'<a href="https://modules4presta.io/index.php?action=redirectToModule&fc=module&module=mfp_license_manager&controller=ajax&modulename=m4p_msclaritypro">Get PRO</a>';



    }

    public function install()
    {

        if (!parent::install()) {
            return false;
        }
        if(!$this->registerHook('displayHeader')) return false;
        if(!$this->registerHook('actionFrontControllerSetMedia')) return false;

        return true;
    }

    public function uninstall()
    {
        // Deletes module tables
        

        if (!parent::uninstall()) {
            return false;
        }
        return true;

    }

    public function displayForm(){
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Ustawienia'),
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Aktywacja modułu'),
                    'name' => 'm4p_msclarityfree_switch',
                    'is_bool' => true,
                    'desc' => $this->l('Włącz/wyłącz połączenie z Clarity'),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Włącz')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Wyłącz')
                        )
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Projekt ID z Clarity'),
                    'name' => 'm4p_msclarityfree_text',
                    'desc' => $this->l('ID projektu znajduje się w panelu Clarity, w zakładce "My Projects". Klikamy w koło zębate i kopiujemy "Project ID".

')

                ),


            ),
            'submit' => array(
                'title' => $this->l('Zapisz'),
                'class' => 'btn btn-default pull-right'
            )
        );
        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = array(
            'save' => array(
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' => array(
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );
        $helper->tpl_vars = array(
            'fields_value' => array(
                'm4p_msclarityfree_text' => Configuration::get('m4p_msclarityfree_text'),
                'm4p_msclarityfree_switch' => Configuration::get('m4p_msclarityfree_switch'),
            ),
            'languages' => $this->context->controller->getLanguages(),
        );


        return $helper->generateForm($fields_form);
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {

            $m4p_msclarityfree_text= Tools::getValue('m4p_msclarityfree_text');
            $m4p_msclarityfree_switch = Tools::getValue('m4p_msclarityfree_switch');

            if (!isset( $m4p_msclarityfree_text )) {
                $output .= $this->displayError($this->l('Nie podano ID projektu Clarity'));
            } else {

                Configuration::updateValue('m4p_msclarityfree_text', $m4p_msclarityfree_text);
                Configuration::updateValue('m4p_msclarityfree_switch', $m4p_msclarityfree_switch);

                $output .= $this->displayConfirmation($this->l('Poprawnie zapisano'));
            }
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=6');

        }
        require_once dirname(__FILE__) . '/classes/Modules4PrestaMarketingMSclarity.php';
        $this->context->smarty->assign(array(
            'modules_ads' => Modules4PrestaMarketingMSclarity::getAdsFromModules4Presta()
        ));
        $this->content .= $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->name.'/views/templates/admin/m4p_ads.tpl');

        $this->context->smarty->assign(array(
            'content' => $this->content,
            'modules_ads' => Modules4PrestaMarketingMSclarity::getAdsFromModules4Presta()
        ));
        $output .= $this->displayForm().$this->content;

        return $output ;
    }

    public function hookDisplayHeader()
    {


    }
    public function hookActionFrontControllerSetMedia() {
        if(intval(Configuration::get('m4p_msclarityfree_switch')) == 1) {
            $this->context->smarty->assign('m4p_msclarityfree_code', Configuration::get('m4p_msclarityfree_text'));

            $defJsVariables = [
                'm4P_msclarityfree' => [
                    'm4p_msclarityfree_code' => Configuration::get('m4p_msclarityfree_text')
                ]
            ];
            Media::addJsDef($defJsVariables);

            $this->context->controller->registerJavascript(
                'm4P_msclarityfree',
                $this->_path . 'views/js/main.js',


            );
        }
    }

    
}