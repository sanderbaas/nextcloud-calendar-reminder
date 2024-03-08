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
				<fieldset>
					<div class="reminder-config-modal__form__row">
						<label for="nameField">Reminder name</label>
						<NcTextField id="nameField"
							:label="t('calendarreminder', 'Name')"
							:label-outside="true"
							:value.sync="editing.name" />
					</div>
					<div class="reminder-config-modal__form__row">
						<label for="typeField">Type</label>
						<NcTextField id="typeField"
							:label="t('calendarreminder', 'Type')"
							:label-outside="true"
							:value.sync="editing.type" />
					</div>
					<div class="reminder-config-modal__form__row">
						<label for="firstTimeAtField">First time at</label>
						<NcTextField id="firstTimeAtField"
							:label="t('calendarreminder', 'First time at')"
							:label-outside="true"
							:value.sync="editing.firstTimeAt" />
					</div>
					<div class="reminder-config-modal__form__row">
						<label for="customIntervalField">Custom interval</label>
						<NcTextField id="customIntervalField"
							:label="t('calendarreminder', 'Custom interval')"
							:label-outside="true"
							:value.sync="editing.customInterval" />
					</div>
				</fieldset>
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
import { NcModal as Modal, NcButton, NcTextField } from '@nextcloud/vue'
// import TextInput from './TextInput.vue'
import Confirmation from './Confirmation.vue'
import Reminder from '../models/reminder.js'
import { mutations } from '../store.js'
import { showError } from '@nextcloud/dialogs'
// showSuccess

export default {
	name: 'ReminderModal',
	components: {
		Modal,
		NcTextField,
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
			this.editing = Object.assign(this.reminder)

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
	padding: 2vw;

	&__talk-room-description {
		color: var(--color-text-maxcontrast);
	}
}

.reminder-config-modal__form__row + .reminder-config-modal__form__row {
	margin-top: 10px;
}

.reminder-config-modal__form__row .input-field {
	margin-top: 3px;
	margin-bottom: 3px;
}

fieldset {
	padding-top: 20px;
	padding-bottom: 20px;
}

.reminder-modal__submit-button {
	margin-top: 20px;
}
</style>
