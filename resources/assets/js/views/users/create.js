module.exports = function (Resources) {
    return Resources.form.extend({
        methods: {
            successFunction: function (data) {
                $(this.$$.loadingArea).collapse('hide');
                $(this.$$.successArea).collapse({'toggle': false});
                $(this.$$.successArea).collapse('show');
                console.log(this.$parent);
                this.$dispatch('pledge_created', data);
            }
        }
    });
};