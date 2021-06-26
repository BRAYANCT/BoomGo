export class DistrictService{
    constructor() {
        // console.log('entro a constructor DistrictService');
    }


    /*
    * Trae la lista de distritos
    *
    * @return array
    */
    async getAll(params = {}) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/districts`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }

}
