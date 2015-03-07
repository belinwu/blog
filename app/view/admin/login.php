<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>登录 - belin_wu.blog {}</title>
	<link rel="stylesheet" href="http://wujilin.com/assets/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="http://wujilin.com/css/app.css" />
	<script type="text/javascript" src="http://wujilin.com/assets/jquery.js"></script>
	<script type="text/javascript" src="http://wujilin.com/assets/cryptojs.md5.js"></script>
	<script type="text/javascript" src="http://wujilin.com/assets/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="http://wujilin.com/assets/bootbox.js"></script>
    <link rel="shortcut icon" href="http://wujilin.com/img/favicon.ico" />
</head>
<body>
	<div class="wjl-login-box">
    	<a href="http://wujilin.com">
    		<img src="http://wujilin.com/img/logo.jpg" class="img-circle" id="login-luffy-image" />
    	</a>
		<form class="form-horizontal">
			<fieldset>
    			<legend>网站管理后台登录</legend>
				<div class="control-group">
					<div class="controls">
						<input type="text" id="account" placeholder="管理员" required />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="password" id="password" placeholder="密码" required />
					</div>
				</div>
				<div class="control-group">
					<div class="controls wjl-btn-control">
						<a id='login-btn' class="btn">登录</a>
					</div>
				</div>
			</fieldset>
		</form>
		<hr />
		<p>Proudly powered by 
            <a href="javascript:void(0);" id='wjl-op-link-tip' dtat-toogle='tooltip' 
                title='A PHP micro framework only I use!'>Op</a>. 
        </p> 
	</div>
	<script type="text/javascript">
		$(function () {
			var $account = $('#account'),
				$password = $('#password'),
				$loginBtn = $('#login-btn');
					
			$loginBtn.on('click', function () {
				var account = $account.val(),
					$this = $(this),
					password = $password.val();

				if (account.length == 0) {
					$account.focus();
					return;
				}

				if (password.length == 0) {
					$password.focus();
					return;
				}

				$password.val(CryptoJS.MD5(password).toString());

				$.ajax({
					type: 'post',
					url: 'http://wujilin.com/login',
					data: {
						account: account,
						password: $password.val()
					},
					success: function (response) {
						if (response.success) {
							window.location = 'http://wujilin.com/admin';
						} else {
							var $notice = $('<span/>', {
	                            text: '用户名或密码不正确！',
	                        }).css({
	                            color: 'red'
	                        });

	                        $notice.insertBefore($this).fadeOut(2000, function () {
		                        $notice.remove();
		                    });

							$password.val('');
						}
					}
				});
			});

			$password.on('keyup', function (event) {
				if (event.keyCode == 13) {
					$loginBtn.trigger('click');
				}
			});
		});
	</script>
</body>
</html>