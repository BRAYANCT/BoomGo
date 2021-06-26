<template>
    <div v-if="validateShow()" :class='classTag'  >
        {{ getMessage() }}
    </div>
</template>

<script>
    export default {
        name: 'ValidationErrorMessage',
        props: {
            errors:{ default: null },
            name : { default:'' },
            classTag: { default:'form-text-error' },
        },
        mounted() {

        },
        methods:{
            validateShow: function(){
                if(this.errors == null){
                    return false;
                }

                if(!this.errors[this.name]){
                    return false;
                }
                return true;
            },
            getMessage: function(){
                if(!this.validateShow()){
                    return;
                }
                return this.errors[this.name][0];
            },

        },
        // watch: {
        //     errors: function (val) {
        //         this.validateShow();
        //     },
        // }
    }
</script>
