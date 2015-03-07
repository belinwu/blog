<div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
    <h3>预览文章</h3>
</div>
<div class='modal-body'>
    <div class="wjl-post">
        <div class="wjl-post-header">
            <div class="wjl-post-logo">
                <img src="<?=$post->logo?>" class="img-polaroid" />
            </div>
            <div class="wjl-post-info">
                <div class="wjl-post-title">
                    <a class='gray'><?=$post->title?></a>
                    <span class="label label-success"><?=$post->type?></span>         
                    <?php if ($post->sticky == 1) { ?>
                        <span class="label label-important">推荐</span>
                    <?php } ?>
                </div>
                <div class="wjl-post-attr">
                    <div class="wjl-post-date"> 
                        <i class="icon-calendar"></i>
                        <a href="http://wujilin.com/archive/<?=$post->year_month?>">
                            <?=date('Y年m月d日', strtotime($post->created))?>
                        </a>
                    </div>
                    <div class="wjl-post-category">
                        <i class="icon-folder-close"></i>
                        <?php $category = explode(',', $post->category) ?>
                        <a href="<?=$category[1]?>"><?=$category[0]?></a>
                    </div>                   
                </div>
            </div>
        </div>
        <hr class='wjl-post-hr' />
        <div class="wjl-post-content">
            <?=$post->content?>
        </div>
        <div class="wjl-post-footer">
            <div class="wjl-post-tags">
                <i class="icon-tags"></i>
                <?php if (isset($post->tags)) { ?>
                    <?php foreach (explode(';', $post->tags) as $post_tag) { ?>
                        <?php $post_tag = explode(',', $post_tag); ?>
                        <a href="<?=$post_tag[1]?>"><?=$post_tag[0]?></a>;
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class='modal-footer'>
    <button class='btn' data-dismiss="modal" aria-hidden="true">关闭</button>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('pre code').each(function (i, e) {
            hljs.highlightBlock(e);
        });
    });
</script>