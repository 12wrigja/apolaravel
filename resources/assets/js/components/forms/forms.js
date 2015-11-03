module.exports = function (Vue) {
    return Vue.extend(
        {
            data: function () {
                return {
                    loadingText: '',
                    method: 'POST',
                    debug: true,
                    loadTime: 0,
                    requirees: []
                }
            },

            computed: {
                formURL: function () {
                    var base = $(this.$$.iform).attr('action');
                    var xdebug_key = this.getURLVars()['XDEBUG_SESSION_START'];
                    if (xdebug_key !== undefined) {
                        var delim;
                        if (base.contains('?')) {
                            delim = '&';
                        } else {
                            delim = '?';
                        }
                        base = base + delim + "XDEBUG_SESSION_START=" + xdebug_key;
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
                    var form = this.getForm();
                    console.log(this.requirees.length);
                    for (var i = 0; i < this.requirees.length; i++) {
                        var res = this.requirees[i].onPreFormSubmit(form);
                        if (!res) {
                            setTimeout(function() {
                                instance.setNotLoading();
                            },1000);
                            return;
                        }
                    }
                    console.log(JSON.stringify(form));
                    $.ajax({
                        url: this.formURL,
                        type: this.method,
                        data: JSON.stringify(form)
                    }).done(function (data) {
                        localStorage.removeItem(window.location.href + '|form');
                        setTimeout(function () {
                            console.log("Done Waiting.");
                            console.log("Successful call to " + this.formURL);
                            for(var i=0; i<instance.requirees.length; i++){
                                instance.requirees[i].onSuccessfulSubmit();
                            }
                            $(instance.$$.loadingArea).collapse('hide');
                            instance.successFunction(JSON.parse(data));
                        }, 1000);
                    }).fail(function (error) {
                        setTimeout(function () {
                            console.log("Done Waiting.");
                            if (error.status >= 500) {
                                //TODO update the error code management for production
                                console.log(error);
                                //document.open();
                                //document.write(error.responseText);
                                //document.close();
                            } else {
                                console.log(error);
                                instance.renderErrors(error.responseJSON);
                                instance.setNotLoading();
                            }
                        }, 1000);
                    });
                },
                loopRequirees: function(index, allCompleteFunction, failFunction){
                  if(index > this.requirees.length){
                      allCompleteFunction();
                  } else {
                      var response = this.requirees[index].onPreFormSubmit()
                  }
                },
                getForm: function () {
                    return this.form;
                },
                setupLoading: function () {
                    $(this.$$.iform).collapse({'toggle': false});
                    $(this.$$.loadingArea).collapse({'toggle': false});
                },
                setLoading: function () {
                    $(this.$$.loadingArea).collapse('show');
                    $(this.$$.iform).collapse('hide');
                },
                setNotLoading: function () {
                    $(this.$$.iform).collapse('show');
                    $(this.$$.loadingArea).collapse('hide');
                    console.log('Set not loading. Form should be visible.');
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
                startOver: function () {
                    this.clearForm();
                    $(this.$$.loadingArea).collapse('hide');
                    $(this.$$.successArea).collapse('hide');
                    $(this.$$.iform).collapse('show');
                },
                closeForm: function(){
                    this.setNotLoading;
                },
                confirmClearForm: function () {
                    var instance = this;
                    if (window.confirm("Are you sure you want to clear this form?")) {
                        instance.clearForm();
                    }
                }
            },
            events : {
                'registerFormDependency': function(component){
                    console.log('registering form dependency');
                    if (!(component in this.requirees)) {
                        this.requirees.push(component);
                    }
                    console.log(this.requirees);
                }
            },
            ready: function () {
                var that = this;
                window.onbeforeunload = function () {
                    if (that.form) {
                        localStorage.setItem(window.location.href + '|form', JSON.stringify(that.form));
                    }
                };
                var formData = localStorage.getItem(window.location.href + "|form");
                if (formData && formData != null) {
                    formData = JSON.parse(formData);
                    this.form = formData;
                }
                //this.setupDebug();
                this.setupLoading();
                this.register();
            }
        });
}
