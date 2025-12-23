<?php

$this->title = 'Our Team';

$teamInfo = [
    [
        'name' => '管一凡',
        'work' => '设计实现时间线页面、团队页面',
        'files' => [
        'frontend/views/timeline/*', 
        'frontend/controllers/TimelineController.php',
        'frontend/controllers/TeamController.php',
        'frontend/views/team/*',
        'frontend/models/Timeline.php',
        ],
    ],
    [
        'name' => '张瑞宸',
        'work' => '设计实现重大战役页面',
        'files' => [
        'frontend/views/battles/*',
        'frontend/controllers/BattlesController.php',
        'frontend/web/battles/*',
        ],
    ],
    [
        'name' => '叶坤豪',
        'work' => '设计实现词云页面',
        'files' => [
        'frontend/models/WordCloud.php',
        'frontend/controllers/SiteController.php (actionWordcloud)',
        'frontend/views/site/wordcloud.php',
        ],
    ],
    [
        'name' => '李佳泽',
        'work' => '',
        'files' => [],
    ],
];
?>

<div>
    <h1 class="m-5 fs-1">团队</h1>
    <div >
        <?php foreach ($teamInfo as $member): ?>
            <div class="card m-4">
                <div class="card-body">
                    <h5 class="card-title fs-2 m-2"><?= htmlspecialchars($member['name']) ?></h5>
                    <h6 class="card-subtitle fs-4 m-2 text-muted"><?= htmlspecialchars($member['work']) ?></h6>
                    <?php foreach ($member['files'] as $file): ?>
                        <p class="card-text fs-5 m-2"><?= htmlspecialchars($file) ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>