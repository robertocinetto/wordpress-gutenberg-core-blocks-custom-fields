import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import { CheckboxControl, PanelBody, PanelRow } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

addFilter('blocks.registerBlockType', 'rc/columns', function (settings, name) {
	if (name !== 'core/columns') {
		return settings;
	}

	return {
		...settings,
		attributes: {
			...settings.attributes,
			reverseOnMobile: {
				type: 'boolean',
				default: false
			}
		}
	};
});

function Edit(props) {
	const setReverseOnMobile = (value) => {
		props.setAttributes({ reverseOnMobile: value });
	};

	return (
		<InspectorControls>
			<PanelBody>
				<PanelRow>
					<CheckboxControl
						label={__('Reverse on mobile', 'rc')}
						checked={props.attributes.reverseOnMobile}
						onChange={setReverseOnMobile}
					/>
				</PanelRow>
			</PanelBody>
		</InspectorControls>
	);
}




addFilter(
	'editor.BlockEdit',
	'rc/columns',
	createHigherOrderComponent((BlockEdit) => {
		return (props) => {
			if (props.name !== 'core/columns') {
				return <BlockEdit {...props} />;
			}

			return (
				<>
					<BlockEdit {...props} />
					<Edit {...props} />
				</>
			);
		};
	})
);
