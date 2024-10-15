import { InnerBlocks } from '@wordpress/block-editor';
import { blockColumn } from './template';

const ALLOWED_BLOCKS = ['core/group'];

const INNER_BLOCK_TEMPLATE = [
	[
		'core/group',
		{
			className: 'asgard-dos-and-donts__group',
			backgroundColor: 'luminous-vivid-amber',
		},
		blockColumn,
	],
];
const Edit = () => {
	return (
		<div className="asgard-dos-and-donts">
			<InnerBlocks
				template={INNER_BLOCK_TEMPLATE}
				templateLock={true}
				allowedBlocks={ALLOWED_BLOCKS}
			/>
		</div>
	);
};
export default Edit;
