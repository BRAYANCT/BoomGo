export class ContactService{
    constructor() {
        // console.log('entro a constructor ContactService');
    }


    /*
    * Registra un reclamo
    *
    * @return array
    */
    async store(formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/contacts`,formData);
        }catch (error) {
            throw error;
        }
        return response;
    }

}
