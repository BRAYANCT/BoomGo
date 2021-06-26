export class DocumentTypeService{
    constructor() {
        // console.log('entro a constructor DocumentTypeService');
    }


    /*
    * Trae la lista de tipos de documento de identidad
    *
    * @return array
    */
    async getAll(params = {}) {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/document-types`,{params: params });
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }

}
