<?php include __DIR__ . '/header.php'; ?>

<div class="wjl-entries">
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a><?=$taxonomy_text?></a>
        </div>
    </div>
    <hr />
    <?php for ($i = 0; $i < count($taxonomies); $i++) { ?>
        <?php $taxonomy = $taxonomies[$i]; ?>
        <div class="wjl-entry">
            <div class="wjl-entry-title">
                <i class="<?=$taxonomy_icon?>"></i> 
                <a href="http://wujilin.com/<?=$taxonomy_type?>/<?=$taxonomy['name']?>"><?=$taxonomy['text']?></a>
            </div>
            <div class="wjl-entry-count">
                <span class="badge badge-success"><?=$taxonomy['count']?></span>
            </div>
        </div>
        <hr />
    <?php } ?>
    <br />
    <br />
</div>

<?php include __DIR__ . '/footer.php'; ?>