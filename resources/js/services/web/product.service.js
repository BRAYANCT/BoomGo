export class ProductService  {
    constructor() {
        // console.log('entro a constructor ProductService');
    }

    /*
    * Trae un registro por el id.
    *
    * @return Object
    */
    async getOne(id) {
        let model = null;
        try {
            const response = await axios.get(`${urlPagina}/api/products/${id}`);
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }

    /*
    * Trae la lista productos
    *
    * @return array
    */
    async getAll(quantity,params={}) {
        let list = [];
        params.quantity = quantity;
        try {
            const response = await axios.get(`${urlPagina}/api/products`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }


}
