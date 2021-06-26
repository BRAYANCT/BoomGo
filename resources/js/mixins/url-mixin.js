export const urlMixin = {
    data() {
        return {
            pageUrl: urlPagina,
        }
    },
    methods: {
        /**
         * Obtiene el url del proyecto
         *
         * @param  String uri  Uri de la pagina
         * @return Boolean
         */
        getUrl : function(){
            return this.pageUrl;
        },
        /**
         * Obtiene el url del proyecto
         *
         * @param  String uri  Uri de la pagina
         * @return Boolean
         */
        getCompleteUrlByUri : function(uri){
            return `${this.getUrl()}/${uri}`;
        },

        /**
         * Obtiene el url del market place del negocio
         *
         * @param  string businessSlug
         * @return Boolean
         */
        getMarketPlaceBusinessUrl : function(businessSlug){
            return this.getCompleteUrlByUri(`market-place/negocios/${businessSlug}`);
        },

        /**
         * Obtiene el url del market place del negocio para una categoria
         *
         * @param  string businessSlug
         * @param  string categorySlug
         * @return Boolean
         */
        getMarketPlaceBusinessCategoryUrl : function(businessSlug,categorySlug){
            return this.getCompleteUrlByUri(`market-place/negocios/${businessSlug}/categorias/${categorySlug}`);
        }
    }
};
