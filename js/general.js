/* Custom General jQuery
/*--------------------------------------------------------------------------------------------------------------------------------------*/
;(function($, window, document, undefined) {
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
        
       
        
        
              
		/* Popup function
                ---------------------------------------------------------------------*/

                // get value form url
                function GetParameterValues(name) {
                    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                    var results = regex.exec(location.search);
                    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
                };
            
                var is_register = GetParameterValues('register');  
                

                if($('#account_registration').length){
                    setTimeout(function(){ showmodel('account_registration') }, 600); 
                }
                
                var get_book = GetParameterValues('book');
                get_book = get_book ? get_book : null;
                
                if(get_book != null){
                    var get_class = $('body').hasClass('logged-in'); 
                    if(!$('body').hasClass('logged-in') ){
                        setTimeout(function(){ showmodel('account_login') }, 600); 
                    }
                }
                
                /*Custom Popup
		---------------------------------------------------------------------*/
                var $dialogTrigger = $('.poptrigger'),
                $pagebody =  $('body');
                
                $dialogTrigger.click( function(){
                    
                    close_popup();
                    
                        var popID = $(this).attr('data-rel');
                        $('body').addClass('overflowhidden');
                        var winHeight = $(window).height();
                        $('#' + popID).fadeIn();
                        var popheight = $('#' + popID).find('.popup-block').outerHeight(true);
                        
                        if( $('.popup-block').length){
                            var popMargTop = popheight / 2;
                            //var popMargLeft = ($('#' + popID).find('.popup-block').width()/2);

                            if ( winHeight > popheight ) {
                                $('#' + popID).find('.popup-block').css({
                                    'margin-top' : -popMargTop,
                                    //'margin-left' : -popMargLeft
                                });	
                            } else {
                                $('#' + popID).find('.popup-block').css({
                                    'top' : 0,
                                    //'margin-left' : -popMargLeft
                                });
                            }

                        }

                        $('#' + popID).append("<div class='modal-backdrop'></div>");
                        $('.popouterbox .modal-backdrop').fadeTo("slow", 0.70);
                        if( popheight > winHeight ){
                            $('.popouterbox .modal-backdrop').height(popheight);
                        } 
                        $('#' + popID).focus();
                        return false;
                    
                });
                        
                       
               
                    $pagebody =  $('body');
                    function showmodel( popup_ID){
                        //var popID = $('#account_rst_pwd');
                        var popID = $('#'+popup_ID);
                        $('body').addClass('overflowhidden');
                        var winHeight = $(window).height();
                        $(popID).fadeIn().addClass('visible');
                        var popheight = $(popID).find('.popup-block').outerHeight(true);
                        if ($('.popup-block').length){
                            var popMargTop = popheight / 2;
                            //var popMargLeft = ($('#' + popID).find('.popup-block').width()/2);

                            if (winHeight > popheight) {
                                $(popID).find('.popup-block').css({
                                    'margin-top' : - popMargTop,
                                    //'margin-left' : -popMargLeft
                                });
                            } else {
                                $(popID).find('.popup-block').css({
                                    'top' : 0,
                                    //'margin-left' : -popMargLeft
                                });
                            }
                        }

                        $(popID).append("<div class='modal-backdrop'></div>");
                        $('.popouterbox .modal-backdrop').fadeTo("slow", 0.70);
                        if (popheight > winHeight){
                            $('.popouterbox .modal-backdrop').height(popheight);
                        }
                        $(popID).focus();
                        //return false;
                    }    
                    

                $('.present_confirmation').click(function(){
                    var current_booking = $(this).attr('data-booking');
                    if (confirm('Are you sure you want to do this?')) {
                        //console.log(current_booking);
                        $.ajax({
                            url: WP_Fanzone_Obj.ajaxurl,
                            type: 'post',
                            dataType: 'json',
                            data: { 
                                action : 'set_present', //calls wp_ajax_nopriv_ajaxlogin
                                booking:current_booking, 
                            },
                            beforeSend: function () {
                            },
                            success: function(data){
                               window.location.reload();
                            }
                        });
                        
                    }else{
                          
                    }
                });
                    

                if($('#account_rst_pwd').length){
                    jQuery(document).ready(function(){
                        setTimeout(function(){ showmodel('account_rst_pwd') }, 600);
                    });
                }
                
                if($('#account_login').length){
                    $(document).ready(function(){
                        var queryString = window.location.search;
                        var urlParams = new URLSearchParams(queryString);
                        var setpassword    = urlParams.get('setpassword');
                        var getlogin    = urlParams.get('getlogin');
                        
                        if(setpassword != null && setpassword == 'true'){
                            setTimeout(function(){ showmodel('account_login') }, 600);
                            
                            var uri = window.location.toString();
                            if (uri.indexOf("?") > 0) {
                                var clean_uri = uri.substring(0, uri.indexOf("?"));
                                window.history.replaceState({}, document.title, clean_uri);  
                            }
                        }
                        if(getlogin != null && getlogin == 'true'){
                            setTimeout(function(){ showmodel('account_login') }, 600);
                            
                            var uri = window.location.toString();
                            if (uri.indexOf("?") > 0) {
                                var clean_uri = uri.substring(0, uri.indexOf("?"));
                                window.history.replaceState({}, document.title, clean_uri);  
                            }
                        }
                    });
                }
                
                $(window).on("resize", function () {
                    if( $('.popouterbox').length && $('.popouterbox').is(':visible')){
                        var popheighton = $('.popouterbox .popup-block').height()+60;
                        var winHeight = $(window).height();
                        if( popheighton > winHeight ){
                            $('.popouterbox .modal-backdrop').height(popheighton);
                            $('.popouterbox .popup-block').removeAttr('style').addClass('taller');
                            
                        } else {
                            $('.popouterbox .modal-backdrop').height('100%');
                            $('.popouterbox .popup-block').removeClass('taller');
                            $('.popouterbox .popup-block').css({
                                'margin-top' : -(popheighton/2)
                            });
                        }	
                    }
                }).resize();
                
                
                //Close popup		
                $(document).on('click', '.close-dialogbox, .modal-backdrop', function(){
                    
                    if(!$('#pool_booking').length){
                        $('form').each(function( index ) {
                            $(this)[0].reset(); 
                        });
                    }
                    $('.status-msg').html('').css('color','');
                    $(this).parents('.popouterbox').fadeOut(300, function(){
                        $(this).find('.modal-backdrop').fadeOut(250, function(){
                            $('body').removeClass('overflowhidden');
                            $('.popouterbox .popup-block').removeAttr('style');
                            $(this).remove();
                        });
                    });
                    return false;
                });
                
                function close_popup(){
                    
                    if(!$('#pool_booking').length){
                        $('form').each(function( index ) {
                            $(this)[0].reset(); 
                        });
                    }
                    $('.status-msg').html('').css('color','');
                    
                    var data = $('.modal-backdrop');
                    data.parents('.popouterbox').hide();
                    data.find('.modal-backdrop').hide();
                    $('body').removeClass('overflowhidden');
                    $('.popouterbox .popup-block').removeAttr('style');
                    data.remove();                   
                    return false;
                }
                
                var date_hide = WP_Fanzone_Obj.role;
                
                var endDate = "";
                var d = new Date();
                
                var hour = d.getHours();
                var n = d.getDay()
                
                if(n == 0 || n == 6){
                    if(n == 0){
                        endDate = "+7d";
                    }else{
                        console.log(hour);
                        if(hour >= 10 ){
                            endDate = "+8d";
                        }else{
                            endDate = "+1d";
                        }
                    }
                } else{
                   
                   var endday = 7 -  n;
                   //console.log(endday);
                   endDate = '+'+endday+'d';
                }
                
                console.log()
                
                if(date_hide == 1){
                    $('.date').datepicker({
                        calendarWeeks: false,
                        todayHighlight: true,
                        autoclose: true,
                        language: "en",
                        format: 'MM dd, yyyy',
                        startDate: '0',
                        orientation:"auto",
                        weekStart: 0,
                    });
                }else{
                    if(typeof holidays != "undefined" && holidays.length > 0){
                        $('.date').datepicker({
                            calendarWeeks: false,
                            todayHighlight: true,
                            autoclose: true,
                            language: "en",
                            format: 'MM dd, yyyy',
                            startDate: '0',
                            endDate: endDate,
                            orientation:"auto",
                            datesDisabled: holidays,
                            weekStart: 0,
                        }).on('changeDate', function(e) {
                        }); 
                    }else{ 
                        $('.date').datepicker({
                            calendarWeeks: false,
                            todayHighlight: true,
                            autoclose: true,
                            language: "en",
                            format: 'MM dd, yyyy',
                            startDate: '0',
                            endDate:endDate,
                            orientation:"auto",
                            weekStart: 0,
                        }).on('changeDate', function(e) {
                        }); 
                    } 
                }
                $('.reservation_date_picker').datepicker({
                    calendarWeeks: false,
                    todayHighlight: true,
                    autoclose: true,
                    language: "en",
                    format: 'yyyy-mm-dd',
                    startDate: '0',
                    orientation:"auto",
                    weekStart: 0,
                }).change(function(){
                    console.log($('.reservation_date_picker').val());
                    var current_date = $('.reservation_date_picker').val();
                    window.location.href = "https://inmanparkpool.org/pool-reservations/?date="+current_date;
                });
                
                $("#startdate").datepicker().on('changeDate', function (e) {
                    
                    var value = e.format();
                    
                    var date = e.date;
                    
                    console.log(date);
                    
                    var d = new Date();
                    var n = d.getHours();
                    
                    console.log(d);
                    
                    var startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+1);
                    var end_Date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+7);
                    
                    var weak_start_date, weak_end_date = ''; 
                    
                    var s_month = (startDate.getMonth() + 1);
                    var e_month = (end_Date.getMonth() + 1);
                    if(s_month <10){
                        s_month = "0"+s_month;
                    }
                    if(e_month <10){
                        e_month = "0"+e_month;
                    }
                    weak_start_date = startDate.getFullYear()+ '-' + s_month + '-' + startDate.getDate();
                    weak_end_date =  end_Date.getFullYear() + '-' + e_month + '-' + end_Date.getDate();
                    $('#weak_s_date').val(weak_start_date);
                    $('#weak_e_date').val(weak_end_date);
                    
                    
                    
                });
                
                $( document ).ready(function(e) {

                    /*var date = $("#startdate").datepicker("getDate");
                    console.log(date);
                    var startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
                    var end_Date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+6);
                    console.log(startDate);
                    console.log(end_Date);
                    var weak_start_date, weak_end_date = ''; 
                    
                    var s_month = (startDate.getMonth() + 1);
                    var e_month = (end_Date.getMonth() + 1);
                    if(s_month <10){
                        s_month = "0"+s_month;
                    }
                    if(e_month <10){
                        e_month = "0"+e_month;
                    }
                    weak_start_date = startDate.getFullYear()+ '-' + s_month + '-' + startDate.getDate();
                    weak_end_date =  end_Date.getFullYear() + '-' + e_month + '-' + end_Date.getDate();
                    $('#weak_s_date').val(weak_start_date);
                    $('#weak_e_date').val(weak_end_date);
                    */
                    
                });


                $('.zone-boxes .zone-box').not('.sold').click(function(){
                    $('.zone-boxes .zone-box').removeClass('select');
                    if(!$(this).hasClass('sold') ){
                        $(this).addClass('select');
                    }
                });

                $('.modify-toggle').click(function(event){
                    $(this).next('.modify-box').fadeIn('normal').parent().toggleClass('active');
                    return false;
                });
                
                $(document).click(function(e){
                    if($(e.target).closest('.modify-box').length != 0);
                    $('.modify-box').fadeOut('normal').parent().removeClass('active');
                }); 

                /* Menu ICon Append prepend for responsive
                ---------------------------------------------------------------------*/
                $(window).on('resize', function(){
                    if (screencheck(991)) {
                        $('.nav-tabs li a').on('click', function(){
                            $(this).parents('.nav-tabs').slideUp();
                        });
                    } else {
                        $(".nav-tabs").slideDown();
                    }
                }).resize();
                
                /* Menu ICon Append prepend for responsive
                ---------------------------------------------------------------------*/
                $(window).on('resize', function(){
                    if (screencheck(991)) {
                        $('.profile-info').on('click', function(){
                            $('.profile-info').next('.nav-tabs').slideToggle();
                        });
                    } else {
                        //$("#menu").remove();
                    }
                }).resize();

                $('#formLogin').validate({
                    errorElement: "span", 
                    rules:{
                        username: {
                            required:true,
                        },
                        password:{
                            required:true,
                        },
                    },
                });
                
                $('#formforgetPass').validate({
                    errorElement: "span", 
                    rules:{
                        email: {
                            required:true,
                            email: true,
                        },
                    },
                });
                
                $("li.user-dropdown").hover(function () {
                    var isHovered = $(this).is(":hover");
                    if (isHovered) {
                        $(this).children("ul").stop().slideDown(300);
                    } else {
                        $(this).children("ul").stop().slideUp(300);
                    }
                });
                
                $('#addPassword').validate({
                    rules:{
                        password:{
                            required:true,
                            minlength: 8,
                        },
                        confirmpassword:{
                            required:true,
                            minlength: 8,
                            equalTo: "#password"
                        }  
                    },
                    messages: {
                        confirmpassword:{
                            equalTo:"Confirm Password must be same as 'Password'",
                        }  
                    },
                    errorElement: "span",   
                });

                if($('#resetPassword').length){
                    $('#resetPassword').validate({
                        rules:{
                            password:{
                                required:true,
                                minlength: 8,
                            },
                            confirmpassword:{
                                required:true,
                                minlength: 8,
                                equalTo: "#password",
                            } 
                        },
                        messages: {
                            confirmpassword:{
                                equalTo:"Confirm Password must be same as 'New Password'",
                            }  
                        },
                        errorElement: "span",   
                    });
                }
                
                var CALL_LOGIN = false;
                // Perform AJAX login on form submit
                $(document).on("click","#login",function(e){
                    e.preventDefault();
                    
                    var formStatus = $('#formLogin').validate().form();
                    
                    if(true == formStatus){
                        
                        var $THIS = $(this);
                        var username    = $('#user_login').val();
                        var password    = $('#user_pass').val(); 
                        var remember_me = $('#remember_me').val();

                        if( CALL_LOGIN == false ){

                            $('p.status-msg').show().html(WP_Fanzone_Obj.loadingmessage);
                            $.ajax({
                                url: WP_Fanzone_Obj.ajaxurl,
                                type: 'post',
                                dataType: 'json',
                                data: { 
                                    action : 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                                    username:username,password:password,remember_me:remember_me, 
                                },
                                beforeSend: function () {
                                    CALL_LOGIN = true;
                                },
                                success: function(data){
                                    $('p.status-msg').html(data.message).css('color',data.color);
                                    if (data.loggedin == true){
                                        document.location.href = WP_Fanzone_Obj.redirecturl;
                                    }
                                },
                                error: function(error){
                                    console.log(error);
                                },
                                complete: function() {
                                    $('#formLogin')[0].reset(); 
                                    CALL_LOGIN = false;
                                }
                            });
                        }
                    }
                });

                var CALL_LostPass = false;
                // Perform AJAX Lost Password on form submit
                $(document).on("click","#lostpassword",function(e){
                    e.preventDefault();
                    
                    var form_Status = $('#formforgetPass').validate().form();
                    
                    if(true == form_Status){
                        
                        var $THIS = $(this);
                        var user_login = $('#sendemail').val();
                        
                        if( CALL_LostPass == false ){

                            $('p.pass_info').show().html(WP_Fanzone_Obj.loadingmessage);
                            $.ajax({
                                url: WP_Fanzone_Obj.ajaxurl,
                                type: 'post',
                                dataType: 'json',
                                data: { 
                                    user_login:user_login,
                                    action: 'ajax_forgotpass', //calls wp_ajax_nopriv_ajax_forgotpass
                                },
                                beforeSend: function () {
                                    CALL_LostPass = true;
                                },
                                success: function(data){
                                    console.log(data);
                                    $('p.pass_info').html(data.message).css('color',data.color);
                                    if (data.checkemail == true){
                                        document.location.href = data.redirect;
                                    }
                                },
                                error: function(error){
                                    console.log(error);
                                },
                                complete: function() {
                                    $('#formforgetPass')[0].reset(); 
                                    CALL_LostPass = false;
                                }
                            });
                        }
                    }
                });
                
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                }, 7000);
                
                var CALL_ResetPass = false;
                // Perform AJAX Lost Password on form submit
                $(document).on("click","#resetPass",function(e){
                    e.preventDefault();
                    
                    var form_Status = $('#resetPassword').validate().form();
                    
                    if(true == form_Status){
                        
                        var $THIS = $(this);
                        var password = $('#password').val();
                        var confirmpassword = $('#confirmpassword').val();
                        var userlogin = $('#userlogin').val();
                        var useraction = $('#useraction').val();
                        var key = $('#key').val();
                        
                        if( CALL_ResetPass == false ){

                            $('p.status-label').show().html(WP_Fanzone_Obj.loadingmessage);
                            $.ajax({
                                url: WP_Fanzone_Obj.ajaxurl,
                                type: 'post',
                                dataType: 'json',
                                data: { 
                                    password:password,
                                    confirmpassword:confirmpassword,
                                    userlogin:userlogin,
                                    useraction:useraction,
                                    key:key,
                                    action: 'ajax_resetpass', //calls wp_ajax_nopriv_ajax_forgotpass
                                },
                                beforeSend: function () {
                                    CALL_ResetPass = true;
                                },
                                success: function(data){
                                    $('p.status-label').html(data.message).css('color',data.color);
                                    if (data.loggedin == true){
                                        document.location.href = data.redirect;
                                    }
                                },
                                error: function(error){
                                    console.log(error);
                                },
                                complete: function() {
                                    $('#resetPassword')[0].reset(); 
                                    CALL_ResetPass = false;
                                }
                            });
                        }
                    }
                });
                
                $('a.close-dialog').click(function(e){
                    e.preventDefault();
                    close_popup();
                    $('#booking').val('');
                });
                
                $('.zone-box').click(function(e){                    
                    e.preventDefault();
                    var $this = $(this);
                    var zone_name = $this.find('.series').html();
                    $('.get_zone').html(zone_name);
                    $('#zone').val(zone_name);
                });
                
                
                $('#time_slot').change(function(e){                    
                    e.preventDefault();
                    var $this = $(this);
                    var time = $this.val();
                    time = time ? time : null;
                    $('.get_time').html(time);
                    $('#slottime').val(time);
                });
                
                
                $('#total_people').change(function(e){     
                    e.preventDefault();
                    var $this = $(this);
                    var total_no_of_people = $this.val();
                    total_no_of_people = total_no_of_people ? total_no_of_people : null;
                    $('.get_people').html(total_no_of_people);
                    $('#people').val(total_no_of_people);
                });
                
                $("#startdate").datepicker().on('changeDate', function (e) {
                    var date = e.format();
                    $('.get_date').html(date);
                    $('#book_date').val(date);
                });
                
                $('#confirmation_reservation').validate({
                    errorElement: "span", 
                    rules:{
                        user: {
                            required:true,
                        },
                        zone: {
                            required:true,
                        },
                        people: {
                            required:true,
                        },
                        book_date: {
                            required:true,
                        },
                        slottime: {
                            required:true,
                        },
                    },
                });
                
                var CALL_RESERVATION = false;
                // Perform AJAX Lost Password on form submit
                $(document).on("click","#reservation_confrim",function(e){
                    e.preventDefault();
                    
                    var formStatus = $('#confirmation_reservation').validate().form();
                    
                    if(true == formStatus){
                        
                        var $THIS = $(this);
                        var user = $('#user').val();
                        var zone = $('#zone').val();
                        var people = $('#people').val();
                        var book_date = $('#book_date').val();
                        var slottime = $('#slottime').val();
                        var book_id = $('#book_id').val();
                        book_id = book_id ? book_id : 0;
                        var weak_start_date = $('#weak_s_date').val();
                        var weak_end_date = $('#weak_e_date').val();
                        
                        if( CALL_RESERVATION == false ){

                            $('#booking-label').show().html(WP_Fanzone_Obj.loadingmessage);
                            $('#reservation_confrim').attr('disabled', true);
                            
                            $.ajax({
                                url: WP_Fanzone_Obj.ajaxurl,
                                type: 'post',
                                dataType: 'json',
                                data: { 
                                    user:user,
                                    zone:zone,
                                    people:people,
                                    book_date:book_date,
                                    slottime:slottime,
                                    book_id:book_id,
                                    weak_s_date:weak_start_date,
                                    weak_e_date:weak_end_date,
                                    action: 'book_reservation', //calls wp_ajax_nopriv_ajax_forgotpass
                                },
                                beforeSend: function () {
                                    CALL_ResetPass = true;
                                },
                                success: function(data){
                                    $('#booking-label').html(data.message).css('color',data.color);
                                    if (data.success == true){
                                        document.location.href = data.redirect;
                                    }
                                },
                                error: function(error){
                                    console.log(error);
                                },
                                complete: function() {
                                    $('#reservation_confrim').attr('disabled', false);
                                    CALL_RESERVATION = false;
                                }
                            });
                        }
                    }
                });
                
                
                $('.booking-cancel').click(function(e){                   
                    e.preventDefault();
                    var $this = $(this);
                    var pID = $(this).attr('data-id');
                    pID = pID ? pID : null;
                    $('#booking').val(pID);
                });
                
                var CALL_Booking_Cancel = false;
                // Perform AJAX Lost Password on form submit
                $(document).on("click","#cancel_booking",function(e){
                    e.preventDefault();
                    
                    var $THIS = $(this);
                    var booking = $('#booking').val();

                    if(typeof booking !== typeof undefined && CALL_Booking_Cancel == false ){

                        $('#message-label').show().html(WP_Fanzone_Obj.loadingmessage);
                        $('#cancel_booking').attr('disabled', true);
                        $.ajax({
                            url: WP_Fanzone_Obj.ajaxurl,
                            type: 'post',
                            dataType: 'json',
                            data: { 
                                booking:booking,
                                action: 'booking_cancal', //calls wp_ajax_nopriv_ajax_forgotpass
                            },
                            beforeSend: function () {
                                CALL_Booking_Cancel = true;
                            },
                            success: function(data){
                                $('#message-label').html(data.message).css('color',data.color);
                                if (data.success == true){
                                    document.location.href = data.redirect;
                                }

                            },
                            error: function(error){
                                console.log(error);
                            },
                            complete: function() {
                                $('#cancel_booking').attr('disabled', false);
                                CALL_Booking_Cancel = false;
                            }
                        });
                    }
                });
                
                
                $('#pool_booking').validate({
                    rules:{
                        startdate:{
                            required:true,
                        },
                        time_slot:{
                            required:true,
                        },
                        total_people:{
                            required:true,
                        },
                    },
                    errorElement: "span",   
                });
                
                $('.confirmation').click(function(e){  
                    e.preventDefault();
                    
                    var zone = $('#zone').val();
                    zone = zone ? zone : null;
                    
                    var formStatus = $('#pool_booking').validate().form();
                    
                    if(true == formStatus){
                        if(zone == null ){
                            alert('Please select any zone');
                        }else{
                            showmodel('confirmation-window');
                        }   
                    }else{
                        $("html:not(:animated),body:not(:animated)").animate({ scrollTop:0}, 'normal');
                    } 
                });
                
                if($('#change-password-form').length){
                    $('#change-password-form').validate({
                        rules:{
                            old_password:{
                                required:true,
                            },
                            new_password:{
                                required:true,
                                minlength: 8,
                            },
                            confirm_password:{
                                required:true,
                                minlength: 8,
                                equalTo: "#new_password",
                            } 
                        },
                        messages: {
                            confirm_password:{
                                equalTo:"Confirm Password must be same as 'New Password'",
                            }  
                        },
                        errorElement: "span",   
                    });
                }
                
                function filter_zone() {
                   
                    var time_slot = $('#time_slot').val();
                    time_slot = time_slot ? time_slot : null;
                    var startdate = $('#book_date').val();
                    startdate = startdate ? startdate : null;
                    
                    var total_people = $('#total_people').val();
                    total_people = total_people ? total_people : null;
                    
                    var form_status = $('#pool_booking').validate().form();
                    
                    
                    var CALL_Filter_Zone = false;
                    // if(time_slot != null && startdate != null){
                    if(true == form_status){
                        $.ajax({
                            url: WP_Fanzone_Obj.ajaxurl,
                            type: 'post',
                            dataType: 'json',
                            data: { 
                                time_slot:time_slot,
                                startdate:startdate,
                                total_people:total_people,
                                action: 'booked_zone', //calls wp_ajax_nopriv_ajax_forgotpass
                            },
                            beforeSend: function () {
                                $('.overlay-box').show();
                                CALL_Filter_Zone = true;
                            },
                            success: function(response){
                                
                                if (response.data){
                                    // remove class before load data
                                    $('.zone-box').each(function() {
                                        var zone = $(this).find('span').html();
                                        $(this).removeClass('sold');
                                        $(this).removeClass('select');
                                    });
                                    
                                    $.each( response.data, function( key, value ) {
                                        // add class zones 
                                        $('.zone-box').each(function() {
                                            var zone = $(this).find('span').html();
                                            if(zone == value){
                                                $(this).addClass('sold');
                                            }
                                        });
                                        
                                    });
                                }
                            },
                            error: function(error){
                                console.log(error);
                            },
                            complete: function(){
                                $('.overlay-box').hide();
                                CALL_Filter_Zone = false;
                            }
                        });
                    }
                    
                }
                
                $('#time_slot,#startdate,#total_people').on('change', function(e){
                    e.preventDefault();
                    filter_zone();
                });
                
                if ($('#get_phone').length) {
                    $( document ).ready(function() {
                        var phone = $('#get_phone').html();
                        phone = phone ? phone : null;
                        if(phone != null){
                            $('#uphone').val(phone);
                        }
                    });
                }
                
                $('a.printPage').click(function(e){
                   window.print();
                   return false;
                });
                
                var CALL_Zone = false;
                $(document).on("click",".zone-boxes .zone-box",function(e){
                    var $this = $(this);
                    var zone = $this.find('span').html();
                    
                    var time_slot = $('#time_slot').val();
                    time_slot = time_slot ? time_slot : null;
                    
                    var startdate = $('#book_date').val();
                    startdate = startdate ? startdate : null;
                    
                    var form_status = $('#pool_booking').validate().form();
                    
                    if(true == form_status && typeof zone !== typeof undefined){
                        
                        $.ajax({
                            url: WP_Fanzone_Obj.ajaxurl,
                            type: 'post',
                            dataType: 'json',
                            data: { 
                                zone:zone,
                                time_slot:time_slot,
                                startdate:startdate,
                                action: 'reserved_zone', //calls wp_ajax_nopriv_ajax_forgotpass
                            },
                            beforeSend: function() {
                                CALL_Zone = true;
                            },
                            success: function(response){
                                if (response.status){
                                    console.log(response.status);      
                                }
                            },
                            error: function(error){
                                console.log(error);
                            },
                            complete: function(){
                                CALL_Zone = false;
                            }
                        });
                    }
                });
                
                $("#startdate").datepicker().on('changeDate', function (e) {
                    var today = new Date();
                    var hour = today.getHours();
                    today.setHours(0);
                    today.setMinutes(0);
                    today.setSeconds(0);
                    
                    var date = $("#startdate").datepicker('getDate');

                    if (Date.parse(today) == Date.parse(date)) {
                       $('#time_slot option').each(function(){
                           
                            var current_start = $(this).attr('data-start');
                            console.log(current_start);
                            if(eval(current_start) > hour){
                                console.log(1024);
                                $(this).removeAttr('disabled');
                            }else{
                                console.log(1027);
                                $(this).attr('disabled','disabled');
                            }
                        })
                    } else {
                        console.log('not today');
                        $('#time_slot option').each(function(){
                           $(this).removeAttr('disabled');
                            
                        })
                    }
                });
                
/*--------------------------------------------------------------------------------------------------------------------------------------*/		
    });	
    
/*--------------------------------------------------------------------------------------------------------------------------------------*/
})(jQuery, window, document);