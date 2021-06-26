export class ClaimService{
    constructor() {
        // console.log('entro a constructor ClaimService');
    }


    /*
    * Registra un reclamo
    *
    * @return array
    */
    async store(formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/claims`,formData);
        }catch (error) {
            throw error;
        }
        return response;
    }



}
