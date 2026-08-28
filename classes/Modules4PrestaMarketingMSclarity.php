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

class Modules4PrestaMarketingMSclarity
{
    const ADS_CACHE_KEY = 'M4P_MSCLARITYFREE_ADS_CACHE';
    const ADS_CACHE_TS_KEY = 'M4P_MSCLARITYFREE_ADS_CACHE_TS';
    const ADS_CACHE_TTL = 86400;

    public static function checkServerRequirements()
    {
        $requirements = [];

        $requirements[] = [
            'name' => 'PHP min 7.3.0',
            'status' => version_compare(phpversion(), '7.3.0', '>=') ? 1 : 0,
        ];

        $requirements[] = [
            'name' => 'PrestaShop version min 1.7.0.0',
            'status' => version_compare(_PS_VERSION_, '1.7.0.0', '>=') ? 1 : 0,
        ];

        return $requirements;
    }

    public static function getAdsFromModules4Presta()
    {
        $cached = Configuration::get(self::ADS_CACHE_KEY);
        $cachedAt = (int) Configuration::get(self::ADS_CACHE_TS_KEY);

        if ($cached && (time() - $cachedAt) < self::ADS_CACHE_TTL) {
            $decoded = json_decode($cached, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://modules4presta.io/index.php?action=getAdsForModul&fc=module&module=mfp_license_manager&controller=ajax&modulename=' . urlencode('m4p_msclarityfree'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_TIMEOUT => 3,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $ads = json_decode((string) $response, true);
        if (!is_array($ads)) {
            return [];
        }

        Configuration::updateValue(self::ADS_CACHE_KEY, json_encode($ads));
        Configuration::updateValue(self::ADS_CACHE_TS_KEY, (string) time());

        return $ads;
    }
}
