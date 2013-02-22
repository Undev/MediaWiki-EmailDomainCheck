<?php
/**
 * Internationalisation file for extension EmailDomainCheck
 *
 * @addtogroup Extensions
 */

$messages = array();

/** English
 * @author Wookienz
 */
$messages['en'] = array(
    'emaildomaincheck-desc'  => 'Enforces a specific email domain during registration',
    'emaildomaincheck-error' => 'Your email domain is invalid. Your email address must end in $1.',
);

/** German (Deutsch)
 * @author SVG
 */
$messages['ru'] = array(
    'emaildomaincheck-desc'  => 'Проверяет email по домену из списка.',
    'emaildomaincheck-error' => 'Email адрес не в списке разрешенных адресов. Пожалуйста введите адрес корпоративной почты на домене из списка $1.',
);