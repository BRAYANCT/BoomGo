export class UserService{
    constructor() {
        // console.log('entro a constructor UserService');
    }


    /*
    * Trae la lista de usuarios
    *
    * @return array
    */
    async getAll(params = {}) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/admin/users`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }

    /*
    * Trae los datos del usuario atenticado
    *
    * @return Object
    */
    async getAuthUser() {
        let model = null;
        try {
            const response = await axios.get(`${urlPagina}/api/admin/users/auth-user`);
            model = response.data.model;
        } catch (error) {
            throw error;
        }
        return model;
    }

}
