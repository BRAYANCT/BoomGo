<template>
    <div class="row ">
        <div class="col-12 upload-none">
            <label :for="inputId" :class="classLabel" >{{ textLabel }}</label>
            <div class="file-loading">
                <input :id="inputId" :name="inputName" type="file" accept="image/*" class="form-control" multiple >
            </div>
            <small v-if="helper" class="form-text text-muted helper-text text-primary" >
                {{ helper }}
            </small>
        </div>
    </div><!--!row-->
</template>

<script>

let component = null;

export default {
    props: {
        imagesProp : { default: null },
        textLabelProp: { type: String, default: 'Seleccione la imagen:'},
        classLabelProp: { type: String, default: ''},
        inputNameProp: { type: String, default: 'image_multiple'},
        helperProp: { type: String, default: ''},
        maxFileCountProp: { type: Number, default: 5},
        loadInputProp: { default: false },
    },
    data(){
        return {
            images: this.imagesProp,
            inputId: this.getInputId(),
            inputImage: null,
            textLabel: this.textLabelProp,
            classLabel: this.classLabelProp,
            inputName: this.inputNameProp,
            helper: this.helperProp,
            maxFileCount: this.maxFileCountProp,
            filesToUpload: [],
            errors: []
        }
    },
    mounted() {
        // console.log('Component Multiple Image mounted.',this.images);
        component = this;
        this.initInputImage();
    },
    methods: {
        getInputId: function () {
            return fg.generateUniqueString('image-multiple');
        },
        filesToUploadRemove: function (id) {
            this.filesToUpload.some((item, index, array)=>{
                if(item.id == id){
                    this.filesToUpload.splice(index,1)
                    return true;
                }
            });
        },
        filesToUploadClear: function () {
            this.filesToUpload = [];
        },
        getInitialPreview:function(){
            return this.images.map((item)=>{
                return item.picture_url_thumbnail;
            })

            //     [
            //     "http://lorempixel.com/800/460/people/1",
            //     "http://lorempixel.com/800/460/people/2"
            // ]
        },
        getInitialPreviewConfig:function(){
            return  this.images.map((item)=>{
                return { key: item.id,caption: item.name,url:`/api/admin/images/${item.id}/destroy-from-file-input`};
            })


            // [
            //     {caption: "People-1.jpg", size: 576237, width: "120px", url: "/site/file-delete", key: 1},
            //     {caption: "People-2.jpg", size: 932882, width: "120px", url: "/site/file-delete", key: 2},
            // ]
        },
        initInputImage: function () {
            // console.log('initInputImage');

            let initialPreview = [];
            let initialPreviewConfig = [];
            let initialPreviewAsData = false;

            if(this.images && this.images.length > 0){
                initialPreview = this.getInitialPreview();
                initialPreviewConfig = this.getInitialPreviewConfig();
                initialPreviewAsData =  true;

            }


            this.inputImage =$(`#${this.inputId}`).fileinput({
                language: "es",
                theme: 'fas',
                autoOrientImage :false,
                // browseClass: "btn btn-primary btn-block",
                removeClass: "btn btn-warning",
                uploadClass: 'btn btn-primary-custom',

                uploadUrl: "images/test",
                uploadAsync: true,
                showUpload:false,

                allowedFileExtensions: this.$root.configImages.allowed_extensions,
                maxFileSize: this.$root.configImages.max_size,
                maxFileCount: this.maxFileCount,

                overwriteInitial: false,
                initialPreview: initialPreview,
                initialPreviewConfig: initialPreviewConfig,
                initialPreviewAsData: initialPreviewAsData, // identify if you are sending preview data only and not the raw markup
                initialPreviewFileType: 'image', // image is the default and can be overridden in config below


                // msgErrorClass: 'd-none',
                browseOnZoneClick: true,
                dropZoneTitle: '<span class="d-none d-lg-inline">Arrastre y suelte aquí los archivos …</span>',
                dropZoneClickTitle:'<span class="d-none d-lg-block">(o haga clic para seleccionar archivo)</span><span class="d-inline d-lg-none">Haga clic para seleccionar archivo</span>',

            })

            .on('change', function(event) {
                // console.log('cambio la imagen change',event);

            }).on('fileloaded', (event,file, previewId, fileId, index, reader) => {
                // console.log('cargo la imagen fileloaded',event);
                // console.log('file',file);
                // console.log('previewId',previewId);
                // console.log('fileId',fileId);
                // console.log('index',index);
                // console.log("component:",component);

                component.filesToUpload.push( { 'id':previewId,file:file}     )

            }).on('fileclear', function(event) {
                component.filesToUploadClear();
            }).on('filecleared', function(event) {
                    component.filesToUploadClear();
            }).on('fileremoved', function(event, id, index) {

                component.filesToUploadRemove(id);

            }).on('filepreupload', function() {
                // console.log('cargo la imagen filepreupload');

            }).on('fileuploaded', function(e, params) {
                    // console.log('file uploaded', e, params);
            }).on('filebatchuploadsuccess', function(e, params) {
                // console.log('file filebatchuploadsuccess', e, params);
            }).on('fileuploaderror', function(event, data, msg) {
                // console.log('file fileuploaderror', event, data, msg);
                // console.log("response:",data.response)
                // if(data.jqXHR.responseJSON){
                //     console.log('error en servidor');
                // }else{
                //     console.log('error antes de servidor ');
                // }

            });

            // setTimeout(()=>{
            //     $(`#${this.inputId}`).fileinput('reset');
            // }, 1000);




            // this.inputImage.fileinput('refresh', {initialPreviewConfig: [
            //         {caption: "People-1.jpg", size: 576237, width: "120px", url: "/site/file-delete", key: 1},
            //         {caption: "People-2.jpg", size: 932882, width: "120px", url: "/site/file-delete", key: 2},
            //     ]});

            // this.inputImage.fileinput('initialPreviewConfig',  [
            //     {caption: "People-1.jpg", size: 576237, width: "120px", url: "/site/file-delete", key: 1},
            //     {caption: "People-2.jpg", size: 932882, width: "120px", url: "/site/file-delete", key: 2},
            // ]);

        },
    },
    watch: {
        filesToUpload: function(filesToUpload){
            this.$emit('changeFiles',filesToUpload)
        },
        imagesProp: function(images){
            // console.log("images in watch: ",images)
        }
    }
}
</script>
