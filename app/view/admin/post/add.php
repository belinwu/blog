<?php include __DIR__ . '/.././header.php'; ?>

<div class="wjl-entries">
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>新文章</a>
        </div>
        <div class="wjl-entries-action">
            <a class="btn btn-link preview-btn" href='javascript:void(0);'>预览文章</a>
        </div>
    </div>
    <hr />
	<div class="wjl-post">
		<div class="wjl-post-header">
            <div class="wjl-post-info" style='margin-left:0px;margin-right:15px;'>
                <div class="wjl-post-title">
                    <label for="post-title" style='text-align:left;'>文章标题</label>
                    <input class='span6' type="text" id='post-title' value='' required />
                </div>
            </div>
			<div class="wjl-post-logo">
                <img src="http://wujilin.com/img/logo/blogger.png" id="post-logo" class='img-polaroid' />            
			</div>
		</div>
		<div class="wjl-post-content">
			<form class="form-horizontal post-form">
	            <div class="control-group">
	                <div class="controls">
                        <label for="post-content" style='text-align:left;'>文章内容</label>
	                    <textarea name="content" id="post-content" style='width:645px;max-width:645px;margin-top:8px;' rows="30" required></textarea>
	                </div>
	            </div>
	        </form>	
		</div>
	</div>
	<hr />
	<br />
	<br />
</div>

<div id='logo-modal' class='modal hide fade' data-backdrop='static'></div>
<div id='post-modal' class='modal hide fade'></div>

<div class="wjl-entries" id='category-list'>
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>分类</a>
        </div>
        <div class="wjl-entries-action">
            <a href='javascript:void(0);' class="btn btn-link add-taxonomy-btn" 
                type="button" data-type='category'>新增分类</a>
        </div>        
    </div>
    <hr />
	<?php for ($i = 0; $i < count($categories); $i++) { ?>
		<?php $category = $categories[$i]; ?>
		<div class="wjl-entry">
            <div class="wjl-entry-title">
                <i class="icon-folder-close"></i> 
                <a href="http://wujilin.com/category/<?=$category['name']?>"><?=$category['text']?></a>
            </div>
            <div class="wjl-entry-checkable">
            	<input type="radio" class="post-category post-checker" 
                    <?php if ($i == 0) { ?>checked <?php } ?>
                    value="<?=$category['id']?>" name="post-category" />
            </div>
    	</div>
    	<hr />
	<?php } ?>
	<br class='category-list-br' />
	<br />
</div>

<div class="wjl-entries" id='series-list'>
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>系列</a>
        </div>
        <div class="wjl-entries-action">
            <a href='javascript:void(0);' class="btn btn-link add-taxonomy-btn" 
                data-type='series' type="button">新增系列</a>
        </div>        
    </div>
    <hr />
    <?php for ($i = 0; $i < count($series); $i++) { ?>
        <?php $entry = $series[$i]; ?>
        <div class="wjl-entry">
            <div class="wjl-entry-title">
                <i class="icon-book"></i> 
                <a href="http://wujilin.com/series/<?=$entry['name']?>"><?=$entry['text']?></a>
            </div>
            <div class="wjl-entry-checkable">
                <input type="checkbox" class="post-series post-checker" 
                    value="<?=$entry['id']?>" name="post-series" />
            </div>
        </div>
        <hr />
    <?php } ?>
    <br class='series-list-br' />
    <br />
</div>

<div class="wjl-entries" id='tag-list'>
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>标签</a>
        </div>
        <div class="wjl-entries-action">
            <a href='javascript:void(0);' class="btn btn-link add-taxonomy-btn" 
                type="button" data-type='tag' >新增标签</a>
        </div>        
    </div>
    <hr />
	<?php for ($i = 0; $i < count($tags); $i++) { ?>
		<?php $tag = $tags[$i]; ?>
		<div class="wjl-entry">
            <div class="wjl-entry-title">
                <i class="icon-tag"></i> 
                <a href="http://wujilin.com/tag/<?=$tag['name']?>"><?=$tag['text']?></a>
            </div>
            <div class="wjl-entry-checkable">
            	<input type="checkbox" class="post-tag post-checker"
                    value="<?=$tag['id']?>" name="post-tag" />
            </div>
    	</div>
    	<hr />
	<?php } ?>  
	<br class='tag-list-br' />
	<br />
</div>

<div class="wjl-entries">
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>文章属性</a>
        </div>
    </div>
    <hr />
	<form class="form-horizontal" id='wjl-attr-form'>
        <div class="control-group">
            <label class="control-label wjl-checkable-label" for="postType">文章类型</label>
            <div class="controls">
                <div class="wjl-checkable">
                    <input type="radio" class="post-type post-checker" value="原创" checked
                        name="post-type" data-label='原创' />
                    <input type="radio" class="post-type post-checker" value="翻译"
                        name="post-type" data-label='翻译' />   
                    <input type="radio" class="post-type post-checker" value="转载"
                        name="post-type" data-label='转载' />                     
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="wjl-checkable">
                    <input type="checkbox" class="post-sticky post-checker" value="1" 
                        data-label='文章置顶推荐？' />
                </div>
            </div>
        </div>
    </form>
    <hr />
	<br />
	<br />
</div>

<div class="wjl-entries">
	<div class="wjl-post">
		<form class="form-horizontal" style='margin-top: 15px;'>
            <div class="control-group">
                <div class="controls">
                	<input class="btn btn-success publish-btn" data-action='new' data-status='已发布' type="button" value="发表" />
                	<input class="btn publish-btn" type="button" data-action='new' data-status='草稿' value="存为草稿" />
                    <a class="btn btn-link preview-btn" href='javascript:void(0);'>预览文章</a>
                    <span style='color:gray;'> 
                        # 文章支持 Markdown 格式。
                    </span>
		        </div>
            </div>
        </form>	
	</div>   
</div>

<div id='taxonomy-modal' class='modal hide fade' data-backdrop='static'>
    <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h3 id='taxonomy-modal-title'></h3>
    </div>
    <div class='modal-body'>
        <form class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="text">显示文本</label>
                <div class="controls">
                    <input type="text" id="taxonomy-text" placeholder="显示文本">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="name">名称</label>
                <div class="controls">
                    <input type="text" id="taxonomy-name" placeholder="名称">
                    <input type="hidden" id="taxonomy-type" value='' />
                </div>
            </div>
        </form>
    </div>
    <div class='modal-footer'>
        <a href='javascript:void(0);' id='save-taxonomy-btn' class='btn btn-success'>保存</a>
        <a href='javascript:void(0);' data-dismiss='modal' class='btn'>关闭</a>
    </div>
</div>

<script type="text/javascript" src='http://wujilin.com/js/post.js'></script>

<?php include __DIR__ . '/../../www/footer.php'; ?>