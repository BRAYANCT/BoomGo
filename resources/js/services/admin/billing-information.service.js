export class BillingInformationService  {
    constructor() {
        // console.log('entro a constructor BusinessService');
    }



    /*
    * Trae el ultimo registro del usuario autenticado
    *
    * @param numeric id
    * @return Object
    */
    async getLastOneForAuthUser() {
        let model = null;
        try {
            const response = await axios.get(`${urlPagina}/api/admin/billing-information/last-one-for-auth-user`);
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }



}
