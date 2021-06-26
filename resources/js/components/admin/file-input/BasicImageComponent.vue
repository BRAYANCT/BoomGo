
<template>
    <div class="row">
        <div class="col-md-12">
            <label :for="inputId" :class="inputLabelClass" >{{ inputLabel }}</label>
            <div class="file-loading">
                <input :id="inputId" :name="inputName" type="file" accept="image/*" class="form-control" >
            </div>

            <small v-if="helper" class="form-text text-muted helper-text text-primary" >
                {{ helper }}
            </small>
        </div>
    </div>
</template>

<script type="text/javascript">

    require("../../../bootstrap-fileinput");

    let inputImage;

    export default {
        props: {
            urlImage: String,
            inputLabel: { type: String, default: 'Seleccione la imagen:'},
            inputLabelClass: { type: String, default: ''},
            inputName: { type: String, default: 'image'},
            helper: String,
        },

        data(){
            return {
                inputId: this.getInputId(),
            }
        },
        created(){
            // console.log('Component creado.');
        },
        mounted() {
            // console.log("Mounted BasicImageComponent",this.urlImage);
            // //inicializa el input de imagenes
            initInputImage(this.inputId);

            //agrega la imagen previa
            this.setUrlImage(this.urlImage);
        },
        methods:{
            getInputId:  function()  {
                return fg.generateUniqueString('image-');
            },
            setUrlImage:  function(urlImage)  {
                if(!fg.isEmpty(urlImage)){
                    inputImage.fileinput('clear');
                    inputImage.fileinput('refresh', {defaultPreviewContent: `<img class="img-fluid" src="${urlImage}">`});
                    inputImage.fileinput('reset');
                }
            }
        },
        watch: {
            urlImage(val) {
                // console.log('watch urlImage',val);
                this.setUrlImage(val)
            },
        },
    }

    function initInputImage(inputId){

        // uploadExtraData uploadAsync
        inputImage =$(`#${inputId}`).fileinput({
            // browseClass: "btn btn-primary btn-block",
            removeClass: "btn btn-warning",
            showUpload:false,

            autoOrientImage :false,
            uploadAsync: false,
            // uploadUrl: "" ,
            language: "es",
            theme: 'fas',
            maxFileSize: configImage.max_size,
            maxFilesNum: 1,
            uploadClass: 'btn btn-primary-custom',
            allowedFileExtensions: configImage.allowed_extensions,
            browseOnZoneClick: true,
            dropZoneTitle: '<span class="d-none d-lg-inline">Arrastre y suelte aquí los archivos …</span>',
            dropZoneClickTitle:'<span class="d-none d-lg-block">(o haga clic para seleccionar archivo)</span><span class="d-inline d-lg-none">Haga clic para seleccionar archivo</span>',

        });
    }

</script>
