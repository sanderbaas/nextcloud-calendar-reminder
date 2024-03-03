<template>
	<div>
		<AppNavigationItem :name="reminder.name"
			@click.prevent>
			<template #icon>
				<CalendarCheckIcon :size="20" decorative />
			</template>
			<template #actions>
				<ActionButton :close-after-click="true"
					@click="showModal = true">
					<template #icon>
						<PencilIcon :size="20" />
					</template>
					{{ t('calendarreminder', 'Edit') }}
				</ActionButton>
				<ActionButton :close-after-click="true"
					@click="$emit('delete', $event)">
					<template #icon>
						<DeleteIcon :size="20" />
					</template>
					{{ t('calendarreminder', 'Delete') }}
				</ActionButton>
			</template>
		</AppNavigationItem>
		<ReminderModal v-if="showModal"
			:is-new="false"
			:reminder="reminder"
			@close="closeModal" />
	</div>
</template>

<script>
import {
	NcAppNavigationItem as AppNavigationItem,
	NcActionButton as ActionButton,
} from '@nextcloud/vue'
import CalendarCheckIcon from 'vue-material-design-icons/CalendarCheck.vue'
import DeleteIcon from 'vue-material-design-icons/Delete.vue'
import PencilIcon from 'vue-material-design-icons/Pencil.vue'
import Reminder from '../models/reminder.js'
import ReminderModal from './ReminderModal.vue'
// import LinkVariantIcon from 'vue-material-design-icons/LinkVariant.vue'
// import { showError, showSuccess } from '@nextcloud/dialogs'
// import logger from '../../../utils/logger.js'

export default {
	name: 'ReminderListItem',
	components: {
		ReminderModal,
		AppNavigationItem,
		ActionButton,
		// ActionLink,
		DeleteIcon,
		// OpenInNewIcon,
		PencilIcon,
		CalendarCheckIcon,
		// LinkVariantIcon,
	},
	props: {
		reminder: {
			type: Reminder,
			required: true,
		},
	},
	data() {
		return {
			showModal: false,
			loading: false,
		}
	},
	computed: {

	},
	methods: {
		closeModal() {
			this.showModal = false
		},
	},
}
</script>
