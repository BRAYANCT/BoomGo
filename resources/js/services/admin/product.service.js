export class ProductService  {
    constructor() {
        // console.log('entro a constructor BusinessService');
    }


    /*
    * Trae un registro por el id.
    *
    * @return Object
    */
    async getOne(id) {
        let model = null;
        try {
            const response = await axios.get(`${urlPagina}/api/admin/products/${id}`);
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }

    /*
    * Registra un producto
    *
    * @return array
    */
    async store(formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/admin/products`,formData);
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
            response = await axios.post(`${urlPagina}/api/admin/products/${id}`,formData);
        } catch (error) {
            throw error;
        }
        return response;
    }



}
