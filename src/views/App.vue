<template>
	<NcContent app-name="calendarreminder">
		<MyNavigation />
		<NcAppContent>
			<MyMainContent v-if="true" />
			<NcEmptyContent v-else
				:title="t('tutorial_5', 'Select a note')">
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

import MyNavigation from '../components/MyNavigation.vue'
import MyMainContent from '../components/MyMainContent.vue'

// import axios from '@nextcloud/axios'
// import { generateOcsUrl, generateUrl } from '@nextcloud/router'
// import { showSuccess, showError, showUndo } from '@nextcloud/dialogs'
// import { loadState } from '@nextcloud/initial-state'

// import { Timer } from '../utils.js'

export default {
	name: 'App',

	components: {
		NoteIcon,
		NcContent,
		NcAppContent,
		NcEmptyContent,
		MyMainContent,
		MyNavigation,
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
