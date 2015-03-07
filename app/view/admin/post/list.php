<?php include __DIR__ . '/.././header.php'; ?>

<div class="wjl-entries">
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>文章</a>
        </div>
        <div class="wjl-entries-action">
            <a href='http://wujilin.com/admin/post/new' class="btn btn-link" type="button">写文章</a>
        </div>
    </div>
    <hr />
    <?php for ($i = 0; $i < count($posts); $i++) { ?>
        <?php $post = Op::arrays($posts[$i]); ?>
        <div class="wjl-post">
            <div class="wjl-post-header">
                <div class="wjl-post-logo">
                    <img src="<?=$post->logo?>" class="img-polaroid">
                </div>
                <div class="wjl-post-info">
                    <div class="wjl-post-title">
                        <?php if ($active == 'draft') { ?>
                            <a class='gray'>
                                <?=$post->title?>
                            </a>
                        <?php } else { ?>
                            <a href="http://wujilin.com/<?=$post->id?>" title="<?=$post->title?>" target='_blank'>
                                <?=$post->title?>
                            </a>
                        <?php } ?>
                        <span class="label label-success"><?=$post->type?></span>
                        <?php if ('1' == $post->sticky) { ?>
                            <span class="label label-important">推荐</span>
                        <?php } ?>
                    </div>
                    <div class="wjl-post-attr">
                        <div class="wjl-entry-label">
                            <i class="icon-calendar"></i> 
                            <a><?=date('Y年m月d日', strtotime($post->created))?></a>
                        </div>
                        <div class="wjl-post-category">
                            <i class="icon-folder-close"></i> 
                            <a href="http://wujilin.com/category/<?=$post->name?>"><?=$post->text?></a>
                        </div>
                        <div class="wjl-entry-action">
                            <i class="icon-edit"></i> 
                            <a href='http://wujilin.com/admin/post/<?=$post->id?>/edit'>编辑</a>
                        </div>
                        <div class="wjl-entry-action">
                            <i class="icon-remove"></i> 
                            <a href='javascript:void(0);' data-id='<?=$post->id?>' class='delete-post-btn'>删除</a>
                        </div>   
                    </div>
                </div>                    
            </div>
        </div>
        <hr />
    <?php } ?>
    <div class='wjl-entries-footer'>
        <?php if (empty($paginations)) { ?>
            <br />
            <br />
        <?php } else { ?>
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
        var $deleteBtn = $('.delete-post-btn');

        $deleteBtn.on('click', function () {
            var $this = $(this);

            bootbox.confirm("确认要删除？", function (result) {
                if (result) {
                    $.ajax({
                        type: 'post',
                        url: 'http://wujilin.com/admin/post',
                        data: {
                            '_method': 'delete',
                            id: $this.data('id')
                        },
                        success: function (response) {
                            if (response.success) {
                                var $post = $this.parents('.wjl-post');

                                $post.next('hr').remove();
                                $post.slideUp('slow', function () {
                                    $post.remove();
                                });
                            } else {
                                bootbox.alert('操作失败！');
                            }
                        }
                    });
                }
            });
        });
    });
</script>

<?php include __DIR__ . '/../../www/footer.php'; ?>