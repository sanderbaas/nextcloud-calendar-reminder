/** @class */
export default class Reminder {

	/** @member {?number} */
	id

	/** @member {string} */
	name

	/**
	 * Create a new AppointmentConfig from the given plain object data
	 *
	 * @param {object} data Appointment config data to construct an instance from
	 * @param {?number} data.id Id
	 * @param {string} data.name Name
	 */
	constructor(data) {
		data ??= {}
		this.id = data.id
		this.name = data.name
		this.type = data.type
		this.firstTimeAt = new Date(data.firstTimeAt)
		this.customInterval = data.customInterval
	}

	static createDefault() {
		const firstTimeAt = new Date()
		firstTimeAt.setMinutes(0)
		firstTimeAt.setSeconds(0)
		firstTimeAt.setMilliseconds(0)

		return new Reminder({
			name: t('calendarreminder', 'New reminder'),
			type: 'daily',
			firstTimeAt,
			customInterval: '',
		})

	}

	clone() {
		return Reminder.fromJSON(JSON.stringify(this))
	}

	static fromJSON(jsonString) {
		return new Reminder(JSON.parse(jsonString))
	}

}
