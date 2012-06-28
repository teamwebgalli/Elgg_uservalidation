<?php
/**
 * Email user validation plugin language pack.
 *
 * @package Elgg.Core.Plugin
 * @subpackage Elgguservalidation
 */

$english = array(
	'admin:users:unvalidated' => 'Unvalidated',
	
	'email:validate:subject' => "%s please confirm your email address for %s!",
	'email:validate:body' => "%s,

Before you can start you using %s, you must confirm your email address.

Please confirm your email address by clicking on the link below:

%s

If you can't click on the link, copy and paste it to your browser manually.

%s
%s
",

	'admin:user:validate:subject' => "%s is requesting validation of account for %s!",
	'admin:user:validate:body' => "Hello %s,

A user named %s is requesting validation of their account. 

You can validate their account by clicking on the link below:

%s

If you can't click on the link, copy and paste it to your browser manually.

%s
%s
",

	'admin:user:validated:subject' => "Congrats %s! Your account has been activated",
	'admin:user:validated:body' => "Hello %s,

This is to notify that your account at %s has been activated by an admin. 

You can now login to the site with:

Username: %s
Password: the one you provided during registration

%s
%s
",

	'email:confirm:success' => "You have confirmed your email address!",
	'email:confirm:fail' => "Your email address could not be verified...",

	'uservalidation:registerok' => "To activate your account, please confirm your email address by clicking on the link we just sent you.",
	'uservalidation:login:fail' => "Your account is not validated so the log in attempt failed. Another validation email has been sent.",
	'admin:uservalidation:registerok' => "You will be notified once the admin approves your account",
	'admin:uservalidation:login:fail' => "Your account is not validated so the log in attempt failed. You have to wait until admin validates your account.",

	'uservalidation:admin:no_unvalidated_users' => 'No unvalidated users.',

	'uservalidation:admin:unvalidated' => 'Unvalidated',
	'uservalidation:admin:user_created' => 'Registered %s',
	'uservalidation:admin:resend_validation' => 'Resend validation',
	'uservalidation:admin:validate' => 'Validate',
	'uservalidation:admin:delete' => 'Delete',
	'uservalidation:confirm_validate_user' => 'Validate %s?',
	'uservalidation:confirm_resend_validation' => 'Resend validation email to %s?',
	'uservalidation:confirm_delete' => 'Delete %s?',
	'uservalidation:confirm_validate_checked' => 'Validate checked users?',
	'uservalidation:confirm_resend_validation_checked' => 'Resend validation to checked users?',
	'uservalidation:confirm_delete_checked' => 'Delete checked users?',
	'uservalidation:check_all' => 'All',

	'uservalidation:errors:unknown_users' => 'Unknown users',
	'uservalidation:errors:could_not_validate_user' => 'Could not validate user.',
	'uservalidation:errors:could_not_validate_users' => 'Could not validate all checked users.',
	'uservalidation:errors:could_not_delete_user' => 'Could not delete user.',
	'uservalidation:errors:could_not_delete_users' => 'Could not delete all checked users.',
	'uservalidation:errors:could_not_resend_validation' => 'Could not resend validation request.',
	'uservalidation:errors:could_not_resend_validations' => 'Could not resend all validation requests to checked users.',

	'uservalidation:messages:validated_user' => 'User validated.',
	'uservalidation:messages:validated_users' => 'All checked users validated.',
	'uservalidation:messages:deleted_user' => 'User deleted.',
	'uservalidation:messages:deleted_users' => 'All checked users deleted.',
	'uservalidation:messages:resent_validation' => 'Validation request resent.',
	'uservalidation:messages:resent_validations' => 'Validation requests resent to all checked users.',
	
	'uservalidation:method' => 'Select the user validation method',
	'option:email' => 'Email Validation',
	'option:admin' => 'Admin validation',
	

);

add_translation("en", $english);