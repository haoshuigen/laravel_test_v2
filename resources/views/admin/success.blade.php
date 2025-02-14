<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Successful operation jumping</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Lantinghei SC, Open Sans, Arial, Hiragino Sans GB, Microsoft YaHei, "微软雅黑", STHeiti, WenQuanYi Micro Hei, SimSun, sans-serif;
            -webkit-font-smoothing: antialiased
        }

        body {
            padding: 70px 0;
            background: #edf1f4;
            font-weight: 400;
            font-size: 1pc;
            -webkit-text-size-adjust: none;
            color: #333
        }

        a {
            outline: 0;
            color: #3498db;
            text-decoration: none;
            cursor: pointer
        }

        .system-message {
            margin: 20px 5%;
            padding: 40px 20px;
            background: #fff;
            box-shadow: 1px 1px 1px hsla(0, 0%, 39%, .1);
            text-align: center
        }

        .system-message h1 {
            margin: 0;
            margin-bottom: 9pt;
            color: #444;
            font-weight: 400;
            font-size: 40px
        }

        .system-message .jump, .system-message .image {
            margin: 20px 0;
            padding: 0;
            padding: 10px 0;
            font-weight: 400
        }

        .system-message .jump {
            font-size: 14px
        }

        .system-message .jump a {
            color: #333
        }

        .system-message p {
            font-size: 9pt;
            line-height: 20px
        }

        .system-message .btn {
            display: inline-block;
            margin-right: 10px;
            width: 138px;
            height: 2pc;
            border: 1px solid #44a0e8;
            border-radius: 30px;
            color: #44a0e8;
            text-align: center;
            font-size: 1pc;
            line-height: 2pc;
            margin-bottom: 5px;
        }

        .success .btn {
            border-color: #69bf4e;
            color: #69bf4e
        }

        .error .btn {
            border-color: #ff8992;
            color: #ff8992
        }

        .info .btn {
            border-color: #3498db;
            color: #3498db
        }

        .system-message .btn-grey {
            border-color: #bbb;
            color: #bbb
        }

        .clearfix:after {
            clear: both;
            display: block;
            visibility: hidden;
            height: 0;
            content: "."
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 0;
            }
        }

        @media (max-width: 480px) {
            .system-message h1 {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
@php
    $codeText = $code == 1 ? 'success' : ($code == 0 ? 'error' : 'info');
@endphp
<div class="system-message {$codeText}">
    <h1>{{strip_tags($msg)}}</h1>
    <p class="jump">
        The page will jump after <span id="wait">{{$wait}}</span> seconds
    </p>
    <p class="clearfix">
        <a href="#" onClick="javascript :history.back(-1);" class="btn btn-grey">Go back</a>
        <a id="href" href="{{$url}}" class="btn btn-primary">Jump now</a>
    </p>
</div>
<script type="text/javascript">
    (function () {
        var wait = document.getElementById('wait'),
            href = document.getElementById('href').href;
        var interval = setInterval(function () {
            var time = --wait.innerHTML;
            if (time <= 0) {
                location.href = href;
                clearInterval(interval);
            }
        }, 1000);
    })();
</script>
</body>
</html>
