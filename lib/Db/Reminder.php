<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: Sander Baas <sander@baasmail.nl>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CalendarReminder\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

/**
 * @method getId(): int
 * @method getName(): string
 * @method setName(string $name): void
 * @method getType(): string
 * @method setType(string $type): void
 * @method getFirstTimeAt(): dateTime
 * @method setFirstTimeAt(string $firstTimeAt): void
 * @method getCustomInterval(): string
 * @method setCustomInterval(string $customInterval): void
 * @method getUserId(): string
 * @method setUserId(string $userId): void
 */
class Reminder extends Entity implements JsonSerializable {
	protected string $name = '';
	protected string $type = '';
	protected string $userId = '';
	protected ?string $firstTimeAt = null;
	protected ?string $customInterval = null;

	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'type' => $this->type,
            'firstTimeAt' => $this->firstTimeAt,
            'customInterval' => $this->customInterval
		];
	}
}
