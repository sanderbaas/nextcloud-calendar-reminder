<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: Sander Baas <sander@baasmail.nl>
// SPDX-License-Identifier: AGPL-3.0-or-later

/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\CalendarReminder\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
	'resources' => [
		'reminder_api' => ['url' => '/api/v1/reminders']
	],
	'routes' => [
		['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'reminder_api#preflighted_cors', 'url' => '/api/v1/{path}',
			'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']]
	]
];
