<div class="dropdown float-end">
<span class="mt-2 me-4 cursor-pointer fs-5" data-bs-toggle="dropdown"><i class="fa-solid fa-user"></i></span>
<ul class="dropdown-menu">
    <li><button class="dropdown-item theme-btn-hover" onclick="location.href='<?php echo WEB_ROOT; ?>my-account'" {SHOW_LOADER}>My account</button></li>
    <li><form action="<?php echo WEB_ROOT; ?>api" method="post">
    <input type="hidden" name="on_success" value="" />
    <input type="hidden" name="on_failure" value="" />
    <input type="hidden" name="title" value="Log out" />
    <button class="dropdown-item theme-btn-hover" type="submit" name="action" value="log_out" {SHOW_LOADER}>Log out</button>
    </form></li>
</ul>
</div>
