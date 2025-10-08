<!-- TODO: mvc coins and fomratted post time  isn't set yet -->

<?php $post = $DATA; ?>

<li class="post-item">
  <div><a class="title" href="/post?id=<?= $post->id ?>"><?= htmlspecialchars($post->title) ?></a></div>
  <div class="info">
    <span><?= 0 ?> mvccoins </span>
    <a href="/user?id=<?= $post->owner_id ?>"><?= htmlspecialchars($post->owner_name ?? "<Deleted user>") ?></a>
    <span><?= $post->get_ftime(); ?></span>
  </div>
</li>
