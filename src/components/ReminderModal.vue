<template>
	<Modal size="large"
		@close="$emit('close')">
		<!-- Wait for the config to become available before rendering the form. -->
		<div v-if="editing" class="reminder-modal">
			<Confirmation v-if="showConfirmation"
				:is-new="isNew"
				:reminder="editing"
				@close="$emit('close')" />
			<template v-else>
				<h2>{{ formTitle }}</h2>
				<div class="reminder-modal__form">
					<fieldset>
						<TextInput class="reminder-modal__form__row"
							:label="t('calendarreminder', 'Reminder name')"
							:value.sync="editing.name" />
					</fieldset>
				</div>
				<NcButton class="reminder-modal__submit-button"
					type="primary"
					:disabled="!editing.name || editing.length === 0"
					@click="save">
					{{ saveButtonText }}
				</NcButton>
			</template>
		</div>
	</Modal>
</template>

<script>
import { NcModal as Modal, NcButton } from '@nextcloud/vue'
import TextInput from './TextInput.vue'
import Confirmation from './Confirmation.vue'
import Reminder from '../models/reminder.js'
import { mutations } from '../store.js'
import { showError } from '@nextcloud/dialogs'
// showSuccess

export default {
	name: 'ReminderModal',
	components: {
		Modal,
		TextInput,
		Confirmation,
		NcButton,
	},
	props: {
		reminder: {
			type: Reminder,
			required: true,
		},
		isNew: {
			type: Boolean,
			required: true,
		},
	},
	data() {
		return {
			editing: undefined,
			enablePreparationDuration: false,
			enableFollowupDuration: false,
			enableFutureLimit: false,
			rateLimitingReached: false,
			showConfirmation: false,
		}
	},
	computed: {
		formTitle() {
			if (this.isNew) {
				return t('calendarreminder', 'Create reminder')
			}

			return t('calendarreminder', 'Edit reminder')
		},
		saveButtonText() {
			if (this.isNew) {
				return t('calendarreminder', 'Save')
			}

			return t('calendarreminder', 'Update')
		},
		defaultReminder() {
			return Reminder.createDefault(
				// this.calendarUrlToUri(this.$store.getters.ownSortedCalendars[0].url),
				// this.$store.getters.scheduleInbox,
				// this.$store.getters.getResolvedTimezone,
			)
		},
	},
	watch: {
		reminder() {
			this.reset()
		},
	},
	created() {
		this.reset()
	},
	methods: {
		reset() {
			this.editing = this.reminder.clone()

			this.showConfirmation = false
		},
		async save() {
			const reminder = this.editing

			try {
				if (this.isNew) {
					this.editing = await mutations.createReminder(reminder)
				} else {
					this.editing = await mutations.updateReminder(reminder)
				}

				this.showConfirmation = true
			} catch (error) {
				if (this.isNew) {
					showError(t('calendarreminder', 'Could not create reminder'))
				}

				if (!this.isNew) {
					showError(t('calendarreminder', 'Could not update reminder'))
				}
			}
		},
	},
}
</script>

<style lang="scss" scoped>
.reminder-modal {
	&__talk-room-description {
		color: var(--color-text-maxcontrast);
	}
}
</style>
