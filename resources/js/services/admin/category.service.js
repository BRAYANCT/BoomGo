export class CategoryService  {
    constructor() {
        // console.log('entro a constructor CategoryService');
    }


    /*
	* Trae la lista de categories de los negocios
	*
	* @return array
	*/
    async getBusinessCategories(params) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/admin/categories/businesses`,{params: params });
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
            const response = await axios.get(`${urlPagina}/api/admin/categories/products`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }


}
