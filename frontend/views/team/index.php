<?php

$this->title = 'Our Team';

$teamHomework = [
    'requirement' => 'https://pan.baidu.com/s/1c1H2bw-99b_1f9TXjCPfzA?pwd=xc5j',
    'design' => 'https://pan.baidu.com/s/1c1H2bw-99b_1f9TXjCPfzA?pwd=xc5j',
    'implement' => 'https://pan.baidu.com/s/1c1H2bw-99b_1f9TXjCPfzA?pwd=xc5j',
    'user_guide' => 'https://pan.baidu.com/s/1c1H2bw-99b_1f9TXjCPfzA?pwd=xc5j',
    'deployment' => 'https://pan.baidu.com/s/1c1H2bw-99b_1f9TXjCPfzA?pwd=xc5j',
    'ppt' => 'https://pan.baidu.com/s/1c1H2bw-99b_1f9TXjCPfzA?pwd=xc5j',
    'video' => 'https://pan.baidu.com/s/1c1H2bw-99b_1f9TXjCPfzA?pwd=xc5j',
];

$teamInfo = [
    [
        'name' => '管一凡',
        'work' => '设计实现时间线页面、团队页面、主页',
        'homework' => 'https://pan.baidu.com/s/1sORO0bbpvBrsXpoCg498Aw?pwd=a68r',
    ],
    [
        'name' => '张瑞宸',
        'work' => '设计实现重大战役页面',
        'homework' => 'https://pan.baidu.com/s/1sORO0bbpvBrsXpoCg498Aw?pwd=a68r',
    ],
    [
        'name' => '叶坤豪',
        'work' => '设计实现词云页面',
        'homework' => 'https://pan.baidu.com/s/1sORO0bbpvBrsXpoCg498Aw?pwd=a68r',
    ],
    [
        'name' => '李佳泽',
        'work' => '设计实现英雄查询页面',
        'homework' => 'https://pan.baidu.com/s/1sORO0bbpvBrsXpoCg498Aw?pwd=a68r',
    ],
];
?>

<div>

    <div class="card m-4">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title fs-2 m-2">烽火记忆</h5>
            <h6 class="card-subtitle fs-4 m-2 text-muted">团队作业文档下载链接</h6>
            <a href="<?= htmlspecialchars($teamHomework['requirement']) ?>" class="card-link fs-4 m-2">需求文档</a>
            <a href="<?= htmlspecialchars($teamHomework['design']) ?>" class="card-link fs-4 m-2">设计文档</a>
            <a href="<?= htmlspecialchars($teamHomework['implement']) ?>" class="card-link fs-4 m-2">实现文档</a>
            <a href="<?= htmlspecialchars($teamHomework['user_guide']) ?>" class="card-link fs-4 m-2">用户手册</a>
            <a href="<?= htmlspecialchars($teamHomework['deployment']) ?>" class="card-link fs-4 m-2">部署手册</a>
            <a href="<?= htmlspecialchars($teamHomework['ppt']) ?>" class="card-link fs-4 m-2">项目PPT</a>
            <a href="<?= htmlspecialchars($teamHomework['video']) ?>" class="card-link fs-4 m-2">项目视频</a>
        </div>
    </div>

    <div >
        <?php foreach ($teamInfo as $member): ?>
            <div class="card m-4">
                <div class="card-body">
                    <h5 class="card-title fs-2 m-2"><?= htmlspecialchars($member['name']) ?></h5>
                    <h6 class="card-subtitle fs-4 m-2 text-muted"><?= htmlspecialchars($member['work']) ?></h6>
                    <a href="<?= htmlspecialchars($member['homework']) ?>" class="card-link fs-4 m-2">个人作业</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>