<template>
        <div class="row">

            <div class="col-12" v-if="(shoppingCart == null || shoppingCart.items.length == 0 ) && loadShoppingCart">
                <div class="alert alert-primary" >
                    El carrito de compras está vacío.
                </div>
                <a class="btn btn-custom btn-secondary-custom btn-block" :href="$root.getCompleteUrlByUri('market-place')">
                    <i class="fas fa-store"></i> Ir a la tienda
                </a>
            </div>


            <div class="col-12" v-if="shoppingCart && shoppingCart.items.length > 0" >

                <div class="mb-5" v-for="(shoppingCartBusiness,index) in  shoppingCartBusinesses" >
                    <h3 class="h3 font-weight-bold">
                        {{ shoppingCartBusiness.name }}
                    </h3>
                    <div class="table-responsive"  >
                        <table class="table product-table">

                            <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <span class="h4">Producto</span>
                                </th>
                                <th></th>
                                <th class="font-weight-bold">
                                    <span class="h4">Precio</span>
                                </th>
                                <th class="font-weight-bold">
                                    <span class="h4">Cantidad</span>
                                </th>
                                <th class="font-weight-bold">
                                    <span class="h4">Subtotal</span>
                                </th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="(item , index) in shoppingCartBusiness.items" >
                                <th scope="row">
                                    <img v-lazyload :data-src="item.product.picture_url_thumbnail" :alt="item.name" class="img-fluid z-depth-0">
                                </th>
                                <td>
                                    <h5 class="h5">
                                        <strong>{{ item.name }}</strong>
                                    </h5>
                                </td>
                                <td></td>
                                <td>
                                    <span class="h6">S/ {{ item.final_price }}</span>
                                    <p v-if="item.offer_active" class="h6 crossed-out-price mt-2 mb-0">
                                        S/ {{ item.price }}
                                    </p>
                                </td>
                                <td class="text-center text-md-left">

                                    <span class="d-flex align-items-center">
                                        <button :id="'decrease-'+item.id" type="button"  class="px-2 py-1 btn btn-outline-primary-custom btn-rounded" @click="decreaseOneItem(item)" :disabled="item.quantity == 1" >
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        <span :id="'quantity-'+item.id" class="h6 mb-0 mx-2"  >
                                            {{ item.quantity }}
                                        </span>

                                        <button :id="'increase-'+item.id" type="button" class="px-2 py-1 btn btn-outline-primary-custom btn-rounded" @click="increaseOneItem(item)"   >
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </span>

                                </td>
                                <td >
                                    <span class="font-weight-bold h6">
                                        <strong>S/ {{ getItemSubTotal(item) }}</strong>
                                    </span>
                                </td>
                                <td>

                                    <a  @click="deleteItem($event,item,index)" title="Quitar Producto" >
                                        <i class="far fa-trash-alt text-danger h4"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!--/table-responsive-->
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-6 col-lg-5 col-xl-4">
                            <div class="d-flex mb-3" >
                                <h4 class="h4 mb-0 bg-white-grey p-3">Total</h4>
                                <h4 class="h4 mb-0 p-3 ">S/ {{ getTotalByItems(shoppingCartBusiness.items) }}</h4>
                            </div>
                            <a :href="$root.getCompleteUrlByUri('checkout/businesses/'+shoppingCartBusiness.slug)" class="btn btn-custom btn-secondary-custom btn-block" >
                                Procesar pago <i :class="$root.configIcons.checkout_go.class"></i>
                            </a>
                        </div>
                    </div>
                </div>



<!--                <div class="row d-flex justify-content-end">-->
<!--                    <div class="col-md-6 col-lg-5 col-xl-4">-->

<!--                        <a :href="$root.getCompleteUrlByUri('market-place')" class="btn btn-custom btn-primary-custom btn-block mb-5" title="Ir al market place" >-->
<!--                            <i :class="$root.configIcons.market_place.class"></i> Seguir comprando-->
<!--                        </a>-->

<!--                        <h2 class="h2 mb-3">Resumen de compra</h2>-->
<!--                        <div class="d-flex mb-3" >-->
<!--                            <h4 class="h4 mb-0 bg-white-grey p-3">Total</h4>-->
<!--                            <h4 class="h4 mb-0 p-3 ">S/ {{ getTotal() }}</h4>-->
<!--                        </div>-->
<!--                        <a :href="$root.getCompleteUrlByUri('checkout')" class="btn btn-custom btn-secondary-custom btn-block" >-->
<!--                            Procesar pago <i :class="$root.configIcons.checkout_go.class"></i>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->

            </div><!--/col-->



        </div><!--!row-->
</template>

<script>

import { ItemService} from "../../../services/web/item.service";

import { shoppingCartMixin } from "../../../mixins/shopping-cart-mixin";

const itemService = new ItemService();

export default {
    mixins: [
        shoppingCartMixin
    ],
    mounted() {
        // console.log('Component Shopping Cart List mounted.');
        this.setShoppingCart();
        this.cookieToken = this.getCookieToken();
    },
    methods: {
        getItemSubTotal: function (item) {
            return parseFloat(item.quantity*item.final_price).toFixed(2);
        },
        deleteItem: async function (event, item, index) {
            let confirm = await fg.confirmModal();
            if (confirm) {
                let element = $(event.target)
                fg.loadingElement(element, 'fa-1x');

                try {
                    let response = await itemService.delete(item.id,this.cookieToken);
                    this.shoppingCart.items.splice(index, 1);
                    fg.modalMessage(response.data.message, 'success')

                } catch (error) {
                    console.error(error);
                }
                fg.resetLoadingElement(element);
            }
        },
        increaseOneItem: async function (item) {
            // console.log("increaseOne");
            let increaseBtn =  $(`#increase-${item.id}`);
            let decreaseBtn =  $(`#decrease-${item.id}`);

            let element = $("#quantity-" + item.id);
            fg.loadingElement(element, 'fa-1x mx-2');
            increaseBtn.prop('disabled', true);
            decreaseBtn.prop('disabled', true);

            try {
                let response = await itemService.increaseOne(item.id,this.cookieToken);
                item.quantity++;
            } catch (error) {
                console.error(error);
            }

            fg.resetLoadingElement(element)
            increaseBtn.prop('disabled', false);
            decreaseBtn.prop('disabled', false);
        },
        decreaseOneItem: async function (item) {
            if (item.quantity > 1) {
                let increaseBtn =  $(`#increase-${item.id}`);
                let decreaseBtn =  $(`#decrease-${item.id}`);

                let element = $("#quantity-" + item.id);
                fg.loadingElement(element, 'fa-1x mx-2');
                increaseBtn.prop('disabled', true);
                decreaseBtn.prop('disabled', true);

                try {
                    let response = await itemService.decreaseOne(item.id,this.cookieToken);
                    item.quantity--;
                } catch (error) {
                    console.error(error);
                }

                fg.resetLoadingElement(element)
                increaseBtn.prop('disabled', false);
                decreaseBtn.prop('disabled', false);
            }
        },
    }
}
</script>
