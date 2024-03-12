import Vue from 'vue'
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import Reminder from './models/reminder.js'

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
		const response = await axios.get(generateUrl('/apps/calendarreminder/api/v1/reminders'))
		response.data.forEach(function(data) {
			store.reminders.push(new Reminder(data))
		})
	},

	async setCurrentUser() {
		const response = await axios.get(generateUrl('/apps/calendarreminder/api/v1/current_user'))
		store.currentUser = response.data
	},

	async createReminder(reminder) {
		const response = await axios.post(generateUrl('/apps/calendarreminder/api/v1/reminders'), reminder)
		store.reminders.push(new Reminder(response.data))
	},

	async updateReminder(reminder) {
		const response = await axios.put(generateUrl(`/apps/calendarreminder/api/v1/reminders/${reminder.id}`), reminder)
		let storedReminder = store.reminders.find((element) => element.id === reminder.id)
		storedReminder = response.data
		return storedReminder
	},

	async deleteReminder(reminder) {
		await axios.delete(generateUrl(`/apps/calendarreminder/api/v1/reminders/${reminder.id}`))
		this.reminders.splice(this.reminders.indexOf(reminder), 1)
		if (this.currentReminderId === reminder.id) {
			this.currentReminderId = null
		}
	},

}
