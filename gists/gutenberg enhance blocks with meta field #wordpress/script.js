wp.domReady(() => {
    wp.hooks.addFilter('blocks.registerBlockType', 'custom/attrs', settings => {
        settings.attributes = {
            ...settings.attributes,
            attr1: {
                type: 'string',
                default: ''
            },
            attr2: {
                type: 'string',
                default: ''
            }
        };
        return settings;
    });

    wp.hooks.addFilter(
        'editor.BlockEdit',
        'custom/attrinputs',
        wp.compose.createHigherOrderComponent(
            BlockEdit => props => {
                return (
                    <wp.element.Fragment>
                        <BlockEdit {...props} />
                        {
                            <wp.blockEditor.InspectorControls>
                                <wp.components.PanelBody title="Title of accordeon">
                                    <wp.components.TextControl
                                        label="Title of attr1"
                                        value={props.attributes.attr1}
                                        onChange={val => props.setAttributes({ attr1: val })}
                                    />
                                    <wp.components.TextControl
                                        label="Title of attr2"
                                        value={props.attributes.attr2}
                                        onChange={val => props.setAttributes({ attr2: val })}
                                    />
                                </wp.components.PanelBody>
                            </wp.blockEditor.InspectorControls>
                        }
                    </wp.element.Fragment>
                );
                return <BlockEdit {...props} />;
            },
            'withcustomattrinputs'
        )
    );
});