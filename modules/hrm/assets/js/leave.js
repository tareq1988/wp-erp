/* jshint devel:true */
/* global wpErpHr */
/* global wp */

;(function($) {
    'use strict';

    var Leave = {

        initialize: function() {
            var self = this;

            $( '.erp-hr-leave-policy' ).on( 'click', 'a.submitdelete', self, this.policy.remove );
            $( 'body' ).on( 'change', '#erp-hr-leave-req-from-date, #erp-hr-leave-req-to-date', self, this.leave.requestDates );
            // trigger policy
            this.leave.setPolicy();
            $( 'body' ).on( 'change', '#erp-hr-leave-req-employee-id', self, this.leave.setPolicy );
            $( 'body' ).on( 'change', '.new-leave-request-form .f_year, .erp-hr-leave-request-new .f_year', self, this.leave.setPolicy );
            $( 'body' ).on( 'change', '#erp-hr-leave-req-leave-policy', self, this.leave.setAvailableDays );

            $( '.hrm-dashboard' ).on( 'click', '.erp-hr-new-leave-request-wrap a#erp-hr-new-leave-req', this.leave.takeLeave );
            $( '.erp-employee-single' ).on('submit', 'form#erp-hr-empl-leave-history', this.leave.showHistory );
            $( '.entitlement-list-table' ).on( 'click', 'a.submitdelete', self, this.entitlement.remove );

            //Holiday
            $( '.erp-hr-holiday-wrap' ).on( 'click', 'a#erp-hr-new-holiday', self, this.holiday.create );
            $( '.erp-hr-holiday-wrap' ).on( 'click', '.erp-hr-holiday-edit', self, this.holiday.edit );
            $( '.erp-hr-holiday-wrap' ).on( 'click', '.erp-hr-holiday-delete', self, this.holiday.remove );
            $( 'body' ).on( 'change', '.erp-hr-holiday-date-range', self, this.holiday.checkRange );

            // ICal calendar import
            $( '.erp-hr-holiday-wrap' ).on( 'click', '#erp-hr-import-ical', self, this.importICalInit );
            $( '.erp-hr-holiday-wrap' ).on( 'change', '#erp-ical-input', self, this.uploadICal );

            $( '.erp-hr-leave-requests' ).on( 'click', '.erp-hr-leave-approve-btn', self, this.leave.approve );
            $( '.erp-hr-leave-requests' ).on( 'click', '.erp-hr-leave-reject-btn', self, this.leave.reject );
            $( '.request-list-table' ).on( 'click', 'a.submitdelete', self, this.leave.remove );

            // Leaave report custom filter
            $( '#filter_year' ).on( 'change', self, this.customFilterLeaveReport );
            $( 'input[name="end"], input[name="start"]' ).on( 'change', self, this.checkDateRange );

            // leave entitlement initialize
            $( '.leave-entitlement-form' ).on( 'change', '#assignment_to', self, this.entitlement.hideEmployee );

            // trigger entitlement hide employee checkbox
            $( '.leave-entitlement-form#assignment_to' ).change();

            // trigger get policy names
            this.entitlement.getLeavePolicies();
            // trigger on change
            $( '.leave-entitlement-form' ).on( 'change', '.change_policy', self, this.entitlement.getLeavePolicies );

            // trigger get employees
            $( '.leave-entitlement-form' ).on( 'change', '#leave_policy', self, this.entitlement.getFilteredEmployee );

            this.initDateField();
        },

        initToggleCheckbox: function() {
            var lastClicked = false;
            // check all checkboxes
            $('tbody').children().children('.check-column').find(':checkbox').click( function(e) {
                if ( 'undefined' == e.shiftKey ) { return true; }
                if ( e.shiftKey ) {
                    if ( ! lastClicked ) {
                        return true;
                    }

                    checks  = $( lastClicked ).closest( 'form' ).find( ':checkbox' ).filter( ':visible:enabled' );
                    first   = checks.index( lastClicked );
                    last    = checks.index( this );
                    checked = $(this).prop('checked');

                    if ( 0 < first && 0 < last && first != last ) {
                        sliced = ( last > first ) ? checks.slice( first, last ) : checks.slice( last, first );
                        sliced.prop( 'checked', function() {
                            if ( $(this).closest('tr').is(':visible') )
                                return checked;

                            return false;
                        });
                    }
                }

                lastClicked = this;

                // toggle "check all" checkboxes
                var unchecked = $(this).closest('tbody').find(':checkbox').filter(':visible:enabled').not(':checked');
                $(this).closest('table').children('thead, tfoot').find(':checkbox').prop('checked', function() {
                    return ( 0 === unchecked.length );
                });

                return true;
            });

            $('thead, tfoot').find('.check-column :checkbox').on( 'click.wp-toggle-checkboxes', function( event ) {
                var $this          = $(this),
                    $table         = $this.closest( 'table' ),
                    controlChecked = $this.prop('checked'),
                    toggle         = event.shiftKey || $this.data('wp-toggle');

                $table.children( 'tbody' ).filter(':visible')
                    .children().children('.check-column').find(':checkbox')
                    .prop('checked', function() {
                        if ( $(this).is(':hidden,:disabled') ) {
                            return false;
                        }

                        if ( toggle ) {
                            return ! $(this).prop( 'checked' );
                        } else if ( controlChecked ) {
                            return true;
                        }

                        return false;
                    });

                $table.children('thead,  tfoot').filter(':visible')
                    .children().children('.check-column').find(':checkbox')
                    .prop('checked', function() {
                        if ( toggle ) {
                            return false;
                        } else if ( controlChecked ) {
                            return true;
                        }

                        return false;
                    });
            });
        },

        initDateField: function() {
            $( '.erp-leave-date-field' ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true
            });

            $( ".erp-leave-date-picker-from" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                    $( ".erp-leave-date-picker-to" ).datepicker( "option", "minDate", selectedDate );
                }
            });

            $( ".erp-leave-date-picker-to" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                    $( ".erp-leave-date-picker-from" ).datepicker( "option", "maxDate", selectedDate );
                }
            });

            $('.erp-color-picker').wpColorPicker();
        },

        holiday: {
            checkRange: function() {
                var self = $('input[name="range"]');

                if ( self.is(':checked') ) {
                    $('input[name="end_date"]').closest('.row').show();
                } else {
                    $('input[name="end_date"]').closest('.row').hide();
                }
            },

            create: function(e) {
                e.preventDefault();

                $.erpPopup({
                    title: wpErpHr.popup.holiday,
                    button: wpErpHr.popup.holiday_create,
                    id: 'erp-hr-holiday-create-popup',
                    content: wperp.template('erp-hr-holiday-js-tmp')({ data: null }).trim(),
                    extraClass: 'smaller',
                    onReady: function() {
                        Leave.initDateField();
                        Leave.holiday.checkRange();
                        Leave.initToggleCheckbox();
                    },
                    onSubmit: function(modal) {
                        e.data.holiday.submit.call(this, modal);
                    }
                }); //popup
            },

            edit: function(e) {
                e.preventDefault();
                var self = $(this);
                $.erpPopup({
                    title: wpErpHr.popup.holiday,
                    button: wpErpHr.popup.holiday_update,
                    id: 'erp-hr-holiday-create-popup',
                    content: wperp.template('erp-hr-holiday-js-tmp')({ data: null }).trim(),
                    extraClass: 'smaller',
                    onReady: function() {
                        Leave.initDateField();
                        Leave.holiday.checkRange();
                        var modal = this;
                        $( 'header', modal).after( $('<div class="loader"></div>').show() );

                        wp.ajax.send( 'erp-hr-get-holiday', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpHr.nonce
                            },
                            success: function(response) {
                                $( '.loader', modal).remove();
                                var holiday = response.holiday;

                                $( '#erp-hr-holiday-title', modal ).val( holiday.title );
                                $( '#erp-hr-holiday-start', modal ).val( holiday.start );
                                $( '#erp-hr-holiday-end', modal ).val( holiday.end );
                                $( '#erp-hr-holiday-id', modal ).val( holiday.id );
                                $( '#erp-hr-holiday-description', modal ).val( holiday.description );
                                $( '#erp-hr-holiday-action', modal ).val( 'erp_hr_holiday_create' );

                                var date1 = new Date( holiday.start );
                                var date2 = new Date( holiday.end );
                                var timeDiff = Math.abs( date2.getTime() - date1.getTime() );
                                var diffDays = Math.ceil( timeDiff / ( 1000 * 3600 * 24 ) );

                                if ( diffDays > 0 ) {
                                    $( '#erp-hr-holiday-range' ).attr( 'checked', 'checked' );
                                    $( '#erp-hr-holiday-range' ).trigger( 'change' );
                                };
                            }
                        });
                    },
                    onSubmit: function(modal) {
                        e.data.holiday.submit.call(this, modal);
                    }
                }); //popup
            },

            /**
             * Remove holiday
             *
             * @param  {event}
             */
            remove: function(e) {
                e.preventDefault();

                var self = $(this);

                if ( confirm( wpErpHr.delConfirmHoliday ) ) {
                    wp.ajax.send( 'erp-hr-holiday-delete', {
                        data: {
                            '_wpnonce': wpErpHr.nonce,
                            id: self.data( 'id' )
                        },
                        success: function() {
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                            });
                        },
                        error: function(response) {
                            alert( response );
                        }
                    });
                }
            },

            submit: function(modal) {
                wp.ajax.send( {
                    data: this.serializeObject(),
                    success: function() {
                        modal.closeModal();

                        $( '.list-table-wrap' ).load( window.location.href + ' .list-wrap-inner', function() {
                            Leave.initDateField();
                            Leave.initToggleCheckbox();
                        } );
                    },
                    error: function(error) {
                        modal.enableButton();
                        modal.showError( error );
                    }
                });
            },
        },

        policy: {
            remove: function(e) {
                e.preventDefault();

                var self = $(this);

                if ( confirm( wpErpHr.delConfirmPolicy ) ) {
                    wp.ajax.send( 'erp-hr-leave-policy-delete', {
                        data: {
                            '_wpnonce': wpErpHr.nonce,
                            id: self.data( 'id' )
                        },
                        success: function() {
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                            });
                        },
                        error: function(response) {
                            alert( response );
                        }
                    });
                }
            },
        },

        entitlement: {
            remove: function(e) {
                e.preventDefault();

                var self = $(this);

                if ( confirm( wpErpHr.delConfirmEntitlement ) ) {
                    wp.ajax.send( 'erp-hr-leave-entitlement-delete', {
                        data: {
                            '_wpnonce': wpErpHr.nonce,
                            id: self.data( 'id' ),
                            user_id: self.data( 'user_id' ),
                            policy_id: self.data( 'policy_id' ),
                        },
                        success: function() {
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                            });
                        },
                        error: function(response) {
                            alert( response );
                        }
                    });
                }
            },

            hideEmployee: function (e) {
                e.preventDefault();

                if ( $(this).is(':checked') ) {
                    $( '.single_employee_field' ).hide();
                } else {
                    $( '.single_employee_field' ).show();
                }
            },

            getLeavePolicies: function () {

                $( '.leave-entitlement-form .leave_policy').find('option').remove();
                $( ".leave-entitlement-form .leave_policy" ).prop("disabled", true);

                var department  = $('.leave-entitlement-form .department_id').select2('data'),
                    designation = $('.leave-entitlement-form .designation_id').select2('data'),
                    location    = $('.leave-entitlement-form .location_id').select2('data'),
                    gender      = $('.leave-entitlement-form .gender').select2('data'),
                    marital     = $('.leave-entitlement-form .marital').select2('data'),
                    f_year      = $('.leave-entitlement-form .f_year').select2('data'),
                    employee_type = $('.leave-entitlement-form .employee_type').select2('data');;

                if ( typeof f_year === "undefined" ) {
                    return;
                }

                if ( f_year[0].id == '' ) {
                    return;
                }

                wp.ajax.send( 'erp-hr-leave-get-policies', {
                    data: {
                        '_wpnonce': wpErpHr.nonce,
                        employee_type:      employee_type[0].id,
                        department_id:      department[0].id,
                        designation_id:     designation[0].id,
                        location_id:        location[0].id,
                        gender:             gender[0].id,
                        marital:            marital[0].id,
                        f_year:             f_year[0].id,
                    },
                    success: function( resp ) {
                        var policy_select = $( '.leave-entitlement-form .leave_policy');
                        //remove old items
                        policy_select.find('option').remove();

                        $.each( resp, function ( policy_id, policy_name ) {
                            var option = new Option(policy_name, policy_id);
                            policy_select.append(option);
                        } );

                        // trigger value change
                        policy_select.trigger('change');

                        policy_select.prop("disabled", false);
                    },
                    error: function( response ) {
                        console.log( response )
                    }
                });

            },

            getFilteredEmployee: function () {

                var leave_policy  = $('.leave-entitlement-form #leave_policy').val();

                $( ".leave-entitlement-form .single_employee" ).prop("disabled", true);

                if ( typeof leave_policy === 'undefined' || leave_policy == 0 || leave_policy == '' ) {
                    return;
                }

                wp.ajax.send( 'erp-hr-leave-get-employees', {
                    data: {
                        '_wpnonce': wpErpHr.nonce,
                        policy_id:      leave_policy,
                    },
                    success: function( resp ) {
                        var employee_select = $( '.leave-entitlement-form .single_employee');
                        //remove old items
                        employee_select.find('option').remove();

                        $.each( resp, function ( employee_id, employee_name ) {
                            var option = new Option(employee_name, employee_id);
                            employee_select.append(option);
                        } );

                        // trigger value change
                        employee_select.trigger('change');

                        employee_select.prop("disabled", false);
                    },
                    error: function( response ) {
                        console.log( response )
                    }
                });
            },
        },

        leave: {
            takeLeave: function(e) {
                e.preventDefault();

                $.erpPopup({
                    title: wpErpHr.popup.new_leave_req,
                    button: wpErpHr.popup.take_leave,
                    id: 'erp-hr-new-leave-req-popup',
                    content: wp.template( 'erp-new-leave-req' )().trim(),
                    extraClass: 'smaller',
                    onReady: function() {
                        Leave.initDateField();
                    },
                    onSubmit: function(modal) {
                        $( 'button[type=submit]', '.erp-modal' ).attr( 'disabled', 'disabled' );

                       // console.log(this.serialize());
                        var form = $('#erp-hr-new-leave-req-popup .erp-modal-form')[0];
                        var data = new FormData( form );

                        $.ajax({
                            type: "POST",
                            enctype: 'multipart/form-data',
                            url: ajaxurl,
                            data: data,
                            processData: false,
                            contentType: false,
                            cache: false,
                            timeout: 600000,
                            success: function ( res ) {
                                modal.enableButton();
                                alert( res.data );
                                modal.closeModal();
                            },
                            error: function (e) {
                                modal.enableButton();
                                modal.showError( e );
                            }
                        });
                    }
                });
                Leave.leave.setPolicy();
            },

            requestDates: function(e) {
                var from = $('#erp-hr-leave-req-from-date').val(),
                    to = $('#erp-hr-leave-req-to-date').val(),
                    submit = $(this).closest('form').find('*[type="submit"]'),
                    user_id = parseInt( $( '#erp-hr-leave-req-employee-id').val() ),
                    type = $('#erp-hr-leave-req-leave-policy').val();

                    // From WPERP pro
                    // we are sending request only for `from date``
                    var halfDay = $('#halfday');
                    var isHalfDay = false;

                    if ( halfDay.val() !== 'undefined' ) {
                        if ( halfDay.is(':checked') ) {
                            isHalfDay = true;

                            if (e.target.name === 'leave_to') {
                                return;
                            }
                        }
                    }

                if ( from !== '' && to !== '' ) {

                    wp.ajax.send( 'erp-hr-leave-request-req-date', {
                        data: {
                            '_wpnonce': wpErpHr.nonce,
                            from: from,
                            to: to,
                            employee_id: user_id,
                            type : type
                        },
                        success: function(resp) {
                            var html = wp.template('erp-leave-days')(resp.print);

                            // Show day counts if half day is holiday or not working day
                            if ( isHalfDay === true && resp.leave_count != '0' ) {
                                html = '';
                            }

                            $('div.erp-hr-leave-req-show-days').html( html );

                            if ( parseInt( resp.leave_count ) <= 0 ) {
                                submit.prop('disabled', true);
                            } else {
                                submit.prop('disabled', false);
                            }

                        },
                        error: function(response) {
                            $('div.erp-hr-leave-req-show-days').empty();
                            submit.attr( 'disabled', 'disable' );
                            if ( typeof response !== 'undefined' ) {
                                alert( response );
                            }
                        }
                    });
                }
            },

            setPolicy: function() {
                Leave.leave.resetDateRange();
                var self = $(this),
                    leaveWrap = $('div.erp-hr-leave-reqs-wrap'),
                    leavetypewrap = leaveWrap.find('.erp-hr-leave-type-wrapper')

                leavetypewrap.html('');

                if ( $('#erp-hr-leave-req-employee-id').val() == 0 ) {
                    return;
                };

                var f_year = $('.f_year').val();

                if ( f_year == 0 || f_year === undefined ) {
                    return;
                }

                wp.ajax.send( 'erp-hr-leave-employee-assign-policies', {
                    data: {
                        '_wpnonce'  : wpErpHr.nonce,
                        employee_id : $('#erp-hr-leave-req-employee-id').val(),
                        f_year: f_year,
                    },
                    success: function(resp) {
                        leavetypewrap.html( resp ).hide().fadeIn();
                        leaveWrap.find( 'input[type="text"], textarea').removeAttr('disabled');
                    },
                    error: function(resp) {
                        leavetypewrap.html( '<div class="notice error"><p>' + resp + '</p></div>' ).hide().fadeIn();
                    }
                } );
            },

            setAvailableDays: function() {
                Leave.leave.resetDateRange();
                var self = $(this);

                wp.ajax.send( 'erp-hr-leave-policies-availablity', {
                    data: {
                        '_wpnonce'  : wpErpHr.nonce,
                        employee_id : $('#erp-hr-leave-req-employee-id').val(),
                        policy_id   : self.val()
                    },
                    success: function(resp) {
                        self.closest('div.row').find('span.description').remove();
                        $(resp).insertAfter(self);
                    },
                    error: function(resp) {
                        alert( resp );
                    }
                } );
            },

            resetDateRange: function() {
                $('#erp-hr-leave-req-from-date').val('');
                $('#erp-hr-leave-req-to-date').val('');
                $('div.erp-hr-leave-req-show-days').html('');
            },

            showHistory: function(e) {
                e.preventDefault();

                var form = $(this);

                wp.ajax.send( 'erp-hr-empl-leave-history', {
                    data: form.serializeObject(),
                    success: function(resp) {
                        $('table#erp-hr-empl-leave-history-table tbody').html(resp);
                    }
                } );
            },

            approve: function(e) {
                e.preventDefault();

                var self = $(this),
                data = {
                    id : self.data('id')
                };

                $.erpPopup({
                    title: wpErpHr.popup.leave_approve,
                    button: wpErpHr.popup.leave_approve_btn,
                    id: 'erp-hr-leave-approve-popup',
                    content: wperp.template('erp-hr-leave-approve-js-tmp')(data).trim(),
                    extraClass: 'smaller',
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serialize()+'&_wpnonce='+wpErpHr.nonce,
                            success: function(res) {
                                var error_string = '';
                                if ( res.errors ) {
                                    $.each( res.errors, function( key, val ) {
                                        error_string += '<div class="notice notice-error is-dismissible"><p>' + val[0] + '</p></div>';
                                    });
                                    if ( error_string != '' ) {
                                        $('#leave-approve-form-error').html( error_string );
                                    }
                                }
                                else if( res.redirect ) {
                                    var approve_url = window.location.origin + window.location.pathname + '?1=1';
                                    $.each( res.redirect, function( key, val ) {
                                        approve_url += '&' + key + '=' + val;
                                    });
                                    window.location.replace( approve_url );
                                }
                                else {
                                    var approve_url = window.location.origin + window.location.pathname + '?page=erp-hr&section=leave&status=1';
                                    window.location.replace( approve_url );
                                }
                            },
                            error: function(error) {
                                modal.showError( error );
                            }
                        });
                    }
                }); //popup
            },

            reject: function(e) {
                e.preventDefault();

                var self = $(this),
                data = {
                    id : self.data('id')
                };

                $.erpPopup({
                    title: wpErpHr.popup.leave_reject,
                    button: wpErpHr.popup.leave_reject_btn,
                    id: 'erp-hr-leave-reject-popup',
                    content: wperp.template('erp-hr-leave-reject-js-tmp')(data).trim(),
                    extraClass: 'smaller',
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serialize()+'&_wpnonce='+wpErpHr.nonce,
                            success: function(res) {
                                var error_string = '';
                                if ( res.errors ) {
                                    $.each( res.errors, function( key, val ) {
                                        error_string += '<div class="notice notice-error is-dismissible"><p>' + val[0] + '</p></div>';
                                    });
                                    if ( error_string != '' ) {
                                        $('#leave-reject-form-error').html( error_string );
                                    }
                                }
                                else if( res.redirect ) {
                                    var approve_url = window.location.origin + window.location.pathname + '?1=1';
                                    $.each( res.redirect, function( key, val ) {
                                        approve_url += '&' + key + '=' + val;
                                    });
                                    window.location.replace( approve_url );
                                }
                                else {
                                    var approve_url = window.location.origin + window.location.pathname + '?page=erp-hr&section=leave&status=3';
                                    window.location.replace( approve_url );
                                }
                            },
                            error: function(error) {
                                modal.showError( error );
                            }
                        });
                    }
                }); //popup
            },

            remove: function(e) {
                e.preventDefault();

                var self = $(this);

                if ( confirm( wpErpHr.delConfirmRequest ) ) {
                    wp.ajax.send( 'erp-hr-leave-request-delete', {
                        data: {
                            '_wpnonce': wpErpHr.nonce,
                            id: self.data( 'id' ),
                        },
                        success: function() {
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                            });
                        },
                        error: function(response) {
                            alert( response );
                        }
                    });
                }
            },
        },

        importICalInit: function ( e ) {
            e.preventDefault();
            $( 'body #erp-ical-input' ).trigger( 'click' );
        },

        uploadICal: function ( e ) {
            e.preventDefault();

            var icsFile = e.target.files[0],
                data = new FormData(),
                form = $(this).parents('form');

            data.append( 'ics', icsFile );
            data.append( 'action', 'erp-hr-import-ical' );
            data.append( '_wpnonce', wpErpHr.nonce );

            wp.ajax.send( {
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function( res ) {
                    $( '.list-table-wrap' ).load( window.location.href + ' .list-wrap-inner', function() {
                        Leave.initDateField();
                        $('#holiday_msg').html( res );
                    } );

                    form[0].reset();
                },
                error: function(error) {
                    form[0].reset();
                    alert( error );
                }
            });
        },
        customFilterLeaveReport: function() {
            if ( 'custom' != this.value ) {
                $('#custom-input').remove();
            } else {
                var element = '<span id="custom-input" style="float:left"><span>From </span><input name="start" class="erp-leave-date-field" type="text">&nbsp;<span>To </span><input name="end" class="erp-leave-date-field" type="text"></span>';
                $('#custom-date-range').after( element );
            }
            Leave.initDateField();
        },
        checkDateRange: function() {
            var new_date = new Date( this.value );
            var year = new_date.getFullYear();
            var current_date = new Date();
            var current_year = current_date.getFullYear();

            if ( year > current_year ) {
                alert( 'Enter date range between current year' );
                this.value = "";
            }
        }
    };

    $(function() {
        Leave.initialize();
    });

})(jQuery);
