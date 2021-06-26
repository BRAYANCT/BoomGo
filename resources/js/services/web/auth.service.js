export class AuthService{
    constructor() {
        // console.log('entro a constructor CategoryService');
    }

    /*
	* Loguea al usuario
	* @return array
	*/
    async login(formData) {
        let response = null;
        try {
            response = await axios.post(`${urlPagina}/api/login`,formData);
        } catch (error) {
            throw error;
        }
        return response;
    }



}
