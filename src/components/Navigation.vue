<template>
	<NcAppNavigation>
		<template #list>
			<NcAppNavigationCaption name="Reminders" :title="t('calendarreminder', 'Reminders')">
				<template #actions>
					<NcActionButton :close-after-click="true"
						@click="showModalForNewReminder = true">
						<template #icon>
							<PlusIcon :size="20" decorative />
						</template>
						{{ t('calendarreminder', 'Add new') }}
					</NcActionButton>
				</template>
			</NcAppNavigationCaption>

			<template v-if="hasUserEmailAddress">
				<template v-if="reminders.length > 0">
					<ReminderListItem v-for="reminder in reminders"
						:key="reminder.id"
						:reminder="reminder"
						@delete="deleteReminder(reminder)" />
				</template>

				<ReminderModal v-if="showModalForNewReminder"
					:is-new="true"
					:reminder="defaultReminder"
					@close="closeModal" />
			</template>
			<NoEmailAddressWarning v-else />
		</template>
	</NcAppNavigation>
</template>

<script>
import ReminderListItem from './ReminderListItem.vue'
import ReminderModal from './ReminderModal.vue'
import NoEmailAddressWarning from './NoEmailAddressWarning.vue'
// import FileExportIcon from 'vue-material-design-icons/FileExport.vue'
import PlusIcon from 'vue-material-design-icons/Plus.vue'
// import DeleteIcon from 'vue-material-design-icons/Delete.vue'

// import NoteIcon from './icons/NoteIcon.vue'

import NcAppNavigation from '@nextcloud/vue/dist/Components/NcAppNavigation.js'
// import NcEmptyContent from '@nextcloud/vue/dist/Components/NcEmptyContent.js'
// import NcAppNavigationItem from '@nextcloud/vue/dist/Components/NcAppNavigationItem.js'
import NcActionButton from '@nextcloud/vue/dist/Components/NcActionButton.js'
// import NcAppNavigationNewItem from '@nextcloud/vue/dist/Components/NcAppNavigationNewItem.js'
// import NcAppNavigationNew from '@nextcloud/vue/dist/Components/NcAppNavigationNew.js'
import NcAppNavigationCaption from '@nextcloud/vue/dist/Components/NcAppNavigationCaption.js'

import ClickOutside from 'vue-click-outside'
import { store, mutations } from '../store.js'
import Reminder from '../models/reminder.js'
// import { showError, showSuccess } from '@nextcloud/dialogs'

export default {
	name: 'Navigation',

	components: {
		NoEmailAddressWarning,
		ReminderModal,
		ReminderListItem,
		// NoteIcon,
		NcAppNavigation,
		// NcEmptyContent,
		// NcAppNavigationItem,
		NcActionButton,
		// NcAppNavigationNewItem,
		// NcAppNavigationNew,
		PlusIcon,
		NcAppNavigationCaption,
		// DeleteIcon,
		// FileExportIcon,
	},

	directives: {
		ClickOutside,
	},

	props: {
		notes: {
			type: Object,
			default: null,
		},
		selectedNoteId: {
			type: Number,
			default: 0,
		},
		loading: {
			type: Boolean,
			default: false,
		},
	},

	data() {
		return {
			creating: false,
			showModalForNewReminder: false,
		}
	},
	computed: {
		reminders() {
			return store.reminders
		},
		currentUser() {
			return store.currentUser
		},
		defaultReminder() {
			return Reminder.createDefault()
		},
		hasUserEmailAddress() {
			return !!this.currentUser?.email
		},
		sortedReminders() {
			return [...this.reminders].sort((reminder1, reminder2) => reminder1.name.localeCompare(reminder2.name))
		},
	},
	beforeMount() {
		this.setReminders()
	},
	methods: {
		onCreate(value) {
			console.debug('create new note')
		},

		closeModal() {
			this.showModalForNewReminder = false
		},

		setReminders: mutations.setReminders,

		deleteReminder: mutations.deleteReminder,
	},
}
</script>
<style scoped lang="scss">
.addNoteItem {
	position: sticky;
	top: 0;
	z-index: 1000;
	border-bottom: 1px solid var(--color-border);
	:deep(.app-navigation-entry) {
		background-color: var(--color-main-background-blur, var(--color-main-background));
		backdrop-filter: var(--filter-background-blur, none);
		&:hover {
			background-color: var(--color-background-hover);
		}
	}
}

:deep(.selectedNote) {
	> .app-navigation-entry {
		background: var(--color-primary-light, lightgrey);
	}

	> .app-navigation-entry a {
		font-weight: bold;
	}
}
</style>
