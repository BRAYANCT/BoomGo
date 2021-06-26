export class DepartmentService{
    constructor() {
        // console.log('entro a constructor DepartmentService');
    }


    /*
    * Trae la lista de departamentos
    *
    * @return array
    */
    async getAll(params = {}) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/departments`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }

}
