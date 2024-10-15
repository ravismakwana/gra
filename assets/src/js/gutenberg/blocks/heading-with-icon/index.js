import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';
import Edit from './Edit';
import { getIconComponent } from './map-icons';

registerBlockType('asgard-blocks/heading', {
	title: __('Icon Heading', 'asgard'),
	description: __('This is the description of heading icon block', 'asgard'),
	category: 'asgard',
	icon: 'admin-customizer',
	attributes: {
		option: {
			type: 'string',
			default: 'dos',
		},
		content: {
			type: 'string',
			source: 'html',
			selector: 'h4',
			default: __('Dos', 'asgard'),
		},
	},
	edit: Edit,
	save({ attributes: { option, content } }) {
		const HeadingIcon = getIconComponent(option);
		return (
			<div className="asgard-icon-heading">
				<span className="asgard-icon-heading__heading">
					<HeadingIcon />
				</span>
				<RichText.Content tagName="h4" value={content} />
			</div>
		);
	},
});
