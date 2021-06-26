export class CategoryService  {
    constructor() {
        // console.log('entro a constructor CategoryService');
    }

    /*
    * Trae la categoria por el id.
    * @return Object
    */
    async getOne(id,params = {}) {
        let model = null;
        try {
            const response = await axios.get(`${urlPagina}/api/categories/${id}`,{params: params });
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }

    /*
	* Trae la lista de categories de los negocios
	*
	* @return array
	*/
    async getBusinessCategories(params) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/categories/businesses`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }


    /*
   * Trae la lista de categories de los productos
   *
   * @return array
   */
    async getProductCategories(params) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/categories/products`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }


}
