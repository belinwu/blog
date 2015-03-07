<?php include __DIR__ . '/header.php'; ?>

<div class="wjl-entries">
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>关于我</a>
        </div>
        <div class="wjl-entries-action">
            <a class="btn btn-link save-meta-btn" data-name='about' href='javascript:void(0);'>保存</a>
        </div>
    </div>
    <hr />
    <div class="wjl-post">
        <div class="wjl-post-content">
            <form class="form-horizontal post-form">
                <div class="control-group">
                    <div class="controls">
                        <textarea name="about" id="about" 
                            style="width:645px;max-width:645px;margin-top:8px;" rows="30" required=""><?=$metas->about?></textarea>
                    </div>
                </div>
            </form> 
        </div>
    </div>
    <hr />
    <br />
    <br />    
</div>

<div class="wjl-entries">
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>修改密码</a>
        </div>
        <div class="wjl-entries-action">
            <a class="btn btn-link" id='modify-password-btn' href='javascript:void(0);'>修改</a>
        </div>        
    </div>
    <hr />
    <form class="form-horizontal" id="wjl-attr-form">
        <div class="control-group">
            <label class="control-label" for="password">新密码</label>
            <div class="controls">
                <input type="password" id="password" required />      
            </div>
        </div> 
    </form>
    <hr />
    <br />
    <br />    
</div>

<script type="text/javascript" src="http://wujilin.com/assets/cryptojs.md5.js"></script>
<script type="text/javascript">
    $(function () {
        $('.wjl-entries-title').on('click', function () {
            $(this).parents('.wjl-entries-header').nextAll().slideToggle();
        });

        var $password = $('#password')
            $saveMeta = $('.save-meta-btn');

        $saveMeta.on('click', function () {
            var $this = $(this);
            var name = $this.data('name');
            var $meta = $('#' + name);

            $.ajax({
                type: 'post',
                url: 'http://wujilin.com/admin/meta',
                data: {
                    '_method': 'put',
                    'meta.name': name,
                    'meta.value': $meta.val()
                },
                success: function (response) {
                    var $notice = null;

                    if (response.success) {
                        $notice = $('<span/>', {
                            text: '保存成功！',
                        }).css({
                            color: 'green'
                        });
                    } else {
                        $notice = $('<span/>', {
                            text: '保存失败！',
                        }).css({
                            color: 'red'
                        });
                    }
                    $notice.insertBefore($this).fadeOut(2000, function () {
                        $notice.remove();
                    });
                }
            });
        });

        $('#modify-password-btn').on('click', function () {
            var password = $password.val();
            var $this = $(this);

            if (password.length == 0) {
                $password.focus();
                return;
            }

            $.ajax({
                type: 'post',
                url: 'http://wujilin.com/admin/meta',
                data: {
                    '_method': 'put',
                    'meta.name': 'password',
                    'meta.value': CryptoJS.MD5($password.val()).toString()
                },
                success: function (response) {
                    var $notice = null;

                    if (response.success) {
                        $notice = $('<span/>', {
                            text: '密码修改成功！',
                        }).css({
                            color: 'green'
                        });
                    } else {
                        $notice = $('<span/>', {
                            text: '密码修改失败！',
                        }).css({
                            color: 'red'
                        });
                    }

                    $notice.insertBefore($this).fadeOut(2000, function () {
                        $notice.remove();
                    });

                    $password.val('');
                }
            });
        });
    });
</script>

<?php include __DIR__ . '/../www/footer.php'; ?>