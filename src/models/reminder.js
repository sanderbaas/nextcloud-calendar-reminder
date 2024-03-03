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
	}

	static createDefault() {
		return new Reminder({
			name: '',
		})

	}

	clone() {
		return Reminder.fromJSON(JSON.stringify(this))
	}

	static fromJSON(jsonString) {
		return new Reminder(JSON.parse(jsonString))
	}

}
