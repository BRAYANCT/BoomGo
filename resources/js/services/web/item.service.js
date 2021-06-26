export class ItemService  {
    constructor() {
        // console.log('entro a constructor ItemService');
    }

    /*
	* Borra un registro
	* @return array
	*/
    async delete(itemId,cookieToken) {
        let response = null;
        let params = {'cookie_token':cookieToken};
        try {
            response = await axios.delete(`${urlPagina}/api/items/${itemId}`,{params:params});
        } catch (error) {
            throw error;
        }
        return response;
    }


    /*
	* Suma 1 en la cantidad del item
	*
	* @return Object
	*/
    async increaseOne(itemId,cookieToken) {
        let response = null;
        let params = {'cookie_token':cookieToken};
        try {
            response = await axios.post(`${urlPagina}/api/items/${itemId}/increase-one`,params);
        } catch (error) {
            throw error;
        }
        return response;
    }


    /*
	* Resta 1 en la cantidad del item
	*
	* @return Object
	*/
    async decreaseOne(itemId,cookieToken) {
        let response = null;
        let params = {'cookie_token':cookieToken};
        try {
            response = await axios.post(`${urlPagina}/api/items/${itemId}/decrease-one`,params);
        } catch (error) {
            throw error;
        }
        return response;
    }


}
