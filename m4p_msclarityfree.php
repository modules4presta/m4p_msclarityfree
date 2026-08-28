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

require_once __DIR__ . '/classes/Modules4PrestaMarketingMSclarity.php';

class m4P_msclarityfree extends Module
{
    public function __construct()
    {
        $this->name = 'm4p_msclarityfree';
        $this->tab = 'analytics_stats';
        $this->version = '1.1.0';
        $this->author = 'Modules4Presta.io';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => '8.1.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Integration Microsoft Clarity FREE');
        $this->description = $this->l('Module to connect with Microsoft Clarity');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('actionFrontControllerSetMedia');
    }

    public function uninstall()
    {
        Configuration::deleteByName('m4p_msclarityfree_text');
        Configuration::deleteByName('m4p_msclarityfree_switch');
        Configuration::deleteByName(Modules4PrestaMarketingMSclarity::ADS_CACHE_KEY);
        Configuration::deleteByName(Modules4PrestaMarketingMSclarity::ADS_CACHE_TS_KEY);

        return parent::uninstall();
    }

    public function displayForm()
    {
        $fields_form[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input' => [
                [
                    'type' => 'switch',
                    'label' => $this->l('Active module'),
                    'name' => 'm4p_msclarityfree_switch',
                    'is_bool' => true,
                    'desc' => $this->l('On/Off connect with Clarity'),
                    'values' => [
                        [
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('On'),
                        ],
                        [
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Off'),
                        ],
                    ],
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Project ID Clarity'),
                    'name' => 'm4p_msclarityfree_text',
                    'desc' => $this->l('The project ID is located in the Clarity panel, under the "My Projects" tab. Click on the gear icon and copy the "Project ID."'),
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ],
        ];
        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ],
            'back' => [
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list'),
            ],
        ];
        $helper->tpl_vars = [
            'fields_value' => [
                'm4p_msclarityfree_text' => Configuration::get('m4p_msclarityfree_text'),
                'm4p_msclarityfree_switch' => Configuration::get('m4p_msclarityfree_switch'),
            ],
            'languages' => $this->context->controller->getLanguages(),
        ];

        return $helper->generateForm($fields_form);
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {
            $projectId = trim((string) Tools::getValue('m4p_msclarityfree_text'));
            $enabled = (int) Tools::getValue('m4p_msclarityfree_switch') ? 1 : 0;

            if (!preg_match('/^[a-z0-9]{5,20}$/i', $projectId)) {
                $output .= $this->displayError($this->l('Invalid Clarity Project ID'));
            } else {
                Configuration::updateValue('m4p_msclarityfree_text', $projectId);
                Configuration::updateValue('m4p_msclarityfree_switch', $enabled);

                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=6');
            }
        }

        $this->context->smarty->assign([
            'modules_ads' => Modules4PrestaMarketingMSclarity::getAdsFromModules4Presta(),
            'requirements' => Modules4PrestaMarketingMSclarity::checkServerRequirements(),
        ]);
        $requirements = $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->name . '/views/templates/admin/modules4presta.tpl');
        $ads = $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->name . '/views/templates/admin/m4p_ads.tpl');

        return $output . $this->displayForm() . $requirements . $ads;
    }

    public function hookActionFrontControllerSetMedia()
    {
        $projectId = Configuration::get('m4p_msclarityfree_text');

        if ((int) Configuration::get('m4p_msclarityfree_switch') !== 1 || !$projectId) {
            return;
        }

        Media::addJsDef([
            'm4P_msclarityfree' => [
                'm4p_msclarityfree_code' => $projectId,
            ],
        ]);

        $this->context->controller->registerJavascript(
            'modules-m4p-msclarityfree',
            'modules/' . $this->name . '/views/js/main.js',
            ['position' => 'bottom', 'priority' => 150]
        );
    }
}
