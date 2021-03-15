/* script.js should be compiled to bundle.js with babel or https://babeljs.io/en/repl */
// this has to be left out (because of https://github.com/WordPress/gutenberg/issues/9757)
//wp.domReady(() => {

	/* add meta field to block */
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
              	/* js style */
                return wp.element.createElement(
                    wp.element.Fragment,
                    null,
                    wp.element.createElement(BlockEdit, props),
                    wp.element.createElement(
                        wp.blockEditor.InspectorControls,
                        null,
                        wp.element.createElement(
                            wp.components.PanelBody,
                            {
                                title: 'Title of accordeon'
                            },
                            wp.element.createElement(wp.components.TextControl, {
                                label: 'Title of attr1',
                                value: props.attributes.attr1,
                                onChange: val => props.setAttributes({ attr1: val })
                            }),
                            wp.element.createElement(wp.components.TextControl, {
                                label: wp.i18n.__('Localized title of attr2', 'textdomain'),
                                value: props.attributes.attr2,
                                onChange: val => props.setAttributes({ attr2: val })
                            }),
                            wp.element.createElement(wp.components.SelectControl, {
                                label: custom_attrs_data.foo,
                                value: props.attributes.attr3,
                                onChange: val => props.setAttributes({ attr3: val }),
                                options: {[
                                    { value: null, label: '––' },
                                    { value: 'a', label: 'User A' },
                                    { value: 'b', label: 'User B' },
                                    { value: 'c', label: 'User c' }
                                ]}
                            }),
                            wp.element.createElement(wp.components.ToggleControl, {
                                label: 'Fixed Background',
                                checked: props.attributes.attr4 === true,
                                onChange: val => props.setAttributes({ attr4: val })
                            })
                        )
                    )
                );
              	/* jsx style */
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
            },
            'withcustomattrinputs'
        )
    );

	/* add meta fields to whole page */
	if (window.pagenow === 'post') {
        wp.plugins.registerPlugin('my-plugin-sidebar', {
            render: () => {
                return wp.element.createElement(
                    wp.editPost.PluginDocumentSettingPanel,
                    {
                        name: 'my-plugin-sidebar',
                        icon: 'admin-site-alt3',
                        title: 'My plugin sidebar'
                    },
                    wp.element.createElement(
                        'div',
                        null,
                        /* general label / help */
                        wp.element.createElement(wp.components.BaseControl, {
                            label: 'foo',
                            help: 'bar'
                        }),
                        /* custom html */
                        wp.element.createElement('div', {
                            dangerouslySetInnerHTML: {
                                __html: '<strong>Custom html!</strong>'
                            }
                        }),
                        /* text field */
                        wp.element.createElement(
                            wp.compose.compose(
                                wp.data.withDispatch((dispatch, props) => {
                                    return {
                                        setMetaFieldValue: value => {
                                            dispatch('core/editor').editPost({
                                                meta: { [props.fieldName]: value }
                                            });
                                        }
                                    };
                                }),
                                wp.data.withSelect((select, props) => {
                                    return {
                                        metaFieldValue: select('core/editor').getEditedPostAttribute('meta')[
                                            props.fieldName
                                        ]
                                    };
                                })
                            )(props => {
                                return wp.element.createElement(wp.components.TextControl, {
                                    label: 'Meta Block Field',
                                    value: props.metaFieldValue,
                                    onChange: content => {
                                        props.setMetaFieldValue(content);
                                    }
                                });
                            }),
                            { fieldName: 'page_field_1' }
                        ),
                        /* radio field */
                        wp.element.createElement(
                            wp.compose.compose(
                                wp.data.withDispatch((dispatch, props) => {
                                    return {
                                        setMetaFieldValue: value => {
                                            dispatch('core/editor').editPost({
                                                meta: { [props.fieldName]: value === true ? '1' : '0' }
                                            });
                                        }
                                    };
                                }),
                                wp.data.withSelect((select, props) => {
                                    return {
                                        metaFieldValue: select('core/editor').getEditedPostAttribute('meta')[
                                            props.fieldName
                                        ]
                                    };
                                })
                            )(props => {
                                return wp.element.createElement(wp.components.ToggleControl, {
                                    label: 'Meta Block Field',
                                    checked: props.metaFieldValue == '1',
                                    onChange: content => {
                                        props.setMetaFieldValue(content);
                                    }
                                });
                            }),
                            { fieldName: 'page_field_2' }
                        ),
                        /* select field */
                        wp.element.createElement(
                            wp.compose.compose(
                                wp.data.withDispatch((dispatch, props) => {
                                    return {
                                        setMetaFieldValue: value => {
                                            dispatch('core/editor').editPost({
                                                meta: { [props.fieldName]: value }
                                            });
                                        }
                                    };
                                }),
                                wp.data.withSelect((select, props) => {
                                    return {
                                        metaFieldValue: select('core/editor').getEditedPostAttribute('meta')[
                                            props.fieldName
                                        ]
                                    };
                                })
                            )(props => {
                                return wp.element.createElement(wp.components.SelectControl, {
                                    label: 'Meta Block Field',
                                    value: props.metaFieldValue,
                                    options: [
                                        { value: null, label: wp.i18n.__('Localized label', 'textdomain') },
                                        { label: 'Big', value: '100%' },
                                        { label: 'Medium', value: '50%' },
                                        { label: 'Small', value: '25%' }
                                    ],
                                    onChange: content => {
                                        props.setMetaFieldValue(content);
                                    }
                                });
                            }),
                            { fieldName: 'page_field_3' }
                        )
                    )
                );
            }
        });
    }

//});