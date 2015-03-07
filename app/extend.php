<?php 

# wallpaper roller service.

op::extend('wallpaper', function () {
    return date('j');
});

# markdown transform service.

op::extend('markdown', function ($text) {
    $parser = op::object('parsedown');

    if (is_null($parser)) {
        $parser = new ParsedownExtra();
        op::object('parsedown', $parser);
    }

    return $parser->text($text);
});

op::extend('db', function () {
    static $crude = null;

    if (is_null($crude)) {
        $db = \Op::attr('db');
        if (!isset($db)) { 
            throw new \Exception('数据库连接参数未配置，无法进行数据库操作！');
        }
        $crude = new Crude($db->to_array());
    }

    return $crude;
});

op::extend('sql', function ($name, $sql = null) {
    if (is_null($sql)) {
        return op::attr('op.sql.' . $name);
    }
    op::attr('op.sql.' . $name, $sql);
});

/**
 * $options = [
 *     'sql' => ,
 *     'params' => [],
 *     'no' => ,
 *     'url' =>
 * ]
 */
op::extend('paginate', function ($options) {
    $row_count = op::column($options['sql'], $options['params']); // 总记录数
    $page_size = op::attr('op.size'); // 每页记录数
    $page_count = ceil($row_count / $page_size); // 总页数
    $page_no = $options['no']; // 当前页码

    if ($page_count == 0) {
        return [];
    }

    if ($page_no > $page_count) {
        op::error(404);
    }

    $paginations = [];
    $base_url = 'http://wujilin.com' . $options['url'];
    $i = 0;
    $breakpage = 5;
    $position = 2;
    $breakspace = 2;
    $maxspace = 3;
    $prev_len = $page_no < $position + 1 ? 1 : $page_no - $position;
    $next_len = $page_no + $position > $page_count ? $page_count : $page_no + $position;

    $paginations[] = ($page_no == 1) ? 
        '<li class="disabled"><a>&laquo; 上一页</a></li>' : 
        '<li><a href="' . $base_url . (($page_no == 2) ? '' : '/page/' . ($page_no - 1)) . '">&laquo; 上一页</a></li>';

    if ($prev_len - $breakspace > $maxspace) {
        for ($i = 1; $i <= $breakspace; $i++) {
            $paginations[] = '<li><a href="' . $base_url . (($i == 1) ? '' : '/page/' . $i) . '">' . $i . '</a></li>';
        }

        $paginations[] = '<li class="disabled"><a>...</a></li>';

        for ($i = $page_count - $breakpage + 1; $i < $prev_len; $i++) {
            $paginations[] = '<li><a href="' . $base_url . (($i == 1) ? '' : '/page/' . $i) . '">' . $i . '</a></li>';
        }
    } else {
        for ($i = 1; $i < $prev_len; $i++) {
            $paginations[] = '<li><a href="' . $base_url . (($i == 1) ? '' : '/page/' . $i) . '">' . $i . '</a></li>';
        }
    }

    for ($i = $prev_len; $i <= $next_len; $i++) {
        $paginations[] = ($page_no == $i) ? 
            '<li class="active"><a>' . $i . '</a></li>' : 
            '<li><a href="' . $base_url . (($i == 1) ? '' : '/page/' . $i) . '">' . $i . '</a></li>';
    }

    if ($page_count - $breakspace - $next_len + 1 > $maxspace) {
        for ($i = $next_len + 1; $i <= $breakpage; $i++) {
            $paginations[] = '<li><a href="' . $base_url . (($i == 1) ? '' : '/page/' . $i) . '">' . $i . '</a></li>';
        }
        
        $paginations[] = '<li class="disabled"><a>...</a></li>';

        for ($i = $page_count - $breakspace + 1; $i <= $page_count; $i++) {
            $paginations[] = '<li><a href="' . $base_url . (($i == 1) ? '' : '/page/' . $i) . '">' . $i . '</a></li>';
        }
    } else {
        for ($i = $next_len + 1; $i <= $page_count; $i++) {
           $paginations[] = '<li><a href="' . $base_url . (($i == 1) ? '' : '/page/' . $i) . '">' . $i . '</a></li>';
        }
    }

    $paginations[] = ($page_no == $page_count || $page_count == 1) ? 
        '<li class="disabled"><a>下一页 &raquo;</a></li>' : 
        '<li><a href="' . $base_url . '/page/' . ($page_no + 1) . '">下一页 &raquo;</a></li>';

    return $paginations;
});

op::extend('parse_image', function ($file) {
    $path = './img/' . $file;
    $type = getimagesize($path);//取得图片的大小，类型等 
    $fp = fopen($path, "r") or die("Can't open file");  
    $file_content = chunk_split(base64_encode(fread($fp, filesize($path))));//base64编码 
    switch($type[2]){//判读图片类型 
        case 1:$img_type="gif";break;  
        case 2:$img_type="jpg";break;  
        case 3:$img_type="png";break;  
    }  
    $img = 'data:image/'.$img_type.';base64,'.$file_content;//合成图片的base64编码 
    fclose($fp);
    return $img;
});