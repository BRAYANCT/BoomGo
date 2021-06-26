import { UserService } from "../services/admin/user.service";

const userService = new UserService();

export const authMixin = {
    mounted() {
        // console.log('Auth Mixin.');
        this.getAuthUser();
    },
    data() {
        return {
            configRoles: configRoles,
            authCheck: authCheck,
            authUser: null,
            authRole: authRole,
        }
    },
    methods: {
        getAuthUser : async function(){
            try {
                this.authUser = await userService.getAuthUser();
                // console.log('this.authUser:',this.authUser);
            }catch (error) {
                console.log(error);
            }
        },
        /**
         * Verifica si el usuario autenticado es administrador del sistema
         *
         * @return void
         */
        isAdminSys : function(){
            return authRole.id == configRoles.ADMIN_SYS_ID;
        },
        /**
         * Verifica si el usuario autenticado es administrador del sistema
         *
         * @return void
         */
        isAdmin : function(){
            return authRole.id == configRoles.ADMIN_ID;
        },
        /**
         * Verifica si el usuario autenticado es vendor
         *
         * @return void
         */
        isVendor : function(){
            return authRole.id == configRoles.VENDOR_ID;
        },
        /**
         * Verifica si el usuario autenticado es cliente
         *
         * @return void
         */
        isCustomer : function(){
            return authRole.id == configRoles.CUSTOMER_ID;
        },
        /**
         * Verifica si el role del usuario puede elegir un negocio
         *
         * @return void
         */
        canChooseBusiness : function(){
            return this.isAdminSys() || this.isAdmin() ;
        },
    }
};

export const loginModalMixin = {
    mounted() {
        // console.log('Login modal Mixin.');
    },
    // data() {
    //     return {
    //         // errors: null,
    //     }
    // },
    methods: {
        /**
         * Muestra la modal de login
         *
         * @return void
         */
        showLoginModal : function(){
            this.$root.$emit('clean-login-modal-form');
            $("#modal-login").modal('show');
        },
    }
};
