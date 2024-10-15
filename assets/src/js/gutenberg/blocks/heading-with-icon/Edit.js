import { InspectorControls, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { RadioControl, PanelBody } from '@wordpress/components';
import { getIconComponent } from './map-icons';

const Edit = ({ className, attributes, setAttributes }) => {
	const { option, content } = attributes;

	const HeadingIcon = getIconComponent(option);
	console.warn('Option HeadingIcon', option, HeadingIcon);
	return (
		<div className="asgard-icon-heading">
			<span className="asgard-icon-heading__heading">
				<HeadingIcon />
			</span>
			<RichText
				tagName="h4"
				className={className}
				value={content}
				onChange={(content) => setAttributes({ content })}
				placeholder={__('Heading...', 'asgard')}
			/>
			<InspectorControls>
				<PanelBody title={__('Heading Settings', 'asgard')}>
					<RadioControl
						label={__('Select Icon', 'asgard')}
						help={__('Controls Icon Selection', 'asgard')}
						selected={option}
						options={[
							{ label: __('Dos', 'asgard'), value: 'dos' },
							{ label: __("Dont's", 'asgard'), value: 'donts' },
						]}
						onChange={(option) => setAttributes({ option })}
					/>
				</PanelBody>
			</InspectorControls>
		</div>
	);
};
export default Edit;
