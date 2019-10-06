<template>
    <div>
        <editor v-model="editorModel" :init="tinyMceConfiguration"></editor>
        {{ editorData }}
    </div>
</template>

<script>
/* core */
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/modern/theme';
/* tinymce-vue */
import Editor from '@tinymce/tinymce-vue';
export default {
    data() {
        return {
            editorData: 'default3',
            tinyMceConfiguration: {
                branding: false,
                skin_url: '/_assets/tinymce/skins/lightgray',
                language_url: '/_assets/tinymce/langs/de.js',
                language: 'de',
              	/* plugins (this way, we can place the plugins anywhere and all assets are found) */
                external_plugins: {
                    advlist: '/_assets/tinymce/plugins/advlist/plugin.min.js',
                    anchor: '/_assets/tinymce/plugins/anchor/plugin.min.js',
                    autolink: '/_assets/tinymce/plugins/autolink/plugin.min.js',
                    charmap: '/_assets/tinymce/plugins/charmap/plugin.min.js',
                    code: '/_assets/tinymce/plugins/code/plugin.min.js',
                    contextmenu: '/_assets/tinymce/plugins/contextmenu/plugin.min.js',
                    directionality: '/_assets/tinymce/plugins/directionality/plugin.min.js',
                    emoticons: '/_assets/tinymce/plugins/emoticons/plugin.min.js',
                    fullscreen: '/_assets/tinymce/plugins/fullscreen/plugin.min.js',
                    hr: '/_assets/tinymce/plugins/hr/plugin.min.js',
                    image: '/_assets/tinymce/plugins/image/plugin.min.js',
                    insertdatetime: '/_assets/tinymce/plugins/insertdatetime/plugin.min.js',
                    link: '/_assets/tinymce/plugins/link/plugin.min.js',
                    lists: '/_assets/tinymce/plugins/lists/plugin.min.js',
                    media: '/_assets/tinymce/plugins/media/plugin.min.js',
                    nonbreaking: '/_assets/tinymce/plugins/nonbreaking/plugin.min.js',
                    pagebreak: '/_assets/tinymce/plugins/pagebreak/plugin.min.js',
                    paste: '/_assets/tinymce/plugins/paste/plugin.min.js',
                    preview: '/_assets/tinymce/plugins/preview/plugin.min.js',
                    print: '/_assets/tinymce/plugins/print/plugin.min.js',
                    save: '/_assets/tinymce/plugins/save/plugin.min.js',
                    searchreplace: '/_assets/tinymce/plugins/searchreplace/plugin.min.js',
                    spellchecker: '/_assets/tinymce/plugins/spellchecker/plugin.min.js',
                    table: '/_assets/tinymce/plugins/table/plugin.min.js',
                    template: '/_assets/tinymce/plugins/template/plugin.min.js',
                    textcolor: '/_assets/tinymce/plugins/textcolor/plugin.min.js',
                    visualblocks: '/_assets/tinymce/plugins/visualblocks/plugin.min.js',
                    visualchars: '/_assets/tinymce/plugins/visualchars/plugin.min.js',
                    wordcount: '/_assets/tinymce/plugins/wordcount/plugin.min.js'
                },
                paste_as_text: true,
                menubar: 'file edit view',
                menubar: false,
                statusbar: false,
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons mybutton',
              	// set this to false if no p tag should be wrapped
              	forced_root_block: 'p',
              	// these three options prevent tinymce from auto converting links to relative links
                relative_urls: false,
                convert_urls: false,
                remove_script_host: false,
                setup: editor => {
                    editor.addButton('mybutton', {
                        text: 'My button',
                      	tooltip: 'Some help',
                        icon: false,
                        onclick: () =>
                        {
                            if (confirm('Press a button!') == true)
                            {
                                editor.insertContent('&nbsp;<b>You pressed OK, gringo!</b>&nbsp;');
                            }
                            else
                            {
                                editor.insertContent('&nbsp;<b>You pressed NOT OK, motherfucker!</b>&nbsp;');
                            }                            
                        }
                    });
                    this.maxLengthPreventInput(editor);
                    editor.on('focus', (e) => {
						/* focus event */
                    });
                    editor.on('blur', (e) => {
                        /* blur event */
                    });
                },
                paste_preprocess: (plugin, args) => {
                    args = this.maxLengthPreventPaste(args);
                }
            }
        }
    },
    watch: {},
    components: {
        'editor': Editor
    },
    methods: {
		maxLengthPreventInput(editor) {
            if (this.maxlength) {
                let allowedKeys = [8, 37, 38, 39, 40, 46]; // backspace, delete and cursor keys
                editor.on('keydown', (e) => {
                    let length = editor.getContent({ format: 'text' }).length;
                    if (allowedKeys.indexOf(e.keyCode) != -1) {
                        return true;
                    }
                    if (length + 1 > this.maxlength) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                    return true;
                });
            }
        },
        maxLengthPreventPaste(args) {
            if (this.maxlength) {
                let length_old = args.target.getContent({ format: 'text' }).length,
                    length_new = args.content.length;
                if (length_old + length_new > this.maxlength) {
                    args.content = args.content
                        .substr(0, this.maxlength - length_old)
                        .replace(/<\/?[^>]+(>|$)/g, ''); // strip html tags
                }
            }
            return args;
        },
    },
    computed: {
        editorModel: {
            get()
            {
                return this.editorData;
            },
            set(value)
            {
                this.editorData = value;
            }
        }
    },
    created() {},
    mounted() {},
  	props: {
     	maxlength: Number 
    }
}
</script>

<style>
</style>