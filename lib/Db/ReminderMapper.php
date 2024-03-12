<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: Sander Baas <sander@baasmail.nl>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CalendarReminder\Db;

use Carbon\Carbon;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\QBMapper;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IConfig;
use OCP\IDBConnection;
use OCP\IUserSession;

/**
 * @template-extends QBMapper<Reminder>
 */
class ReminderMapper extends QBMapper {
    private IUserSession $userSession;
    private IConfig $config;
    private ?\OCP\IUser $currentUser;

    public function __construct(
        IDBConnection $db,
        IUserSession $userSession,
        IConfig $config
    ) {
        $this->userSession = $userSession;
        $this->config = $config;
        $this->currentUser = $userSession->getUser();

		parent::__construct($db, 'cr24_reminders', Reminder::class);
	}

    protected function mapRowToEntity(array $row): \OCP\AppFramework\Db\Entity
    {
        $defaultTimeZone = date_default_timezone_get();
        $userTimezone = $this->config->getUserValue(
            $this->currentUser->getUID(),
            'core',
            'timezone',
            $defaultTimeZone
        );

        $reminder = parent::mapRowToEntity($row);
        $reminder->setFirstTimeAt(Carbon::parse($reminder->getFirstTimeAt())
            ->setTimezone($userTimezone)
            ->isoFormat('YYYY-MM-DD HH:mm:ss'));

        return $reminder;
    }

    /**
	 * @throws \OCP\AppFramework\Db\MultipleObjectsReturnedException
	 * @throws DoesNotExistException
	 */
	public function find(int $id, string $userId): Reminder {
		/* @var $qb IQueryBuilder */
		$qb = $this->db->getQueryBuilder();
		$qb->select('*')
			->from('cr24_reminders')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id, IQueryBuilder::PARAM_INT)))
			->andWhere($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)));
		return $this->findEntity($qb);
	}

	/**
	 * @param string $userId
	 * @return array
	 */
	public function findAll(string $userId): array {
		/* @var $qb IQueryBuilder */
		$qb = $this->db->getQueryBuilder();
		$qb->select('*')
			->from('cr24_reminders')
			->where($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)));
		return $this->findEntities($qb);
	}
}
