<template>
    <div class="row" v-show="loadOrders">
        <div class="col-12" v-if="orders.length == 0">
            <div class="alert alert-primary" >
                No se encontraron pedidos.
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4" v-for="(item , index) in orders" >
            <div class="card card-my-order mb-3" >
                <a :href="getUrlOrder(item.id)">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="w-100 mr-3">
                            <h4 class="card-title mb-2 h5 ">
                                Pedido {{ item.code }}<br>
                                <small>{{ item.display_full_created_at }}</small>
                            </h4>
                            <p class="card-text d-flex justify-content-between">
                                Total: S/. {{ item.total }}

                                <span v-html="item.order_state.badge" ></span>
                            </p>
                        </div>

                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>

</template>

<script>

import { OrderService } from '../../../services/admin/order.service';

const orderService = new OrderService();

export default {
    props: {
        orderStateId: {  default: '' }
    },
    data(){
        return {
            orders: [],
            loadOrders:false,
        }
    },
    mounted() {
        this.getOrders(this.orderStateId);
    },methods:{
        getOrders: async function(orderStateId){
            try {
                let params = {'order_state_id':orderStateId}
                this.orders = await orderService.getAllForAuthUser(params);
                this.loadOrders = true;
                console.log('orders:',this.orders);
            } catch (error) {
                console.error(error)
            }
        },
        getUrlOrder: function(orderId){
            return `${urlPagina}/admin/mis-compras/${orderId}`;
        }
    }
}
</script>
