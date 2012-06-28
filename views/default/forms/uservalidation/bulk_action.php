<?php
/**
 * Admin area to view, validate, resend validation email, or delete unvalidated users.
 *
 * @package Elgg.Core.Plugin
 * @subpackage uservalidation.Administration
 */

$limit = get_input('limit', 10);
$offset = get_input('offset', 0);

// can't use elgg_list_entities() and friends because we don't use the default view for users.
$ia = elgg_set_ignore_access(TRUE);
$hidden_entities = access_get_show_hidden_status();
access_show_hidden_entities(TRUE);

$options = array(
	'type' => 'user',
	'wheres' => uservalidation_get_unvalidated_users_sql_where(),
	'limit' => $limit,
	'offset' => $offset,
	'count' => TRUE,
);
$count = elgg_get_entities($options);

if (!$count) {
	access_show_hidden_entities($hidden_entities);
	elgg_set_ignore_access($ia);

	echo autop(elgg_echo('uservalidation:admin:no_unvalidated_users'));
	return TRUE;
}

$options['count']  = FALSE;

$users = elgg_get_entities($options);

access_show_hidden_entities($hidden_entities);
elgg_set_ignore_access($ia);

// setup pagination
$pagination = elgg_view('navigation/pagination',array(
	'base_url' => 'admin/users/unvalidated',
	'offset' => $offset,
	'count' => $count,
	'limit' => $limit,
));

$bulk_actions_checkbox = '<label><input type="checkbox" id="uservalidation-checkall" />'
	. elgg_echo('uservalidation:check_all') . '</label>';

$validate = elgg_view('output/url', array(
	'href' => 'action/uservalidation/validate/',
	'text' => elgg_echo('uservalidation:admin:validate'),
	'title' => elgg_echo('uservalidation:confirm_validate_checked'),
	'class' => 'uservalidation-submit',
	'is_action' => true,
	'is_trusted' => true,
));

$resend_email = elgg_view('output/url', array(
	'href' => 'action/uservalidation/resend_validation/',
	'text' => elgg_echo('uservalidation:admin:resend_validation'),
	'title' => elgg_echo('uservalidation:confirm_resend_validation_checked'),
	'class' => 'uservalidation-submit',
	'is_action' => true,
	'is_trusted' => true,
));

$delete = elgg_view('output/url', array(
	'href' => 'action/uservalidation/delete/',
	'text' => elgg_echo('uservalidation:admin:delete'),
	'title' => elgg_echo('uservalidation:confirm_delete_checked'),
	'class' => 'uservalidation-submit',
	'is_action' => true,
	'is_trusted' => true,
));

$bulk_actions = <<<___END
	<ul class="elgg-menu elgg-menu-general elgg-menu-hz float-alt">
		<li>$resend_email</li><li>$validate</li><li>$delete</li>
	</ul>

	$bulk_actions_checkbox
___END;

if (is_array($users) && count($users) > 0) {
	$html = '<ul class="elgg-list elgg-list-distinct">';
	foreach ($users as $user) {
		$html .= "<li id=\"unvalidated-user-{$user->guid}\" class=\"elgg-item uservalidation-unvalidated-user-item\">";
		$html .= elgg_view('uservalidation/unvalidated_user', array('user' => $user));
		$html .= '</li>';
	}
	$html .= '</ul>';
}

echo <<<___END
<div class="elgg-module elgg-module-inline uservalidation-module">
	<div class="elgg-head">
		$bulk_actions
	</div>
	<div class="elgg-body">
		$html
	</div>
</div>
___END;

if ($count > 5) {
	echo $bulk_actions;
}

echo $pagination;
