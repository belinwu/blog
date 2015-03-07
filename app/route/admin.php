<?php 

# login routes

op::get('/login as to_login', function () {
    op::render('admin/login.php');
});

op::get('/logout as to_logout', function () {
    op::session();
    op::render('admin/login.php');
});

op::post('/login as login', function () {
    $account  = op::param('account');
    $password = op::param('password');

    $pairs = op::pairs('select name, value from meta where name=? or name=?', ['account', 'password']);

    if ($pairs['account'] == $account && 
        $pairs['password'] == $password) {
        
        $json['success'] = true;
        op::session('root', $pairs['account']);
    } else {
        $json['success'] = false;
    }

    op::json($json);
})->ajax(true);

# admin module

op::group(function () {
    op::get('/ as admin', function () {
        $sql = 'select name, value from meta where name in (?,?)';
        $pairs = op::pairs($sql, ['one', 'about']);

        $view_data = [
            'title' => '首页 - 管理后台 - belin_wu.blog {}',
            'active' => 'home',
            'metas' => op::arrays($pairs)
        ];        

        op::render('admin/index.php', $view_data);
    });

    op::put('/meta as save_meta', function () {
        $success = op::transaction(function () {
            $meta = op::param('meta');

            op::modify('meta', [
                'value' => $meta['value']
            ], $meta['name'], 'name');
        });

        $json['success'] = $success;

        op::json($json);
    })->ajax(true);
 
    # category route

    op::get('/category as admin_categories', function () {
        $sql = '
            select t.*, 
                   (select count(*) 
                      from post p 
                     where p.category=t.id) count 
             from taxonomy t 
            where t.type=?';

        $categories = op::maps($sql, ['category']);
        
        $view_data = [
            'title' => '分类 - 管理后台 - belin_wu.blog {}',
            'active' => 'category',
            'taxonomies' => $categories,
            'taxonomy_text' => '分类',
            'taxonomy_type' => 'category',
            'taxonomy_icon' => 'icon-folder-close'
        ];

        op::render('admin/taxonomies.php', $view_data);
    });

    # tag route

    op::get('/tag as admin_tags', function () {
        $sql = '
            select t.*,
                   (select count(*)
                      from post_and_tag pt 
                     where pt.tag=t.id) count
              from taxonomy t 
             where t.type=?';

        $tags = op::maps($sql, ['tag']);

        $view_data = [
            'title' => '标签 - 管理后台 - belin_wu.blog {}',
            'active' => 'tag',
            'taxonomies' => $tags,
            'taxonomy_text' => '标签',
            'taxonomy_type' => 'tag',
            'taxonomy_icon' => 'icon-tag'
        ];

        op::render('admin/taxonomies.php', $view_data);
    });  

    # series route

    op::get('/series as admin_series', function () {
        $sql = '
            select t.*,
                   (select count(*)
                      from post_and_series ps 
                     where ps.series=t.id) count
              from taxonomy t 
             where t.type=?';

        $series = op::maps($sql, ['series']);
        
        $view_data = [
            'title' => '系列 - 管理后台 - belin_wu.blog {}',
            'active' => 'series',
            'taxonomies' => $series,
            'taxonomy_text' => '系列',
            'taxonomy_type' => 'series',
            'taxonomy_icon' => 'icon-book'
        ];

        op::render('admin/taxonomies.php', $view_data);
    });

    # taxonomies routes

    op::post('/taxonomy as add_taxonomy', function () {
        $taxonomy = op::param('taxonomy');
        $sql = 'select count(*) count from taxonomy where type=? and name=?';
        $count = op::column($sql, [$taxonomy->type, $taxonomy->name]);

        $json = [];
        $id = -1;

        if ($count == 0) {
            $success = op::transaction(function () use (&$id, $taxonomy) {
                $id = op::create('taxonomy', $taxonomy->to_array());
            });
        } else {
            $success = false;
            $json['note'] = '名称“' . $taxonomy->name . '”已存在！';
        }

        $json['success'] = $success;
        $json['id'] = $id;
        
        op::json($json);
    })->ajax(true);

    op::get('/taxonomy/{id} as get_taxonomy', function ($id) {
        $taxonomy = op::select('taxonomy', $id);

        if (is_null($taxonomy)) {
            $json['success'] = false;
        } else {
            $json['success'] = true;
            $json['taxonomy'] = $taxonomy;
        }

        op::json($json);
    })->ajax(true);    

    op::put('/taxonomy as update_taxonomy', function () {
        $taxonomy = op::param('taxonomy');
        $id = op::param('id');
        $sql = 'select count(*) count from taxonomy where type=? and name=? and id!=?';
        $count = op::column($sql, [$taxonomy->type, $taxonomy->name, $id]);

        $json = [];

        if ($count == 0) {
            $success = op::transaction(function () use ($taxonomy, $id) {
                op::modify('taxonomy', $taxonomy->to_array(), $id);
            });
        } else {
            $success = false;
            $json['note'] = '名称“' . $taxonomy->name . '”已存在！';
        }       

        $json['success'] = $success;
        
        op::json($json);        
    })->ajax(true);

    op::delete('/taxonomy as delete_taxonomy', function () {
        $success = op::transaction(function () {
            op::remove('taxonomy', op::param('id'));
        });

        $json['success'] = $success;
        
        op::json($json);        
    })->ajax(true);

    # post routes

    op::get('/post as admin_posts', function () {
        op::forward('/admin/post/page/1');
    });

    op::get('/post/page/{number} as page_admin_posts', function ($number) {
        $size = op::attr('op.size');
        $paginations = op::paginate([
            'sql' => 'select count(*) count from post p where p.status!=?',
            'params' => ['草稿'],
            'no' => $number,
            'url' => '/admin/post'
        ]);

        $sql = '
            select p.*,
                   t.name,
                   t.text 
              from post p, 
                   taxonomy t 
             where t.id=p.category
               and p.status!=? 
          order by p.sticky desc, 
                   p.created desc
             limit ' . ($number - 1) * $size . ', ' . $size;

        $posts = op::maps($sql, ['草稿']);

        $view_data = [
            'title' => '文章 - 管理后台 - belin_wu.blog {}',
            'active' => 'post',
            'posts' => $posts,
            'paginations' => $paginations
        ];

        op::render('admin/post/list.php', $view_data);
    })->match([
        'number' => '[0-9]+'
    ]);    

    op::get('/draft as drafts', function () {
        op::forward('/admin/draft/page/1');
    });

    op::get('/draft/page/{number} as page_drafts', function ($number) {
        $size = op::attr('op.size');
        $paginations = op::paginate([
            'sql' => 'select count(*) count from post p where p.status=?',
            'params' => ['草稿'],
            'no' => $number,
            'url' => '/admin/draft'
        ]);

        $sql = '
            select p.*,
                   t.name,
                   t.text 
              from post p, 
                   taxonomy t 
             where t.id=p.category
               and p.status=?
          order by p.sticky desc, 
                   p.created desc
             limit ' . ($number - 1) * $size . ', ' . $size;

        $posts = op::maps($sql, ['草稿']);

        $view_data = [
            'title' => '草稿箱 - 管理后台 - belin_wu.blog {}',
            'active' => 'draft',
            'posts' => $posts,
            'paginations' => $paginations
        ];

        op::render('admin/post/list.php', $view_data);
    })->match([
        'number' => '[0-9]+'
    ]);

    op::get('/post/new as new_post', function () {
        $taxonomies = op::keys_maps('select type,id,name,text from taxonomy');

        $view_data = [
            'title' => '写文章 - 管理后台 - belin_wu.blog {}',
            'active' => 'post',
            'tags' => $taxonomies['tag'],
            'categories' => $taxonomies['category'],
            'series' => array_key_exists('series', $taxonomies) ? $taxonomies['series'] : []
        ];

        op::render('admin/post/add.php', $view_data);
    });
        
    op::post('/post/preview as preview_post', function () {
        $post = op::param('post');

        $post['created'] = date('Y-m-d H:i:s');
        $post['year_month'] = date('Y/n');
        $post['content'] = op::markdown($post->content);

        $view_data = [
            'post' => $post
        ];

        op::render('admin/post/preview.php', $view_data);
    })->ajax(true);    

    op::post('/post as add_post', function () {
        $id = -1;
        $post = op::param('post');
        $date = date('Y-m-d H:i:s');

        $post['created'] = $date;
        $post['updated'] = $date;
        $post['year'] = date('Y');
        $post['month'] = date('n');
        $post['html'] = op::markdown($post->content);

        $success = op::transaction(function () use (&$id, $post) {
            $tags = $post->pop('tags');
            $series = $post->pop('series');

            $id = op::create('post', $post->to_array());

            if (isset($tags)) {
                foreach (explode(';', $tags) as $tag) {
                    op::create('post_and_tag', [
                        'post' => $id,
                        'tag' => $tag
                    ]);
                }
            }

            if (isset($series)) {
                foreach (explode(';', $series) as $sery) {
                    op::create('post_and_series', [
                        'post' => $id,
                        'series' => $sery
                    ]);
                }
            }
        });

        $json['success'] = $success;
        $json['id'] = $id;

        op::json($json);
    })->ajax(true);    

    op::get('/post/{id}/edit as edit_post', function ($id) {
        $post = op::select('post', $id);
        if (!$post) { op::error(404); }

        $post = op::arrays($post);
        $post_tags = op::columns('select tag from post_and_tag where post=?', [$id]);
        $post_series = op::columns('select series from post_and_series where post=?', [$id]);
        $taxonomies = op::keys_maps('select type,id,name,text from taxonomy');
        
        $view_data = [
            'title' => '编辑文章 - 管理后台 - belin_wu.blog {}',
            'active' => ($post->status == '草稿') ? 'draft' : 'post',
            'tags' => $taxonomies['tag'],
            'categories' => $taxonomies['category'],
            'series' => array_key_exists('series', $taxonomies) ? $taxonomies['series'] : [],
            'entries_title' => '编辑文章',
            'post' => $post,
            'post_tags' => $post_tags,
            'post_series' => $post_series
        ];

        op::render('admin/post/edit.php', $view_data);
    });

    op::put('/post as update_post', function () {
        $post = op::param('post');
        $id = $post->pop('id');

        $post['html'] = op::markdown($post->content);
        $post['updated'] = date('Y-m-d H:i:s');

        $success = op::transaction(function () use ($id, $post) {
            $tags = $post->pop('tags');
            $series = $post->pop('series');

            op::modify('post', $post->to_array(), $id);

            op::update('delete from post_and_tag where post=?', [$id]);
            op::update('delete from post_and_series where post=?', [$id]);

            if (isset($tags)) {
                foreach (explode(';', $tags) as $tag) {
                    op::create('post_and_tag', [
                        'post' => $id,
                        'tag' => $tag
                    ]);
                }
            }

            if (isset($series)) {
                foreach (explode(';', $series) as $sery) {
                    op::create('post_and_series', [
                        'post' => $id,
                        'series' => $sery
                    ]);
                }
            }            
        });

        $json['success'] = $success;
        $json['id'] = $id;

        op::json($json);
    })->ajax(true);

    op::delete('/post as delete_post', function () {
        $success = op::transaction(function () {
            op::remove('post', op::param('id'));
            op::remove('post_and_tag', op::param('id'), 'post');
        });

        $json['success'] = $success;
        
        op::json($json);        
    })->ajax(true);

    op::get('/logo as logos', function () {
        $dir = dirname(dirname(__DIR__)) . '/public/img/logo';
        $logos = [];

        if ($handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $logos[] = 'http://wujilin.com/img/logo/' . $file;
                }
            }
        }
        
        $view_data = [
            'logos' => $logos
        ];

        op::render('admin/logos.php', $view_data);
    })->ajax(true);
}, [
    'prefix' => '/admin'
]);