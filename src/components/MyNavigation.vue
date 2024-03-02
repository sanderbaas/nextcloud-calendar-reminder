<template>
	<NcAppNavigation>
		<template #list>
			<NcAppNavigationNewItem
				:title="t('calendarreminder', 'Create note')"
				@new-item="$emit('create-note', $event)">
				<template #icon>
					<PlusIcon />
				</template>
			</NcAppNavigationNewItem>
		</template>
	</NcAppNavigation>
</template>

<script>
// import FileExportIcon from 'vue-material-design-icons/FileExport.vue'
import PlusIcon from 'vue-material-design-icons/Plus.vue'
// import DeleteIcon from 'vue-material-design-icons/Delete.vue'

// import NoteIcon from './icons/NoteIcon.vue'

import NcAppNavigation from '@nextcloud/vue/dist/Components/NcAppNavigation.js'
// import NcEmptyContent from '@nextcloud/vue/dist/Components/NcEmptyContent.js'
// import NcAppNavigationItem from '@nextcloud/vue/dist/Components/NcAppNavigationItem.js'
// import NcActionButton from '@nextcloud/vue/dist/Components/NcActionButton.js'
import NcAppNavigationNewItem from '@nextcloud/vue/dist/Components/NcAppNavigationNewItem.js'

import ClickOutside from 'vue-click-outside'

export default {
	name: 'MyNavigation',

	components: {
		// NoteIcon,
		NcAppNavigation,
		// NcEmptyContent,
		// NcAppNavigationItem,
		// NcActionButton,
		NcAppNavigationNewItem,
		PlusIcon,
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
		}
	},
	computed: {
	},
	beforeMount() {
	},
	methods: {
		onCreate(value) {
			console.debug('create new note')
		},
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
