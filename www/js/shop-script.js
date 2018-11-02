$(document).ready(function () {
    $("#newsticker").jCarouselLite({
        vertical: true,
        hoverPause: true,
        btnPrev: "#news-prev",
        btnNext: "#news-next",
        visible: 2,
        auto: 3000,
        speed: 500
    });


    $("#style-grid").click(function () {

        $("#block-tovar-grid").show();
        $("#block-tovar-list").hide();

        $("#style-grid").attr("src", "images/grid_red.png");
        $("#style-list").attr("src", "images/list.png");

        $.cookie('select_style', 'grid');
    });

    $("#style-list").click(function () {

        $("#block-tovar-grid").hide();
        $("#block-tovar-list").show();

        $("#style-list").attr("src", "images/list_red.png");
        $("#style-grid").attr("src", "images/grid.png");

        $.cookie('select_style', 'list');
    });


    if ($.cookie('select_style') == 'grid') {
        $("#block-tovar-grid").show();
        $("#block-tovar-list").hide();

        $("#style-grid").attr("src", "images/grid_red.png");
        $("#style-list").attr("src", "images/list.png");
    }
    else {
        $("#block-tovar-grid").hide();
        $("#block-tovar-list").show();

        $("#style-list").attr("src", "images/list_red.png");
        $("#style-grid").attr("src", "images/grid.png");
    }

    $("#select-sort").click(function () {
        $("#sorting-list").slideToggle(200);
    });

    //гормошка-категорий товаров
    $('#block-category > ul > li > a').click(function () {
        if ($(this).attr('class') != 'active') {
            // черех парамметр this передается на какую ссылку нажали и применяется актив
            $('#block-category > ul > li > ul').slideUp(400); //закрыть
            $(this).next().slideToggle(400); // открыть
            $('#block-category > ul > li > a').removeClass('active'); //удаление классов со всех категорий
            $(this).addClass('active');//присваеваем класс к конкретной категории (но класс нужно прописать в стилях)
            $.cookie('select_cat', $(this).attr('id')); //указ на плагин кук создается файл с селект_кат и указ ай ди (ИНДЕКС 1(2,3))
        } else {
            $('#block-category > ul > li > a').removeClass('active');
            $('#block-category > ul > li > ul').slideUp(400);
            $.cookie('select_cat', '');
        }
    });

    if ($.cookie('select_cat') != '') {
        $('#block-category > ul > li > #' + $.cookie('select_cat')).addClass('active').next().show();
    }

    $('#genpass').click(function () {
        $.ajax({
            type: "POST",
            url: "functions/genpass.php",
            dataType: "html",
            cache: false,
            success: function (data) {
                $('#reg_password').val(data);
            }
        })
    });

    $('#reloadcaptcha').click(function () {
        $('#block-captcha > img').attr("src", "reg/reg_captcha.php?r=" + Math.random());
    });


    $('.top-auth').toggle(
        function () {
       $('.top-auth').attr("id","active-button");
       $('#block-top-auth').show();
    },
        function () {
            $('.top-auth').attr("id","");
            $('#block-top-auth').hide();
        }
    );

    /*$('#button-pass-show-hide').click(function(){
        var statuspass = $('#button-pass-show-hide').attr("class");

        if (statuspass == "pass-show")
        {
            $('#button-pass-show-hide').attr("class","pass-hide");

            var $input = $("#auth_pass");
            var change = "text";
            var rep = $("<input placeholder='Пароль' type='" + change + "' />")
                .attr("id", $input.attr("id"))
                .attr("name", $input.attr("name"))
                .attr('class', $input.attr('class'))
                .val($input.val())
                .insertBefore($input);
            $input.remove();
            $input = rep;

        }else {
            $('#button-pass-show-hide').attr("class","pass-show");

            var $input = $("#auth_pass");
            var change = "password";
            var rep = $("<input placeholder='Пароль' type='" + change + "' />")
                .attr("id", $input.attr("id"))
                .attr("name", $input.attr("name"))
                .attr('class', $input.attr('class'))
                .val($input.val())
                .insertBefore($input);
            $input.remove();
            $input = rep;

        }
    });
    */

    $('#button-password-show-hide').click(function(){
        var type = $('#auth_password').attr('type') == "text" ? "password" : 'text',
            c = $(this).text() == "" ? "" : "";
        $(this).text(c);
        $('#auth_password').prop('type', type);
    });



    $('#button-auth').click(function () {
       var auth_login = $('#auth_login').val();
       var auth_password = $('#auth_password').val();

        if (auth_login == "" || auth_login.length > 30) {
            $('#auth_login').css("borderColor", "red");
            send_login = 'no';
        } else {
            $('#auth_login').css("borderColor","#DBDBDB");
            send_login = 'yes';
        }

        if (auth_password == "" || auth_password.length >15) {
            $('#auth_password').css("borderColor","red");
            send_password = 'no';
        } else {
            $('#auth_password').css("borderColor","#DBDBDB");
            send_password = 'yes';
        }

        if ($('#rememberMe').prop('checked')){
            auth_rememberMe = "yes";
        } else {
            auth_rememberMe = "no";
        }

        if (send_login == 'yes' && send_password == 'yes'){
            $('#button-auth').hide();
            $('.auth-loading').show();
            $.ajax({
               type: "POST", 
                url: "include/auth.php",
                data: "login="+auth_login+"&password="+auth_password+"&rememberMe="+auth_rememberMe,
                dataType: "html",
                cache: false,
                success: function (data) {
                    if (data == true){
                        location.reload();
                    } else {
                        $('#message-auth').slideDown(400);
                        $('.auth-loading').hide();
                        $('#button-auth').show();
                    }
                }
            });
        }
    });

    $('#remindPassword').click(function () {
       $('#input-email-pass').fadeOut(200, function () {
         $('#block-remind').fadeIn(300);
       });
    });

    $('#prev-auth').click(function () {
       $('#block-remind').fadeOut(200,function () {
          $('#input-email-pass').fadeIn(300);
       });
    });

    $('#button-remind').click(function(){

        var recall_email = $("#remind-email").val();

        if (recall_email == "" || recall_email.length > 30 )
        {
            $("#remind-email").css("borderColor","red");

        }else
        {
            $("#remind-email").css("borderColor","#DBDBDB");

            $("#button-remind").hide();
            $(".auth-loading").show();

            $.ajax({
                type: "POST",
                url: "include/remind-pass.php",
                data: "email="+recall_email,
                dataType: "html",
                cache: false,
                success: function(data) {

                    if (data == true) {
                        $(".auth-loading").hide();
                        $("#button-remind").show();
                        $('#message-remind').attr("class","message-remind-success").html("На ваш e-mail выслан пароль.").slideDown(400);

                        setTimeout("$('#message-remind').html('').hide(),$('#block-remind').hide(),$('#input-email-pass').show()", 3000);

                    }else {
                        $(".auth-loading").hide();
                        $("#button-remind").show();
                        $('#message-remind').attr("class","message-remind-error").html(data).slideDown(400);

                    }
                }
            });
        }
    });

    $('#auth-user-info').toggle(
        function () {
            $('#block-user').fadeIn(100);
    },
        function () {
            $('#block-user').fadeOut(100);
        }
    );

    $('#logout').click(function(){

        $.ajax({
            type: "POST",
            url: "include/logout.php",
            dataType: "html",
            cache: false,
            success: function(data) {

                if (data == 'logout') {
                    location.reload();
                }
            }
        });
    });
});
