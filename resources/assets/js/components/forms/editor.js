module.exports = function (Resources) {

    return Resources.Vue.extend({
        data: function () {
            return {
                topVerb: 'Edit',
                loadText: 'Editing',
                actionButton: 'Save Changes',
                isCreate: false,
                isEdit: true
            }
        },
        props: {
            canSubmit: {
                type: Boolean,
                required: false,
                default: true
            },
            itemName: {
                type: String,
                required: false,
                default: ''
            }
        },
        computed: {
          loadingText: function(){
              return this.loadText + " " + this.itemName + " ...";
          }
        },
        template: require('./editor.template.html'),
        methods: {
            successFunction: function (data) {
                $(this.$$.loadingArea).collapse('hide');
                //collapse modal, update data in main list
                this.$dispatch('successfulEdit', data['data']);
                //Update the existing report reference to use this data.
                $(this.$$.modal).modal('hide');
            },
            show: function () {
                $(this.$$.modal).modal('show');
            },
            setEditMode: function () {
                this.isEdit = true;
                this.isCreate = false;
                this.topVerb = 'Edit';
                this.loadText = 'Editing';
                this.actionButton = 'Save Changes';
            },
            setCreateMode: function () {
                this.isCreate = true;
                this.isEdit = false;
                this.topVerb = 'Create';
                this.loadText = 'Creating';
                this.actionButton = 'Create';
            },
            actionButtonClicked: function(event){
                console.log('Editor Action Button Clicked!');
            },
            editorClosed: function(event){
                console.log('Editor closing!');
            }
        }
    });
};

