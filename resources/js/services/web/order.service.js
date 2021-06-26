export class OrderService{
    constructor() {
        // console.log('entro a constructor OrderService');
    }


    /*
    * Registra una orden
    *
    * @return array
    */
    async store(formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/orders`,formData);
        }catch (error) {
            throw error;
        }
        return response;
    }

    /*
    * Registra una orden para un negocio
    *
    * @return array
    */
    async storeByBusiness(businessId,formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/orders/businesses/${businessId}`,formData);
        }catch (error) {
            throw error;
        }
        return response;
    }

}
