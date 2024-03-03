<template>
	<div class="app-config-modal-confirmation">
		<EmptyContent :name="title">
			<template #icon>
				<CheckIcon />
			</template>
		</EmptyContent>
		<div class="app-config-modal-confirmation__buttons" />
	</div>
</template>

<script>
import { NcEmptyContent as EmptyContent } from '@nextcloud/vue'
import CheckIcon from 'vue-material-design-icons/Check.vue'
import Reminder from '../models/reminder.js'

export default {
	name: 'Confirmation',
	components: {
		EmptyContent,
		CheckIcon,
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
	computed: {
		title() {
			if (this.isNew) {
				return t('calendarreminder', 'Reminder was created successfully')
			}

			return t('calendarreminder', 'Reminder was updated successfully')
		},
	},
	methods: {
	},
}
</script>
