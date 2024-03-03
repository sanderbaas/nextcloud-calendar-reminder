import Vue from 'vue'
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

export const store = Vue.observable({
	reminders: [],
	currentReminderId: null,
	currentUser: {
		name: 'Admin',
		email: 'ad@min.org',
	},
})

export const mutations = {
	async setReminders() {
		const response = await axios.get(generateUrl('/apps/calendarreminder/reminders'))
		store.reminders = response.data
	},

	async setCurrentUser() {
		const response = await axios.get(generateUrl('/apps/calendarreminder/current_user'))
		store.currentUser = response.data
	},

	async createReminder(reminder) {
		// const response = await axios.post(generateUrl('/apps/calendarreminder/reminders'), reminder)
		// store.reminders.push(response.data)
		store.reminders.push(reminder)
	},

	async updateReminder(reminder) {
		const response = await axios.put(generateUrl(`/apps/calendarreminder/reminder/${reminder.id}`), reminder)
		let storedReminder = store.reminders.find((element) => element.id === reminder.id)
		storedReminder = response.data
		return storedReminder
	},

	async deleteReminder(reminder) {
		await axios.delete(generateUrl(`/apps/calendarreminder/reminders/${reminder.id}`))
		this.reminders.splice(this.reminders.indexOf(reminder), 1)
		if (this.currentReminderId === reminder.id) {
			this.currentReminderId = null
		}
	},

}
