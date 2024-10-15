import * as SvgIcons from '../../../icons';
import { isEmpty } from 'lodash';

export const getIconComponent = ( option ) => {
	const IconMap = {
		dos: SvgIcons.Check,
		donts: SvgIcons.Close,
	};
	return !isEmpty(option) && option in IconMap
		? IconMap[option]
		: IconMap.dos;
};
