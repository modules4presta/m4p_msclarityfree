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


require_once __DIR__.'/classes/ModulesForPrestaMarketingMSCclarity.php';


if (!defined('_PS_VERSION_')) {
    exit;
}

class mfp_msc_clarity extends Module
{


    public function __construct()
    {
        $this->name = 'mfp_msc_clarity';
        $this->tab = 'administration';
        $this->version = '1.0.3';
        $this->author = 'Modules for Presta';
        $this->need_instance = 0;
        $this->_path = _PS_MODULE_DIR_.$this->name;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => '8.1.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Integration Microsoft Clarity');
        $this->description = $this->l('Module to connect with Microsoft Clarity');



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
                'title' => $this->l('Ustawienia Integration Microsoft Clarity'),
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Aktywacja modułu'),
                    'name' => 'mfp_msc_clarity_switch',
                    'is_bool' => true,
                    'desc' => $this->l('Włącz/wyłącz połaczneie z Clarity'),
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
                    'name' => 'mfp_msc_clarity_text',
                    'desc' => $this->l('ID projektu znajduje się ')

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
                'mfp_msc_clarity_text' => Configuration::get('mfp_msc_clarity_text'),
                'mfp_msc_clarity_switch' => Configuration::get('mfp_msc_clarity_switch'),
            ),
            'languages' => $this->context->controller->getLanguages(),
        );
        return $helper->generateForm($fields_form);
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {

            $mfp_msc_clarity_text= Tools::getValue('mfp_msc_clarity_text');
            $mfp_msc_clarity_switch = Tools::getValue('mfp_msc_clarity_switch');

            if (!isset( $mfp_msc_clarity_text )) {
                $output .= $this->displayError($this->l('Nie podano ID projektu Clarity'));
            } else {

                Configuration::updateValue('mfp_msc_clarity_text', $mfp_msc_clarity_text);
                Configuration::updateValue('mfp_msc_clarity_switch', $mfp_msc_clarity_switch);

                $output .= $this->displayConfirmation($this->l('Poprawnie zapisano'));
            }
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=6');

        }
        $output .= $this->displayForm();

        return $output ;
    }

    public function hookDisplayHeader()
    {


    }
    public function hookActionFrontControllerSetMedia() {
        if(intval(Configuration::get('mfp_msc_clarity_switch')) == 1) {
            $this->context->smarty->assign('mfp_ms_clarity_code', Configuration::get('mfp_msc_clarity_text'));

            $defJsVariables = [
                'mfp_msc_clarity' => [
                    'mfp_ms_clarity_code' => Configuration::get('mfp_msc_clarity_text')
                ]
            ];
            Media::addJsDef($defJsVariables);

            $this->context->controller->registerJavascript(
                'mfp_msc_clarity',
                $this->_path . 'views/js/main.js',


            );
        }
    }

    
}