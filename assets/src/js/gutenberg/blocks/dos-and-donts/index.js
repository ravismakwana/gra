import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { InnerBlocks } from '@wordpress/block-editor';
import Edit from './Edit';

registerBlockType('asgard-blocks/dos-and-donts', {
	title: __("Dos and Dont's", 'asgard'),
	description: __('Dos and Donts description', 'asgard'),
	category: 'asgard',
	icon: 'editor-table',
	edit: Edit,
	save() {
		return (
			<div className="asgard-dos-and-donts">
				<InnerBlocks.Content />
			</div>
		);
	},
});
