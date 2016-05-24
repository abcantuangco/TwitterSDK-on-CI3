<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Baking App</title>
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Baking App</h1>
                <p>The form below will try to post on Twitter.</p>
                <form action="javascript:;" id="test-form">
                    <textarea name="status" id="" cols="30" rows="10" class="form-input" maxlength="140"></textarea>
                    <p><input id="submit-btn" type="button" value="Post It"></p>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <hr>
                <p>The button below will initiate Twitter login and on successful/failed will passback a response.</p>
                <input type="button" id="login-with-twitter" value="Login with Twitter">
            </div>
        </div>
    </div>
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/assets/js/main.js"></script>
</body>
</html>