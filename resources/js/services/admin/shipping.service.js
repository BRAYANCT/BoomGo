export class ShippingService  {
    constructor() {
        // console.log('entro a constructor ShippingService');
    }


    /*
    * Trae un registro por el id.
    *
    * @return Object
    */
    async getOne(id) {
        let model = null;
        try {
            const response = await axios.get(`${urlPagina}/api/admin/shipping/${id}`);
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }

    /*
    * Registra un envío
    *
    * @return array
    */
    async store(formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/admin/shipping`,formData);
        } catch (error) {
            throw error;
        }
        return response;
    }


    /*
    * Actualiza un envio
    *
    * @param integer id
    * @param Object
    * @return array
    */
    async update(id,formData) {
        let response = null;
        try {
            formData.append("_method", "PUT");
            response = await axios.post(`${urlPagina}/api/admin/shipping/${id}`,formData);
        } catch (error) {
            throw error;
        }
        return response;
    }

}
