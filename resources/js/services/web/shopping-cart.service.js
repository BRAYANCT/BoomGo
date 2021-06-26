export class ShoppingCartService{
    constructor() {
        // console.log('entro a constructor ShoppingCartService');
    }

    /*
	* Aumenta la cantidad de un item al carrito de compras, si no existe lo crea
	*
	* @param Integer productId
	* @param Integer quantity
	* @return array
	*/
    async increaseItem(productId,quantity,cookieToken){
        let response = null;
        let data = {'product_id':productId,'quantity':quantity,'cookie_token':cookieToken};
        try {
            response = await axios.post(`${urlPagina}/api/shopping-carts/increase-item`,data);
        } catch (error) {
            throw error;
        }
        return response;
    }

    /*
	* Disminuye la cantidad de un item del carrito de compras
	*
	* @param Integer productId
	* @param Integer quantity
	* @return array
	*/
    async decreaseItem(productId,quantity){
        let response = null;
        let data = {'product_id':productId,'quantity':quantity};
        try {
            response = await axios.post(`${urlPagina}/api/shopping-carts/decrease-item`,data);
        } catch (error) {
            throw error;
        }
        return response;
    }


    /*
	* Obtiene el carrito de compras del usuario visitan o usuario autenticado
	*
	* @return Object
	*/
    async getCartUser(cookieToken){
        let model = null;

        let params = { 'cookie_token':cookieToken}
        try {
            const response = await axios.get(`${urlPagina}/api/shopping-carts/user`,{params: params });
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }


}
