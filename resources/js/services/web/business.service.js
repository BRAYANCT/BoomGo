export class BusinessService{
    constructor() {
        // console.log('entro a constructor BusinessService');
    }


    /*
    * Trae la lista de negocios recomendados
    *
    * @return array
    */
    async getAllRecommended(limit,params = {}) {
        let list = [];
        params.limit = limit;
        try {
            const response = await axios.get(`${urlPagina}/api/businesses/recommended`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }

}
