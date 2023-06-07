<?php



class mfp_license_managerAjaxModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {


        if (Tools::getAdminToken('AdminModules') != Tools::getValue('token')) {
            // Ooops! Token is not valid!
            die('Token is not valid, hack stop');
            return;
        }


    }

}

