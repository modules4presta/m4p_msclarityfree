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
class ModulesForPrestaConnector
{
    public static function newInstallation() {

        // @todo implement newInstallation

        return true;
    }

    public static function checkLicenseForDomain() {

        // @todo implement newInstallation
        $currentlyDomain = $_SERVER["SERVER_NAME"];

        return $currentlyDomain;
    }

    public static function sendFeedback($msg) {

        // @todo implement sendFeedback

        return true;
    }

    public static function getAdsMFP() {


        // @todo implement getAdsMFP
        $ads = [];
        return $ads;
    }
}