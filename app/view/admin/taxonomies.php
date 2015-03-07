<?php include __DIR__ . '/header.php'; ?>

<div class='wjl-entries'>
    <div class='wjl-entries-header'>
        <div class='wjl-entries-title'>
            <a><?=$taxonomy_text?></a>
        </div>
        <div class='wjl-entries-action'>
            <button id='add-btn' class='btn btn-link' type='button'>新增<?=$taxonomy_text?></button>
        </div>
    </div>
    <hr />
    <?php for ($i = 0; $i < count($taxonomies); $i++) { ?>
        <?php $taxonomy = Op::arrays($taxonomies[$i]); ?>
        <div class='wjl-entry'>
            <div class='wjl-entry-top'>
                <div class='wjl-entry-title'>
                    <i class='<?=$taxonomy_icon?>'></i> 
                    <a href='http://wujilin.com/<?=$taxonomy_type?>/<?=$taxonomy["name"]?>'><?=$taxonomy['text']?></a>
                </div>
                <div class='wjl-entry-count'>
                    <span class='badge badge-success'><?=$taxonomy["count"]?></span>
                </div>
            </div>
            <div class='wjl-entry-bottom'>
                <div class='wjl-entry-name'>
                    <a><?=$taxonomy['name']?></a>
                </div>
                <div class='wjl-entry-action'>
                    <i class='icon-edit'></i> 
                    <a class='edit-btn' data-id='<?=$taxonomy["id"]?>' href='javascript:void(0);'>编辑</a>
                </div>
                <div class='wjl-entry-action'>
                    <i class='icon-remove'></i> 
                    <a class='delete-btn' data-id='<?=$taxonomy["id"]?>' data-count='<?=$taxonomy["count"]?>' 
                        href='javascript:void(0);'>删除</a>
                </div>
            </div>
        </div>
        <hr />
    <?php } ?>
    <br />
    <br />
    <div id='modal' class='modal hide fade' data-backdrop='static'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h3 id='modal-title'></h3>
        </div>
        <div class='modal-body'>
            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="text">显示文本</label>
                    <div class="controls">
                        <input type="text" id="text" placeholder="显示文本">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="name">名称</label>
                    <div class="controls">
                        <input type="hidden" id='id' />
                        <input type="text" id="name" placeholder="名称">
                    </div>
                </div>
            </form>
        </div>
        <div class='modal-footer'>
            <a href='javascript:void(0);' id='save-btn' class='btn btn-success'>保存</a>
            <a href='javascript:void(0);' data-dismiss='modal' class='btn'>关闭</a>
        </div>
    </div>
</div>

<script type='text/javascript'>
    $(function () {
        var $modal      = $('#modal'),
            $name       = $('#name'),
            $id         = $('#id'),
            $modalTitle = $('#modal-title'),
            $saveBtn    = $('#save-btn'),
            $text       = $('#text');

        $('#add-btn').on('click', function (event) {
            $modalTitle.text('新增<?=$taxonomy_text?>');
            $saveBtn.data('method', 'post');

            $modal.modal('show');
        });

        $name.on('keyup', function (event) {
            if (event.keyCode == 13) {
                $saveBtn.trigger('click');
            }
        });

        $('.edit-btn').on('click', function (event) {
            var $this = $(this),
                $taxonomy = $this.parents('.wjl-entry');

            $name.val($taxonomy.find('.wjl-entry-name a').text());
            $text.val($taxonomy.find('.wjl-entry-title a').text());
            $id.val($this.data('id'));

            $modalTitle.text('修改<?=$taxonomy_text?>');
            $saveBtn.data('method', 'put');

            $modal.modal('show');
        });

        $saveBtn.on('click', function (event) {
            var $this = $(this),
                method = $this.data('method'),
                data = {
                    '_method': method,
                    'taxonomy.name': $name.val(),
                    'taxonomy.type': '<?=$taxonomy_type?>',
                    'taxonomy.text': $text.val()
                };

            if (method === 'put') {
                data.id = $id.val();
            }

            $.ajax({
                type: 'post',
                url: 'http://wujilin.com/admin/taxonomy',
                data: data,
                success: function (response) {
                    if (response.success) {
                        window.location = 'http://wujilin.com/admin/<?=$taxonomy_type?>';
                    } else {
                        bootbox.alert('操作失败！' + (response.note ? response.note : ""));
                    }
                    $modal.modal('hide');
                }
            });
        });

        $('.delete-btn').on('click', function (event) {
            var $this = $(this);

            if (parseInt($this.data('count')) > 0) {
                bootbox.alert('该<?=$taxonomy_text?>下仍有文章！');
                return false;
            }

            bootbox.confirm("确认要删除？", function (result) {
                if (result) {
                    $.ajax({
                        type: 'post',
                        url: 'http://wujilin.com/admin/taxonomy',
                        data: {
                            '_method': 'delete',
                            id: $this.data('id')
                        },
                        success: function (response) {
                            if (response.success) {
                                var $taxonomy = $this.parents('.wjl-entry');

                                $taxonomy.next('hr').remove();
                                $taxonomy.slideUp('slow').remove();
                            } else {
                                bootbox.alert('操作失败！');
                            }
                        }
                    });
                }
            });
        });

        $modal.on('hide', function () {
            $name.val('');
            $text.val('');
            $id.val('');
        });
    });
</script>

<?php include __DIR__ . '/../www/footer.php'; ?>