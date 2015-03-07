<!DOCTYPE html>
<html>
<head>
    <title><?=$title?></title>
    
    <meta charset='utf-8' />

    <link rel='stylesheet' href='http://wujilin.com/assets/highlight/styles/github.css' />
    <link rel='stylesheet' href='http://wujilin.com/assets/bootstrap/css/bootstrap.css' />
    <link rel='stylesheet' href='http://wujilin.com/assets/checker/checker.css' />
    <link rel='stylesheet' href='http://wujilin.com/assets/bootstrap-modal/css/bootstrap-modal.css' />
    <link rel='stylesheet' href='http://wujilin.com/css/app.css' />

    <script type='text/javascript' src='http://wujilin.com/assets/jquery.js'></script>
    <script type='text/javascript' src='http://wujilin.com/assets/bootstrap/js/bootstrap.js'></script>
    <script type='text/javascript' src='http://wujilin.com/assets/highlight/highlight.js'></script>
    <script type='text/javascript' src='http://wujilin.com/assets/bootbox.js'></script>
    <script type='text/javascript' src='http://wujilin.com/assets/checker/checker.js'></script>
    <script type='text/javascript' src='http://wujilin.com/assets/bootstrap-modal/js/bootstrap-modalmanager.js'></script>
    <script type='text/javascript' src='http://wujilin.com/assets/bootstrap-modal/js/bootstrap-modal.js'></script>
    
    <link rel="shortcut icon" href="http://wujilin.com/img/favicon.ico" />

    <script type='text/javascript'>
        $(function () {
            hljs.initHighlightingOnLoad();

            $('.nav:first li[key=<?=$active?>]').addClass('active');

            $('#wjl-goto-top').on('click', function(event) {
                event.preventDefault();
                $('html, body').animate({scrollTop: 0}, 500);
            });

            $('#wjl-goto-bottom').on('click', function(event) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 500);
            });

            $('#wjl-op-link-tip').tooltip({
                placement: 'right'
            });
        });
    </script>
</head>
<body>
    <div class='navbar navbar-fixed-top'>
        <div class='navbar-inner'>
            <div class='container'>
                <button type='button' class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </button>
                <div class='nav-collapse collapse'>
                    <ul class='nav'>
                        <li key='home'>
                            <a href='http://wujilin.com/admin'>首页</a>
                        </li>
                        <li key='post'>
                            <a href='http://wujilin.com/admin/post'>文章</a>
                        </li>
                        <li key='draft'>
                            <a href='http://wujilin.com/admin/draft'>草稿箱</a>
                        </li>
                        <li key='category'>
                            <a href='http://wujilin.com/admin/category'>分类</a>
                        </li>
                        <li key='series'>
                            <a href='http://wujilin.com/admin/series'>系列</a>
                        </li>                        
                        <li key='tag'>
                            <a href='http://wujilin.com/admin/tag'>标签</a>
                        </li>
                        <li class="divider-vertical"></li>
                        <li>
                            <a href='http://wujilin.com/logout'>注销</a>
                        </li>
                    </ul>
                    <ul class='nav pull-right'>
                        <li>
                            <a href='http://wujilin.com'>belin_wu.blog {}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="wjl-main">