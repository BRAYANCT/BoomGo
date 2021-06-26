export class ImageService{
    constructor() {
        // console.log('entro a constructor ImageService');
    }


    /*
    * Trae la lista de imagenes de un producto
    *
    * @return array
    */
    async getAllProductImages(productId,params = {}) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/images/products/${productId}`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }


    /*
    * Trae la lista de imagenes de un negocio
    *
    * @return array
    */
    async getAllBusinessImages(businessId,params = {}) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/images/businesses/${businessId}`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }

}
