
export const constantMixin = {
    data() {
        return {
            configAttributes: configAttributes,
            configButtons: configButtons,
            configIcons: configIcons,
            configImages: (typeof configImage === 'undefined') ? null : configImage,
        }
    },
    mounted() {

    }
};
