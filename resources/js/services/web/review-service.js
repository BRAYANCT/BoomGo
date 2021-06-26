export class ReviewService{
    constructor() {
        // console.log('entro a constructor reviewService');
    }

    /*
    * Registra un review para el negocio por el usuario atenticado
    *
    * @return array
    */
    async storeByBusinessForAuthUser(businessId,formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/reviews/businesses/${businessId}/auth-user`,formData);
        }catch (error) {
            throw error;
        }
        return response;
    }


    /*
    * Trae la lista de los reviews tipo negocios
    *
    * @return array
    */
    async getBusinessReviews(quantity,params={}) {
        let list = [];
        params.quantity = quantity;
        try {
            const response = await axios.get(`${urlPagina}/api/reviews/businesses`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }

    /*
    * Trae los ultimos comentarios de los negocios
    *
    * @return array
    */
    async getAllLatest(limit,params = {}) {
        let list = [];
        params.limit = limit;
        try {
            const response = await axios.get(`${urlPagina}/api/reviews/businesses/latest`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }



}
