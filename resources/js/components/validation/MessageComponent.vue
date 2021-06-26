<template>
    <div v-if="validateShow()" :class='getClass()+" "+classTag'  >
        {{ getMessage() }}
    </div>
</template>

<script>
    export default {
        name: 'ValidationMessage',
        props: {
            errors:{ default: null },
            name : { default:'' },
            classTag: { default:'' },
        },
        mounted() {
            // console.log('Component mounted Error Message.',this.errors,this.name);

        },
        methods:{
            validateShow: function(){
                if(this.errors == null){
                    return false;
                }
                return true;
            },
            getMessage: function(){
                if(this.errors[this.name]){
                    return this.errors[this.name][0];
                }
                return "El campo es correcto.";
            },
            getClass: function()  {
                if(this.errors[this.name]){
                    return 'form-text-error';
                }
                return " form-text-success ";
            },
        },
        // watch: {
        //     name: function (val) {
        //         this.
        //     },
        // }
    }
</script>
