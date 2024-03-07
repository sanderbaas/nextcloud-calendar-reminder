<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: Sander Baas <sander@baasmail.nl>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CalendarReminder\Controller;

use Closure;

use OCA\CalendarReminder\Service\ReminderNotFound;
use OCP\AppFramework\Http;

use OCP\AppFramework\Http\DataResponse;

trait Errors {
	protected function handleNotFound(Closure $callback): DataResponse {
		try {
			return new DataResponse($callback());
		} catch (ReminderNotFound $e) {
			$message = ['message' => $e->getMessage()];
			return new DataResponse($message, Http::STATUS_NOT_FOUND);
		}
	}
}
