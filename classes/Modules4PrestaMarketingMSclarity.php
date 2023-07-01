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
class Modules4PrestaMarketingMSclarity
{
    public static function checkServerRequirements()
    {
        $ionCubeLoaderEnabled = extension_loaded('ionCube Loader');
        $phpVersion = phpversion();
        $prestashopVersion = _PS_VERSION_;

        if ($ionCubeLoaderEnabled && version_compare($phpVersion, '7.0.0', '>=') && version_compare($prestashopVersion, '1.7.0.0', '>=')) {
            return 'Server meets the requirements';
        } else {

            $requirements = [];

            if (!$ionCubeLoaderEnabled) {
                $requirements[] = [
                    'name' => 'IonCube Loader',
                    'status' => 0
                ];
            }
            else {
                $requirements[] = [
                    'name' => 'IonCube Loader',
                    'status' => 1
                ];
            }

            if (version_compare($phpVersion, '7.3.0', '<')) {
                $requirements[] = [
                    'name' => 'PHP min 7.3.0',
                    'status' => 0
                ];
            }
            else {
                $requirements[] = [
                    'name' => 'PHP min 7.3.0',
                    'status' => 1
                ];
            }

            if (version_compare($prestashopVersion, '1.7.0.0', '<')) {

                $requirements[] = [
                    'name' => 'PrestaShop version is min requirements 1.7.0.0',
                    'status' => 0
                ];
            }
            else {
                $requirements[] = [
                    'name' => 'PrestaShop version is min requirements 1.7.0.0',
                    'status' => 0
                ];
            }

            return $requirements;
        }
    }
    public static function getAdsFromModules4Presta(){


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://modules4presta.io/index.php?action=getAdsForModul&fc=module&module=mfp_license_manager&controller=ajax&modulename='.urlencode('m4P_barinfofree'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',

        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response,true);

    }
    public function getRequaiermentsTemplate() {

        $this->context->smarty->assign([
            'requaierments' => $this->checkServerRequirements(),

        ]);

        return $this->content = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'mfp_license_manager/views/templates/admin/modulesforpresta.tpl');
    }
}