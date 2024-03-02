<template>
	<div class="main-content">
		<h2>
			{{ note.name }}
		</h2>
		<NcRichContenteditable
			class="content-editable"
			:value="note.content"
			:maxlength="10000"
			:multiline="true"
			:placeholder="t('calendarreminder', 'Write a note')"
			@update:value="onUpdateValue" />
	</div>
</template>

<script>
import NcRichContenteditable from '@nextcloud/vue/dist/Components/NcRichContenteditable.js'

export default {
	name: 'MyMainContent',

	components: {
		NcRichContenteditable,
	},

	props: {
	},

	data() {
		return {
			note() {
				return {
					name: 'Sander',
					content: 'Inhoud',
				}
			},
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
		onUpdateValue() {
			//
		},
	},
}
</script>

<style scoped lang="scss" rel="stylesheet/scss">
.main-content {
	height: 100%;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;

	.content-editable {
		min-width: 600px;
		min-height: 200px;
	}
}
</style>
