/* Custom General jQuery
/*--------------------------------------------------------------------------------------------------------------------------------------*/
;(function($, window, document, undefined) {

    $.fn.usPhoneFormat = function (options) {
        var params = $.extend({
            format: 'xxx-xxx-xxxx',
            international: false,

        }, options);

        if (params.format === 'xxx-xxx-xxxx') {
            $(this).bind('paste', function (e) {
                e.preventDefault();
                var inputValue = e.originalEvent.clipboardData.getData('Text');
                if (!$.isNumeric(inputValue)) {
                    return false;
                } else {
                    inputValue = String(inputValue.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3"));
                    $(this).val(inputValue);
                    $(this).val('');
                    inputValue = inputValue.substring(0, 12);
                    $(this).val(inputValue);
                }
            });
            $(this).on('keypress', function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
                var curchr = this.value.length;
                var curval = $(this).val();
                if (curchr == 3) {
                    $(this).val(curval + "-");
                } else if (curchr == 7) {
                    $(this).val(curval + "-");
                }
                $(this).attr('maxlength', '12');
            });

        } else if (params.format === '(xxx) xxx-xxxx') {
            $(this).on('keypress', function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
                var curchr = this.value.length;
                var curval = $(this).val();
                if (curchr == 3) {
                    $(this).val('(' + curval + ')' + " ");
                } else if (curchr == 9) {
                    $(this).val(curval + "-");
                }
                $(this).attr('maxlength', '14');
            });
            $(this).bind('paste', function (e) {
                e.preventDefault();
                var inputValue = e.originalEvent.clipboardData.getData('Text');
                if (!$.isNumeric(inputValue)) {
                    return false;
                } else {
                    inputValue = String(inputValue.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3"));
                    $(this).val(inputValue);
                    $(this).val('');
                    inputValue = inputValue.substring(0, 14);
                    $(this).val(inputValue);
                }
            });

        }
    }


	//Genaral Global variables
	//"use strict";
	var $win = $(window);
	var $doc = $(document);
	var $winW = function(){ return $(window).width(); };
	var $winH = function(){ return $(window).height(); };
	var $screensize = function(element){  
            $(element).width($winW()).height($winH());
        };
		
            var screencheck = function(mediasize){
                if (typeof window.matchMedia !== "undefined"){
                        var screensize = window.matchMedia("(max-width:"+ mediasize+"px)");
                        if( screensize.matches ) {
                                return true;
                        }else {
                                return false;
                        }
                } else { // for IE9 and lower browser
                        if( $winW() <=  mediasize ) {
                                return true;
                        }else {
                                return false;
                        }
                }
            };
	
	$doc.ready(function() {

        $('.contact_number').usPhoneFormat();

        if(jQuery('body').hasClass('post-type-reservation')){
            jQuery('.post-type-reservation input[name="post_title"]').attr('readonly',true);
        }

        if($('.household_member').hasClass('edited')){
            jQuery('input[name="member_ID"]').attr('readonly',true);
            jQuery('input[name="user_city"]').attr('readonly',true);
            jQuery('input[name="user_state"]').attr('readonly',true);
            jQuery('input[name="purchase_date"]').attr('readonly',true);
            jQuery('input[name="dues_amount"]').attr('readonly',true);
            jQuery('input[name="pool_key"]').attr('readonly',true);
            jQuery('select[name="annual_dues"]').attr('readonly',true);
        }
       
        $('select.pool_member').select2({   
            ajax: {
                    url: ajax_url, // AJAX URL is predefined in WordPress admin
                    dataType: 'json',
                    delay: 250, // delay in ms while typing when to perform a AJAX search
                    data: function (params) {
                        return {
                            q: params.term, // search query
                            action: 'get_poolmember' // AJAX action for admin-ajax.php
                        };
                    },
                    processResults: function( data ) {
                    var options = [];
                    if ( data ) {
    
                        // data is the array of arrays, and each of them contains ID and the Label of the option
                        $.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
                            options.push( { id: text[0], text: text[1]  } );
                        });
    
                    }
                    return {
                        results: options
                    };
                },
                cache: true
            },
            minimumInputLength: 3 // the minimum of symbols to input before perform a search
          })
          
          //$('.pool_member').select2('val', ["15"], true);
          $('select.pool_member').on('select2:select', function (e) {
            var current_data = e.params.data;
            var data = {
                'action': 'get_pool_member_info',
                'pool_member': current_data.id
            }; 
            // We can also pass the url value separately from ajaxurl for front end AJAX implementations
            jQuery.post(ajax_url, data, function(response) {
                var current_data = jQuery.parseJSON(response);
                if(typeof current_data.member_ID != "undefined"){
                    jQuery('input[name="member_ID"]').val(current_data.member_ID).attr('readonly',true);
                    jQuery('input[name="contact_number"]').val(current_data.contact_number).attr('readonly',false);
                    jQuery('input[name="address_one"]').val(current_data.address_one);
                    jQuery('input[name="address_two"]').val(current_data.address_two);
                    jQuery('input[name="user_city"]').val(current_data.user_city).attr('readonly',true);
                    jQuery('input[name="user_state"]').val(current_data.user_state).attr('readonly',true);
                    jQuery('input[name="zip"]').val(current_data.zip);
                    jQuery('input[name="purchase_date"]').val(current_data.purchase_date).attr('readonly',true);
                    jQuery('input[name="dues_amount"]').val(current_data.dues_amount).attr('readonly',true);
                    jQuery('input[name="pool_key"]').val(current_data.pool_key).attr('readonly',true);
                    jQuery('select[name="annual_dues"]').val(current_data.annual_dues).attr('readonly',true);
                }else{
                    jQuery('input[name="member_ID"]').val('').attr('readonly',false);
                    jQuery('input[name="contact_number"]').val('');
                    jQuery('input[name="address_one"]').val('');
                    jQuery('input[name="address_two"]').val('');
                    jQuery('input[name="user_city"]').val('').attr('readonly',false);
                    jQuery('input[name="user_state"]').val('').attr('readonly',false);
                    jQuery('input[name="zip"]').val('');
                    jQuery('input[name="purchase_date"]').val('').attr('readonly',false);
                    jQuery('input[name="dues_amount"]').val('').attr('readonly',false);
                    jQuery('input[name="pool_key"]').val('').attr('readonly',false);
                    jQuery('select[name="annual_dues"]').val('').attr('readonly',false);
                }
                
            });
        });
            
           // $(".phone_type").inputmask({"mask": "(999) 999-9999"});
            
            //for birthdate
            jQuery('.date_of_birth').datepicker({
                onSelect: function (value, ui) {
                    var today = new Date();
                    age = today.getFullYear() - ui.selectedYear;
                    $('#member_age').val(age);
                },
                changeMonth: true, 
                changeYear: true,
                maxDate: '-1',
                yearRange: "-100:+0",
                dateFormat:"m/d/yy",
            }); 
            //for select Date
            jQuery('.select_date').datepicker({
                changeMonth: true, 
                changeYear: true,
                yearRange: "-100:+0",
                dateFormat:"m/d/y",
                showButtonPanel: true,
            }); 

            jQuery('#role').change(function(){
                if(jQuery(this).val() == "household_member"){
                    jQuery('#pool_member').val('');
                    jQuery('.household_member').show();
                    jQuery('.member_profile_section table tr:not(:first-child) td.overlay').show();
                    jQuery('.membership_section table tr td.overlay').show();
                }else{
                    jQuery('.member_profile_section table tr:not(:first-child) td.overlay').hide();
                    jQuery('.membership_section table tr td.overlay').hide();
                    jQuery('.household_member').hide();
                    jQuery('input[name="member_ID"]').val('').attr('readonly',false);
                    jQuery('input[name="contact_number"]').val('');
                    jQuery('input[name="address_one"]').val('');
                    jQuery('input[name="address_two"]').val('');
                    jQuery('input[name="user_city"]').val('').attr('readonly',false);
                    jQuery('input[name="user_state"]').val('').attr('readonly',false);
                    jQuery('input[name="zip"]').val('');
                    jQuery('input[name="purchase_date"]').val('').attr('readonly',false);
                    jQuery('input[name="dues_amount"]').val('').attr('readonly',false);
                    jQuery('input[name="pool_key"]').val('').attr('readonly',false);
                    jQuery('select[name="annual_dues"]').val('').attr('readonly',false);
                }
            });

            jQuery('#pool_member').change(function(){
                if(jQuery(this).val() != ""){
                    var data = {
                        'action': 'get_pool_member_info',
                        'pool_member': jQuery(this).val()
                    };
                    // We can also pass the url value separately from ajaxurl for front end AJAX implementations
                    jQuery.post(ajax_url, data, function(response) {
                        var current_data = jQuery.parseJSON(response);
                        if(typeof current_data.member_ID != "undefined"){
                            jQuery('input[name="member_ID"]').val(current_data.member_ID).attr('readonly',true);
                            jQuery('input[name="contact_number"]').val(current_data.contact_number).attr('readonly',false);
                            jQuery('input[name="address_one"]').val(current_data.address_one);
                            jQuery('input[name="address_two"]').val(current_data.address_two);
                            jQuery('input[name="user_city"]').val(current_data.user_city).attr('readonly',true);
                            jQuery('input[name="user_state"]').val(current_data.user_state).attr('readonly',true);
                            jQuery('input[name="zip"]').val(current_data.zip);
                            jQuery('input[name="purchase_date"]').val(current_data.purchase_date).attr('readonly',true);
                            jQuery('input[name="dues_amount"]').val(current_data.dues_amount).attr('readonly',true);
                            jQuery('input[name="pool_key"]').val(current_data.pool_key).attr('readonly',true);
                            jQuery('select[name="annual_dues"]').val(current_data.annual_dues).attr('readonly',true);
                        }else{
                            jQuery('input[name="member_ID"]').val('').attr('readonly',false);
                            jQuery('input[name="contact_number"]').val('');
                            jQuery('input[name="address_one"]').val('');
                            jQuery('input[name="address_two"]').val('');
                            jQuery('input[name="user_city"]').val('').attr('readonly',false);
                            jQuery('input[name="user_state"]').val('').attr('readonly',false);
                            jQuery('input[name="zip"]').val('');
                            jQuery('input[name="purchase_date"]').val('').attr('readonly',false);
                            jQuery('input[name="dues_amount"]').val('').attr('readonly',false);
                            jQuery('input[name="pool_key"]').val('').attr('readonly',false);
                            jQuery('select[name="annual_dues"]').val('').attr('readonly',false);
                        }
                        
                    });
                }else{
                    jQuery('input[name="member_ID"]').val('').attr('readonly',false);
                    jQuery('input[name="contact_number"]').val('');
                    jQuery('input[name="address_one"]').val('');
                    jQuery('input[name="address_two"]').val('');
                    jQuery('input[name="user_city"]').val('').attr('readonly',false);
                    jQuery('input[name="user_state"]').val('').attr('readonly',false);
                    jQuery('input[name="zip"]').val('');
                    jQuery('input[name="purchase_date"]').val('').attr('readonly',false);
                    jQuery('input[name="dues_amount"]').val('').attr('readonly',false);
                    jQuery('input[name="pool_key"]').val('').attr('readonly',false);
                    jQuery('select[name="annual_dues"]').val('').attr('readonly',false);
                }
            })

            jQuery('#createusersub').click(function(e){
                e.preventDefault();
                var current_email = jQuery('#email').val();
                if(current_email == ""){
                    alert("Please enter valid Email!");
                    return false;
                }
                jQuery('#user_login').val(current_email);
                jQuery('#pass1').val('yJB8ZNdZTlr9sCdureMi8H').attr('data-pw','yJB8ZNdZTlr9sCdureMi8H');
                jQuery('#pass2').val('yJB8ZNdZTlr9sCdureMi8H'); 

                if(jQuery('#role').val() == "household_member"){
                    
                        if(jQuery('#pool_member').val() == ""){
                            alert("Please select the Pool member associate with this member!");
                        }else{
                            var current_email = jQuery('#email').val();
                            jQuery('#user_login').val(current_email);

                            jQuery('#createuser').submit();
                        }
                }else{

                        jQuery('#pool_member').val('');
                        jQuery('#createuser').submit();
                }
            })
            
            window.onload = function () {
                
                var element = jQuery("#role").children("option:selected").val();
                if(element !== null && element != "undefined" && element != undefined){
                    if(element == "household_member"){
                        jQuery('.household_member').show()
                    }else{
                        jQuery('.household_member').hide()
                    }
                }
            };
            
            
            var counter = 2;
            $("#addSlot").click(function () {

                if (counter > 10) {
                    alert("Only 10 Slot allow");
                    return false;
                }
                
                var newSlotbox = '';

                newSlotbox =Dynamic_SlotField(counter);
                        
                $(".new_slot_sec").before(newSlotbox);
                counter++;
            });
            
            
            $(document).on('click', '#remove_field', function (e) {
		e.preventDefault(); 
                jQuery(this).closest('tr').remove();
                counter--;
            });

            function Dynamic_SlotField(value) {

                var html_Slot_field  = '';               

                var data = '';
                for (var i = 1; i <= 12; i++){
                    data += '<option value="'+i+'">'+i+'</option>';
                }
                
                html_Slot_field =  '<tr valign="top"><th scope="row"><label for="">From</label></th>'+
                        '<td><select class="form-control" name="start_pool_time[][]" placeholder="Start Time">'+data+'</select>'+
                        '<select class="form-control" name="pool_time_minutes[][]" placeholder="Start time mintes">'
                            +'<option value="00">00</option>'
                            +'<option value="15">15</option>'
                            +'<option value="30">30</option>'
                            +'<option value="45">45</option>'+'</select>'
                            +'<select class="form-control" name="start_pool_time_ampm[][]" placeholder="AM/PM">'
                            +'<option value="AM">AM</option>'
                            +'<option value="PM">PM</option>'
                        +'</select>'
                    +'<label for=""> To </label>'
                        +'<select class="form-control" name="end_pool_time[][]" placeholder="End time">'
                        +data+'</select>'
                        +'<select class="form-control" name="end_pool_time_minutes[][]" placeholder="End time mintes">'
                            +'<option value="00">00</option>'
                            +'<option value="15">15</option>'
                            +'<option value="30">30</option>'
                            +'<option value="45">45</option>'
                        +'</select>'
                        +'<select class="form-control" name="end_pool_time_ampm[][]" placeholder="AM/PM">'
                            +'<option value="AM">AM</option>'
                            +'<option value="PM">PM</option>'
                        +"</select>"
                    +"   <a href='javascript:void(0);' id='remove_field'>Remove</a></td>"
                +"</tr>";
                        
                return html_Slot_field;
            }
                        
            // on upload button click
            $('body').on('click', '.misha-upl', function (e) {
                e.preventDefault();

                var button = $(this),
                        custom_uploader = wp.media({
                            title: 'Insert image',
                            library: {
                                // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                                type: 'image'
                            },
                            button: {
                                text: 'Use this image' // button label text
                            },
                            multiple: false
                        }).on('select', function () { // it also has "open" and "close" events
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    button.html('<img width=100" height="100" src="' + attachment.url + '">').next().val(attachment.id).next().show();
                    var link = button.next('a.misha-rmv').show();
                    link.next('.image_val').val(attachment.id);
                }).open();

            });

            // on remove button click
            $('body').on('click', '.misha-rmv', function(e) {
                e.preventDefault();
                var button = $(this);
                button.next().val(''); // emptying the hidden field
                button.hide().prev().html('Upload image');
            });
            
            var loop = 2;
            $("#addzone").click(function () {

                if (loop > 25) {
                    alert("Only 25 Slot allow");
                    return false;
                }
                
                var newZonebox = '';
                newZonebox = Dynamic_ZoneField(loop);
                        
                $(".new_zone_sec").before(newZonebox);
                loop++;
            });
            
            function Dynamic_ZoneField(value) {

                var html_Zone_field  = '';               

                var data = '';
                for (var i = 1; i <= 12; i++){
                    data += '<option value="'+i+'">'+i+'</option>';
                }
                
                html_Zone_field = '<tr valign="top"><th scope="row"><label>Zone details</label></th>'
                    +'<td>'
                        +'<input type="name" id="zone_name" class="form-control" name="zone_name[][]" placeholder="Zone name" value=""/>'
                        +' <select class="form-control" id="setting_capacity" name="setting_capacity[][]" placeholder="Setting capacity">'
                            +'<option value="2">2 seat</option>'
                            +'<option value="3">3 seat</option>'
                            +'<option value="4">4 seat</option>'
                            +'<option value="5">5 seat</option>'
                            +'<option value="6">6 seat</option>'
                        +'</select>'
                        +' <select class="form-control" id="zone_status" name="zone_status[][]" placeholder="Zone status">'
                            +'<option value="active">Active</option>'
                            +'<option value="deactive">Deactive</option>'
                        +'</select> <a href="javascript:void(0);" id="remove_field">Remove</a></td></tr>';
        
                return html_Zone_field;
            }
            
            if(jQuery('#mdp-demo').length){
                console.log(holidays);
                //holidays = holidays ? holidays : undefined;
                if(typeof holidays != "undefined" && holidays.length > 0){
                    
                    jQuery('#mdp-demo').multiDatesPicker({
                        dateFormat: "d-m-y",
                        minDate: 0, 
                        addDates: holidays, 
                        onSelect: function(dateText) { 
                            var holidays = jQuery('#mdp-demo').multiDatesPicker('getDates');
                            jQuery('.holidays').val(holidays);
                        }
                    });

                }else{
                    jQuery('#mdp-demo').multiDatesPicker({
                        dateFormat: "d-m-y",
                        minDate: 0, 
                        onSelect: function(dateText) {
                            var holidays = jQuery('#mdp-demo').multiDatesPicker('getDates');
                            jQuery('.holidays').val(holidays);
                        }
                    });
                }
            }
            
    });
/*All function need to define here for use strict mode
----------------------------------------------------------------------------------------------------------------------------------------*/
	
/*--------------------------------------------------------------------------------------------------------------------------------------*/
})(jQuery, window, document);