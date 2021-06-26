export class PriceRangeService  {
    constructor() {
        // console.log('entro a constructor PriceRangeService');
    }

    /*
	* Trae la lista de las prices ranges
	*
	* @return array
	*/
    async getAll() {
        let list = [];
        try {
            const response = await axios.get(`${urlPagina}/api/admin/price-ranges`);
            list = response.data.list;
        } catch (error) {
            throw error;
        }
        return list;
    }


}
