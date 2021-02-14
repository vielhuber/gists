/* script.js should be compiled to bundle.js with babel or https://babeljs.io/en/repl */
// this has to be left out (because of https://github.com/WordPress/gutenberg/issues/9757)
//wp.domReady(() => {
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
            },
            attr3: {
                type: 'string',
                default: ''
            },
            attr4: {
                type: 'boolean',
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
                                        label={wp.i18n.__('Localized title of attr2', 'textdomain')}
                                        value={props.attributes.attr2}
                                        onChange={val => props.setAttributes({ attr2: val })}
                                    />
                                    <wp.components.SelectControl
                                        label={custom_attrs_data.foo}
                                        value={props.attributes.attr3}
                                        onChange={val => props.setAttributes({ attr3: val })}
                                        options={[
                                                 { value: null, label: '––' },
                                                 { value: 'a', label: 'User A' },
                                                 { value: 'b', label: 'User B' },
                                                 { value: 'c', label: 'User c' }
                                                 ]}
                                    />
                                    <wp.components.ToggleControl
                                        label="Fixed Background"
                                        checked={props.attributes.attr4 === true}
                                        onChange={val => props.setAttributes({ attr4: val })}
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
//});