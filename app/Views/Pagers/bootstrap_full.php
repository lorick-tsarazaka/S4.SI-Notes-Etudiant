<?php
/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
    <div class="pagination">
        <div class="page-btns">
            <?php if ($pager->hasPrevious()) : ?>
                <a class="page-btn" href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
                    «
                </a>
                <a class="page-btn" href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                    ‹
                </a>
            <?php endif ?>

            <?php foreach ($pager->links() as $link) : ?>
                <a class="page-btn<?= $link['active'] ? ' active' : '' ?>" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            <?php endforeach ?>

            <?php if ($pager->hasNext()) : ?>
                <a class="page-btn" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                    ›
                </a>
                <a class="page-btn" href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
                    »
                </a>
            <?php endif ?>
        </div>
    </div>
</nav>