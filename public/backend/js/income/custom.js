"use strict";
$(document).ready(function(){

    // Select from
    $(".delivery_man_search").hide();
    $(".merchant_search").hide();
    $(".hub_search").hide();
    $("#income_hub_id").prop('disabled', true);


    if($("#account_head").val() != null){
        if($("#account_head").val() == 1){
            $(".merchant_search").show();
        }
        else if($("#account_head").val() == 2){
            $(".delivery_man_search").show();
        }
        else if($("#account_head").val() == 7){
            $(".hub_search").show();
            $("#income_hub_id").prop('disabled', false);
        }
    }

    $("#account_head").on('change', function(){

        if($(this).val() == 1){
            $(".merchant_search").show();
            $(".delivery_man_search").hide();
            $(".delivery_man_searchs").hide();
            $(".hub_search").hide();
            $("#income_hub_id").prop('disabled', true);
            $("#hubs").hide();
        }
        else if($(this).val() == 2){
            $(".merchant_search").hide();
            $(".delivery_man_search").show();
            $(".delivery_man_searchs").show();
            $(".hub_search").hide();
            $("#income_hub_id").prop('disabled', true);
            $("#hubs").show();
        }
        else if($(this).val() == 7){
            $(".merchant_search").hide();
            $(".delivery_man_search").hide();
            $(".delivery_man_searchs").hide();
            $(".hub_search").show();
            $("#income_hub_id").prop('disabled', false);
            $("#hubs").hide();
        }
        else{
            $(".delivery_man_search").hide();
            $(".delivery_man_searchs").hide();
            $(".merchant_search").hide();
            $(".hub_search").hide();
            $("#income_hub_id").prop('disabled', true);
            $("#hubs").hide();

        }
    });


    $('#parcelDeliveryManID_').on('change',function(){
            $.ajax({
                type: 'post',
                url: '/admin/income/balance-check',
                data: {'search': value,'from':$('#account_head').val(),'deliveryman':$('#parcelDeliveryManID_').val(),'merchant':$('#parcelMerchantid_').val(),'income':'true'},
                success: function (data) {

                    $('.deliveryman_balance').text('Current Balance: '+parseFloat(data['mhd']['current_balance']));
                    $("#deliveryman_amount").val(parseFloat(data['mhd']['current_balance']));
                }
            });
    });

    $('#parcelMerchantid_').on('change',function(){
            $.ajax({
                type: 'post',
                url: '/admin/income/balance-check',
                data: {'search': value,'from':$('#account_head').val(),'deliveryman':$('#parcelDeliveryManID_').val(),'merchant':$('#parcelMerchantid_').val(),'income':'true'},
                success: function (data) {

                    $('.merchant_balance').text('Current Balance: '+parseFloat(data['mhd']['current_balance']));
                    $("#merchant_amount").val(parseFloat(data['mhd']['current_balance']));
                }
            });
    });

    // Hub change
    $('.hub_users').hide();
    $('.hub_user_accounts').hide();

    if($('#income_hub_id').val() != ''){
        $('.hub_users').show();
    }
    if($('.hub_users').val() != ''){
        $('.hub_user_accounts').show();
    }

    $('#income_hub_id').on('change',function(){
        $.ajax({
            type: 'post',
            url: '/admin/income/balance-check',
            data: {'search': value,'from':$('#account_head').val(),'hub':$('#income_hub_id').val()},
            success: function (data) {
                // console.log(data);
                // console.log(data['hub']['current_balance']);

                $('.hub_balance').text('Current Balance: '+parseInt(data['mhd']['current_balance']));
                $("#hub_amount").val(parseInt(data['mhd']['current_balance']));

                // option insert in hub users
                $('#hub_users').empty();
                $('#hub_users').append('<option selected disabled>Select User</option>');
                $('#hub_user_accounts').empty();
                let n = 0;
                
                for(n ; n < data['users'].length; n++){
                    $('#hub_users').append('<option value="'+ data['users'][n]['id'] +'">'+ data['users'][n]['name'] +'</option>');
                }
                // console.log(data['users']['0']['name']);
            }
        });
        $('.hub_users').show();
    });
    $('#hub_users').on('change',function(){
        $.ajax({
            type: 'post',
            url: '/admin/income/hub-user-accounts',
            data: {'id':$('#hub_users').val()},
            success: function (data) {
                console.log(data.length);
                // option insert in hub user accounts
                $('#hub_user_accounts').empty();
                $('#hub_user_accounts').append('<option selected disabled>Select Account</option>');
                let n = 0;
                for(n ; n < data.length; n++){
                    $('#hub_user_accounts').append('<option value="'+ data[n]['id'] +'">'+ data[n]['account_holder_name'] +' | ('+ data[n]['balance'] +')</option>');
                }
                // console.log(data['users']['0']['name']);
            }
        });
        $('.hub_user_accounts').show();
    });




    // Show balance
    if($("#account_id").val() == null){
        $(".amount_div").hide();
        $(".btn").prop('disabled', true);
    }
    $("#account_id").on('change', function(){

        $.ajax({
            type: 'post',
            url: '/admin/expense/search-account/'+ $("#account_id").val(),
            data: {'search': value,income:'true'},
            success: function (data) {

                setTimeout(function() {
                    $('#account_balance_').text(data['balance']);
                    $('#account_balance').val(parseInt(data['balance']));
                    $(".amount_div").show();

                    if(parseInt($('#account_balance').val()) >= parseInt($("#amount").val()) && $("#amount").val() != ''){
                        $(".btn").prop('disabled', false);
                        $('.check_message').empty();
                    }
                    else if($("#amount").val() == ''){
                        $(".btn").prop('disabled', true);
                        $('.check_message').empty();
                    }
                    else{
                        $(".btn").prop('disabled', true);
                        $('.check_message').empty();
                        $('.check_message').append('<small class="text-danger">Ops! not enough blance.</small>');
                    }

                }, 250);
            }
        })
    });

    // Check balance
    $("#amount").on('keyup', function(){

        if($('#from').val() == 1){
            if(parseInt($('#merchant_amount').val()) < parseInt($(this).val())){
                $('.check_message').text('Ops! not enough blance.');
            }
        }else if($('#from').val() == 2){
            if(parseInt($('#deliveryman_amount').val()) < parseInt($(this).val())){
                $('.check_message').text('Ops! not enough blance.');
            }
        }


        if(parseInt($('#account_balance').val()) >= parseInt($("#amount").val()) && $("#amount").val() != ''){
            $(".btn").prop('disabled', false);
            $('.check_message').empty();
        }
        else if($("#amount").val() == ''){
            $(".btn").prop('disabled', true);
            $('.check_message').empty();
        }
        else{
            $(".btn").prop('disabled', false);
            // $(".btn").prop('disabled', true);
            // $('.check_message').empty();
            // $('.check_message').append('<small class="text-danger">Ops! not enough blance.</small>');
        }
    });

    $( "#parcelMerchantid_" ).select2({
        ajax: {
            url: merchantUrl,
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    searchQuery: true
                };
            },
            processResults: function (response) {
                console.log(response);
                return {

                    results: response
                };
            },
            cache: true
        }

    });

    $( "#parcelDeliveryManID_").select2({
        ajax: {
            url: $("#parcelDeliveryManID_").data('url'),
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function (params) {

                return {
                    search: params.term,
                    searchQuery: true
                };
            },
            processResults: function (response) {
                console.log(response);
                return {

                    results: response
                };
            },
            cache: true
        }
    });



    $( "#income_hub_id" ).select2({
        ajax: {
            url: hubUrl,
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    searchQuery: true
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });


    // Transfer to hub multiple parcel
    let value, submit = 0;
    $('#transfer_to_hub_track_id_').on('keyup', function () {
        value = $('#transfer_to_hub_track_id_').val();
        if(value.length == 14 && submit == 0){
            submit = 1; // multiple request hande!
            $.ajax({
                type: 'post',
                url: '/admin/parcel/search-income',
                data: {'search': value},
                success: function (data) {
                    setTimeout(function() {
                        submit = 0;
                        if(data == 0){
                            $('#parcel_id').val(null);
                            $('.search_message').empty();
                            $('.search_message').append('<small class="text-danger">Parcel not found!</small>');
                        }
                        else{
                            $('.search_message').empty();
                            $('.search_message').append('<small class="text-success">Parcel found.</small>');
                            $('#parcel_id').val(data['id']);
                        }
                    }, 250);
                }
            })
        }
        else if(value.length > 14 && submit == 0){
            $('#parcel_id').val(null);
            $('.search_message').empty();
            $('.search_message').append('<small class="text-danger">Maximum 14 characters!</small>');
        }
        else{
            $('#parcel_id').val(null);
            $('.search_message').empty();
            $('.search_message').append('<small class="text-danger">Minimum 14 characters!</small>');
        }

    })

    // $('#head_title').hide();
    $('#account_head').on('change',function () {
        var accounthead = $(this).val();

        if(accounthead == '3'){
            $('#user_head').show();
            $('#head_title').show();
        }else{
            $('#user_head').hide();
            $('#head_title').hide();
        }
    });


    $( "#user_id").select2({
        ajax: {
            url: $("#user_id").data('url'),
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    searchQuery: true
                };
            },
            processResults: function (response) {
                console.log(response);
                return {

                    results: response
                };
            },
            cache: true
        }
    });

    $( "#hub_id" ).select2()


});
