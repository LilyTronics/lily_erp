<div class="dropdown float-end">
<span class="mt-2 me-4 cursor-pointer fs-5" data-bs-toggle="dropdown">{ICON_USER}</span>
<ul class="dropdown-menu">
    <li><a class="dropdown-item theme-hover no-link-color" href="{WEB_ROOT}my-account" {LNK_SHOW_LOADER}>My account</a></li>
    <li><form action="<?php echo WEB_ROOT; ?>api" method="post">
    <input type="hidden" name="on_success" value="" />
    <input type="hidden" name="on_failure" value="" />
    <input type="hidden" name="title" value="Log out" />
    <button class="dropdown-item theme-hover" type="submit" name="action" value="log_out" {BTN_SHOW_LOADER}>Log out</button>
    </form></li>
</ul>
</div>
