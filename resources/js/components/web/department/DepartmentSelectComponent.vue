<template>
    <div class="row">
        <div class="col-md-12" >
            <div class="form-group md-style">
                <label >Departamento*</label>
                <Select2
                    v-model="departmentId"
                    name="department_id"
                    :options="optionsDepartment"
                    :settings="{ theme: 'bootstrap4',width:'100%',placeholder:'Seleccione el departamento'}"
                    :class="getValidClassInput('department_id')" >
                </Select2>
                <validation-message  :errors="errors" name="department_id" ></validation-message>
            </div>
        </div><!--/col-->
    </div>
</template>

<script>

import { DepartmentService } from "../../../services/web/department.service";

import Select2 from "v-select2-component";
import { validationMixin } from "../../../mixins/validation-mixin";

const departmentService = new DepartmentService();

export default {
    components: {
        Select2,
    },
    mixins: [
        validationMixin,
    ],
    props: {
        errorsProp: { default: null},
    },
    data(){
        return {
            departments: [],
            optionsDepartment: [{id: '0', text: 'Seleccione el departamento' ,selected:true}],
            departmentId: '0',
            defaultOption: this.getDefaultOption(),
        }
    },
    mounted() {
        // console.log('Component Department Select 2 mounted.');
        this.getDepartments();
    },
    methods: {
        getDepartments: async function(){
            this.departments = await departmentService.getAll();
            // console.log('departments:',this.departments);
        },
        getDefaultOption: function (){
            return {id: '0', text: 'Seleccione el departamento',selected:true}
        },
        setOptionsDepartment: async function(){
            // console.log("setOptionsProvince");
            this.optionsDepartment = [];
            this.optionsDepartment = [this.defaultOption];
            this.departmentId = "0";
            this.departments.forEach((item)=>{
                this.optionsDepartment.push({id: item.id, text: item.name});
            });
        },
    },
    watch:{

        departmentId: function (val) {
            this.$emit('changeValue',val);
        },
        departments: function (val) {
            this.setOptionsDepartment();
        },
        errorsProp: function (val) {
            this.errors = val;
        },
    }
}
</script>
