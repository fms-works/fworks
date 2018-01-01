<?php if ($page_num > 1): ?>
  <ul class="col-12 my-4 pagination pagination-sm justify-content-center">
    <li class="page-item<?php if ($page === 1) echo ' disabled'; ?>">
      <a class="page-link" href="index.php" tabindex="-2">&laquo;&laquo;</a>
    </li>
    <li class="page-item<?php if ($page === 1) echo ' disabled'; ?>">
      <a class="page-link" href="index.php?page=<?php echo $page - 1; ?>" tabindex="-1">&laquo;</a>
    </li>
    <?php if ($page >= 3): // 2個前 ?>
      <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page - 2; ?>"><?php echo $page - 2; ?></a></li>
    <?php endif; ?>
    <?php if ($page >= 2): // 1個前 ?>
      <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?></a></li>
    <?php endif; ?>
    <li class="page-item disabled"><a class="page-link"><?php echo $page; ?></a></li>
    <?php if ($page_num - $page >= 1): // 1個後 ?>
      <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?></a></li>
    <?php endif; ?>
    <?php if ($page_num - $page >= 2): // 2個後 ?>
      <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page + 2; ?>"><?php echo $page + 2; ?></a></li>
    <?php endif; ?>
    <li class="page-item<?php if ($page >= $page_num) echo ' disabled'; ?>">
      <a class="page-link" href="index.php?page=<?php echo $page + 1; ?>">&raquo;</a>
    </li>
    <li class="page-item<?php if ($page >= $page_num) echo ' disabled'; ?>">
      <a class="page-link" href="index.php?page=<?php echo $page_num; ?>">&raquo;&raquo;</a>
    </li>
  </ul>
<?php endif; ?>
