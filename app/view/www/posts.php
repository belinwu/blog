<?php include __DIR__ . '/header.php'; ?>

<div class='wjl-entries'>
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a><?=$posts_title?></a>
        </div>
    </div>
    <hr />
    <?php foreach ($posts as $post) { ?>
    <div class="wjl-post">
        <div class="wjl-post-header">
            <div class="wjl-post-logo">
                <img src="<?=$post->logo?>" class="img-polaroid" /></div>
            <div class="wjl-post-info">
                <div class="wjl-post-title">
                    <a href="http://wujilin.com/<?=$post->id?>" title="<?=$post->title?>" target='_blank'>
                        <?=$post->title?>
                    </a>
                    <span class="label label-success"><?=$post->type?></span>
                    <?php if ($post->sticky > 0) { ?>
                        <span class="label label-important">推荐</span>
                    <?php } ?>
                </div>
                <div class="wjl-post-attr">
                    <div class="wjl-post-date"> <i class="icon-calendar"></i>
                        <a href="http://wujilin.com/archive/<?=$post->year?>/<?=$post->month?>">
                            <?=date('Y年m月d日', strtotime($post->created))?>
                        </a>
                    </div>
                    <div class="wjl-post-category"> <i class="icon-folder-close"></i>
                        <a href="http://wujilin.com/category/<?=$post->name?>">
                            <?=$post->text?>
                        </a>
                    </div>
                    <span data-id='<?=$post->id?>' class="badge">0</span>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <?php } ?>
    <div class='wjl-entries-footer'>
        <?php if (!empty($paginations)) { ?>
            <div class="pagination pagination-right">
                <ul>
                    <?php foreach ($paginations as $pagination) { ?>
                        <?=$pagination?>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var threads = [];
        $('.wjl-post-attr .badge').each(function () {
            var $this = $(this);
            var id = $this.data('id');
            threads.push(id);
        });
        if (threads.length > 0) {
            $.getJSON(['http://api.duoshuo.com/threads/counts.jsonp?short_name=wujilin&threads=', threads.join(','), '&callback=?'].join(''),
                function (data) {
                    $.each(data.response, function (key, value) {
                        $('span[data-id=' + key + ']').html(value.comments);
                    });
                }
            );
        }
    });
</script>

<?php include __DIR__ . '/footer.php'; ?>