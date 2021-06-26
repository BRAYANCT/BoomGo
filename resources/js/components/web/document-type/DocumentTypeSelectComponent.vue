<template>
    <div class="row">
        <div class="col-md-12" >
            <div class="form-group md-style">
                <label >Doc. Identidad*</label>
                <Select2
                    v-model="documentTypeId"
                    :name="documentTypeInputName"
                    :options="optionsDocumentType"
                    :settings="{ theme: 'bootstrap4',width:'100%', minimumResultsForSearch: -1, placeholder:'Seleccione'}"
                    :class="getValidClassInput(documentTypeInputName)" >
                </Select2>
                <validation-message  :errors="errors" :name="documentTypeInputName" ></validation-message>
            </div>
        </div><!--/col-->
    </div>
</template>

<script>

import { DocumentTypeService } from "../../../services/web/document-type.service";

import Select2 from "v-select2-component";
import { validationMixin } from "../../../mixins/validation-mixin";

const documentTypeService = new DocumentTypeService();

export default {
    components: {
        Select2,
    },
    mixins: [
        validationMixin,
    ],
    props: {
        documentTypeInputName: { default:'document_type_id'},
        errorsProp: { default: null},
    },
    data(){
        return {
            documentTypes: [],
            optionsDocumentType: [],
            documentTypeId: '',
        }
    },
    mounted() {
        // console.log('Component DocumentType Select 2 mounted.');
        this.getDocumentTypes();
    },
    methods: {
        getDocumentTypes: async function(){
            this.documentTypes = await documentTypeService.getAll();
            // console.log('documentTypes:',this.documentTypes);
        },
        setOptionsDocumentType: async function(){
            // console.log("setOptionsProvince");
            this.optionsDocumentType = [];
            this.documentTypes.forEach((item)=>{
                this.optionsDocumentType.push({id: item.id, text: item.name});
            });
        },
    },
    watch:{
        errorsProp: function (val) {
            // console.log('errors documentType');
            this.errors = val;
        },
        documentTypes: function (val) {
            this.setOptionsDocumentType();
        },
    }
}
</script>
