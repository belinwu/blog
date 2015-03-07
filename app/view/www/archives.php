<?php include __DIR__ . '/header.php'; ?>

<div class="wjl-entries">
    <div class="wjl-entries-header">
        <div class="wjl-entries-title">
            <a>归档</a>
        </div>
    </div>
    <hr />
    <?php foreach ($archives as $year => $archive_list) { ?>
        <div class="wjl-archive">
            <a><?=$year?>年</a>
        </div>
        <hr />
        <?php foreach ($archive_list as $archive) { ?>
            <?php $archive = Op::arrays($archive); ?>
            <div class="wjl-entry">
                <div class="wjl-entry-title">
                    <i class="icon-calendar"></i> 
                    <a href="http://wujilin.com/archive/<?=$archive->year?>/<?=$archive->month?>"><?=$archive->month?>月</a>
                </div>
                <div class="wjl-entry-count">
                    <span class="badge badge-success"><?=$archive->count?></span>
                </div>
            </div>
            <hr />
        <?php } ?>
    <?php } ?>
    <br />
    <br />
</div>

<?php include __DIR__ . '/footer.php'; ?>