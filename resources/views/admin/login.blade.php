@include('admin.layout.head')
<link rel="stylesheet" href="/static/admin/css/login.css" media="all">
<div class="login-box">
    <h2>User Login</h2>
    <form name="loginForm">
        <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" maxlength="20"
                   placeholder="Input username">
        </div>
        <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Input password">
        </div>
        <div class="form-group">
            <label for="code" class="control-label">Captcha</label>
            <div class="row">
                <div class="col-xs-7">
                    <input type="text" class="form-control" id="code" name="code" placeholder="Input captcha code">
                </div>
                <div class="col-xs-5">
                    <img src="{{route('captcha')}}" id="refreshCaptcha" class="captcha" title="Click to change"
                         alt="Click to change"
                         onclick="this.src='{{route('captcha')}}?seed='+Math.random()"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" value="1">Keep logged in
                </label>
            </div>
        </div>
        <div class="row" style="text-align:center;">
            {{csrf_field()}}
            <button type="button" class="btn btn-primary" id="submitLogin">Sign in</button>
        </div>
    </form>
</div>
<script>
    $(function () {
        $("#submitLogin").on('click', function () {
            var loading_index = common.loading('loading');
            $.ajax({
                "type": "post",
                "dataType": "json",
                "url": "{{url('/login')}}",
                "data": $("form[name='loginForm']").serialize(),
                "success": function (res) {
                    common.close(loading_index);
                    if (res.code === 0) {
                        common.success('login succeeded!', function () {
                            location.href = '{{url('admin/index/index')}}'
                        })
                    } else {
                        // 重新赋值
                        if (res.token !== undefined) {
                            $("input[name='_token']").val(res.token);
                        }
                        $('#refreshCaptcha').trigger("click");
                        common.error(res.msg);
                    }
                },
                "error": function (res) {
                    $('#refreshCaptcha').trigger("click");
                    var error_msg = res.msg !== undefined ? res.msg : 'system error,try again';
                    common.error(error_msg);
                }
            })
            return false;
        })
    })
</script>
@include('admin.layout.foot')
