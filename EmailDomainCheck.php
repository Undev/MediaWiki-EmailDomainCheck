<?php
/**
 * Extension checks that registering users
 * are from a specific email domain
 * during account creation.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author wookienz <wookienz@gmail.com>
 */

/**
 * email domain that user must come from
 */

// $wgEmailDomain = 'somedomain.org'; or $wgEmailDomain = 'somedomain.org, example.com';

$wgExtensionMessagesFiles['EmailDomainCheck'] = dirname(__FILE__) . '/EmailDomainCheck.i18n.php';

$wgExtensionCredits['other'][] = array(
    'path' => __FILE__,
    'name' => 'Email Domain Check',
    'author' => 'Halfi',
    'url' => 'https://www.halfi.ru',
    'descriptionmsg' => 'emaildomaincheck-desc',
);

$wgHooks['GetPreferences'][] = 'efEmailDomainCheckPref';

/**
 * Hooks the profile edit process,
 * will cancel the prcoess if the dmain is not in list.
 *
 * @param User $user User object being created
 * @param string $error Reference to the error message to show
 * @return bool
 */
function efEmailDomainCheckPref( $user, &$defaultPreferences ) {
    global $wgExtensionCredits;

    $wgExtensionCredits['validation-default-callback'] = $defaultPreferences['emailaddress']['validation-callback'];

    $defaultPreferences['emailaddress']['validation-callback'] = array(
        'preferencesDomainCheck',
        'validateEmail'
    );

    return true;
}

class preferencesDomainCheck {
    static function validateEmail( $email, $alldata ) {
        global $wgExtensionCredits;
        global $wgEmailDomain;

        $returnOriginalFunc = call_user_func( $wgExtensionCredits['validation-default-callback'], $email, $alldata );

        if ( isset( $wgEmailDomain ) && $returnOriginalFunc === true) {

            list( , $host ) = explode( "@", $email);

            if (empty($email)) return true;

            $wgEmailDomainArray = explode(',', $wgEmailDomain);

            foreach($wgEmailDomainArray as $allowedDomain) {
                $allow = false;
                if ( $host == trim($allowedDomain) ) {
                    $allow = true;
                    break;
                }
            }
            if (!$allow) {
                return wfMsgHtml( 'emaildomaincheck-error', $wgEmailDomain );
            }

        }

        return $returnOriginalFunc;
    }
}