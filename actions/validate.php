<?php
/**
 * Validate a user or users by guid
 *
 * @package Elgg.Core.Plugin
 * @subpackage uservalidation
 */

$user_guids = get_input('user_guids');
$error = FALSE;

if (!$user_guids) {
	register_error(elgg_echo('uservalidation:errors:unknown_users'));
	forward(REFERRER);
}

$access = access_get_show_hidden_status();
access_show_hidden_entities(TRUE);

foreach ($user_guids as $guid) {
	$user = get_entity($guid);
	if (!$user instanceof ElggUser) {
		$error = TRUE;
		continue;
	}

	// only validate if not validated
	$is_validated = elgg_get_user_validation_status($guid);
	$validate_success = elgg_set_user_validation_status($guid, TRUE, 'manual');

	if ($is_validated !== FALSE || !($validate_success && $user->enable())) {
		$error = TRUE;
		continue;
	}
}

access_show_hidden_entities($access);

if (count($user_guids) == 1) {
	$message_txt = elgg_echo('uservalidation:messages:validated_user');
	$error_txt = elgg_echo('uservalidation:errors:could_not_validate_user');
} else {
	$message_txt = elgg_echo('uservalidation:messages:validated_users');
	$error_txt = elgg_echo('uservalidation:errors:could_not_validate_users');
}

if ($error) {
	register_error($error_txt);
} else {
	system_message($message_txt);
}

forward(REFERRER);