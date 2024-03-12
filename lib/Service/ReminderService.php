<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: Sander Baas <sander@baasmail.nl>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CalendarReminder\Service;

use Exception;

use OCA\CalendarReminder\Db\Reminder;
use OCA\CalendarReminder\Db\ReminderMapper;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
use OCP\IUserSession;

class ReminderService {
	private ReminderMapper $mapper;
    private IUserSession $userSession;

    public function __construct(
        ReminderMapper $mapper,
        IUserSession $userSession
    ) {
		$this->mapper = $mapper;
        $this->userSession = $userSession;
	}

	/**
	 * @return list<Reminder>
	 */
	public function findAll(string $userId): array {
		return $this->mapper->findAll($userId);
	}

	/**
	 * @return never
	 */
	private function handleException(Exception $e) {
		if ($e instanceof DoesNotExistException ||
			$e instanceof MultipleObjectsReturnedException) {
			throw new ReminderNotFound($e->getMessage());
		} else {
			throw $e;
		}
	}

	public function find(int $id, string $userId): Reminder {
		try {
			return $this->mapper->find($id, $userId);

			// in order to be able to plug in different storage backends like files
			// for instance it is a good idea to turn storage related exceptions
			// into service related exceptions so controllers and service users
			// have to deal with only one type of exception
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function create(string $name, string $type, string $firstTimeAt, string $customInterval, string $userId): Reminder {
		$reminder = new Reminder();
		$reminder->setName($name);
		$reminder->setType($type);
		$reminder->setFirstTimeAt($firstTimeAt);
		$reminder->setCustomInterval($customInterval);
		$reminder->setUserId($userId);
		return $this->mapper->insert($reminder);
	}

	public function update(int $id, string $name, string $type, string $firstTimeAt, string $customInterval, string $userId): Reminder {
		try {
			$reminder = $this->mapper->find($id, $userId);
            $reminder->setName($name);
            $reminder->setType($type);
            $reminder->setFirstTimeAt($firstTimeAt);
            $reminder->setCustomInterval($customInterval);
			return $this->mapper->update($reminder);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete(int $id, string $userId): Reminder {
		try {
			$reminder = $this->mapper->find($id, $userId);
			$this->mapper->delete($reminder);
			return $reminder;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
