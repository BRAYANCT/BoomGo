import { ShoppingCartService } from '../services/web/shopping-cart.service';
import { ShippingService } from "../services/web/shipping.service";

const shoppingCartService = new ShoppingCartService();
const shippingService = new ShippingService();


export const shoppingCartMixin = {
    data() {
        return {
            shoppingCartBusinesses: [],
            shoppingCart: { 'items': [] },
            loadShoppingCart: false,
            cookieToken : '',
            shippings: [],
            shippingPrice : 0.00,

            businessItems:[],

            businessId:[],
        }
    },
    methods: {
        setShoppingCart: async function(notification = false){
            try {
                let cookieToken = this.getCookieToken();
                this.shoppingCart = await shoppingCartService.getCartUser(cookieToken);
                this.loadShoppingCart = true;

                // console.log('shoppingCart:',this.shoppingCart);
                if(notification){
                    this.setShoppingCartNotification(this.shoppingCart);
                }
            } catch (error) {
                console.error(error);
            }
        },
        generateObjectShoppingCartBusiness: function(business)
        {
            return {'id':business.id,'name':business.name,'slug':business.slug,'items':[]};
        },
        groupShoppingCartByBusiness: async function(){
            this.shoppingCartBusinesses = [];

            if(this.shoppingCart && this.shoppingCart.items){
                this.shoppingCart.items.forEach((item)=>{
                    let existBusiness = false;

                    this.shoppingCartBusinesses.some((shoppingCartBusiness,index)=>{
                        if(parseInt(shoppingCartBusiness.id) === parseInt(item.product.business_id)){
                            shoppingCartBusiness.items.push(item);
                            existBusiness = true;
                            return true;
                        }
                    });

                    if(!existBusiness){
                        // console.log('product:',item.product);
                        // console.log('product business:',item.product.business);
                        let shoppingCartBusiness = this.generateObjectShoppingCartBusiness(item.product.business);
                        shoppingCartBusiness.items.push(item);
                        this.shoppingCartBusinesses.push(shoppingCartBusiness);
                    }
                });
            }

            // console.log('shoppingCartBusinesses: ',this.shoppingCartBusinesses)
        },
        getCookieToken: function () {

            let nameCookie = 'shopping-cart-boom-go';
            let cookieToken = "";

            if(fg.getCookie(nameCookie) === ""){
                let randomString = fg.getRandomString(60);
                cookieToken = fg.generateUniqueString(randomString+"-");
                fg.setCookie(nameCookie, cookieToken, 365);
            }else{
                cookieToken = fg.getCookie(nameCookie)
            }

            return  cookieToken;
        },

        setShoppingCartNotification: function (shoppingCart) {
            let total = 0.00;
            let totalQuantity=0;
            if(shoppingCart){

                total = shoppingCart.total;
                totalQuantity = shoppingCart.total_quantity;

                // if(shoppingCart.items.length > 0){
                //     if($("#navbar-footer-shopping-cart").length > 0){
                //         $("#navbar-footer-shopping-cart").show();
                //         $("#app").addClass('shopping-cart-menu-open');
                //     }
                // }else{
                //     $("#navbar-footer-shopping-cart").hide();
                //     $("#app").removeClass('shopping-cart-menu-open');
                // }
            }

            $(".shopping-cart-total").text(total);
            $(".shopping-cart-total-quantity").text(totalQuantity);
            $(".shopping-cart-total").show();
            $(".shopping-cart-total-quantity").show();
        },
        /**
         * Obtiene el total del carrito de compras
         * @param  Object shoppingCart
         * @return Decimal
         */
        getTotal : function(){
            let total = 0.00;
            if(this.shoppingCart){
                this.shoppingCart.items.forEach((item)=>{
                    total += item.quantity*item.final_price;
                });
                total += parseFloat(this.shippingPrice);
            }
            return parseFloat(total).toFixed(2);
        },
        getTotalByItems : function(items){
            let total = 0.00;
            items.forEach((item)=>{
                total += item.quantity*item.final_price;
            });
            total += parseFloat(this.shippingPrice);
            return parseFloat(total).toFixed(2);
        },
        /**
         * Pone todos los items de un negocio en la variable
         * @param  Integer businessId
         */
        setBusinessItems : async function(businessId){

            this.businessItems = [];

            if(this.shoppingCart && this.shoppingCart.items){
                this.shoppingCart.items.forEach( item => {
                    if(businessId == item.product.business_id){
                        this.businessItems.push(item);
                    }
                })
            }
        },
        /**
         * Obtiene el total de envios del carrito de compras
         * @param  Integer districtId
         */
        getShippings: async function (districtId) {
            this.shippings = await shippingService.getAllForShoppingCart(districtId);
            // console.log('shippings:',this.shippings)
            // return this.shippings;
        },

        /**
         * Obtiene el envío de un negocio priorizando el distrito
         * @param  Integer businessId
         * @param  Integer districtId
         */
        getShippingByBusinessAndPriorityDistrict: async function (businessId,districtId) {
            this.shippings = [];
            let shipping = await shippingService.getByBusinessAndPriorityDistrict(businessId,districtId);
            if(shipping){
                this.shippings.push(shipping);
            }
            // console.log('shipping:',shipping)
            // return this.shippings;
        },

        /**
         * Verifica si el carrito de compras tiene items
         * @return boolean
         */
        shoppingCartHasItems: function () {

            if(fg.isEmpty(this.businessId)){
                if(this.shoppingCart){
                    return this.shoppingCart.items.length > 0;
                }
            }else{
                return this.businessItems.length > 0;
            }

            return false;
        },

    },
    watch: {

        shoppingCart: {

            handler: function (newShoppingCart) {
                // console.log('se modifico el carrito de compras new shopping cart',newShoppingCart);

                this.groupShoppingCartByBusiness();

                if(!fg.isEmpty(this.businessId)){
                    this.setBusinessItems(this.businessId)
                }

            },
            deep: true

        },


        // shoppingCart(val) {
        //     console.log('se modifico el carrito de compras',val);
        //
        //     this.groupShoppingCartByBusiness();
        //
        //     if(!fg.isEmpty(this.businessId)){
        //         this.setBusinessItems(this.businessId)
        //     }
        //
        // },
    }
};
