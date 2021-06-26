import ValidationMessage from '../components/validation/MessageComponent';
import ValidationErrorMessage from '../components/validation/ErrorMessageComponent';


export const validationMixin = {
    components: {
        'validation-message': ValidationMessage,
        'validation-error-message': ValidationErrorMessage,
    },
    data() {
        return {
            errors: null,
        }
    },
    methods: {
        /**
         * Borra todos los errores
         *
         * @return void
         */
        cleanErrors:function(){
            this.errors = null;
        },
        cleanError:function(key){
            if(this.errors){
                delete this.errors[key];
            }
        },
        /**
         * Verifica si un input con array tiene errores en sus valores
         *
         * @param  String name  Nombre del input sin []
         * @param  Array array Valores del input
         * @return Boolean
         */
        fieldArrayHasErrors:function(name,array){
            let retorno = false;
            if(!fg.isEmpty(this.errors) ){
                for (var i = 0; i < array.length; i++) {
                    if(this.errors[`${name}.${i}`]){
                        retorno = true;
                        break;
                    }
                }
            }
            return retorno;
        },

        /**
         * Verifica si el input tiene un error o si sus valores tienen error y devuelve la clase de validacion del input
         *
         * @param  String name  Nombre del input sin []
         * @param  Array array Valores del input
         * @return String Clase de la validacion
         */
        getValidClassInputArray: function(name,array){
            if(!fg.isEmpty(this.errors) ){
                if(this.fieldArrayHasErrors(name,array)){
                    return 'is-invalid';
                }
                return this.errors[name] ? 'is-invalid' : 'is-valid';
            }
            return '';
        },

        /**
         * Devuelve la clase de validacion del input
         *
         * @param  String name  Nombre del input
         * @return String Clase de la validacion
         */
        getValidClassInput: function(name){
            if(!fg.isEmpty(this.errors) ){
                return this.errors[name] ? 'is-invalid' : 'is-valid';
            }
            return '';
        },
        /**
         * Devuelve la clase de validacion del input de una lista
         *
         * @param  String name  Nombre del input
         * @param int index Posicion del item
         * @param int listValidateLength Tamanio de la lista validada
         * @return String Clase de la validacion
         */
        getValidClassInputList: function(name,index,listValidateLength){
            if(this.checkIsItemValidate(index,listValidateLength)){
                return this.getValidClassInput(`${name}.${index}`);
            }
            return '';
        },
        /**
         * Verifica si el item de una lista esta validado
         *
         * @param int index Posicion del item
         * @param int listValidateLength Tamanio de la lista validada
         * @return Boolean
         */
        checkIsItemValidate: function(index,listValidateLength) {
            return index < listValidateLength;
        },
    }
};
