<template>
	<div class="main-content" />
</template>

<script>
// import NcRichContenteditable from '@nextcloud/vue/dist/Components/NcRichContenteditable.js'

export default {
	name: 'MainContent',

	components: {
		// NcRichContenteditable,
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
