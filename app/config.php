<?php
# db
op::attr('db.dsn', 'mysql:dbname=dbname;host=127.0.0.1');
op::attr('db.username', 'username');
op::attr('db.password', 'password');
op::attr('db.options', [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
]);
op::attr('op.size', 16);
date_default_timezone_set('PRC');
# attr
op::attr('op.debug', false);
op::attr('op.views', __DIR__ . '/view/');
op::attr('op.404', 'www/404.php');
op::attr('op.500', 'www/500.php');
# sql
op::sql('about', 'SELECT value FROM meta WHERE name=?');
op::sql('archives', 'SELECT year, month, COUNT(*) count FROM post WHERE status!=? GROUP BY year, month ORDER BY year DESC, month ASC');
op::sql('page_tag', 'SELECT count(*) count FROM post p, taxonomy t, post_and_tag pt WHERE p.id=pt.post AND t.id=p.category AND pt.tag=? AND p.status!=?');
op::sql('page_series', 'SELECT count(*) count FROM post p, taxonomy t, post_and_series ps WHERE p.id=ps.post AND t.id=p.category AND ps.series=? AND p.status!=?');
op::sql('tags', 'select t.*,
       count(pt.tag) count 
  from taxonomy t, 
       post p,
       post_and_tag pt 
 where t.id=pt.tag
   and p.id=pt.post
   and p.status!=?
 group by pt.tag');