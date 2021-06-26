export class OrderService{
    constructor() {
        // console.log('entro a constructor OrderService');
    }


    /*
    * Trae la lista de ordenes que compro el usuario autenticado
    *
    * @return array
    */
    async getAllForAuthUser(params = {}) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/admin/orders/auth-user`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }

}
