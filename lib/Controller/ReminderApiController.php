<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: Sander Baas <sander@baasmail.nl>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CalendarReminder\Controller;

use OCA\CalendarReminder\AppInfo\Application;
use OCA\CalendarReminder\Service\ReminderService;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class ReminderApiController extends ApiController {
	private ReminderService $service;
	private ?string $userId;

	use Errors;

	public function __construct(IRequest $request,
		ReminderService $service,
		?string $userId) {
		parent::__construct(Application::APP_ID, $request);
		$this->service = $service;
		$this->userId = $userId;
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function index(): DataResponse {
		return new DataResponse($this->service->findAll($this->userId));
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function show(int $id): DataResponse {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->find($id, $this->userId);
		});
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function create(string $name, string $type, string $firstTimeAt, string $customInterval = ''): DataResponse {
		return new DataResponse($this->service->create(
            $name,
            $type,
            $firstTimeAt,
            $customInterval,
			$this->userId
        ));
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function update(int $id, string $name, string $type, string $firstTimeAt, string $customInterval = ''): DataResponse {
		return $this->handleNotFound(function () use ($id, $name, $type, $firstTimeAt, $customInterval) {
			return $this->service->update($id, $name, $type, $firstTimeAt, $customInterval, $this->userId);
		});
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function destroy(int $id): DataResponse {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->delete($id, $this->userId);
		});
	}
}
