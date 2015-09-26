module.exports = function (Vue) {
    return Vue.extend(
        {
            data: function () {
                return {
                    loadingText: '',
                    method: 'POST',
                    debug: true,
                    loadTime: 0
                }
            },

            computed: {
                formURL: function () {
                    var base = $(this.$$.iform).attr('action');
                    var xdebug_key = this.getURLVars()['XDEBUG_SESSION_START'];
                    if(xdebug_key !== undefined){
                        base = base + "?XDEBUG_SESSION_START="+xdebug_key;
                    }
                    return base;
                }
            },

            methods: {
                getURLVars : function(){
                        var vars = {};
                        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                            vars[key] = value;
                        });
                        return vars;
                },
                register: function () {
                    console.log('Registering form.');
                    console.log(this.formURL);
                    this.$$.iform.addEventListener('submit', this.submitForm);
                },
                loadWait: function(){
                    var timeTaken = new Date().getTime()/1000 - this.loadTime;
                    while(timeTaken < 2) {
                        timeTaken = new Date().getTime()/1000 - this.loadTime;
                    }
                },
                submitForm: function (event) {
                    console.log('Submitting form.');
                    console.log(this.formURL);
                    event.preventDefault();
                    this.loadTime = new Date().getTime() / 1000;
                    this.setLoading();
                    this.cleanupErrors();
                    var instance = this;
                    $.ajax({
                        url: this.formURL,
                        type: this.method,
                        data: JSON.stringify(this.getForm())
                    }).done(function (data) {
                        localStorage.removeItem(window.location.href + '|form');
                        instance.loadWait();
                        console.log("Successful call to " + this.formURL);
                        $(instance.$$.loadingArea).collapse('hide');
                        instance.successFunction(data);
                    }).fail(function (error) {
                        instance.loadWait();
                        if (error.status >= 500) {
                            //TODO update the error code management for production
                            console.log(error);
                            document.open();
                            document.write(error.responseText);
                            document.close();
                        } else {
                            console.log(error);
                            instance.setNotLoading();
                            instance.renderErrors(error.responseJSON);
                        }
                    });
                },
                getForm: function(){
                  return this.form;
                },
                setupLoading: function () {
                },
                setupDebug: function () {
                    this.$$.iform.insertAdjacentHTML('afterend','<pre v-show="debug"> {{ getForm() | json }} </pre>');
                },
                setLoading: function () {
                    $(this.$$.loadingArea).collapse('show');
                    $(this.$$.iform).collapse('hide');
                },
                setNotLoading: function () {
                    $(this.$$.iform).collapse('show');
                    $(this.$$.loadingArea).collapse('hide');
                },
                collapseSwap: function (obj1, obj2) {
                    $(obj1).collapse('show');
                    $(obj2).collapse('hide');
                },
                renderErrors: function (jsonErrors) {
                    var instance = this;
                    $.each(jsonErrors, function (fieldName, error) {
                        var field = $(instance.$$.iform).find('[name="' + fieldName + '"]')[0];
                        var parent = $(field).closest('.form-group')[0];
                        $(parent).addClass('has-error');
                        var errorBlock = $(parent).find(".help-block");
                        $(errorBlock).text(error[0]);
                    });
                },
                cleanupErrors: function () {
                    var formGroups = $(this.$$.iform).find(".form-group.has-error");
                    $.each(formGroups, function (index, group) {
                        $(group).removeClass('has-error');
                        $(group).find(".help-block").text('');
                    });
                },
                successFunction: function (data) {
                    console.log('Default Success Function Called.');
                },
                minimizeToIDs: function (collection) {
                    var result = [];
                    if ($.isArray(collection)) {
                        for (var i = 0; i < collection.length; i++) {
                            result.push(collection[i].id);
                        }
                    }
                    return result;
                },
                startOver : function(){
                    this.clearForm();
                    $(this.$$.loadingArea).collapse('hide');
                    $(this.$$.successArea).collapse('hide');
                    $(this.$$.iform).collapse('show');
                }
            },
            ready: function () {
                var that = this;
                window.onbeforeunload = function(){
                    if(that.form) {
                        localStorage.setItem(window.location.href + '|form', JSON.stringify(that.form));
                    }
                };
                var formData = localStorage.getItem(window.location.href+"|form");
                if(formData && formData != null){
                    formData = JSON.parse(formData);
                    this.form = formData;
                }
                //this.setupDebug();
                this.setupLoading();
                this.register();
            }
        });
}
