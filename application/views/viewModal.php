<!-- Modal loader -->
<div id="modal-loader" class="modal" data-bs-backdrop="static">
<div class="modal-dialog" style="top:200px">
<span class="loader"></span>
</div>
</div>
<!-- Modal message -->
<div id="modal-message" class="modal" data-bs-backdrop="static">
<div class="modal-dialog" style="top:200px">
<div class="modal-content">
<div class="modal-header p-2 theme-bg-l1">
<span id="modal-message-title" class="modal-title"></span>
</div>
<div id="modal-message-body" class="modal-body"></div>
<div class="modal-footer p-2">
<button type="button" class="{BUTTON}" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<script>

function showMessage(title, message)
{
    document.getElementById('modal-message-title').innerHTML = title;
    document.getElementById('modal-message-body').innerHTML = message;
    new bootstrap.Modal('#modal-message').show();
}

</script>
