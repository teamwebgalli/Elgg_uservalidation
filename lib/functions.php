<?php
/**
 * Helper functions
 *
 * @package Elgg.Core.Plugin
 * @subpackage uservalidation
 */
/**
 * Get the admin user (returns the first admin user)
 * There is no API in elgg 1.8.5 to get the admin user
*/
function get_admin_user_details(){
	global $CONFIG;
	$query = "SELECT * FROM {$CONFIG->dbprefix}users_entity as e WHERE ( e.admin = 'yes')"; 
	$info = get_data($query);
	return $info[0];
}	

/**
 * Generate an email activation code.
 *
 * @param int    $user_guid     The guid of the user
 * @param string $email_address Email address
 * @return string
 */
function uservalidation_generate_code($user_guid, $email_address) {

	$site_url = elgg_get_site_url();

	// Note I bind to site URL, this is important on multisite!
	return md5($user_guid . $email_address . $site_url . get_site_secret());
}

/**
 * Request user validation email.
 * Send email out to the address and request a confirmation.
 *
 * @param int  $user_guid       The user's GUID
 * @param bool $admin_requested Was it requested by admin
 * @return mixed
 */
function uservalidation_request_validation($user_guid, $admin_requested = FALSE) {
	$site = elgg_get_site_entity();
	$user_guid = (int)$user_guid;
	$user = get_entity($user_guid);
	if (($user) && ($user instanceof ElggUser)) {
		// Work out validate link
		$code = uservalidation_generate_code($user_guid, $user->email);
		$link = "{$site->url}uservalidation/confirm?u=$user_guid&c=$code";
		// Send validation email
		if(elgg_get_plugin_setting('validation_method','uservalidation') == 'admin'){
			$admin = get_admin_user_details();
			$subject = elgg_echo('admin:email:validate:subject', array($user->name, $site->name));
			$body = elgg_echo('admin:email:validate:body', array($admin->name, $user->name, $link, $site->name, $site->url));
			$result = notify_user($admin->guid, $site->guid, $subject, $body, NULL, 'email');
			$success_message = elgg_echo('admin:uservalidation:registerok');
		} else {
			$subject = elgg_echo('email:validate:subject', array($user->name, $site->name));
			$body = elgg_echo('email:validate:body', array($user->name, $site->name, $link, $site->name, $site->url));
			$result = notify_user($user->guid, $site->guid, $subject, $body, NULL, 'email');
			$success_message = elgg_echo('uservalidation:registerok');
		}	

		if ($result && !$admin_requested) {
			system_message($success_message);
		}
		return $result;
	}
	return FALSE;
}

/**
 * Validate a user
 *
 * @param int    $user_guid
 * @param string $code
 * @return bool
 */
function uservalidation_validate_email($user_guid, $code) {
	$user = get_entity($user_guid);

	if ($code == uservalidation_generate_code($user_guid, $user->email)) {
		return elgg_set_user_validation_status($user_guid, true, 'email');
	}

	return false;
}

/**
 * Return a where clause to get entities
 *
 * "Unvalidated" means metadata of validated is not set or not truthy.
 * We can't use elgg_get_entities_from_metadata() because you can't say
 * "where the entity has metadata set OR it's not equal to 1".
 *
 * @return array
 */
function uservalidation_get_unvalidated_users_sql_where() {
	global $CONFIG;

	$validated_id = get_metastring_id('validated');
	if ($validated_id === false) {
		$validated_id = add_metastring('validated');
	}
	$one_id = get_metastring_id('1');
	if ($one_id === false) {
		$one_id = add_metastring('1');
	}

	// thanks to daveb@freenode for the SQL tips!
	$wheres = array();
	$wheres[] = "e.enabled='no'";
	$wheres[] = "NOT EXISTS (
			SELECT 1 FROM {$CONFIG->dbprefix}metadata md
			WHERE md.entity_guid = e.guid
				AND md.name_id = $validated_id
				AND md.value_id = $one_id)";

	return $wheres;
}