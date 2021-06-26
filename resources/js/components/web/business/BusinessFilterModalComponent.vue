<template>
       <div class="modal fade" :id="modalId" tabindex="-1"  >
           <div class="modal-dialog" >
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" >Buscar negocios</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>

                   <form :action="$root.getCompleteUrlByUri('negocios')" method="GET">
                       <div class="modal-body">

                           <div class="form-group">
                               <div class="input-group input-icon-custom border">
                                   <div class="input-group-prepend" >
                                        <span class="input-group-text h-100" >
                                            <i class="fas fa-search"></i>
                                        </span>
                                   </div>
                                   <input v-model="searchText" type="text" class="form-control" placeholder="Buscar restaurantes, barberías ..." name="search_text"   />
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="form-group md-style">
                                   <label >Provincia*:</label>
                                   <Select2
                                       v-model="provinceId"
                                       name="province_id"
                                       :options="optionsProvince"
                                       :settings="{ theme: 'bootstrap4',width:'100%' }"
                                       >
                                   </Select2>
                               </div>
                           </div>


                       </div><!--/modal-body-->
                       <div class="modal-footer">
                           <button type="submit" class="btn btn-primary-custom">
                               Buscar
                           </button>
                           <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                               Cerrar
                           </button>
                       </div><!--/modal-footer-->
                   </form>
               </div><!--/modal-content-->
           </div><!--/modal-dialog-->
       </div><!--/modal-->
</template>

<script>

import { ProvinceService } from "../../../services/web/province.service";

const provinceService = new ProvinceService();

import Select2 from "v-select2-component";

export default {
    components: {
        Select2,
    },
    data(){
        return {
            modalId: this.getModalId(),

            provinces:[],
            optionsProvince: [ {id: 'todas', text: 'Todas' ,selected:true} ],
            provinceId: 'todas',
            searchText:'',
        }
    },
    mounted() {
        // console.log('Component Business Filter Modal mounted.');
        this.getProvinces();
    },methods: {
        getModalId: function (){
            return 'search-business-modal';
        },
        showModal: async function () {
            this.provinceId = "todas";
            this.searchText = "";
            $(`#${this.modalId}`).modal('show');
        },
        getProvinces: async function () {
            this.provinces = await provinceService.getAll();
        },
        setOptionsProvince: async function(){
            this.provinces.forEach((item)=>{
                this.optionsProvince.push({id: item.id, text: item.name});
            });
        },
    },watch: {
        provinces(val) {
            this.setOptionsProvince();
        },
    }
}
</script>
