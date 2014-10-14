/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package main
 * @modified Sep 17, 2010
 */
$(function() {

    /** start apple menu function */
    var d=1000;
    $('#menu span').each(function(){
        $(this).stop().animate({
            'top':'-17px'
        },d+=250);
    });

    $('#menu > li').hover(
        function () {
            var $this = $(this);
            $('a',$this).addClass('hover');
            $('span',$this).stop().animate({
                'top':'40px'
            },300).css({
                'zIndex':'10'
            });
        },
        function () {
            var $this = $(this);
            $('a',$this).removeClass('hover');
            $('span',$this).stop().animate({
                'top':'-17px'
            },800).css({
                'zIndex':'-1'
            });
        }
     );
     /** end of apple menu function */
     

     /** start modal*/
    $( "#dialog:ui-dialog" ).dialog( "destroy" );

    $(".details").click(function(){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );

        $( "#dialog-message" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
     /** end of modal*/

    $('#date').datepicker({
        showOn: 'button',
        buttonImage: '/sik/assets/images/calendar.gif',
        dateFormat: 'dd-mm-yy',
        buttonImageOnly: true ,
        altField: '#alternate',
        altFormat: 'd MM yy'
    });
    $('#date').datepicker('option', $.extend({
        showMonthAfterYear: false
    },
    $.datepicker.regional['id']));

    $('#date2').datepicker({
        showOn: 'button',
        buttonImage: '/sik/assets/images/calendar.gif',
        dateFormat: 'dd-mm-yy',
        buttonImageOnly: true ,
        altField: '#alternate',
        altFormat: 'd MM yy'
    });
    $('#date2').datepicker('option', $.extend({
        showMonthAfterYear: false
    },
    $.datepicker.regional['id']));

    $('#dateview').datepicker({
       dateFormat: 'yy-mm-dd'
    });
    
    $('#dateAdd').datepicker({
       dateFormat: 'yy-mm-dd'
    });
    

    //confirmation dialog shown when user click on the delete link
    $('#dialog').dialog({
        autoOpen: false,
        width: 270,
        modal: true,
        resizable: false,
        buttons: {
            "Submit": function() {
                var link = $(this).data('del-link');
                $(this).dialog("close");
                location.href = link;
            },
            "Cancel": function() {
                $(this).dialog("close");
            }
        }
    });
    // show message box when administrator click on delete link

    $( "#dialog-confirm" ).dialog({
        autoOpen: false,
        resizable: false,
        height:140,
        modal: true,
        hide: 'Slide',
        buttons: {
            "Delete": function() {
                var no_register = {
                    register : $("#no_register").val()
                    };
                    var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
                    $( this ).dialog("close");
                $.ajax({
                    type: "POST",
                    url : site+"user/delete",
                    data: no_register,
                    //beforeSend: function(){
                        //$('#show').html(image_load);
                    //},
                    success: function(response){
                        $('#show').html(response);
                        //$( ".selector" ).dialog( "option", "hide", 'slide' );
                    }
                });

            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });
    $(".delete").live("click",function(){
    	var element = $(this);
    	var no_register = element.attr("register");
    	var info = 'register=' + no_register;
    	$('#no_register').val(no_register);
    	$( "#dialog-confirm" ).dialog( "open" );
    	return false;
    });

    //information dialog
    $('#info').dialog({
        autoOpen: false,
        width: 270,
        modal: true,
        resizable: false,
        buttons: {
            "OK": function() {
                $(this).dialog("close");
            }
        }
    });

    // change page to ajax_page in pagination urls
    $('#pagination a').each(function(){
        var href = $(this).attr('href');
        href = href.replace(/page/,'ajax_page');
        $(this).attr('href',href);
    });
    // ajax request
    $('#pagination a').click(function(){
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            success: function(table){
                $('table').remove(); // remove content
                $('#pagination').after(table); // add content
            }
        });

        return false; // don't let the link reload the page
    });
    $('.date_vp').change(function(){
        var tgl = $('.date_vp').val();
        var kebun = $('#kebun').val();
        if(kebun == ""){
            alert('Kebun belum dipilih!');
            return false;
        }else{
            load('produksi/index_ajax/'+kebun+'/'+tgl,'#show');
        }
        //$("#dateview").attr('disabled', 'disabled');
    });
    
    $('.date_view').change(function(){
        var tgl = $('.date_view').val();
        var kebun = $('#kebun').val();
        if(kebun == ""){
            alert('Kebun belum dipilih!');
            return false;
        }else{
            load('view/index_ajax/'+kebun+'/'+tgl,'#show');
        }
        //$("#dateview").attr('disabled', 'disabled');
    });
    
    $('.date_go').change(function(){
        var tgl = $('.date_go').val();
        var kebun = $('#kebun').val();
        if(kebun == ""){
            alert('Kebun belum dipilih!');
            return false;
        }else{
            load('go/index_ajax/'+kebun+'/'+tgl,'#show');
        }
        //$("#dateview").attr('disabled', 'disabled');
    });
    
    $('.refresh_view').click(function(){
        var tgl = $('.date_view').val();
        var kebun = $('#kebun').val();
        load('view/index_ajax/'+kebun+'/'+tgl,'#show');
    });

    $('.date_input').change(function(){
        var tgl = $('.date_input').val();
        window.location = "http://127.0.0.1/sik/produksi/input/"+tgl;
    });
    /************************************************************************/

    /*************************** User Management ******************************/
    $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
    var register = $( "#register" ), nama_lengkap = $( "#nama_lengkap" ), username = $( "#username" ),
        password = $( "#password" ), repassword = $( "#repassword" ), level = $ ( "#level" ),
        allFields = $( [] ).add( register ).add( nama_lengkap ).add( username ).add(password).add(repassword).add(level),
        tips = $( ".validateTips" );

    var isNew = false;
    
    function updateTips( t ) {
        tips.text( t ).addClass( "ui-state-highlight" );
        setTimeout(function() {
            tips.removeClass( "ui-state-highlight", 1500 );
        }, 500 );
    }

    function checkLength( o, n, min, max ) {
        if ( o.val().length > max || o.val().length < min ) {
            o.addClass( "ui-state-error" );
            updateTips( "Jumlah karakter " + n + " antara " +
                min + " s.d. " + max + "." );
            return false;
        } else {
            return true;
        }
    }

    function checkCombo( cb , str ){
        if( cb.val() == "" ){
            cb.addClass( "ui-state-error" );
            updateTips( str );
            return false;
        }else{
            return true;
        }
    }

    function checkMatch( p, rp ){
        if( p.val() != rp.val() ){
            rp.addClass( "ui-state-error" );
            updateTips( "Password did not match" );
            return false;
        }else{
            return true;
        }
    }

    function checkRegexp( o, regexp, n ) {
        if ( !( regexp.test( o.val() ) ) ) {
            o.addClass( "ui-state-error" );
            updateTips( n );
            return false;
        } else {
            return true;
        }
    }
    
    $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 450,
        width: 400,
        modal: true,
        resizable: false,
        buttons: {
            "Create an account": function() {
                if(isNew){
                    var form_data = {
                        register: register.val(),
                        nama_lengkap: nama_lengkap.val(),
                        username: username.val(),
                        password: password.val(),
                        level: level.val(),
                        ajax:1
                    };
                }else{
                    var form_data = {
                        register: register.val(),
                        nama_lengkap: nama_lengkap.val(),
                        username: username.val(),
                        password: password.val(),
                        level: level.val(),
                        edit:1,
                        ajax:1
                    };
                }
                    
                var validate = true;
                allFields.removeClass( "ui-state-error" );

                validate = validate && checkLength( register, "Register", 3, 16 );
                validate = validate && checkLength( nama_lengkap, "Nama lengkap", 3, 35 );
                validate = validate && checkLength( username, "username", 5, 16 );
                if(isNew){
                    validate = validate && checkLength( password, "password", 5, 16 );
                    validate = validate && checkLength( repassword, "password", 5, 16 );
                    validate = validate && checkMatch( password, repassword );
                }
                validate = validate && checkCombo( level , 'Pilih Level User.' );

                //validate = validate && checkRegexp( name, /^[a-z]([0-9a-z_])+$/i, "Username may consist of a-z, 0-9, underscores, begin with a letter." );
                // From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
                //validate = validate && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );
                //validate = validate && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

                if ( validate ) {
                    $( this ).dialog( "close" );
                    //var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
                    $.ajax({
                        url: site+"user/submit",
                        type : 'POST',
                        data : form_data,
                        //data : $(document.form_user.elements).serialize(),
                        success: function(response){
                            $('#show').html(response);
                        }
                    });
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields.val( "" ).removeClass( "ui-state-error" );
        }
    });
    $( "#create-user" )
        .button()
        .click(function() {
            $( "#password" ).show();
            $( "#repassword" ).show();
            $( "#lblpass" ).show();
            $( "#lblrepass" ).show();
            $( "#register" ).attr("disabled", false);
            isNew = true;

            $( "#dialog-form" ).dialog( "open" );
    });
    
    $(".edit").live("click",function(){
        password.hide();
        repassword.hide();
        $( "#lblpass" ).hide();
        $( "#lblrepass" ).hide();
        $( "#register" ).attr("disabled", true);
        isNew = false;

        var register = $(this).attr("register");
        var username = $(this).attr("username");
        var nama_lengkap = $(this).attr("nama_lengkap");
        var level = $(this).attr("level");

        $('#register').val(register);
        $('#username').val(username);
        $('#nama_lengkap').val(nama_lengkap);
        $('#level').val(level);

        $( "#dialog-form" ).dialog( "open" );

        return false;
    });
    /************************ End of User Management **************************/

    /************************** Member Management *****************************/
    var register_member = $( "#register_member" ), no_ponsel = $( "#no_ponsel" ), nama_member = $( "#nama_member" ),
    kebun_unit = $( "#kebun_unit" ), afd_member = $( "#afd_member" ), jabatan = $( "#jabatan" );
    var allFields2 = $( [] ).add( register_member ).add( no_ponsel ).add( nama_member ).add(kebun_unit).add(afd_member).add(jabatan);
    isNew = false;
    $( "#form-member" ).dialog({
        autoOpen: false,
        height: 423,
        width: 300,
        modal: true,
        resizable: false,
        buttons: {
            "Add Member": function() {
                if(isNew){
                    var form_data = {
                        register: register_member.val(),
                        no_ponsel: no_ponsel.val(),
                        nama_lengkap: nama_member.val(),
                        kebun_unit: kebun_unit.val(),
                        afdeling: afd_member.val(),
                        jabatan: jabatan.val(),
                        ajax:1
                    };
                }else{
                    var form_data = {
                        register: register_member.val(),
                        no_ponsel: no_ponsel.val(),
                        nama_lengkap: nama_member.val(),
                        kebun_unit: kebun_unit.val(),
                        afdeling: afd_member.val(),
                        jabatan: jabatan.val(),
                        edit:1,
                        ajax:1
                    };
                }

                var validate = true;
                allFields2.removeClass( "ui-state-error" );

                validate = validate && checkLength( register_member, "Register", 5, 10 );
                validate = validate && checkLength( no_ponsel, "No. Ponsel", 9, 14 );
                validate = validate && checkLength( nama_member, "Nama Member", 3, 18 );
                validate = validate && checkLength( kebun_unit, "Kebun Unit", 3, 9 );
                validate = validate && checkLength( afd_member, "Afdeling", 1, 2 );
                validate = validate && checkLength( jabatan, "Jabatan", 3, 18 );

                var reg = register_member.val();
                if ( validate ) {
                    $( this ).dialog( "close" );
                    $.ajax({
                        url: site+"/member/cek_data_member/"+reg,
                        success: function(response){
                            if(response == 1 && isNew){
                                alert('Error. Data sudah ada!');
                                return false;
                            }else{
                                $.ajax({
                                    url : site+"member/submit/",
                                    type : 'POST',
                                    data : form_data,
                                    success : function(response){
                                        //$('#show_member').html(response);
                                        window.location = site+'member';
                                    }
                                });
                            }
                        }
                    })
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields2.val( "" ).removeClass( "ui-state-error" );
        }
    });
    $( "#create-member" )
        .button()
        .click(function() {
            $( "#register_member" ).attr("disabled", false);
            isNew = true;
            $( "#form-member" ).dialog( "open" );
    });

    $(".edit_member").live("click",function(){
        isNew = false;

        var register = $(this).attr("register");
        var no_ponsel = $(this).attr("no_ponsel");
        var nama_lengkap = $(this).attr("nama_lengkap");
        var kebun_unit = $(this).attr("kebun_unit");
        var jabatan = $(this).attr("jabatan");

        $('#register_member').val(register);
        $('#no_ponsel').val(no_ponsel);
        $('#nama_member').val(nama_lengkap);
        $('#kebun_unit').val(kebun_unit);
        $('#jabatan').val(jabatan);

        $(" #register_member" ).attr('disabled', 'disabled');
        $( "#form-member" ).dialog( "open" );

        return false;
    });

    $(".delete_member").live("click",function(){
        $( "#dialog3" ).dialog( "open" );

    });
    $( "#dialog3" ).dialog({
            autoOpen: false,
            resizable: false,
            height:140,
            modal: true,
            hide: 'Slide',
            buttons: {
                "Delete": function() {
                    var reg = $(".delete_member").attr("register");
                    $( this ).dialog("close");
                    $.ajax({
                        type: "GET",
                        url : site+'member/delete/'+reg,
                        success: function(response){
                            window.location = site+'member';
                        }
                    });
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });

    /************************** End of Member Management *****************************/

    /************************** RKAP Management *****************************/
    var kebun, rkap = $( "#rkap" ), tahun, id = $( "#id" );
    var allFields3 = $( [] ).add( tahun ).add( kebun ).add( rkap );
    isNew = false;
    $( "#form-rkap" ).dialog({
        autoOpen: false,
        height: 300,
        width: 300,
        modal: true,
        resizable: false,
        buttons: {
            "Save": function() {
                kebun = $( "#kbn" );
                tahun = $( "#tahun2" );
                
                if(isNew){
                    var form_data = {
                        kebun: kebun.val(),
                        rkap: rkap.val(),
                        tahun: tahun.val(),
                        ajax:1
                    };
                }else{
                    var form_data = {
                        id: id.val(),
                        kebun: kebun.val(),
                        rkap: rkap.val(),
                        tahun: tahun.val(),
                        edit:1,
                        ajax:1
                    };
                }
                
                var validate = true;
                allFields3.removeClass( "ui-state-error" );

                validate = validate && checkCombo( tahun, 'Pilih Tahun.' );
                
                validate = validate && checkCombo( kebun, 'Pilih Kebun.' );
                validate = validate && checkLength( rkap, "RKAP", 3, 9 );

                var year = tahun.val();
                var field = kebun.val();
                if ( validate ) {
                    $( this ).dialog( "close" );
                    $.ajax({
                        url: site+"/rkap/cek_data_rkap/"+year+"/"+field,
                        success: function(response){
                            if(response == 1 && isNew){
                                alert('Error. Data sudah ada!');
                                return false;
                            }else{
                                $.ajax({
                                    url : site+"rkap/submit/"+year,
                                    type : 'POST',
                                    data : form_data,
                                    success : function(response){
                                        $('#show_rkap').html(response);
                                    }
                                });
                            }
                        }
                    })
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields.val( "" ).removeClass( "ui-state-error" );
        }
    });
    $( "#create-rkap" )
        .button()
        .click(function() {
            $( "#kebun" ).show();
            $( "#rkap" ).show();
            $( "#tahun" ).show();
            isNew = true;

            $( "#form-rkap" ).dialog( "open" );
            //$( "#kbn" ).attr('disabled', 'disabled');

            $('#tahun2').change(function(){
                tahun = $('#tahun2').val();

                load('rkap/get_kebun_not_in/'+tahun, '#div_kebun');
                //$( "#kbn" ).attr('disabled', false);
            });
    });

    $(".edit_rkap").live("click",function(){
        isNew = false;

        var id = $(this).attr("id");
        var kebun = $(this).attr("kebun");
        var rkap = $(this).attr("rkap");
        var tahun = $(this).attr("tahun");

        $('#id').val(id);
        $('#kbn').val(kebun);
        $('#rkap').val(rkap);
        $('#tahun2').val(tahun);

        $("#kbn").attr('disabled', 'disabled');
        $("#tahun2").attr('disabled', 'disabled');

        $( "#form-rkap" ).dialog( "open" );

        return false;
    });

    $('#tahun_rkap').change(function(){
        var tahun = $('#tahun_rkap').val();
        if(tahun == ""){
            alert('Tahun belum dipilih!');
            return false;
        }else{
            load('rkap/load_rkap/'+tahun,'#show_rkap');
        }
        $("#dateview").attr('disabled', 'disabled');
    });

    $(".delete_rkap").live("click",function(){
    	var element = $(this);
    	var id = element.attr("id");
        var tahun = element.attr("tahun");
    	confirm(id, 'rkap/delete/'+tahun,'#show_rkap');
        $( "#dialog" ).dialog( "open" );
    	return false;
    });

    /************************** End of RKAP Management *****************************/

    /************************** RKO Management *****************************/
    var kebun_rko, rkap_rko = $( "#rkap_rko" ), rko = $( "#rko" ), tahun_rko, bulan_rko, id_rko = $( "#id_rko" );
    var allFields4 = $( [] ).add( kebun_rko ).add( rkap_rko ).add( rko ).add(tahun_rko).add(bulan_rko);
    isNew = false;
    $( "#form-rko" ).dialog({
        autoOpen: false,
        height: 380,
        width: 300,
        modal: true,
        resizable: false,
        buttons: {
            "Save": function() {
                kebun_rko = $( "#kebun_rko_form" );
                tahun_rko = $( "#tahun_rko_form" );
                bulan_rko = $( "#bulan_rko_form" );

                if(isNew){
                    var form_data = {
                        tahun: tahun_rko.val(),
                        bulan: bulan_rko.val(),
                        kebun: kebun_rko.val(),
                        rkap: rkap_rko.val(),
                        rko: rko.val(),
                        ajax:1
                    };
                }else{
                    var form_data = {
                        id: id_rko.val(),
                        tahun: tahun_rko.val(),
                        bulan: bulan_rko.val(),
                        kebun: kebun_rko.val(),
                        rkap: rkap_rko.val(),
                        rko: rko.val(),
                        edit:1,
                        ajax:1
                    };
                }
d
                var validate = true;
                allFields4.removeClass( "ui-state-error" );

                validate = validate && checkCombo( tahun_rko, 'Pilih Tahun.' );
                validate = validate && checkCombo( bulan_rko, 'Pilih Tahun.' );
                validate = validate && checkCombo( kebun_rko, 'Pilih Kebun.' );
                validate = validate && checkLength( rkap_rko, "RKAP", 3, 9 );
                validate = validate && checkLength( rko, "RKAP", 3, 9 );

                var year = tahun_rko.val();
                var month = bulan_rko.val();
                var field = kebun_rko.val();
                if ( validate ) {
                    $( this ).dialog( "close" );
                    $.ajax({
                        url: site+"/rkap/cek_data_rko/"+year+"/"+month+"/"+field,
                        success: function(response){
                            if(response == 1 && isNew){
                                alert('Error. Data sudah ada!');
                                return false;
                            }else{
                                $.ajax({
                                    url : site+"rkap/submit_rko/"+year+"/"+month,
                                    type : 'POST',
                                    data : form_data,
                                    success : function(response){
                                        $('#show_rko').html(response);
                                    }
                                });
                            }
                        }
                    })
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields.val( "" ).removeClass( "ui-state-error" );
        }
    });
    $( "#create-rko" )
        .button()
        .click(function() {
            $( "#kebun_rko_form" ).show();
            $( "#rkap_rko" ).show();
            $( "#tahun_rko_form" ).show();
            $( "#bulan_rko_form" ).show();
            $( "#rko" ).show();
            $('#id_rko').hide();
            isNew = true;
            $( "#form-rko" ).dialog( "open" );
    });

    $(".edit_rko").live("click",function(){
        isNew = false;

        var id = $(this).attr("id");
        var kebun = $(this).attr("kebun");
        var rkap = $(this).attr("rkap");
        var rko = $(this).attr("rko");
        var tahun = $(this).attr("tahun");
        var bulan = $(this).attr("bulan");

        $('#id_rko').val(id);
        $('#kebun_rko_form').val(kebun);
        $('#rkap_rko').val(rkap);
        $('#rko').val(rko);
        $('#tahun_rko_form').val(tahun);
        $('#bulan_rko_form').val(bulan);
        $('#id_rko').hide();

        $("#kebun_rko_form").attr('disabled', 'disabled');
        $("#tahun_rko_form").attr('disabled', 'disabled');
        $("#bulan_rko_form").attr('disabled', 'disabled');

        $( "#form-rko" ).dialog( "open" );

        return false;
    });

    $('#tahun_rko').change(function(){
        $("#bulan_rko").attr('disabled', false);
    });

    $('#bulan_rko').change(function(){
        var tahun = $('#tahun_rko').val();
        var bulan = $('#bulan_rko').val();
        if(tahun == ""){
            alert('Tahun belum dipilih!');
            return false;
        }else if(bulan == ""){
            alert('Bulan belum dipilih!');
            return false;
        }else{
            load('rkap/load_rko/'+tahun+'/'+bulan,'#show_rko');
        }
    });

    $(".delete_rko").live("click",function(){
    	var element = $(this);
    	var id = element.attr("id");
        var tahun = element.attr("tahun");
        var bulan = element.attr("bulan");
    	confirm(id, 'rkap/delete_rko/'+tahun+'/'+bulan,'#show_rko');
        $( "#dialog" ).dialog( "open" );
    	return false;
    });

    /************************** End of RKO Management *****************************/

    /************************** Log Management *****************************/
    $( "#date_log" ).datepicker({
        dateFormat: 'yy-mm-dd'
    });
    var tanggal_log = $("#date_log"), kebun_log = $("#kebun_log"), afdeling = $( "#afdeling" ),
    estimasi = $( "#estimasi" ), realisasi = $( "#realisasi" ), brondolan = $( "#brondolan" ),
    hk_dinas = $( "#hk_dinas" ), hk_bhl = $( "#hk_bhl" ), id_log = $( "#id_log" );
    var allFields5 = $( [] ).add( tanggal_log ).add( kebun_log ).add( afdeling ).add( estimasi ).add( realisasi ).add( brondolan ).add( hk_dinas ).add( hk_bhl );
    isNew = false;
    $( "#form-log" ).dialog({
        autoOpen: false,
        height: 530,
        width: 500,
        modal: true,
        resizable: false,
        buttons: {
            "Add Produksi": function() {
                if(isNew){
                    var form_data = {
                        tanggal: tanggal_log.val(),
                        kebun: kebun_log.val(),
                        afdeling: afdeling.val(),
                        estimasi: estimasi.val(),
                        realisasi: realisasi.val(),
                        brondolan: brondolan.val(),
                        hk_dinas: hk_dinas.val(),
                        hk_bhl: hk_bhl.val(),
                        ajax:1
                    };
                }else{
                    var form_data = {
                        id: id_log.val(),
                        tanggal: tanggal_log.val(),
                        kebun: kebun_log.val(),
                        afdeling: afdeling.val(),
                        estimasi: estimasi.val(),
                        realisasi: realisasi.val(),
                        brondolan: brondolan.val(),
                        hk_dinas: hk_dinas.val(),
                        hk_bhl: hk_bhl.val(),
                        edit:1,
                        ajax:1
                    };
                }

                var validate = true;
                allFields5.removeClass( "ui-state-error" );
                
                validate = validate && checkLength( tanggal_log, "Tanggal ", 10, 10 );
                validate = validate && checkCombo( kebun_log, 'Pilih Kebun.' );
                validate = validate && checkCombo( afdeling, 'Pilih Afdeling.' );
                validate = validate && checkLength( estimasi, 'Estimasi ', 3, 9 );
                validate = validate && checkLength( realisasi, "Realisasi ", 3, 9 );
                validate = validate && checkLength( brondolan, "Brondolan ", 3, 9 );
                validate = validate && checkLength( hk_dinas, "HK Dinas ", 3, 9 );
                validate = validate && checkLength( hk_bhl, "HK BHL ", 3, 9 );

                var tgl = tanggal_log.val();
                var kb = kebun_log.val();
                var af = afdeling.val();
                if ( validate ) {
                    $( this ).dialog( "close" );
                    $.ajax({
                        url: site+"/log/cek_data_log/"+kb+"/"+af+"/"+tgl,
                        success: function(response){
                            if(response == 1 && isNew){
                                alert('Error. Data sudah ada!');
                                return false;
                            }else{
                                $.ajax({
                                    url : site+"log/submit/",
                                    type : 'POST',
                                    data : form_data,
                                    success : function(response){
                                        window.location = site+'log';
                                    }
                                });
                            }
                        }
                    })
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields.val( "" ).removeClass( "ui-state-error" );
        }
    });
    $( "#create-log" )
        .button()
        .click(function() {
            isNew = true;
            $( "#form-log" ).dialog( "open" );
            $("#id_log").hide();
    });

    $(".edit_log").live("click",function(){
        isNew = false;

        var id = $(this).attr("id");
        var tanggal = $(this).attr("tanggal");
        var kebun = $(this).attr("kebun");
        var afdeling = $(this).attr("afdeling");
        var estimasi = $(this).attr("estimasi");
        var realisasi = $(this).attr("realisasi");
        var brondolan = $(this).attr("brondolan");
        var hk_dinas = $(this).attr("hk_dinas");
        var hk_bhl = $(this).attr("hk_bhl");

        $('#id_log').val(id);
        $('#date_log').val(tanggal);
        $('#kebun_log').val(kebun);
        $('#afdeling').val(afdeling);
        $('#estimasi').val(estimasi);
        $('#realisasi').val(realisasi);
        $('#brondolan').val(brondolan);
        $('#hk_dinas').val(hk_dinas);
        $('#hk_bhl').val(hk_bhl);


        $("#date_log").attr('disabled', 'disabled');
        $("#kebun_log").attr('disabled', 'disabled');
        $("#afdeling").attr('disabled', 'disabled');
        $("#id_log").hide();

        $( "#form-log" ).dialog( "open" );

        return false;
    });

    $(".delete_log").live("click",function(){
    	var element = $(this);
    	var id = element.attr("id");
        $( "#dialog2" ).dialog( "open" );
        
    });
    $( "#dialog2" ).dialog({
            autoOpen: false,
            resizable: false,
            height:140,
            modal: true,
            hide: 'Slide',
            buttons: {
                "Delete": function() {
                    var arr = {
                        id : $(".delete_log").attr("id")
                    };
                    $( this ).dialog("close");
                    $.ajax({
                        type: "POST",
                        url : site+'log/'+'delete',
                        data: arr,
                        success: function(response){
                            window.location = site+'log';
                        }
                    });
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });

    /************************** End of Log Management *****************************/
    $( "#all_krani" ).button();
    
    /**************************** New Message Form ********************************/
    var no_tujuan = $( "#no_tujuan" ), pesan = $( "#pesan" );
    var MsgFields = $( [] ).add( no_tujuan ).add( pesan );
    isNew = false;
    $( "#form-new-message" ).dialog({
        autoOpen: false,
        height: 405,
        width: 405,
        modal: true,
        resizable: false,
        buttons: {
            "Send": function() {
                if(isNew){
                    var form_data = {
                        destinationnumber: no_tujuan.val(),
                        textdecoded: pesan.val(),
                        ajax:1
                    };
                }else{
                    var form_data = {
                        destinationnumber: no_tujuan.val(),
                        textdecoded: pesan.val(),
                        edit:1,
                        ajax:1
                    };
                }

                var validate = true;
                MsgFields.removeClass( "ui-state-error" );

                validate = validate && checkLength( no_tujuan, "No. Tujuan", 9, 14 );
                validate = validate && checkLength( pesan, "Pesan", 3, 160 );

                if ( validate ) {
                    $( this ).dialog( "close" );
                    $.ajax({
                        url : site+"outbox/send/",
                        type : 'POST',
                        data : form_data,
                        success : function(response){
                            $('#show_outbox').html(response);
                            //window.location = site+'outbox';
                        }
                    });         
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            MsgFields.val( "" ).removeClass( "ui-state-error" );
        }
    });
    $( "#compose-message" )
        .button()
        .click(function() {
            isNew = true;
            $( "#no_tujuan" ).attr("disabled", false);
            $( "#all_krani" ).attr("checked", false);
            $( "#form-new-message" ).dialog( "open" );
    });
    $( "#all_krani" ).click(function(){
        if($(this).is(":checked")){
            $( "#no_tujuan" ).val("Semua Krani");
            $( "#no_tujuan" ).attr("disabled", "disabled");
        }else{
            $( "#no_tujuan" ).val("");
            $( "#no_tujuan" ).attr("disabled", false);
        }

    });
    
    
    /***************************** End of New Message Form ***************************/

    // combo box @home page
    $("#tahun").change(function(){
        $("#bulan").attr('disabled', false);
    });
    $("#bulan").change(function(){
        var thn = $("#tahun").val();
        var bln = $("#bulan").val();
        load("def/i/"+thn+"/"+bln,"#show");
       
        $('#chartDiv').empty();
        //setVar();
        load_graph("def/igraph/"+thn+"/"+bln,"#show_graph");
        
    });
    $("#kebun").change(function(){
        var thn = $("#tahun").val();
        var bln = $("#bulan").val();
        $("#dateview").attr('disabled', false);
    });
    
    $("#kebun_view").change(function(){
        var thn = $("#tahun").val();
        var bln = $("#bulan").val();
        $("#dateview").attr('disabled', false);
    });

    /*********************** Login Handling **************************/
    $(".login").live("click",function(){
        $( "#form-login" ).dialog( "open" );

    });
    
    $( "#logged_in" ).dialog({autoOpen: false, resizable: false, height: 80, modal: true});
    $( "#not_valid" ).dialog({autoOpen: false, resizable: false, height: 80, modal: true});
    
    $( "#form-login" ).dialog({
        autoOpen: false,
        resizable: false,
        width:225,
        height:216,
        modal: true,
        hide: 'Slide',
        buttons: {
            "Login": function() {
                var reg = $("#register_login").val();
                var pass = $("#password_login").val();
                var arr = {
                    username : reg,
                    password : pass
                };
                $( this ).dialog("close");
                $.ajax({
                    type: "POST",
                    url : site+'login/do_login',
                    data : arr,
                    success : function(response){
                        if(response == 1){
                            window.location.href = site;
                        }else if(response == 2){
                            $( "#logged_in" ).dialog( "open" );
                            return false;
                        }else{
                            $( "#not_valid" ).dialog( "open" );
                            return false;
                        }
                    }
                });
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });

    /*********************** End of Login Handling ***************************/
    
    /************************** Luas Afdeling Management *****************************/
    var kebun_la, afdeling_la = $("#afdeling_la"), luas_la = $( "#luas_la" ), tahun_la, id_la = $( "#id_la" );
    var allFields6 = $( [] ).add( tahun_la ).add( kebun_la ).add( afdeling_la ).add( luas_la );
    isNew = false;
    $( "#form-la" ).dialog({
        autoOpen: false,
        height: 350,
        width: 300,
        modal: true,
        resizable: false,
        buttons: {
            "Save": function() {
                kebun_la = $( "#kebun_la" );
                tahun_la = $( "#tahun_la" );
                
                if(isNew){
                    var form_data = {
                        kebun: kebun_la.val(),
                        afdeling: afdeling_la.val(),
                        luas: luas_la.val(),
                        tahun: tahun_la.val(),
                        ajax:1
                    };
                }else{
                    var form_data = {
                        id: id_la.val(),
                        kebun: kebun_la.val(),
                        afdeling: afdeling_la.val(),
                        luas: luas_la.val(),
                        tahun: tahun_la.val(),
                        edit:1,
                        ajax:1
                    };
                }
                var validate = true;
                allFields6.removeClass( "ui-state-error" );

                validate = validate && checkCombo( tahun_la, 'Pilih Tahun.' );
                validate = validate && checkCombo( kebun_la, 'Pilih Kebun.' );
                validate = validate && checkCombo( afdeling_la, 'Pilih Afdeling.' );
                validate = validate && checkLength( luas_la, "Luas", 3, 9 );

                var year = tahun_la.val();
                var field = kebun_la.val();
                var afd_la = afdeling_la.val();
                if ( validate ) {
                    $( this ).dialog( "close" );
                    $.ajax({
                        url: site+"/afdeling/cek_data_la/"+year+"/"+field+"/"+afd_la,
                        success: function(response){
                            if(response == 1 && isNew){
                                alert('Error. Data sudah ada!');
                                return false;
                            }else{
                                $.ajax({
                                    url : site+"afdeling/submit_la/"+year+"/"+field,
                                    type : 'POST',
                                    data : form_data,
                                    success : function(response){
                                        $('#show_la').html(response);
                                    }
                                });
                            }
                        }
                    })
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields6.val( "" ).removeClass( "ui-state-error" );
        }
    });
    $( "#create-la" )
        .button()
        .click(function() {
            $( "#id_la" ).hide();
            $( "#kebun_la" ).show();
            $( "#afdeling_la" ).show();
            $( "#luas_la" ).show();
            $( "#tahun_la" ).show();
            isNew = true;

            $( "#form-la" ).dialog( "open" );
            $( "#kbn" ).attr('disabled', 'disabled');
    });

    $(".edit_la").live("click",function(){
        $( "#id_la" ).hide();
        isNew = false;

        var id = $(this).attr("id");
        var kebun = $(this).attr("kebun");
        var afdeling = $(this).attr("afdeling");
        var luas = $(this).attr("luas");
        var tahun = $(this).attr("tahun");
        
        $('#id_la').val(id);
        $('#kebun_la').val(kebun);
        $('#afdeling_la').val(afdeling);
        $('#luas_la').val(luas);
        $('#tahun_la').val(tahun);

        $("#kebun_la").attr('disabled', 'disabled');
        $("#afdeling_la").attr('disabled', 'disabled');
        $("#tahun_la").attr('disabled', 'disabled');

        $( "#form-la" ).dialog( "open" );

        return false;
    });

    $('#kebun_la_show').change(function(){
        var kebun = $('#kebun_la_show').val();
        var tahun = $('#tahun_la_show').val();
        if(tahun == ""){
            alert('Tahun belum dipilih!');
            return false;
        }else{
            load('afdeling/load_la/'+kebun +'/' +tahun,'#show_la');
        }
    });
    $('#tahun_la_show').change(function(){
        $("#kebun_la_show").attr('disabled', false);
    });

    $(".delete_la").live("click",function(){
    	var element = $(this);
    	var id = element.attr("id");
        var tahun = element.attr("tahun");
        var kebun = element.attr("kebun");
    	confirm(id, 'afdeling/delete/'+kebun+"/"+tahun,'#show_la');
        $( "#dialog" ).dialog( "open" );
    	return false;
    });

    /********************* End of Luas Afdeling Management **********************/

    /************************** Afdeling Management *****************************/
    var kebun_af, af, rkap_af = $( "#rkap_af" ), rko_af = $( "#rko_af" ), tahun_af, bulan_af, id_af = $( "#id_af" );
    var allFields7 = $( [] ).add( kebun_af ).add( af ).add( rkap_af ).add( rko_af ).add( tahun_af ).add(bulan_af);
    isNew = false;
    $( "#form-af" ).dialog({
        autoOpen: false,
        height: 422,
        width: 300,
        modal: true,
        resizable: false,
        buttons: {
            "Save": function() {
                kebun_af = $( "#kebun_af" );
                af = $( "#af" );
                tahun_af = $( "#tahun_af" );
                bulan_af = $( "#bulan_af" );

                if(isNew){
                    var form_data = {
                        tahun: tahun_af.val(),
                        bulan: bulan_af.val(),
                        kebun: kebun_af.val(),
                        afdeling: af.val(),
                        rkap: rkap_af.val(),
                        rko: rko_af.val(),
                        ajax:1
                    };
                }else{
                    var form_data = {
                        id: id_af.val(),
                        tahun: tahun_af.val(),
                        bulan: bulan_af.val(),
                        kebun: kebun_af.val(),
                        afdeling: af.val(),
                        rkap: rkap_af.val(),
                        rko: rko_af.val(),
                        edit:1,
                        ajax:1
                    };
                }

                var validate = true;
                allFields7.removeClass( "ui-state-error" );

                validate = validate && checkCombo( tahun_af, 'Pilih Tahun.' );
                validate = validate && checkCombo( bulan_af, 'Pilih Bulan.' );
                validate = validate && checkCombo( kebun_af, 'Pilih Kebun.' );
                validate = validate && checkCombo( af, 'Pilih Afdeling.' );
                validate = validate && checkLength( rkap_af, "RKAP", 3, 9 );
                validate = validate && checkLength( rko_af, "RKO", 3, 9 );

                var year = tahun_af.val();
                var month = bulan_af.val();
                var field = kebun_af.val();
                var afdl = af.val();

                if ( validate ) {
                    $( this ).dialog( "close" );
                    $.ajax({
                        url: site+"/afdeling/cek_data_af/"+year+"/"+month+"/"+field+"/"+afdl,
                        success: function(response){
                            if(response == 1 && isNew){
                                alert('Error. Data sudah ada!');
                                return false;
                            }else{
                                $.ajax({
                                    url : site+"afdeling/submit_af/"+field+"/"+year+"/"+month,
                                    type : 'POST',
                                    data : form_data,
                                    success : function(response){
                                        $('#show_afd').html(response);
                                    }
                                });
                            }
                        }
                    })
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields7.val( "" ).removeClass( "ui-state-error" );
        }
    });
    $( "#create-af" )
        .button()
        .click(function() {
            $( "#kebun_af" ).show();
            $( "#af" ).show();
            $( "#rkap_af" ).show();
            $( "#tahun_af" ).show();
            $( "#bulan_af" ).show();
            $( "#rko_af" ).show();
            $('#id_af').hide();
            isNew = true;
            
            $("#kebun_af").attr('disabled', false);
            $("#af").attr('disabled', false);
            $("#tahun_af").attr('disabled', false);
            $("#bulan_af").attr('disabled', false);
            $( "#form-af" ).dialog( "open" );
    });

    $(".edit_af").live("click",function(){
        isNew = false;

        var id = $(this).attr("id");
        var kebun = $(this).attr("kebun");
        var afdeling = $(this).attr("afdeling");
        var rkap = $(this).attr("rkap");
        var rko = $(this).attr("rko");
        var tahun = $(this).attr("tahun");
        var bulan = $(this).attr("bulan");

        $('#id_af').val(id);
        $('#kebun_af').val(kebun);
        $('#af').val(afdeling);
        $('#rkap_af').val(rkap);
        $('#rko_af').val(rko);
        $('#tahun_af').val(tahun);
        $('#bulan_af').val(bulan);
        $('#id_af').hide();

        $("#kebun_af").attr('disabled', 'disabled');
        $("#af").attr('disabled', 'disabled');
        $("#tahun_af").attr('disabled', 'disabled');
        $("#bulan_af").attr('disabled', 'disabled');

        $( "#form-af" ).dialog( "open" );

        return false;
    });

    $('#tahun_af_show').change(function(){
        $("#bulan_af_show").attr('disabled', false);
    });
    
    $('#bulan_af_show').change(function(){
        $("#kebun_af_show").attr('disabled', false);
    });

    $('#kebun_af_show').change(function(){
        var tahun = $('#tahun_af_show').val();
        var bulan = $('#bulan_af_show').val();
        var kebun = $('#kebun_af_show').val();
        if(tahun == ""){
            alert('Tahun belum dipilih!');
            return false;
        }else if(bulan == ""){
            alert('Bulan belum dipilih!');
            return false;
        }else{
            load('afdeling/load_af/'+kebun +'/'+tahun +'/'+bulan,'#show_afd');
        }
    });

    $(".delete_af").live("click",function(){
    	var element = $(this);
    	var id = element.attr("id");
        var kebun = element.attr("kebun");
        var tahun = element.attr("tahun");
        var bulan = element.attr("bulan");
    	confirm(id, 'afdeling/delete_af/'+kebun+"/"+tahun+'/'+bulan,'#show_afd');
        $( "#dialog" ).dialog( "open" );
    	return false;
    });
    /*********************** End of Afdeling Management **************************/
    
    /****************************** HK Management ********************************/
    var tahun_hk = $("#tahun_hk"), bulan_hk = $( "#bulan_hk" ), jlh_hk = $( "#jlh_hari" ), id_hk = $( "#id_hk" );
    var allFields8 = $( [] ).add( tahun_hk ).add( bulan_hk ).add( jlh_hk );
    isNew = false;
    $( "#form-hk" ).dialog({
        autoOpen: false,
        height: 308,
        width: 300,
        modal: true,
        resizable: false,
        buttons: {
            "Save": function() {              
                if(isNew){
                    var form_data = {
                        tahun: tahun_hk.val(),
                        bulan: bulan_hk.val(),
                        jlh_hari: jlh_hk.val(),
                        ajax:1
                    };
                }else{
                    var form_data = {
                        id: id_hk.val(),
                        tahun: tahun_hk.val(),
                        bulan: bulan_hk.val(),
                        jlh_hari: jlh_hk.val(),
                        edit:1,
                        ajax:1
                    };
                }
                var validate = true;
                allFields8.removeClass( "ui-state-error" );

                validate = validate && checkCombo( tahun_hk, 'Pilih Tahun.' );
                validate = validate && checkCombo( bulan_hk, 'Pilih Bulan.' );
                validate = validate && checkLength( jlh_hk, "Jlh. HK", 2, 2 );

                var year = tahun_hk.val();
                var month = bulan_hk.val();
                if ( validate ) {
                    $( this ).dialog( "close" );
                    $.ajax({
                        url: site+"/hk/cek_data/"+year+"/"+month,
                        success: function(response){
                            if(response == 1 && isNew){
                                alert('Error. Data sudah ada!');
                                return false;
                            }else{
                                $.ajax({
                                    url : site+"hk/submit/"+year,
                                    type : 'POST',
                                    data : form_data,
                                    success : function(response){
                                        $('#show_hari_kerja').html(response);
                                    }
                                });
                            }
                        }
                    })
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields6.val( "" ).removeClass( "ui-state-error" );
        }
    });
    $( "#create-hk" )
        .button()
        .click(function() {
            $( "#id_hk" ).hide();
            $( "#jlh_hk" ).show();
            $( "#bulan_hk" ).show();
            $( "#tahun_hk" ).show();
            isNew = true;

            $( "#form-hk" ).dialog( "open" );
            $( "#id_hk" ).hide();
    });
	
	
    $(".edit_hk").live("click",function(){
        $( "#id_hk" ).hide();
        isNew = false;

        var id = $(this).attr("id");
        var jlh_hari = $(this).attr("jlh_hari");
        var bulan = $(this).attr("bulan");
        var tahun = $(this).attr("tahun");
        
        $('#id_hk').val(id);
        $('#jlh_hari').val(jlh_hari);
        $('#bulan_hk').val(bulan);
        $('#tahun_hk').val(tahun);

        $("#bulan_hk").attr('disabled', 'disabled');
        $("#tahun_hk").attr('disabled', 'disabled');

        $( "#form-hk" ).dialog( "open" );

        return false;
    });

    $('#tahun_hk_show').change(function(){
        var tahun = $('#tahun_hk_show').val();
        load('hk/load/'+tahun,'#show_hari_kerja');
    });

    $(".delete_hk").live("click",function(){
    	var element = $(this);
    	var id = element.attr("id");
        var tahun = element.attr("tahun");
    	confirm(id, 'hk/delete/'+tahun,'#show_hari_kerja');
        $( "#dialog" ).dialog( "open" );
    	return false;
    });

    /********************* End of HK Management **********************/
    
    /*********************** Info Management *********************************/
    
    $(".delete_info").live("click",function(){
    	var element = $(this);
    	var id = element.attr("id");
    	confirm(id, 'info/delete/','#show_info');
        $( "#dialog" ).dialog( "open" );
    	return false;
    });
    /*********************** End of Info Management **************************/
 
});
function setVar(){
    var ptg = [$('#ptg0').val(),$('#ptg1').val(),$('#ptg2').val(),$('#ptg3').val(),$('#ptg4').val(), 36.9];
    var klm = [$('#klm0').val(),$('#klm1').val(),$('#klm2').val(),$('#klm3').val(),$('#klm4').val(), 36.9];
    var kbr = [$('#kbr0').val(),$('#kbr1').val(),$('#kbr2').val(),$('#kbr3').val(),$('#kbr4').val(), 36.9];
    var tsw = [$('#tsw0').val(),$('#tsw1').val(),$('#tsw2').val(),$('#tsw3').val(),$('#tsw4').val(), 36.9];
    var jru = [$('#jru0').val(),$('#jru1').val(),$('#jru2').val(),$('#jru3').val(),$('#jru4').val(), 36.9];
    var cgr = [$('#cgr0').val(),$('#cgr1').val(),$('#cgr2').val(),$('#cgr3').val(),$('#cgr4').val(), 36.9];
    var xAxis = [$('#tgl0').val(), $('#tgl1').val(), $('#tgl2').val(), $('#tgl3').val(), $('#tgl4').val()];
}


function confirm(id, url, div){
    $( "#dialog" ).dialog({
        autoOpen: false,
        resizable: false,
        height:140,
        modal: true,
        hide: 'Slide',
        buttons: {
            "Delete": function() {
                var arr = {
                    id : id
                };
                //var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
                $( this ).dialog("close");
                $.ajax({
                    type: "POST",
                    url : site+url,
                    data: arr,
                    success: function(response){
                        $(div).html(response);
                    }
                });
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });
}
function l(page){
    var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
    $.ajax({
        url: page,
        beforeSend: function(){
            $("#temp").html(image_load);
        },
        success: function(response){
            $("#temp").html(response);
            $( "#dialog:ui-dialog" ).dialog( "destroy" );

            $( "#dialog-box" ).dialog({
                modal: true,
                width: 360,
                resizable: false,
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        },
        dataType:"html"
    });
    return false;
}

function l2(page){
    var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
    $.ajax({
        url: page,
        beforeSend: function(){
            $("#temp").html(image_load);
        },
        success: function(response){
            $("#temp").html(response);
            $( "#dialog:ui-dialog" ).dialog( "destroy" );

            $( "#dialog-box" ).dialog({
                modal: true,
                width: 650,
                resizable: false,
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        },
        dataType:"html"
    });
    return false;
}

function l3(page){
    var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
    $.ajax({
        url: page,
        beforeSend: function(){
            $("#temp").html(image_load);
        },
        success: function(response){
            $("#temp").html(response);
            $( "#dialog:ui-dialog" ).dialog( "destroy" );

            $( "#dialog-box" ).dialog({
                modal: true,
                width: 270,
                resizable: false,
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        },
        dataType:"html"
    });
    return false;
}

function load_form(page){
    var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
    $.ajax({
        url: page,
        beforeSend: function(){
            $("#temp").html(image_load);
        },
        success: function(response){
            $("#temp").html(response);
            $( "#dialog:ui-dialog" ).dialog( "destroy" );

            $( "#dialog-box" ).dialog({
                modal: true,
                width: 360,
                resizable: false,
                buttons: {
                    Submit: function() {
                        $( this ).dialog( "close" );
                    },
                    Close: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        },
        dataType:"html"
    });
    return false;
}

function load(page,div){
    var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
    $.ajax({
        url: site+"/"+page,
        beforeSend: function(){
            $(div).html(image_load);
        },
        success: function(response){
            $(div).html(response);
        },
        dataType:"html"
    });
    return false;
}

function load_graph(page,div){
    $.ajax({
        url: site+"/"+page,
        success: function(response){
            $(div).html(response);
            $.jqplot('chartDiv', [ptg, klm, kbr, tsw, jru, cgr], CreateBarChartOptions());
        },
        dataType:"html"
    });
    return false;
}

function load_small(page,div,loadingDom,opt){
    var image_load_small = "<span class='ajax_loading_small'><img src='"+loading_image_small+"' /></span>";
    $.ajax({
        url: site+"/"+page,
        beforeSend: function(){
            $(loadingDom).html(image_load_small);
        },
        success: function(response){
            $(loadingDom).html('');
            if(opt=="append")
            {
                $(div).append(response);
            }
            else
            {
                $(div).html(response);
            }
        },
        dataType:"html"
    });
    return false;
}
function send_form(formObj,action,responseDIV)
{
    $.ajax({
        url: site+"/"+action,
        data: $(formObj.elements).serialize(),
        success: function(response){
                $(responseDIV).html(response);
            },
        type: "post",
        dataType: "html"
    });
    return false;
}
function send_form_loading(formObj,action,responseDIV)
{
    $( "#dialog-box" ).dialog("close");
    var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
    $.ajax({
        url: site+action,
        data: $(formObj.elements).serialize(),
        beforeSend: function(){
            $(responseDIV).html(image_load);
        },
        success: function(response){

            $(responseDIV).html(response);

        },
        type: "post",
        dataType: "html"
    });
    return false;
}
$(document).ready(function(){
    $("#bulan").attr('disabled', 'disabled');
    $("#dateview").attr('disabled', 'disabled');
    $("#kebun_la_show").attr('disabled', 'disabled');
    $("#bulan_af_show").attr('disabled', 'disabled');
    $("#kebun_af_show").attr('disabled', 'disabled');
    $("#bulan_hk_show").attr('disabled', 'disabled');
    var pathname = $(location).attr('href');
    var pos = pathname.indexOf("index");
    
    $('#dateview').val("Pilih Tanggal");

    $("#bulan_rko").attr('disabled', 'disabled');

    /***************************************************/
    
    $.jqplot('chartDiv', [ptg, klm, kbr, tsw, jru, cgr], CreateBarChartOptions());
    

    
    /**$('#barChartButton').click(function() {
        $('#chartDiv').html('');
        $.jqplot('chartDiv', [estimasi, realisasi], CreateBarChartOptions());
    });
    $('#lineChartButton').click(function() {
        $('#chartDiv').html('');
        $.jqplot('chartDiv', [estimasi, realisasi], CreateLineChartOptions());
    });*/
    $("#g").css("background-image", "url(http://www.google.co.uk/images/logos/ps_logo2.png)");
});
