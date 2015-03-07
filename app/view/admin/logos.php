<div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
    <h3>选择文章图标</h3>
</div>
<div class='modal-body'>
	<div class="wjl-logos">
		<?php for ($i = 0; $i < count($logos); $i++) { ?>
			<div class="wjl-post-logo" style='margin:0px 10px 15px 10px;cursor:pointer;'>
		        <img src='<?=$logos[$i]?>' title='<?=$logos[$i]?>' class="img-polaroid post-logo" />
		    </div>
		<?php } ?>
	</div>
</div>
<div class='modal-footer'>
	<button class="btn btn-success" id='select-logo-btn'>确定</button>
    <button class='btn' data-dismiss="modal" aria-hidden="true">关闭</button>
</div>

<script type="text/javascript">
	$(function () {
		var $postLogo = $('#post-logo');

		$('img.post-logo[src="' + $postLogo.attr('src') + '"]')
			.addClass('selected-logo');

		$('.post-logo').on('click', function () {
			$('.selected-logo').removeClass('selected-logo');
			$(this).addClass('selected-logo');
		}).hover(function () {
			$(this).toggleClass('hover-logo');
		}, function () {
			$(this).toggleClass('hover-logo');
		});

		$('#select-logo-btn').on('click', function () {
			$('#logo-modal').modal('hide');
			$postLogo.attr('src', $('.selected-logo').attr('src'));
		});
	});
</script>