<?php

# www module
op::get('/ as home', function () {
    op::forward('/page/1');
});

op::get('/page/{number} as page_posts', function ($number) {
    $size = op::attr('op.size');
    $paginations = op::paginate([
        'sql' => 'select count(*) count from post p where p.status!=?',
        'params' => ['草稿'],
        'no' => $number,
        'url' => ''
    ]);

    $sql = '
        select p.id, p.title, p.year, p.month, p.type, p.created, p.sticky, p.logo,
               t.name, t.text 
          from post p, 
               taxonomy t 
         where t.id=p.category
           and p.status!=?
      order by p.sticky desc, 
               p.created desc
         limit ' . ($number - 1) * $size . ', ' . $size;

    $posts = op::maps($sql, ['草稿']);

    $view_data = [
        'title'      => '首页 - belin_wu.blog {}',
        'active'     => 'home',
        'posts_title' => '文章',
        'posts' => op::arrays($posts),
        'paginations' => $paginations
    ];

    op::render('www/posts.php', $view_data);
})->match([
    'number' => '[0-9]+'
]);

op::get('/{id} as view_post', function ($id) {
    $sql = '
        select p.*,
           t.name,
           t.text
      from post p,
           taxonomy t
     where p.id=?
       and t.id=p.category
       and p.status!=?';
    $post = op::map($sql, [$id, '草稿']);
    if (!$post) { op::error(404); }

    $post = op::arrays($post);

    $sql = '
        select name,
               text 
          from taxonomy t,
               post_and_tag pt 
         where t.id=pt.tag 
           and pt.post=?';
    $tags = op::maps($sql, [$id]);

    $sql = '
        select t.*,
               count(ps.series) count 
          from taxonomy t, 
               post p,
               post_and_series ps 
         where t.id=ps.series
           and p.id=ps.post 
           and p.status!=?
           and exists (select 1 
                         from post_and_series tbl 
                        where tbl.series=ps.series 
                          and tbl.post=?)
        group by ps.series';
    $series = op::maps($sql, ['草稿', $id]);    

    $view_data = [
        'title'      => $post->title . ' - belin_wu.blog {}',
        'breadcrumb' => [
            [
                'url'  => 'http://wujilin.com/category/'. $post->name,
                'text' => $post->text
            ], [
                'url'  => 'http://wujilin.com/' . $id,
                'text' => $post->title
            ]
        ],
        'post' => $post,
        'tags' => $tags,
        'series' => $series
    ];

    $sql = 'select id, title from post where id>? and status!=? order by id asc limit 0, 1';
    $previous_post = op::map($sql, [$id, '草稿']);
    if (!is_null($previous_post)) {
        $view_data['previous_post'] = $previous_post;
    }

    $sql = 'select id, title from post where id<? and status!=? order by id desc limit 0, 1';
    $next_post = op::map($sql, [$id, '草稿']);
    if (!is_null($next_post)) {
        $view_data['next_post'] = $next_post;
    }

    op::render('www/post.php', $view_data);
})->match(['id' => '[0-9]+']);

op::get('/{id}.md as markdown_post', function ($id) {
    $sql = 'select p.content from post p where p.id=? and p.status!=?';
    $content = op::column($sql, [$id, '草稿']);

    if (is_null($content)) { op::error(404); }
    
    op::plan($content);
})->match(['id' => '[0-9]+']);

op::get('/category as categories', function () {
    $sql = '
        select t.*, 
               count(p.category) count 
          from taxonomy t, 
               post p 
         where t.id=p.category 
           and t.type=?
           and p.status!=?
         group by p.category';
    $categories = op::maps($sql, ['category', '草稿']);

    $view_data = [
        'title'      => '分类 - belin_wu.blog {}',
        'active'     => 'category',
        'breadcrumb' => [
            [
                'url'  => 'http://wujilin.com/category',
                'text' => '分类'
            ]
        ],
        'taxonomies' => $categories,
        'taxonomy_text' => '分类',
        'taxonomy_type' => 'category',
        'taxonomy_icon' => 'icon-folder-close',
    ];

    op::render('www/taxonomies.php', $view_data);
});

op::get('/category/{name} as view_category', function ($name) {
    op::forward('/category/' . $name . '/page/1');
});

op::get('/category/{name}/page/{number} as page_category', function ($name, $number) {
    $category = op::map('select * from taxonomy where type=? and name=?', ['category', $name]);
    if (empty($category)) { op::error(404); }

    $category = op::arrays($category);
    $size = op::attr('op.size');

    $paginations = op::paginate([
        'sql' => 'select count(*) count from post p, taxonomy t where p.category=? and p.status!=? and t.id=p.category',
        'params' => [$category->id, '草稿'],
        'no' => $number,
        'url' => '/category/' . $category->name
    ]);

    $sql = '
        select p.*,
               t.name,
               t.text
          from post p,
               taxonomy t
         where p.category=?
           and p.status!=?
           and t.id=p.category
        limit ' . ($number - 1) * $size . ', ' . $size;

    $posts = op::maps($sql, [$category->id, '草稿']);

    $view_data = [
        'title'      => $category->text . ' - 分类 - belin_wu.blog {}',
        'active'     => 'category',
        'breadcrumb' => [
            [
                'url'  => 'http://wujilin.com/category',
                'text' => '分类'
            ], [
                'url'  => 'http://wujilin.com/category/' . $name,
                'text' => $category->text
            ]
        ],
        'posts_title' => '分类: ' . $category->text,
        'posts' => op::arrays($posts),
        'paginations' => $paginations
    ];

    op::render('www/posts.php', $view_data);
})->match([
    'number' => '[0-9]+'
]);

op::get('/series as series', function () {
    $sql =<<<sql
select t.*, 
       count(ps.series) count 
  from taxonomy t, 
       post p,
       post_and_series ps 
 where t.id=ps.series
   and p.id=ps.post
   and p.status!=?
 group by ps.series
sql;

    $series = op::maps($sql, ['草稿']);

    $view_data = [
        'taxonomies' => $series,
        'taxonomy_text' => '系列',
        'taxonomy_type' => 'series',
        'taxonomy_icon' => 'icon-book',        
        'title'      => '系列 - belin_wu.blog {}',
        'active'     => 'series',
        'breadcrumb' => [
            [
                'url'  => 'http://wujilin.com/series',
                'text' => '系列'
            ]
        ]
    ];

    op::render('www/taxonomies.php', $view_data);
});

op::get('/series/{name} as view_series', function ($name) {
    op::forward('/series/' . $name . '/page/1');
});

op::get('/series/{name}/page/{number} as page_series', function ($name, $number) {
    $series = op::map('select * from taxonomy where type=? and name=?', ['series', $name]);
    if (empty($series)) { op::error(404); }

    $series = op::arrays($series);
    $size = op::attr('op.size');
    $paginations = op::paginate([
        'sql' => op::sql('page_series'),
        'params' => [$series->id, '草稿'],
        'no' => $number,
        'url' => '/series/' . $series->name
    ]);

    $sql = '
      select p.*,
             t.name,
             t.text
        from post p,
             taxonomy t,
             post_and_series ps
       where ps.series=?
         and p.id=ps.post
         and t.id=p.category
         and p.status!=?
       limit ' . ($number - 1) * $size . ', ' . $size;

    $posts = op::maps($sql, [$series->id, '草稿']);

    $view_data = [
        'title'      => $series->text . ' - 系列 - belin_wu.blog {}',
        'active'     => 'series',
        'breadcrumb' => [
            [
                'url'  => 'http://wujilin.com/series',
                'text' => '系列'
            ], [
                'url'  => 'http://wujilin.com/series/' . $name,
                'text' => $series->text
            ]
        ],
        'posts_title' => '系列: ' . $series->text,
        'posts' => op::arrays($posts),
        'paginations' => $paginations
    ];

    op::render('www/posts.php', $view_data);
})->match([
    'number' => '[0-9]+'
]);

op::get('/tag as tags', function () {
    $tags = op::maps(op::sql('tags'), ['草稿']);

    $view_data = [
        'title'      => '标签 - belin_wu.blog {}',
        'active'     => 'tag',
        'breadcrumb' => [
            [
                'url'  => 'http://wujilin.com/tag',
                'text' => '标签'
            ]
        ],
        'taxonomies' => $tags,
        'taxonomy_text' => '标签',
        'taxonomy_type' => 'tag',
        'taxonomy_icon' => 'icon-tag',
    ];

    op::render('www/taxonomies.php', $view_data);
});

op::get('/tag/{name} as view_tag', function ($name) {
    op::forward('/tag/' . $name . '/page/1');
});

op::get('/tag/{name}/page/{number} as page_tag', function ($name, $number) {
    $tag = op::map('select * from taxonomy where type=? and name=?', ['tag', $name]);
    if (empty($tag)) { op::error(404); }

    $tag = op::arrays($tag);
    $size = op::attr('op.size');
    $paginations = op::paginate([
        'sql' => op::sql('page_tag'),
        'params' => [$tag->id, '草稿'],
        'no' => $number,
        'url' => '/tag/' . $tag->name
    ]);    

    $sql = '
        select p.*,
               t.name,
               t.text
          from post p,
               taxonomy t,
               post_and_tag pt
         where p.id=pt.post
           and t.id=p.category
           and pt.tag=?
           and p.status!=?
         limit ' . ($number - 1) *$size . ', ' . $size;

    $posts = op::maps($sql, [$tag->id, '草稿']);

    $view_data = [
        'title'      => $tag->text . ' - 标签 - belin_wu.blog {}',
        'active'     => 'tag',
        'breadcrumb' => [
            [
                'url'  => 'http://wujilin.com/tag',
                'text' => '标签'
            ], [
                'url'  => 'http://wujilin.com/tag/' . $name,
                'text' => $tag->text
            ]
        ],
        'posts_title' => '标签: ' . $tag->text,
        'posts' => op::arrays($posts),
        'paginations' => $paginations
    ];

    op::render('www/posts.php', $view_data);
})->match([
    'number' => '[0-9]+'
]);

op::get('/archive as archives', function () {
    $archives = op::keys_maps(op::sql('archives'), ['草稿']);

    $view_data = [
        'title'      => '归档 - belin_wu.blog {}',
        'active'     => 'archive',
        'breadcrumb' => [
            [
                'url'  => 'http://wujilin.com/archive',
                'text' => '归档'
            ]
        ],
        'archives' => $archives
    ];

    op::render('www/archives.php', $view_data);
});

op::get('/archive/{year}/{month} as view_archive', function ($year, $month) {
    op::forward('/archive/' . $year . '/' . $month . '/page/1');
});

op::get('/archive/{year}/{month}/page/{number} as page_archive', function ($year, $month, $number) {
    $size = op::attr('op.size');
    $paginations = op::paginate([
        'sql' => 'select count(*) count from post where year=? and month=? and status!=?',
        'params' => [$year, $month, '草稿'],
        'no' => $number,
        'url' => '/archive/' . $year . '/' . $month
    ]);

    $sql = '
        select p.*,
               t.text,
               t.name 
          from post p,
               taxonomy t
         where year=? 
           and month=?
           and p.status!=?
           and p.category=t.id
         limit ' . ($number - 1) * $size . ', ' . $size;
    $posts = op::maps($sql, [$year, $month, '草稿']);

    $view_data = [
        'title'      => $year . '年' . $month . '月 - 归档 - belin_wu.blog {}',
        'active'     => 'archive',
        'breadcrumb' => [
            [
                'url'  => 'http://wujilin.com/archive',
                'text' => '归档'
            ], [
                'url'  => 'http://wujilin.com/archive/'. $year . '/' . $month,
                'text' => $year . '年' . $month . '月'
            ]
        ],
        'posts_title' => '归档: ' . $year . '年' . $month . '月',
        'posts' => op::arrays($posts),
        'paginations' => $paginations
    ];

    op::render('www/posts.php', $view_data);
})->match([
    'number' => '[0-9]+'
]);

op::get('/about as about', function () {
    $about = op::column(op::sql('about'), ['about']);

    $view_data = [
        'title'      => '关于 - belin_wu.blog {}',
        'active'     => 'about',
        'breadcrumb' => [
            [
                'url'  => 'http://wujilin.com/about',
                'text' => '关于'
            ]
        ],
        'about' => op::markdown($about)
    ];

    op::render('www/about.php', $view_data);
});