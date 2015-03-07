$(function () {
	$('input.post-checker').checker();

    $('.alert').fadeOut(2000, function () {
        $(this).remove();
    });

	$('.wjl-entries-title').on('click', function () {
		$(this).parents('.wjl-entries-header').nextAll().slideToggle();
	});

    var $taxonomyModal = $('#taxonomy-modal'),
        $logoModal     = $('#logo-modal'),
        $postModal     = $('#post-modal'),
        $taxonomyName  = $('#taxonomy-name'),
        $taxonomyText  = $('#taxonomy-text'),
        $taxonomyType  = $('#taxonomy-type'),
        $saveTaxonomyBtn = $('#save-taxonomy-btn'),
        $title   = $('#post-title'),
        $content = $('#post-content'),
        $taxonomyModalTitle = $('#taxonomy-modal-title');

    $taxonomyModal.on('hide', function () {
        $taxonomyName.val('');
        $taxonomyText.val('');
        $taxonomyType.val('');
    });

    $('#taxonomy-name,#taxonomy-text').on('keyup', function (event) {
        if (event.keyCode == 13) {
            $saveTaxonomyBtn.trigger('click');
        }
    });

    $('.add-taxonomy-btn').on('click', function () {
        var $this = $(this);

        $taxonomyType.val($this.data('type'));
        $taxonomyModalTitle.html($this.text());
        $taxonomyModal.modal('show');
    });

    $saveTaxonomyBtn.on('click', function () {
        var name = $taxonomyName.val();
        var text = $taxonomyText.val();
        var type = $taxonomyType.val();

        var taxonomyInfos = {
            'tag': {
                'input': 'checkbox',
                'icon': 'icon-tag',
                'url': 'tag'
            },
            'category': {
                'input': 'radio',
                'icon': 'icon-folder-close',
                'url': 'category'
            },
            'series': {
                'input': 'checkbox',
                'icon': 'icon-book',
                'url': 'series'
            }
        };

        if (name.length == 0) {
            $taxonomyName.focus();
            return;
        }

        if (text.length == 0) {
            $taxonomyText.focus();
            return;
        }
        
        $('body').modalmanager('loading');

        $.ajax({
            type: 'post',
            url: 'http://wujilin.com/admin/taxonomy',
            data: {
                'taxonomy.name': name,
                'taxonomy.type': type,
                'taxonomy.text': text
            },
            success: function (response) {
                if (response.success) {
                    $.ajax({
                        type: 'get',
                        url: 'http://wujilin.com/admin/taxonomy/' + response.id,
                        success: function (response) {
                            $('body').modalmanager('loading');

                            if (response.success) {
                                var $taxonomyList = $('#' + type + '-list');
                                var taxonomy = response.taxonomy;
                                var taxonomyInfo = taxonomyInfos[type];

                                var html = [
                                    '<div class="wjl-entry">',
                                        '<div class="wjl-entry-title">',
                                            '<i class="', taxonomyInfo['icon'], '"></i> ',
                                            '<a href="http://wujilin.com/', taxonomyInfo['url'], '/', taxonomy.name, '">', taxonomy.text, '</a>',
                                        '</div>',
                                        '<div class="wjl-entry-checkable">',
                                            '<input type="', taxonomyInfo['input'], '" class="post-', type, ' post-checker" value="', taxonomy.id, '" name="post-', type, '" />',
                                        '</div>',
                                    '</div>',
                                    '<hr />'
                                ].join('');

                                $(html).insertBefore('.' + type + '-list-br');
                                $('input.post-' + type).checker();
                                $('input.post-' + type + ':last').next('a').trigger('click');
                            } else {
                                bootbox.alert('查询失败！');
                            }

                            $taxonomyModal.modal('hide');
                        }
                    });
                } else {
                    bootbox.alert(response.note);
                }
            }
        });
    });

    $('#post-logo').on('click', function () {
        $('body').modalmanager('loading');

        $logoModal.load('http://wujilin.com/admin/logo', function () {
            $logoModal.modal({
                width: 760
            });
        });
    });

    $('.publish-btn').on('click', function () {
        if (!validated_form()) { return; }

        var $this = $(this);
        var data = {
            'post.title': $title.val(),
            'post.content': $content.val(),
            'post.logo': $('#post-logo').attr('src'),
            'post.status': $this.data('status'),
            'post.category': $('.post-category:checked').val(),
            'post.type': $('.post-type:checked').val(),
            'post.sticky': $('.post-sticky:checked').length > 0 ? $('.post-sticky:checked').val() : 0
        };

        var $tags = $('.post-tag:checked');
        var tags = [];

        $tags.each(function (index) {
            var $this = $(this);
            tags.push($this.val());
        });

        if (tags.length > 0) {
            data['post.tags'] = tags.join(';');
        }

        var $series = $('.post-series:checked');
        var series = [];

        $series.each(function (index) {
            var $this = $(this);
            series.push($this.val());
        });

        if (series.length > 0) {
            data['post.series'] = series.join(';');
        }

        // 判断是写文章，还是编辑文章？
        var action = $this.data('action');
        if (action == 'update') {
            data['post.id'] = $('#post-id').val();
            data['_method'] = 'put';
        }

        $('body').modalmanager('loading');

        $.ajax({
            type: 'post',
            url: 'http://wujilin.com/admin/post',
            data: data,
            success: function (response) {
                if (response.success) {
                    window.location = 'http://wujilin.com/admin/post/' + response.id + '/edit?message=' + action;
                } else {
                    bootbox.alert('发表文章失败！');
                }
            }
        });
    });

    $('.preview-btn').on('click', function () {
        if (!validated_form()) { return; }
        
        $('body').modalmanager('loading');

        var $category = $('.post-category:checked')
            .closest('.wjl-entry')
            .find('.wjl-entry-title a');

        var $tags = $('.post-tag:checked')
            .closest('.wjl-entry')
            .find('.wjl-entry-title a');

        var tags = [];

        $tags.each(function (index) {
            var $this = $(this);
            tags.push($this.text() + ',' + $this.attr('href'));
        });

        var params = {
            'post.title': $title.val(),
            'post.content': $content.val(),
            'post.logo': $('#post-logo').attr('src'),
            'post.category': [ $category.text(), ',' , $category.attr('href') ].join(''),
            'post.type': $('input[name="post-type"]:checked').val(),
            'post.sticky': $('.post-sticky:checked').length > 0 ? $('.post-sticky:checked').val() : 0
        }

        if (tags.length > 0) {
            params['post.tags'] = tags.join(';');
        }

        $postModal.load('http://wujilin.com/admin/post/preview', params, function () {
            $postModal.modal({
                width: 700
            });
        });
    });

    function validated_form() {
        var title   = $title.val(),
            content = $content.val();

        if (title.length == 0) {
            $title.focus();
            return false;
        }

        if (content.length == 0) {
            $content.focus();
            return false;
        }

        return true;
    }
});