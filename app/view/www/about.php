<?php include __DIR__ . '/header.php'; ?>

<div class="wjl-entries">
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>关于我</a>
        </div>
    </div>
    <hr />
    <div class="wjl-post">
        <div class="wjl-post-content">
            <?=$about?>
        </div>
    </div>
    <hr />
    <br /> 
    <br /> 
</div>

<div class="wjl-entries">
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>留言板</a>
        </div>
    </div>
    <hr />
    <div class="wjl-post">
        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="about" data-title="关于" data-url="http://wujilin.com/about"></div>
        <!-- 多说评论框 end -->
        <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
        <script type="text/javascript">
            var duoshuoQuery = {short_name:"wujilin"};
            (function() {
                var ds = document.createElement('script');
                ds.type = 'text/javascript';ds.async = true;
                ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
                ds.charset = 'UTF-8';
                (document.getElementsByTagName('head')[0] 
                 || document.getElementsByTagName('body')[0]).appendChild(ds);
            })();
        </script>
        <!-- 多说公共JS代码 end -->
    </div>
    <hr />
    <br />
    <br />
</div>

<?php include __DIR__ . '/footer.php'; ?>
