/**
 * Created by james on 10/28/15.
 */
module.exports = function (Resources) {
    return Resources.Vue.extend({
        props: {
            route: {
                type: String,
                required: true
            },
            fileTypes: {
                type: String,
                required: false,
                default: '*'
            },
            inputName: {
                type: String,
                required: false,
                default: 'file'
            },
            maxFiles: {
                type: Number,
                required: false,
                default: -1
            },
            message: {
                type: String,
                required: false,
                default: ''
            }
        },
        data: function () {
            return {
                types: {
                    images: ['.jpg', '.jpeg', '.png'],
                    document: ['.pdf', '.doc', '.docx', '.txt']
                },
                token: '',
                createdImageIDs: [],
                dz: {}
            }
        },
        methods: {
            onPreFormSubmit: function (form) {
                var ids = this.createdImageIDs.slice(Math.max(this.createdImageIDs.length - this.maxFiles, 0));
                if(ids.length == 1){
                    ids = ids[0];
                }
                form[this.inputName] = ids;
                return true;
            },
            onSuccessfulSubmit: function(){
                this.dz.removeAllFiles();
            }
        },
        template: require('./dropzone.template.html'),
        ready: function () {
            console.log(this.$parent);
            this.token = Resources.getFromMetadata('csrf-token');
            var options = {
                url: this.route,
                paramName: this.inputName,
                method: 'POST',
                addRemoveLinks: true,
                autoProcessQueue: false
            };
            var maxFiles = this.maxFiles;
            var instance = this;
            options['init'] = function () {
                this.on('sending',function(){
                    console.log('dropzone sending');
                   instance.$dispatch('dropzone-sending');
                });
                this.on('complete',function(){
                    console.log('dropzone complete');
                   instance.$dispatch('dropzone-complete');
                });
                this.on('success',function(file,data){
                    instance.createdImageIDs.push(data['id']);
                });
                if (maxFiles > 0) {
                    this.on('addedfile', function () {
                        if (this.files[maxFiles] != null) {
                            this.removeFile(this.files[0]);
                        }
                    });
                }
            }

            if (this.fileTypes !== '*') {
                var acceptedTypes = [];
                var givenTypes = this.fileTypes.split('|');
                givenTypes.forEach(function (type) {
                    if (type in instance.types) {
                        var mimes = instance.types[type];
                        mimes.forEach(function (mime) {
                            acceptedTypes.push(mime);
                        });
                    }
                });
                options['acceptedFiles'] = acceptedTypes.join();
            }
            if (this.maxFiles > 0) {
                options['maxFiles'] = maxFiles + 1;
            }
            if (this.message !== '') {
                options['dictDefaultMessage'] = this.message;
            }
            this.dz = new Resources.Dropzone(this.$$.dropzone, options);
            this.$dispatch('registerFormDependency', this);
        }
    });
};