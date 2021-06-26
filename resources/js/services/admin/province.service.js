export class ProvinceService{
    constructor() {
        // console.log('entro a constructor ProvinceService');
    }


    /*
    * Trae la lista de provincias
    *
    * @return array
    */
    async getAll(params = {}) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/admin/provinces`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }

}
