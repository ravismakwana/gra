const getBlockColumn = (optionVal, colClassName, heading) => {
	return [
		'core/column',
		{ className: colClassName },
		[
			[
				'asgard-blocks/heading',
				{
					className: 'asgard-dos-and-donts__heading',
					option: optionVal,
					content: heading,
				},
			],
			[
				'core/list',
				{
					className: 'asgard-dos-and-donts__list',
				},
			],
		],
	];
};

export const blockColumn = [
	[
		'core/columns',
		{
			className: 'asgard-dos-and-donts__columns',
		},
		[
			getBlockColumn('dos', 'asgard-dos-and-donts-col-one', 'Dos'),
			getBlockColumn('donts', 'asgard-dos-and-donts-col-one', "Dont's"),
		],
	],
];
