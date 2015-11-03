/**
 * Created by james on 10/28/15.
 */
module.exports = function (Resources) {
    return Resources.Vue.extend({
        data: function () {
            return {
                slides: [],
                canSubmit: true,
                form: {
                    title: '',
                    caption: '',
                    action_test: '',
                    action_url: '',
                    background_image: ''
                }
            }
        },
        methods: {
            enableSlide: function (slide) {

            },
            disableSlide: function (slide) {

            },
            editSlide: function (slide) {
                console.log(slide);
                this.$.editForm.setEditMode();
                this.$.editForm.form = Resources.Vue.util.extend({}, slide);
                this.$.editForm.form.id = slide.id;
                var instance = this;
                this.$on('successfulEdit', function (updatedSlide) {
                    instance.slides.forEach(function (item, index) {
                        if (item.id === updatedSlide.id) {
                            instance.slides.$set(index, updatedSlide);
                            var id = '#collapse' + item.id;
                            Resources.Vue.nextTick(function () {
                                $(id).collapse('show');
                            });
                        }
                    });
                });
                this.$.editForm.show();
            },
            createSlide: function () {
                this.$on('successfulEdit', function (updatedSlide) {
                    instance.slides.push(updatedSlide);
                });
                this.$.editForm.setCreateMode();
                this.$.editForm.show();
            }
        },
        filters: {
            empty: function (array) {
                if (array && array !== null) {
                    return array.constructor === Array && array.length == 0;
                }
                return true;
            },
        },
        events: {
            'dropzone-complete': function () {
                this.isSendingFiles = false;
            },
            'dropzone-sending': function () {
                this.isSendingFiles = true;
            }
        },
        ready: function () {
            console.log(Resources.getFromMetadata('carousel_item_api'));
            this.$http.get(Resources.getFromMetadata('carousel_item_api').replace(':id', 0), function (data, status, request) {
                if (status == 200) {
                    this.slides = data['data'];
                } else {
                    console.log(data);
                }
            });
        }
    });
};