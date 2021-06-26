
window.addEventListener('load',e => {

    let btnBorrarArrayIds = document.getElementById("borrar-array-ids");
    if(btnBorrarArrayIds){
        btnBorrarArrayIds.addEventListener("click",function(){
            let url = btnBorrarArrayIds.getAttribute("data-url");
            // console.log("this:",this);
            deleteByArrayId(url,this);
        });
    }

    let btnDestroy = document.getElementById("btn-destroy");
    if(btnDestroy){
        btnDestroy.addEventListener("click", async function(){
            let confirm = await confirmModal();
            if(confirm){
            document.getElementById("form-destroy").submit();
            }
        });
    }

    // Le da la accion de cerrar sesion a todos los botones con clase logout-accion
    let btnsLogOut = document.getElementsByClassName("logout-action");
    for (var i = 0; i < btnsLogOut.length; i++) {
        btnsLogOut[i].addEventListener("click", function(){
          document.getElementById("form-logout").submit();
        });
    }

    let btnsToggleShowFilter = document.getElementsByClassName('btn-toggle-show-filter');

    for (var i = 0; i < btnsToggleShowFilter.length; i++) {
        btnsToggleShowFilter[i].addEventListener("click", function(){
            $(".filters-business-list").parent().toggle('display');
        });
    }

    let btnsToggleShowFilterFixed = document.getElementsByClassName('btn-toggle-show-filter-fixed');

    for (var i = 0; i < btnsToggleShowFilterFixed.length; i++) {
        btnsToggleShowFilterFixed[i].addEventListener("click", function(){
            // document.body.scrollTop = 40;
            // document.documentElement.scrollTop = 40;
            $('html, body').animate({
                scrollTop: 40
            }, 600);
            $(".filters-business-list").parent().show();
        });
    }



    setLoadPageBtns();

    // Pone un loader a los botones submit luego de enviar el formulario
    $(".form-btn-loader").submit(function( event ) {
        loadingBtn($("button[type='submit']",this));
    });


    $( "input:checkbox.change-value" ).click(function() {
        //console.log("entro a cambiar de valor a checkbox");
        if($(this).prop('checked')){
          $(this).val(1);
        }else{
          $(this).val(0);
        }

    });

    $( ".nearby-businesses" ).click( async function() {
        getCurrentPosition().then(res=>{
            // console.log('responsdio',res);
            let position = res;
            let url = `${urlPagina}/negocios?latitude=${position.lat}&longitude=${position.lng}&distance=10`;
            loadPage(url);
        }).catch(error => {
          console.log('entro al catch',error);
            fg.modalMessage(error,'error');
        });
    });


});

    /*
    * Pone la accion de load page a los botnes con la clase
    *
    * @param string classBtn
    * @return void
    */
    function setLoadPageBtns(classBtn = 'btn-load-page'){
        let btnsLoadPage = document.getElementsByClassName(classBtn);
        for (var i = 0; i < btnsLoadPage.length; i++) {
            btnsLoadPage[i].addEventListener("click", function(){
                loadPage();
            });
        }
    }

    /*
    * El contenido de la pagina se oculta y muestra el spinner de carga
    *
    * @param string url
    * @return void
    */
    function loadPage(url=""){
        let app =  document.getElementById("app");
        app.style.opacity = "0";
        let preload = document.getElementById("spin-loader");
        preload.style.display = "flex";
        preload.style.opacity = "1";

        if(!isEmpty(url)){
            loadUrl(url);
        }
    }

    /*
    * Carga una nueva pagina
    *
    * @param string newLocation
    * @return void
    */
    function loadUrl(newLocation)
    {
        window.location = newLocation;
        return false;
    }

  /*
    * Obtiene el time actual es string
    *
    * @return string
    */
    function generateUniqueString(prefix = "") {
        return prefix+parseInt(time()*Math.random());
    }

    /*
    * Obtiene un string de forma aleatoria
    *
    * @param string length
    * @return string
    */
    function getRandomString(length = 10){

        let stringRandom = "";

        for(let i = 0;i< Math.ceil(length/10) ;i++){
            stringRandom += Math.random().toString(36).substr(2, 15)
        }

        return stringRandom.substr(0, length);
    }


    /*
    * Obtiene el time actual es string
    *
    * @return string
    */
    function time() {
        let timestamp = Math.floor(new Date().getTime() / 1000)
        return timestamp;
    }

  /*
  * Verifica si un valor es nulo vacio o no definido
  *
  * @param valor
  * @return boolean
  */
  function isEmpty(valor){
    if(typeof  valor === 'object'){
      for(var key in valor) {
        if(valor.hasOwnProperty(key))
        return false;
      }
      return true;
    }

    if(valor === undefined | valor == null | valor == '' ){
      return true;
    }
    return false;
  }

    /*
  * Convierte un array o object en un ul de html con todos los items
  * @param array o object
  * @return String
  */
  function convertToListHtml(mensaje){
    if(Array.isArray(mensaje)){
      //console.log("es un arreglo"+mensaje.length);
      if(mensaje.length>=1){
        var arrayMensaje = mensaje;
        var mensaje = "<ul>";
        for(var i = 0;i<arrayMensaje.length;i++){
          mensaje +='<li>'+arrayMensaje[i]+'</li>';
        }
        mensaje += '</ul>';
      }
    }else if(typeof  mensaje === 'object'){
      var objectMensaje = mensaje;
      mensaje = "<ul>";
      $.each(objectMensaje,function(i,item){
          mensaje += "<li>"+item+"</li>";
      });
      mensaje += '</ul>';
    }
    return mensaje;
  }

  /*
  * Muestra un mensaje modal de sweet alert
  * @param (array,object,string) - string - string
  * @return
  */
  async function modalMessage (mensaje,type,title){
    if(Array.isArray(mensaje) || typeof  mensaje === 'object'){
      mensaje = convertToListHtml(mensaje);
    }

    if(isEmpty(type)){
      type = "info";
    }

    if(type=="danger"){
      type = "error";
    }

    if(isEmpty(title)){
      if(type == "error"){
         title = "Error";
      }else if(type == "warning"){
         title = "Advertencia";
      }else if(type == "Info"){
         title = "Información";
      }else{
        title = "Mensaje";
      }
    }

    await Swal.fire({
      title: title,
      html: mensaje,
      icon: type,
    })
    return true;
  };

    /*
  * Muestra un mensaje modal de sweet alert
  * @param message
  * @param string type
  * @param String title
  * @return
  */
  async function toastMessage (message,type,title){

    if( Array.isArray(message) || typeof  message === 'object' ){
      message = convertToListHtml(message);
    }

    if(isEmpty(type)){
      type = "info";
    }

    if(type=="danger"){
      type = "error";
    }

    if(isEmpty(title)){
      if(type == "error"){
         title = "Error";
      }else if(type == "warning"){
         title = "Advertencia";
      }else if(type == "Info"){
         title = "Información";
      }else{
        title = "Mensaje";
      }
    }

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000,
      timerProgressBar: true,
      onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })

    Toast.fire({
      icon: type,
      title: message
    })

  }

  /*
  * Muestra un mensaje modal de sweet alert
  * @param Object
  * @return
  */
  async function modalMessageObject(modalMessage){
    // console.log("modalMessageObject",modalMessage)
    let mensaje = convertToListHtml(modalMessage.texto);

    await Swal.fire({
      title: modalMessage.titulo,
      html: mensaje,
      icon: modalMessage.tipo,
      confirmButtonText: modalMessage.textoBoton,
    })
    return true;
  };

   /*
  * Muestra una ventana modal de confirmación
  * @param string - string - string - string - string
  * @return boolean
  */
  async function  confirmModal (title,mensaje,type,textConfirm,textCancel){
    let retorno = false;
    // return new Promise((resolve, reject) => {
      if(isEmpty(title)){
        title = "Está seguro?";
      }

      if(isEmpty(mensaje)){
        mensaje = "";
      }

      if(isEmpty(type)){
        type = "warning";
      }

      if(isEmpty(textConfirm)){
        textConfirm = "Sí";
      }

      if(isEmpty(textCancel)){
        textCancel = "No";
      }

       await Swal.fire({
          title: title,
          html: mensaje,
          icon: type,
          confirmButtonColor: '#3085d6',
          showCancelButton: true,
          cancelButtonColor: '#d33',
          confirmButtonText: textConfirm,
          cancelButtonText: textCancel
      }).then((result) => {
        if (result.value) {
          retorno = true;
        }else{
          retorno = false;
        }

      });
      // resolve(retorno);
      return retorno;
    // });
  };


/*
  * Deshabilita un boton, pone el icono y texto de procesando
  *
  * @param Object element
  * @return void
  */
function loadingBtn(element,iconClass="fa fa-spinner fa-spin mr-1",btnText="Procesando"){
  element.valor = $(element).html();
  $(element).html(`<i class='${iconClass}'></i> ${btnText}`);
  $(element).prop("disabled",true);
  $(element).addClass('btn-procesando');
}

/*
  * Remueve el procesando de un boton
  *
  * @param Object element
  * @return void
  */
function resetLoadingBtn(element){
  $(element).html(element.valor);
  $("div",element).remove();
  $(element).prop("disabled",false);
  $(element).removeClass('btn-procesando');
}

/*
  * Deshabilita un elemento html, pone el icono de procesando
  *
  * @param Object element
  * @param String tagClass
  * @return void
  */
function loadingElement(element,tagClass="fa-2x mr-1"){
    $(element).hide();

    let spinnerId = generateUniqueString('spinner-element');
    // let id = "spinner-"+generateUniqueString()
    let spinner = $( `<i  id="${spinnerId}" class='fa fa-spinner fa-spin  ${tagClass}'></i>` ).insertAfter( $(element) );
    $(element).attr('data-spinner-id',spinnerId);
}

/*
  * Remueve el procesando de un boton
  *
  * @param Object element
  * @return void
  */
function resetLoadingElement(element){
    let spinnerId = $(element).attr('data-spinner-id');
    $(element).show();
    $(`#${spinnerId}`).remove();
}


/*
  * Remueve las clases de validacion de un formualrio
  *
  * @param Object form
  * @return void
  */
function removeValidateForm(form){
    $(".invalid-feedback,.valid-feedback,.form-text-error,.form-text-success",form).each(function(){
        let inputElement = $("input,select,textarea",$(this).parent());
        if(elementIsValidated(inputElement)){
            $(this).remove();
        }
    });
    $("input,select,textarea",form).each(function(){
        if(elementIsValidated(this)){
            $(this).removeClass(['is-valid','is-invalid']);
        }
    });
}

/*
  * Verifica si un input de un formulario debe ser validado
  *
  * @param Object
  * @return boolean
  */
function elementIsValidated(element){
    if($(element).hasClass('no-validate')){
        return false;
    }
    if($(element).hasClass('select2-hidden-accessible')){
        return !$(element).parent().hasClass('no-validate');
    }
    return true;
}

function validateForm(errors,form){
    //borrar las clases y los mensajes de validacion
    removeValidateForm();
    // agrega los mensaje de error y clases
    $.each(errors, function( index, value ) {
        // console.log( index + ": " + value );
        let element = $(`[name='${index}']`,form);

        let validate = elementIsValidated(element);

        if(validate){
              // agrega el mensaje para combo select2
              if (element.is('select') && element.hasClass('select2-hidden-accessible')) {
                  $(element.parent()).append(`<div class='form-text-error'>${value}</div>`);
                  // agrega el mensaje para el file input
              } else if (element.parents('.file-input').length > 0) {
                  $(element.parents('.file-input')).append(`<div class='form-text-error'>${value}</div>`);

              } else {
                  $(`<div class='invalid-feedback'>${value}</div>`).insertAfter(element);
              }
            element.addClass('is-invalid');
        }
    });

    //agrega el valid a los que no tienen invalid
    let elementsValid = $("input:enabled.form-control:not(.is-invalid),select.form-control:not(.is-invalid),textarea.form-control:not(.is-invalid)",form);

    $.each(elementsValid, function( index, element ) {
        element = $(element);

        let validate = elementIsValidated(element);

        if(validate){
            // agrega el mensaje para combo select2
            if(element.is('select') && element.hasClass('select2-hidden-accessible')){
                $(element.parent()).append(`<div class='form-text-success'>Campo correcto</div>`);
            // agrega el mensaje para el file input
            }else if(element.parents('.file-input').length > 0){
                $(element.parents('.file-input')).append(`<div class='form-text-success'>Campo correcto</div>`);
            }else{
                $(`<div class='valid-feedback'>Campo correcto</div>`).insertAfter(element);
            }

            element.addClass('is-valid');
        }
    });
    modalMessage(errors,'error');
}

function removeInputId(element){
    $("[name='id']",element).remove();
}

/*
  * prepara el formulario de la modal para realizar una accion
  * @param string('create' o 'edit')
  * @return String
  */
function prepareFormModal(accion,form){
  removeInputId(form);
  removeValidateForm(form);
  form.reset();
  let textoAccion = "";
  if(accion == 'create'){
    textoAccion = "Registrar";
    $("#btn-store").show();
    $("#btn-update").hide();
    $(".only-edit").hide();
    $(".only-create").show();
  }else{
    textoAccion = "Actualizar";
    $("#btn-update").show();
    $("#btn-store").hide();
    $(".only-edit").show();
    $(".only-create").hide();
  }

  $(".modal-header .modal-title span",form).text(textoAccion);
}


function loadDataForm(model,form){
  $.each(model, function( index, value ) {
      let element = $(`[name='${index}']`,form);
      element.val(value).change();
  });
}


  /*
  * Devuelve las peticiones de error despues de una peeticion rest
  * @param object,string,object html
  * @return String
  */
function catchErrorAxios(error,mensaje,elementForm){
  console.log("catchErrorAxios");
  if(error.response){
    let response = error.response;
    // handle error
    if(response.status == 403){
        mensaje = "No tiene autorización para realizar esta acción.";
      if(!isEmpty(response.data.message)){
        mensaje = response.data.message;
      }
       modalMessage(mensaje,'error');
    //Error en la validaciones del formulario
    }else if(response.status == 422){
      let errors = response.data.errors;
      validateForm(errors,elementForm);
    }else{
      // si esta enviando un mensaje en el response reemplaza el mensaje del parametro
      if(!isEmpty(response.data.message)){
        mensaje = response.data.message;
      }

      if(!isEmpty(mensaje)){
        modalMessage(mensaje,'error');
      }
      console.error(error.response);
    }
  }
  console.error(error);
}




  /*
  * Borra 1 registro de una tabla por su id
  * @param string
  * @return
  */
  async function deleteById(tag) {
    let confirm = await confirmModal();
    if(confirm){
      let element = $(tag);
      loadingElement(element)
      let id = element.attr("data-id");
      let url = element.attr("data-url");
      window.axios.delete(url)
        .then(function (response) {
          let data = response.data;
          if(!data.hasError){
            let tabla = $('#tabla-listado').DataTable();
            removeRowTable(element.parents('tr'),tabla);

            modalMessage(data.message,'success');
          }else{
            modalMessage(data.message,'error');
          }
        }).catch(function (error) {
          let mensaje = "Problema al eliminar el registro.";
          catchErrorAxios(error,mensaje);
        }).finally(function () {
          resetLoadingElement(element);
        });
    }
  };

   /*
  * Borra varios registros de una tabla por sus ids
  * @param
  * @return
  */
  async function deleteByArrayId(url,elementTag){

      let elementos = $(".check-box-row input:checked");
      let numChecked = elementos.length;

      if(numChecked<=0){
        modalMessage('Debe seleccionar como mínimo 1 fila.','info');
        return;
      }

      let confirm = await confirmModal();
      if(confirm){

        loadingElement(elementTag,"");

        let arrayIds = []
        elementos.each(function (){
          arrayIds.push(parseInt($(this).val()));
        });

        window.axios
            .post(url,{
                  arrayIds: arrayIds
                })
            .then(function (response) {
              // console.log(response);
              let data = response.data;
              if(!data.hasError){
                let tablaListado = $('#tabla-listado').DataTable();

                elementos.each(function(){
                  let id = $(this).val();
                  let element = $(`#delete-item-${id}`).parents('tr');
                  removeRowTable(element,tablaListado);
                });

                modalMessage(data.message,'success');
              }else{
                modalMessage(data.message,'error');
              }
            }).catch(function (error) {
              let mensaje = "Problema al eliminar los registros.";
              catchErrorAxios(error,mensaje);
            }).finally(function () {
              // always executed
               resetLoadingElement(elementTag);
            });
      }
    }

    function removeRowTable(element,table){
      let elementRemove = element;
      if ($(element).hasClass('child')) {
        elementRemove = $(element).prev('tr');
      }
      table.row(elementRemove).remove().draw();
    }



  /*
  * Inicializa lo necesario para que el formulario de la modal funcione
  * @param Object modalForm Modal que contiene el formulario
  * @param Object tabla Tabla que se esta utilizando para los datos
  * @param Object btnCreate boton que abre la modal para registrar
  * @param string urlStore El url del api para crear un registro
  * @param string urlUpdatePrefix El url del api actualizar sin el id
  * @param string mensajeErrorStore Mensaje por personalizado en caso genere un error  al actualizar
  * @param string mensajeErrorUpdate Mensaje personalizado en caso genere un error al crear
  * @return boolean
  */
  function initModalForm(modalForm,tabla,btnCreate,urlStore,urlUpdatePrefix,mensajeErrorStore,mensajeErrorUpdate){
    let form = $('form',modalForm)[0];

    $(form).submit(function(event){
        event.preventDefault();

        let elementId = $("[name='id']",form);
        //crear un nuevo registro
        if(elementId.length == 0){
          storeModalForm(tabla,modalForm,urlStore,mensajeErrorStore);
        //actualiza un registro
        }else{
          let id = elementId.val();
          let urlUpdate = `${urlUpdatePrefix}/${id}`;
          updateModalForm(tabla,modalForm,urlUpdate,mensajeErrorUpdate);
        }
    });

    $(btnCreate).click(function() {
        prepareFormModal('create',form);
        $(modalForm).modal('show');
      });
  }

  /*
  * Guarda un registro del formulario de una modal y agrega los datos a la tabla
  * @param Object tabla Tabla que se esta utilizando para los datos
  * @param Object modalForm Modal que contiene el formulario
  * @param string urlStore El url del api
  * @param string mensajeError Mensaje por personalizado en caso genere un error
  * @return boolean
  */
  function storeModalForm(tabla,modalForm,urlStore,mensajeError){

    let form = $('form',modalForm)[0];

    let formData = new FormData(form);

    let btnStore = $("#btn-store");
    loadingBtn(btnStore);

    window.axios.post(urlStore,formData)
              .then(function (response) {
                let data = response.data;
                if(!data.hasError){
                  removeValidateForm(form);
                  $(modalForm).modal('hide');
                  tabla.row.add(data.model).draw();
                  modalMessage(data.message,'success');
                }else{
                  modalMessage(data.message,'error');
                }
              }).catch(function (error) {
                let mensaje = "Problema al registrar datos.";

                if(!isEmpty(mensajeError)){
                  mensaje = mensajeError;
                }

                catchErrorAxios(error,mensaje,form);
              }).finally(function () {
                // always executed
                resetLoadingBtn(btnStore);
              });
  }

  /*
  * Actualiza un registro del formulario de una modal y modifica los datos a la tabla
  * @param Object tabla Tabla que se esta utilizando para los datos
  * @param Object modalForm Modal que contiene el formulario
  * @param string urlUpdate El url del api
  * @param string mensajeError Mensaje por personalizado en caso genere un error
  * @return boolean
  */
  function updateModalForm(tabla,modalForm,urlUpdate,mensajeError){
    let btnUpdate = $("#btn-update");
    loadingBtn(btnUpdate);

    let form = $('form',modalForm)[0];

    let formData = new FormData(form);
    formData.append("_method", "PUT");

    window.axios.post(urlUpdate,formData)
              .then(function (response) {
                let data = response.data;
                if(!data.hasError){
                  removeValidateForm(form);
                  $(modalForm).modal('hide');
                  //borra la fila con los datos antiguos
                  let element = $("#edit-item-"+data.model.id).parents('tr');
                  removeRowTable(element,tabla);

                  //inserta la fila con los datos nuevos
                  tabla.row.add(data.model).draw();
                  modalMessage(data.message,'success');
                }else{
                  modalMessage(data.message,'error');
                }
              }).catch(function (error) {
                let mensaje = "Problema al actualizar los datos.";

                if(!isEmpty(mensajeError)){
                  mensaje = mensajeError;
                }
                catchErrorAxios(error,mensaje,form);
              }).finally(function () {
                // always executed
                  resetLoadingBtn(btnUpdate);
              });
  }


  /*
  * Carga los datos de un registro en el formulario de una modal y agrega el input hidden id para luego poder actualizar
  * @param Object tag Elemento html que ejecuta la accion para el editar
  * @param string mensajeError Mensaje por personalizado en caso genere un error
  * @return boolean
  */
  function editModalForm(tag,mensajeError){
    let element = $(tag);
    let url = element.attr("data-url");
    let modalId = element.attr("data-modal-id");

    let modalForm = $(`#${modalId}`);

    let form = $('form',modalForm)[0];

    //prepara la modal para poner los nuevos datos
    prepareFormModal("edit",form);

    window.axios.get(url)
              .then(function (response) {
                let data = response.data;
                if(!data.hasError){
                    //cargar los datos
                    $(modalForm).modal('show');
                    //agrega el id para el url de actualizar
                    $(form).append(`<input type="hidden" name="id" />`);

                    //carga los datos input en el formulario
                    loadDataForm(data.model,form)

                }else{
                  modalMessage(data.message,'error');
                }
              }).catch(function (error) {
                let mensaje = "Problema al obtener los datos.";

                if(!isEmpty(mensajeError)){
                  mensaje = mensajeError;
                }

                catchErrorAxios(error,mensaje);
              }).finally(function () {
                // always executed
              });
  }


// function getCurrentPosition(options = {}) {
//     return new Promise((resolve, reject) => {
//         navigator.geolocation.getCurrentPosition(resolve, reject, options);
//     });
// }

async function  getCurrentPosition(){
    // console.log('enetro a getCurrentPosition')
    return new Promise((resolve, reject) => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    // console.log("postiion:",position);
                    resolve({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    });
                },
                (error) => {
                    console.log(error)

                    let message = "No se pudo obtener la ubicación.";

                    if(error.message === "Only secure origins are allowed (see: https://goo.gl/Y0ZkNV)."){
                        message = "Para obtener la ubicación debe utilizar un origen seguro(https).";
                    }else if(error.message === 'User denied Geolocation'){
                        message = "Debe aceptar los permisos de ubicación";
                    }
                    reject(message);
                }
            );
        }else{
            reject("No se pudo obtener la ubicacion, el navegador no es compatible.");
        }
    });
}

/*
* Pone la logica para el rango de fechas de la libreria BootstrapDatePicker
*
* @param string idStartDate
* @param string idEndDate
* @return void
*/
function rangeDateBootstrapDatePicker(idStartDate,idEndDate,optionStartDate='',optionEndDate='')
{
    let options = {
        language: 'es',
        autoclose:true,
    };

    if(optionStartDate !== ''){
        options.startDate = optionStartDate;
    }

    if(optionEndDate !== ''){
        options.endDate = optionEndDate;
    }

    $(`#${idStartDate}`).datepicker(options).on('changeDate', function() {
        $(`#${idEndDate}`).datepicker('setStartDate',this.value);
    });

    $(`#${idEndDate}`).datepicker(options).on('changeDate', function() {
        $(`#${idStartDate}`).datepicker('setEndDate',this.value);
    });
}

function setCookie(cname, cvalue, exdays){
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


function btnFilterFixedToggleDisplay(scrollY) {
    // console.log("scrollY:",scrollY)
    if(scrollY>65){
        $(".btn-toggle-show-filter-fixed").show();
    }else{
        $(".btn-toggle-show-filter-fixed").hide();
    }
}


let funcGeneral = {};

funcGeneral =  {
    generateUniqueString,
    getRandomString,
    time,
    isEmpty,
    toastMessage,
    modalMessage,
    modalMessageObject,
    loadingBtn,
    resetLoadingBtn,
    loadingElement,
    resetLoadingElement,
    catchErrorAxios,
    removeValidateForm,
    removeInputId,
    removeRowTable,
    prepareFormModal,
    loadDataForm,
    initModalForm,
    editModalForm,
    updateModalForm,
    storeModalForm,
    loadPage,
    setLoadPageBtns,
    rangeDateBootstrapDatePicker,
    setCookie,
    getCookie,
    btnFilterFixedToggleDisplay,
    confirmModal: async (title,mensaje,type,textConfirm,textCancel) => {
        return await confirmModal (title,mensaje,type,textConfirm,textCancel);
    },
    deleteById: async (tag) => {
        await deleteById(tag);
    },
    deleteByArrayId: async (url) =>{
        await deleteByArrayId(url);
    }
}


export default funcGeneral


