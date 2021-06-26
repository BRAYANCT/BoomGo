export class PaymentMethodService{
    constructor() {
        // console.log('entro a constructor PaymentMethodService');
    }


    /*
    * Trae la lista de metodos de pagos
    *
    * @return array
    */
    async getAll(params = {}) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/payment-methods`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }


    /*
	* Trae la lista de metodos de pagos de los negocios que tienen productos en el carrito de compras
	*
	* @return array
	*/
    async getAllOfShoppingCartBusinesses() {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/payment-methods/businesses-shopping-cart`);
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }


    /*
    * Trae la lista de metodos de pagos de un negocio
    *
    * @return array
    */
    async getAllByBusiness(businessId) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/payment-methods/businesses/${businessId}`);
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }




}
