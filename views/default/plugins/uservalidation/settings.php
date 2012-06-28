<?php
if (!isset($vars['entity']->validation_method)) {
	$vars['entity']->validation_method = 'email';
}

echo '<div>';
echo elgg_echo('uservalidation:method');
echo ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[validation_method]',
	'options_values' => array(
		'email' => elgg_echo('option:email'),
		'admin' => elgg_echo('option:admin')
	),
	'value' => $vars['entity']->validation_method,
));
echo '</div>';