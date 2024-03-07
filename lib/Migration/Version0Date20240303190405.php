<?php

declare(strict_types=1);

/**
 * @copyright Copyright (c) 2024 Your name <your@email.com>
 *
 * @author Your name <your@email.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\CalendarReminder\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

/**
 * Auto-generated migration step: Please modify to your needs!
 */
class Version0Date20240303190405 extends SimpleMigrationStep {

	/**
	 * @param IOutput $output
	 * @param Closure(): ISchemaWrapper $schemaClosure
	 * @param array $options
	 */
	public function preSchemaChange(IOutput $output, Closure $schemaClosure, array $options): void {
	}

	/**
	 * @param IOutput $output
	 * @param Closure(): ISchemaWrapper $schemaClosure
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options): ?ISchemaWrapper {
        $schema = $schemaClosure();

        if (! $schema->hasTable('cr24_reminders')) {
            $table = $schema->createTable('cr24_reminders');
            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('name', 'string', [
                'notnull' => true,
                'length' => 190
            ]);
            $table->addColumn('user_id', 'string', [
                'notnull' => true,
                'length' => 64,
            ]);
            $table->addColumn('type', 'string', [
                'notnull' => true,
                'length' => 190
            ]);
            $table->addColumn('first_time_at', 'datetime', [
                'notnull' => true
            ]);
            $table->addColumn('custom_interval', 'string', [
                'notnull' => false,
                'length' => 190
            ]);
            $table->setPrimaryKey(['id']);
            $table->addIndex(['user_id'], 'reminders_user_id_index');
        }

        if (! $schema->hasTable('cr24_extra_recipients')) {
            $table = $schema->createTable('cr24_extra_recipients');
            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('reminder_id', 'integer', [
                'notnull' => true
            ]);
            $table->addColumn('email', 'string', [
                'notnull' => true,
                'length' => 190
            ]);
            $table->setPrimaryKey(['id']);
            $table->addIndex(['reminder_id'], 'extra_emails_reminder_id_index');
        }

        if (! $schema->hasTable('cr24_calendar_reminder')) {
            $table = $schema->createTable('cr24_calendar_reminder');
            $table->addColumn('calendar_id', 'integer', [
                'notnull' => true,
            ]);
            $table->addColumn('reminder_id', 'integer', [
                'notnull' => true
            ]);
            $table->setPrimaryKey(['calendar_id', 'reminder_id']);
        }

        return $schema;
	}

	/**
	 * @param IOutput $output
	 * @param Closure(): ISchemaWrapper $schemaClosure
	 * @param array $options
	 */
	public function postSchemaChange(IOutput $output, Closure $schemaClosure, array $options): void {
	}
}
