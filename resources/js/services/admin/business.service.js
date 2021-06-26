export class BusinessService  {
    constructor() {
        // console.log('entro a constructor BusinessService');
    }

    /*
	* Trae la lista de las negocios
	*
	* @return array
	*/
    async getAll() {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/admin/businesses`);
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }


    /*
    * Trae los datos de un negocio
    *
    * @param numeric id
    * @return Object
    */
    async getOne(id) {
        let model = null;
        try {
            const response = await axios.get(`${urlPagina}/api/admin/businesses/${id}`);
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }

    /*
    * Registra un negocio
    *
    * @return array
    */
    async store(formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/admin/businesses`,formData);
        } catch (error) {
            throw error;
        }
        return response;
    }

    /*
    * Actualiza un producto
    *
    * @param integer id
    * @param Object
    * @return array
    */
    async update(id,formData) {
        let response = null;
        try {
            formData.append("_method", "PUT");
            response = await axios.post(`${urlPagina}/api/admin/businesses/${id}`,formData);
        } catch (error) {
            throw error;
        }
        return response;
    }

    /*
    * Registra o actualiza el negocio del usuario autenticado
    *
    * @return array
    */
    async storeOrUpdateForAuthUser(formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/admin/businesses/profile`,formData);
        } catch (error) {
            throw error;
        }
        return response;
    }

}
