export class ShippingService{
    constructor() {
        // console.log('entro a constructor ShippingService');
    }


    /*
    * Trae los envios para el carrito de compras
    *
    * @return array
    */
    async getAllForShoppingCart(districtId) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/shippings/shopping-cart/districts/${districtId}`);
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }

    /*
    * Obtiene el envío de un negocio priorizando el distrito
    *
    * @return array
    */
    async getByBusinessAndPriorityDistrict(businessId,districtId) {
        let model = null;
        try {
            const response = await axios.get(`${urlPagina}/api/shippings/businesses/${businessId}/districts/${districtId}`);
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }



}
