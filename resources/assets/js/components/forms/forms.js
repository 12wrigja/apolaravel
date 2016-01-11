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
                    if (base === undefined) {
                        base = window.location.href;
                    }
                    var xdebug_key = this.getURLVars()['XDEBUG_SESSION_START'];
                    if (xdebug_key !== undefined) {
                        base = base + "?XDEBUG_SESSION_START=" + xdebug_key;
                    }
                    if (base.indexOf(':id') >= 0) {
                        base = base.replace(':id', this.getIDForForm());
                    }
                    return base;
                }
            },

            methods: {
                getURLVars: function () {
                    var vars = {};
                    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
                        vars[key] = value;
                    });
                    return vars;
                },
                register: function () {
                    console.log('Registering form.');
                    this.$$.iform.addEventListener('submit', this.submitForm);
                },
                submitForm: function (event) {
                    console.log('Submitting form.');
                    console.log(this.formURL);
                    if (event !== null && event !== undefined) {
                        event.preventDefault();
                    }
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
                        setTimeout(function () {
                            console.log("Done Waiting.");
                            console.log("Data: \n" + data);
                            $(instance.$$.loadingArea).collapse('hide');
                            if (typeof data == "string") {
                                instance.successFunction(JSON.parse(data));
                            } else {
                                instance.successFunction(data);
                            }
                        }, 1000);
                    }).fail(function (error) {
                        setTimeout(function () {
                            console.log("Done Waiting.");
                            if (error.status == 401 && error.responseJSON.error.redirect_url !== undefined) {
                                //console.log('Redirecting to login page.');
                                console.log(error.responseJSON);
                                window.location.href = error.responseJSON.error.redirect_url;
                            } else if (error.status == 401 && error.responseJSON.error === "reload") {
                                console.log('Reloading page to deal with CSRF issues.');
                                console.log(error.responseJSON);
                                window.location.reload();
                            } else if (error.status == 422) {
                                console.log(error);
                                instance.renderErrors(error.responseJSON);
                                instance.setNotLoading();
                            } else if (error.status == 403){
                                var errors = {};
                                errors.general = error.responseJSON.message;
                                instance.renderErrors(errors);
                                instance.setNotLoading();
                            } else {
                                //Probably a critical error here.
                                console.log(error);
                                if (instance.$$.errorArea !== undefined) {
                                    var eA = $(instance.$$.errorArea);
                                    var textErrorArea = eA.find('.help-block')[0];
                                    if (error.hasOwnProperty('responseJSON') && error.responseJSON.hasOwnProperty('errors') && error.responseJSON.errors.hasOwnProperty('message')) {
                                        textErrorArea.innerHTML = error.responseJSON.errors.message;
                                    } else {
                                        textErrorArea.innerHTML = "An error occured.";
                                    }
                                    $(instance.$$.loadingArea).collapse('hide');
                                    eA.collapse('show');
                                }
                            }
                        }, 1000);
                    });
                },
                getForm: function () {
                    return this.form;
                }
                ,
                setupLoading: function () {
                    $(this.$$.iform).collapse({'toggle': false});
                    $(this.$$.loadingArea).collapse({'toggle': false});
                }
                ,
                setupDebug: function () {
                    this.$$.iform.insertAdjacentHTML('afterend', '<pre v-show="debug"> {{ getForm() | json }} </pre>');
                }
                ,
                setLoading: function () {
                    $(this.$$.loadingArea).collapse('show');
                    $(this.$$.iform).collapse('hide');
                }
                ,
                setNotLoading: function () {
                    $(this.$$.iform).collapse('show');
                    $(this.$$.loadingArea).collapse('hide');
                    console.log('Set not loading. Form should be visible.');
                }
                ,
                collapseSwap: function (obj1, obj2) {
                    $(obj1).collapse('show');
                    $(obj2).collapse('hide');
                }
                ,
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
                }
                ,
                successFunction: function (data) {
                    $(this.$$.loadingArea).collapse('hide');
                    $(this.$$.successArea).collapse({'toggle':false});
                    $(this.$$.successArea).collapse('show');
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
                clearForm: function(){
                  this.form = {};
                },
                startOver: function () {
                    this.clearForm();
                    $(this.$$.loadingArea).collapse('hide');
                    $(this.$$.successArea).collapse('hide');
                    $(this.$$.iform).collapse('show');
                }
                ,
                confirmClearForm: function () {
                    var instance = this;
                    if (window.confirm("Are you sure you want to clear this form?")) {
                        instance.clearForm();
                    }
                },
                fillForm: function(data){
                    for (var key in data) {
                        if (data.hasOwnProperty(key) && this.form[key] !== undefined) {
                            this.form[key] = data[key];
                        }
                    }
                }
            },
            ready: function () {
                var that = this;
                //window.onbeforeunload = function () {
                //    if (that.form) {
                //        localStorage.setItem(window.location.href + '|form', JSON.stringify(that.form));
                //    }
                //};
                //var formData = localStorage.getItem(window.location.href + "|form");
                //if (formData && formData != null) {
                //    formData = JSON.parse(formData);
                //    this.form = formData;
                //}
                //this.setupDebug();
                this.setupLoading();
                this.register();
            }
        })
        ;
}
