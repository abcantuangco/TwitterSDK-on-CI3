var MainApp = {
    twitterAuthWindow: false,
    options: {
        endpoint: 'index.php/test_sdk/post_it',
        oauthUrl: 'index.php/test_sdk/get_url',
        twitterOauth: '',
    },
    handler: {
        formSubmit: function() {
            var submitBtn = $('#test-form').find('#submit-btn'),
                submitTxt = submitBtn.val();

            submitBtn.click(function(){
                submitBtn.val('Processing...');
                $.ajax({
                    method: 'POST',
                    url: MainApp.options.endpoint,
                    data: $('#test-form').serialize(),
                    dataType: 'json',
                }).done(function(data){
                    if (data.code === '200') {
                        alert(data.message);
                    }
                    submitBtn.val( submitTxt );
                });
            });
        },
        twitterLogin: function() {
            $('#login-with-twitter').click(function(){
                var $btn = $(this),
                    btnTxt = $btn.val();
                $btn.val('Processing...');
                $.ajax({
                    method: 'GET',
                    url: MainApp.options.oauthUrl,
                    dataType: 'json',
                }).done(function(data){
                    MainApp.handler.openWindow( data.url );
                    $btn.val(btnTxt);
                });
            });
        },
        openWindow: function(url) {
            if (url) {
                MainApp.twitterAuthWindow = window.open( url , "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50%,left=50%,width=600,height=400");
            }
        },
    },
    init: function() {
        MainApp.handler.formSubmit();
        MainApp.handler.twitterLogin();
    }
};

$(document).ready( MainApp.init );