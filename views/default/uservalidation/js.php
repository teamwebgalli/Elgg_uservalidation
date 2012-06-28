
elgg.provide('elgg.uservalidation');

elgg.uservalidation.init = function() {
	$('#uservalidation-checkall').click(function() {
		var checked = $(this).attr('checked') == 'checked';
		$('#uservalidation-form .elgg-body').find('input[type=checkbox]').attr('checked', checked);
	});

	$('.uservalidation-submit').click(function(event) {
		var $form = $('#uservalidation-form');
		event.preventDefault();

		// check if there are selected users
		if ($('#uservalidation-form .elgg-body').find('input[type=checkbox]:checked').length < 1) {
			return false;
		}

		// confirmation
		if (!confirm($(this).attr('title'))) {
			return false;
		}

		$form.attr('action', $(this).attr('href')).submit();
	});
};

elgg.register_hook_handler('init', 'system', elgg.uservalidation.init);
