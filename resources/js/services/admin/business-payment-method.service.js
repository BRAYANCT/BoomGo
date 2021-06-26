export class BusinessPaymentMethodService  {
    constructor() {
        // console.log('entro a constructor BusinessPaymentMethodService');
    }


    /*
    * Trae los datos de mercado pago para un negocio
    *
    * @param numeric id
    * @return Object
    */
    async getMercadoPagoByBusiness(businessId) {
        let model = null;
        try {
            const response = await axios.get(`${urlPagina}/api/admin/business-payment-method/businesses/${businessId}/mercado-pago`);
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }

    /*
    * Trae los datos de transferencia bancaria para un negocio
    *
    * @param numeric id
    * @return Object
    */
    async getWireTransferByBusiness(businessId) {
        let model = null;
        try {
            const response = await axios.get(`${urlPagina}/api/admin/business-payment-method/businesses/${businessId}/wire-transfer`);
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }


    /*
    * Trae los datos de mercado pago para un negocio
    *
    * @param numeric id
    * @return Object
    */
    async storeOrUpdateWireTransferByBusiness(businessId,formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/admin/business-payment-method/businesses/${businessId}/wire-transfer`,formData);
        } catch (error) {
            throw error;
        }
        return response;
    }


}
