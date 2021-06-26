export class ProviderTypeService  {
    constructor() {
        // console.log('entro a constructor ProviderTypeService');
    }

    /*
	* Trae la lista de las proveedores
	*
	* @return array
	*/
    async getAll() {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/admin/provider-types`);
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }


}
