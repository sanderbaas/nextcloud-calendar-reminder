<template>
	<NcContent app-name="calendarreminder">
		<Navigation />
		<NcAppContent>
			<MainContent v-if="false" />
			<NcEmptyContent v-else
				:title="t('calendarreminder', 'Select a reminder to see a preview')">
				<template #icon>
					<NoteIcon :size="20" />
				</template>
			</NcEmptyContent>
		</NcAppContent>
	</NcContent>
</template>

<script>
import NcContent from '@nextcloud/vue/dist/Components/NcContent.js'
import NcAppContent from '@nextcloud/vue/dist/Components/NcAppContent.js'
import NcEmptyContent from '@nextcloud/vue/dist/Components/NcEmptyContent.js'

import NoteIcon from '../components/icons/NoteIcon.vue'

import Navigation from '../components/Navigation.vue'
import MainContent from '../components/MainContent.vue'

// import { loadState } from '@nextcloud/initial-state'

export default {
	name: 'App',

	components: {
		NoteIcon,
		NcContent,
		NcAppContent,
		NcEmptyContent,
		MainContent,
		Navigation,
	},

	props: {
	},

	data() {
		return {
		}
	},

	computed: {
	},

	watch: {
	},

	mounted() {
	},

	beforeDestroy() {
	},

	methods: {
	},
}
</script>

<style scoped lang="scss">
// nothing yet
</style>
