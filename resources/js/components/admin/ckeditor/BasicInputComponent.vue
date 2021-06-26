<template>
        <div class="row justify-content-center">
            <div class="col-12" :class="getClassContainerEditor()">
                <label v-if="labelText !== ''">{{ labelText }}</label>
                <ckeditor
                    :editor="editor"
                    v-model="editorContent"
                    :config="editorConfig"
                    ></ckeditor>
                <textarea :name="name" style="display: none" >{{ editorContent }}</textarea>
            </div><!--/col-->
        </div><!--/row-->
</template>

<style>
    .ck-content.ck-editor__editable {
        min-height: 500px !important;
    }

    .ck-sm .ck-content.ck-editor__editable {
        min-height: 250px !important;
    }

</style>

<script>

require('../../../../../public/plugins/ckeditor5/build/ckeditor');

let urlUpload = `${urlPagina}/api/admin/images/store/editor-public`;

export default {
    props: {
        placeholderProp: { type: String, default: 'Ingrese el contenido'},
        contentProp: { type: String, default: ''},
        sizeProp : { type: String, default: '' },
        labelTextProp: { type: String, default: '' },
        nameProp: { type: String, default: 'editor' },
    },
    data() {
        return {
            editor: ClassicEditor,
            editorContent: this.contentProp,
            editorConfig: {
                placeholder: this.placeholderProp,
                simpleUpload: {
                    // The URL that the images are uploaded to.
                    uploadUrl: urlUpload,

                    // Headers sent along with the XMLHttpRequest to the upload server.
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        'Authorization': 'Bearer '+document.head.querySelector('meta[name="api-token"]').content,
                    }
                },
                mediaEmbed:{
                    previewsInData :true,
                }
            },
            labelText: this.labelTextProp,
            size: this.sizeProp,
            name: this.nameProp,
        };
    },
    mounted() {
        // console.log('Component Ckeditor Basic Input mounted.')
    },
    methods: {
        getClassContainerEditor: function () {
            if(!fg.isEmpty(this.size)){
                return `ck-${this.size}`;
            }
        },
    },
    watch: {
        contentProp: function (value) {
            this.editorContent = value;
        },
    }
}
</script>
