<?php
/**
 * List of unvalidated users
 */

echo elgg_view_form('uservalidation/bulk_action', array(
	'id' => 'uservalidation-form',
	'action' => 'action/uservalidation/bulk_action'
));
