<?php include __DIR__ . '/header.php'; ?>

<div class='wjl-entries'>
    <div class="wjl-post">
        <div class="wjl-post-header">
            <div class="wjl-post-logo">
                <img src="<?=$post->logo?>" class="img-polaroid" />
            </div>
            <div class="wjl-post-info">
                <div class="wjl-post-title">
                    <a href='http://wujilin.com/<?=$post->id?>.md' class='view-md' target='_blank'
                        data-toogle='tooltip' title='查看Markdown格式原文' data-placement='top'>
                        <?=$post->title?>
                    </a>
                    <span class="label label-success"><?=$post->type?></span>
                    <?php if ($post->sticky > 0) { ?>
                        <span class="label label-important">推荐</span>
                    <?php } ?>
                </div>
                <div class="wjl-post-attr">
                    <div class="wjl-post-date"> 
                        <i class="icon-calendar"></i>
                        <a href="http://wujilin.com/archive/<?=$post->year?>/<?=$post->month?>">
                            <?=date('Y年m月d日', strtotime($post->created))?>
                        </a>
                    </div>
                    <div class="wjl-post-category">
                        <i class="icon-folder-close"></i>
                        <a href="http://wujilin.com/category/<?=$post->name?>"><?=$post->text?></a>
                    </div>
                    <span class="badge" style='cursor: pointer;'>0</span>
                </div>
            </div>
        </div>
        <hr class='wjl-post-hr' />
        <div class="wjl-post-content"><?=$post->html?></div>
        <hr class='wjl-post-hr' />
        <div class="wjl-post-footer">
            <?php if (!empty($tags)) { ?>
                <div class="wjl-post-tags">
                    <i class="icon-tags"></i>
                    <?php foreach ($tags as $tag) { ?>
                        <a href="http://wujilin.com/tag/<?=$tag['name']?>"><?=$tag['text']?></a>;
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="wjl-post-edit">
                <i class="icon-edit"></i>
                <a class='gray'><?=date('Y年m月d日', strtotime($post->updated))?></a>
            </div>
        </div>
    </div>
    <hr />
    <div class='wjl-entries-footer'>
        <ul class="pager">
            <?php if (isset($previous_post)) { ?>
                <li class="previous">
                    <a href="http://wujilin.com/<?=$previous_post['id']?>" title='<?=$previous_post["title"]?>' 
                        data-toogle='tooltip' data-placement='top'>&laquo; 上一篇</a>
                </li>
            <?php } ?>
            <?php if (isset($next_post)) { ?>
                <li class="next">
                    <a href="http://wujilin.com/<?=$next_post['id']?>" title='<?=$next_post["title"]?>' 
                        data-toogle='tooltip' data-placement='top'>下一篇 &raquo;</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="wjl-entries">
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>评论</a>
        </div>
    </div>
    <hr />
    <div class="wjl-post">
        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="<?=$post->id?>" data-title="<?=$post->title?>" data-url="http://wujilin.com/<?=$post->id?>"></div>
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

<!-- <?php if (count($series) > 0) { ?>
    <div class="wjl-entries">
        <div class="wjl-entries-header">
            <div class="wjl-entries-title">
                <a>文章所属系列</a>
            </div>
        </div>
        <hr />
        <?php for ($i = 0; $i < count($series); $i++) { ?>
            <?php $sery = $series[$i]; ?>
            <div class="wjl-entry">
                <div class="wjl-entry-title">
                    <i class="icon-book"></i> 
                    <a href="http://wujilin.com/series/<?=$sery['name']?>"><?=$sery['text']?></a>
                </div>
                <div class="wjl-entry-count">
                    <span class="badge badge-success"><?=$sery['count']?></span>
                </div>
            </div>
            <hr />
        <?php } ?>
        <br />
        <br />
    </div>
<?php } ?> -->

<script type="text/javascript">
    $(function () {
        var $commentBadge = $('.wjl-post-attr .badge');
        $('.pager a,.view-md').tooltip();
        $.getJSON(['http://api.duoshuo.com/threads/counts.jsonp?short_name=wujilin&threads=<?=$post->id?>&callback=?'].join(''),
            function (data) {
                $.each(data.response, function (key, value) {
                    $commentBadge.html(value.comments);
                });
            }
        );
        $commentBadge.on('click', function () {
            $('#wjl-goto-comment').trigger('click');
        });
    });
</script>

<?php include __DIR__ . '/footer.php'; ?>