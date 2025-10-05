<?php if (isset($DATA) && !is_null($DATA) && $DATA): ?>
  <div class="error-box">
    <img src="/assets/error.svg" height="20">
    <span class="flex-1">
      <?= $DATA ?>
    </span>
  </div>
<?php endif; ?>
