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
<div class="modal-header p-2 theme-bg-light">
<span id="modal-message-title" class="modal-title"></span>
</div>
<div id="modal-message-body" class="modal-body"></div>
<div class="modal-footer p-2">
<button type="button" class="{BUTTON}" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<!-- Modal confirm -->
<div id="modal-confirm" class="modal" data-bs-backdrop="static">
<div class="modal-dialog" style="top:200px">
<div class="modal-content">
<div class="modal-header p-2 text-bg-danger">
<span id="modal-confirm-title" class="modal-title"></span>
</div>
<div id="modal-confirm-body" class="modal-body"></div>
<div class="modal-footer p-2">
<button type="button" class="{BUTTON}" data-bs-dismiss="modal">No</button>
<button id="modal-confirm-btn-yes" type="button" class="{BUTTON_RED}" data-bs-dismiss="modal">Yes</button>
</div>
</div>
</div>
</div>
<script>

'use strict';


function showLoader()
{
    new bootstrap.Modal('#modal-loader').show();
}

function showMessage(title, message)
{
    document.getElementById('modal-message-title').innerHTML = title;
    document.getElementById('modal-message-body').innerHTML = message;
    new bootstrap.Modal('#modal-message').show();
}

function showConfirm(title, message, callback)
{
    document.getElementById('modal-confirm-title').innerHTML = title;
    document.getElementById('modal-confirm-body').innerHTML = message;
    document.getElementById('modal-confirm-btn-yes').addEventListener('click', callback);
    new bootstrap.Modal('#modal-confirm').show();
}

</script>
