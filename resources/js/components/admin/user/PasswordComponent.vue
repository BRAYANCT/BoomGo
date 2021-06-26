<template>
    <div class="col-12" >
        <div class="row">
            <input type="hidden" name="cambio_password" v-model="showInput" >
            <template v-if="showInput" >
               <div  :class="classColInput">
                    <!-- Material input password -->
                    <div class="md-form ">

                        <input :type="typeInput ? 'password' : 'text'" id="password" name="password"  value="" class="form-control " :class="errorHas ? 'is-invalid' : '' " autocomplete="off">
                        
                        <label v-if="tipo == 1" for="password">Contraseña</label>
                        <label v-else for="password">Nueva contraseña</label>
                        <div v-if="errorHas" class="invalid-feedback"   >
                                {{ error }}
                        </div>                                      
                        
                        <small class="form-text text-muted helper-text" v-html="helperPassword">
                            
                        </small>
                    </div>
                </div>

                <div v-if="tipo == 2" :class="classColInput">
                    <div class="md-form ">

                        <input :type="typeInput ? 'password' : 'text' " id="passwordConfirmar" name="password_confirmation" value="" class="form-control "  autocomplete="off">
                        
                        <label v-if="tipo == 1" for="passwordConfirmar">Confirmar contraseña</label>
                        <label v-else for="passwordConfirmar">Confirmar nueva contraseña</label>
                                
                    </div>
                </div>
            </template>

            <div class="col-12">
                <div class="md-form ">
                    <div v-if="!showInput">
                        <button  type="button" class="btn btn-grey btn-sm" @click="cambiarShow()" > {{ buttonTexto() }} </button>  
                        
                        <small v-if="tipo == 1" class="form-text text-muted helper-text">
                            Si no genera una contraseña esta se crea de forma automática y se envía al email de la cuenta.
                        </small>

                    </div>
                    <template v-else>
                        <button  type="button" class="btn btn-danger btn-sm" @click="cambiarShow()" >
                            <i class="fas fa-ban"></i>
                            Cancelar 
                        </button>                        

                        <button type="button" class="btn btn-warning btn-sm" @click="abrirGenerarPassword()" >
                            Generador de contraseña
                        </button>

                        <button  type="button" class="btn btn-grey btn-sm py-1 px-2" @click="mostrarPassword()" >
                                <i  style="font-size: 21px;" class="fas fa-2x" :class="!typeInput ? 'fa-eye-slash' :  'fa-eye' "  ></i>  
                        </button>

                    </template>
                </div>
            </div>
        </div>



                  <!--Modal: modalConfirmar-->
      <div class="modal fade" id="modal-generar-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  style="z-index: 11000;" >
              <div class="modal-dialog modal-md modal-notify modal-success" role="document">
                  <!--Content-->
                  <div class="modal-content text-center">
                      <!--Header-->
                      <div class="modal-header d-flex justify-content-center">
                          <p class="heading">Generar contraseña</p>
                      </div>

                      <!--Body-->
                      <div class="modal-body">

                        <form  @submit.prevent >
                                
                            <div class="col-md-12">
                                 <div class="md-form ">
                                    <input type="text" id="passwordGenerado" name="passwordGenerado" v-model="passwordGenerado"  value="" class="form-control"   >
                                    <label for="passwordGenerado" class="active" >Contraseña generada</label>                                       
                                </div>
                            </div>
                            <button type="button" class="btn btn-grey btn-sm" @click="generarPassword()"  > Generar </button>

                            <div class="col-md-12">
                                <div class="md-form ">
                                    <input type="checkbox" id="checkGenerarPassword" name="checkGenerarPassword" value=""  class="change-value form-check-input" v-model="checkGenerarPassword">

                                    <label for="checkGenerarPassword" class="mr-2 label-table form-check-label ">
                                        He copiado esta contraseña en un lugar seguro.
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="md-form ">
                                    <p class="red-text">
                                        {{ errorGenerarPassword }}
                                    </p>
                                </div>
                            </div>

                        </form>

                      </div>

                      <!--Footer-->
                      <div class="modal-footer flex-center">
                            <button type="button" class="btn  btn-success" @click="utilizarPassword()" >Utilizar contraseña</button>
                            <button type="button" class="btn  btn-danger" data-dismiss="modal">Cancelar</button>
                      </div>
                  </div>
                  <!--/.Content-->
              </div>
      </div>
      <!--Modal: modalConfirmar-->


    </div>
</template>

<script>
    import DisableAutocomplete from 'vue-disable-autocomplete';

    Vue.use(DisableAutocomplete);

    export default {
        // props:['tipo','errorHas','error','helperPassword','show','classColInput'],
        props: {
              tipo: String,
              errorHas: Boolean,
              error: String,
              helperPassword: String,
              show: Boolean,
              classColInput: { type: String, default: 'col-md-6'}
            },
        data(){
            return {
                showInput: false,
                typeInput:true,
                errorGenerarPassword:'',
                checkGenerarPassword:0,
                passwordGenerado:'',
            }
        },
        created(){

            if(!fg.isEmpty(this.show)){
                this.showInput = this.show;
            }
            // console.log("show",this.show);
            // console.log("showInput",this.showInput);
            
        },
        mounted() {
            // console.log('Component mounted.')
        },
        methods:{
            cambiarShow:function(){
                this.showInput = !this.showInput;
            },
            buttonTexto:function(){
                // crear    
                if(this.tipo == 1){
                    return 'Registrar contraseña';
                // editar    
                }else if(this.tipo == 2){
                    return 'Cambiar contraseña';
                }
                return 'Mostrar';
            },
            mostrarPassword:function(){
                this.typeInput = !this.typeInput;
            },
            copiarPasswordGenerado:function(){

                var passwordGenerado = document.querySelector('#passwordGenerado');
                var range = document.createRange();
                range.selectNode(passwordGenerado);
                window.getSelection().addRange(range);
                 
                try {
                  // intentar copiar el contenido seleccionado
                  var resultado = document.execCommand('copy');
                  // console.log(resultado ? 'Email copiado' : 'No se pudo copiar el email');
                } catch(err) {
                    console.log('ERROR al intentar copiar el password');
                }
                 
                // eliminar el texto seleccionado
                window.getSelection().removeAllRanges();

            },
            generarPassword: function ()
            {
                let longitud = 10;
                this.passwordGenerado = generarPassword(longitud);

                // var long = parseInt(longitud);
                // var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHIJKLMNPQRTUVWXYZ2346789$@$%^&*-_";
                // var caracteresEspeciles="$@$%^&*-_";
                // var password = "";
                // for (var i=0; i<long; i++){
                //     if(i ==4){
                //         password += caracteresEspeciles.charAt(Math.floor(Math.random()*caracteresEspeciles.length));
                //     }

                //     password += caracteres.charAt(Math.floor(Math.random()*caracteres.length));

                //     if(i+1==long){
                //         password += caracteresEspeciles.charAt(Math.floor(Math.random()*caracteresEspeciles.length));
                //     }

                // } 
                    // console.log(password);
                // this.passwordGenerado = password;  

            },

            abrirGenerarPassword: function(){
                this.generarPassword();
                $("#modal-generar-password form")[0].reset();
                
                $("#modal-generar-password").modal('show');
                
                setTimeout(function(){ $('#passwordGenerado').trigger("change"); }, 300);
            },
            utilizarPassword:function(){
                this.errorGenerarPassword = "";
                if(this.checkGenerarPassword != 1){
                    this.errorGenerarPassword = "Debe copiar la contraseña y activar el check.";
                    return;
                }else if(fg.isEmpty(this.passwordGenerado)){
                     this.errorGenerarPassword = "La contraseña generada no puede ser vacia.";
                    return;
                }else{
                    $("#password").val(this.passwordGenerado);
                    $('#password').trigger("change")
                    
                    if(this.tipo == 2){
                        $("#passwordConfirmar").val(this.passwordGenerado);
                        $('#passwordConfirmar').trigger("change")
                    }

                    $("#modal-generar-password").modal('hide');
                    
                }

            },

        }

    }


    // función que genera un número aleatorio entre los límites superior e inferior pasados por parámetro
    function genera_aleatorio(i_numero_inferior, i_numero_superior) {
        var     i_aleatorio  =   Math.floor((Math.random() * (i_numero_superior - i_numero_inferior + 1)) + i_numero_inferior);
        return  i_aleatorio;
    }


    // función que genera un tipo de caracter en base al tipo que se le pasa por parámetro (mayúscula, minúscula, número, símbolo o aleatorio)
    function genera_caracter(tipo_de_caracter){
        // hemos creado una lista de caracteres específica, que además no tiene algunos caracteres como la "i" mayúscula ni la "l" minúscula para evitar errores de transcripción
        var lista_de_caracteres =   '$+=?@_#%&*23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz';
        var caracter_generado   =   '';
        var valor_inferior      =   0;
        var valor_superior      =   0;

        switch (tipo_de_caracter){
            case 'minúscula':
                valor_inferior  =   42;
                valor_superior  =   65;
                break;
            case 'mayúscula':
                valor_inferior  =   18;
                valor_superior  =   41;
                break;
            case 'número':
                valor_inferior  =   10;
                valor_superior  =   17;
                break;
            case 'símbolo': 
                valor_inferior  =   0;
                valor_superior  =   9;
                break;
            case 'aleatorio':
                valor_inferior  =   0;
                valor_superior  =   65;

        } // fin del switch

        caracter_generado   =   lista_de_caracteres.charAt(genera_aleatorio(valor_inferior, valor_superior));
        return caracter_generado;
    } // fin de la función genera_caracter()


    // función que guarda en una posición vacía aleatoria el caracter pasado por parámetro
    function guarda_caracter_en_posicion_aleatoria(caracter,arrayCaracteres,tamanioPassword){
        var guardado_en_posicion_vacia  =   false;
        var posicion_en_array           =   0;

        while(guardado_en_posicion_vacia    !=  true){
            posicion_en_array   =   genera_aleatorio(0, tamanioPassword-1); // generamos un aleatorio en el rango del tamaño del password
            
            // el array ha sido inicializado con null en sus posiciones. Si es una posición vacía, guardamos el caracter
            if(arrayCaracteres[posicion_en_array] == null){
                arrayCaracteres[posicion_en_array]  =   caracter;
                guardado_en_posicion_vacia          =   true;
            }
        }
    }


    // función que se inicia una vez que la página se ha cargado
    function generarPassword(tamanioPassword){

        var tamanioPassword             =   tamanioPassword;          // definimos el tamaño que tendrá nuestro password
        var arrayCaracteres             =   new Array();// array para guardar los caracteres de forma temporal
        

        
        var numero_minimo_letras_minusculas =   1;          // en ésta y las siguientes variables definimos cuántos 
        var numero_minimo_letras_mayusculas =   1;          // caracteres de cada tipo queremos en cada 
        var numero_minimo_numeros           =   1;
        var numero_minimo_simbolos          =   1;


        //vaciar arreglo
        for(var i = 0; i < tamanioPassword; i++){       // inicializamos el array con el valor null
            arrayCaracteres[i]  =   null;
        }

        let letras_minusculas_conseguidas   =   0;
        let letras_mayusculas_conseguidas   =   0;
        let numeros_conseguidos             =   0;
        let simbolos_conseguidos            =   0;
        let password_definitivo ="";
        let caracteres_conseguidos          =   0;          // contador de los caracteres que hemos conseguido

        let caracter_temporal               =   '';

        // generamos los distintos tipos de caracteres y los metemos en un password_temporal
        while (letras_minusculas_conseguidas < numero_minimo_letras_minusculas){
            caracter_temporal   =   genera_caracter('minúscula');
            guarda_caracter_en_posicion_aleatoria(caracter_temporal,arrayCaracteres,tamanioPassword);
            letras_minusculas_conseguidas++;
            caracteres_conseguidos++;
        }

        while (letras_mayusculas_conseguidas < numero_minimo_letras_mayusculas){
            caracter_temporal   =   genera_caracter('mayúscula');
            guarda_caracter_en_posicion_aleatoria(caracter_temporal,arrayCaracteres,tamanioPassword);
            letras_mayusculas_conseguidas++;
            caracteres_conseguidos++;
        }

        while (numeros_conseguidos < numero_minimo_numeros){
            caracter_temporal   =   genera_caracter('número');
            guarda_caracter_en_posicion_aleatoria(caracter_temporal,arrayCaracteres,tamanioPassword);
            numeros_conseguidos++;
            caracteres_conseguidos++;
        }

        while (simbolos_conseguidos < numero_minimo_simbolos){
            caracter_temporal   =   genera_caracter('símbolo');
            guarda_caracter_en_posicion_aleatoria(caracter_temporal,arrayCaracteres,tamanioPassword);
            simbolos_conseguidos++;
            caracteres_conseguidos++;
        }

        // si no hemos generado todos los caracteres que necesitamos, de forma aleatoria añadimos los que nos falten
        // hasta llegar al tamaño de password que nos interesa
        while (caracteres_conseguidos < tamanioPassword){
            caracter_temporal   =   genera_caracter('aleatorio');
            guarda_caracter_en_posicion_aleatoria(caracter_temporal,arrayCaracteres,tamanioPassword);
            caracteres_conseguidos++;
        }

        // ahora pasamos el contenido del array a la variable password_definitivo
        for(var i=0; i < arrayCaracteres.length; i++){
            password_definitivo =   password_definitivo + arrayCaracteres[i];
        }

        
        return password_definitivo;
    }

</script>
