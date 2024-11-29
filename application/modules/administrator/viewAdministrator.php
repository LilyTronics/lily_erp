<div class="{CONTAINER}">
<p>On these pages you can access and change application settings, view and clear log files,
and make changes directly in the database.</p>
<p>Note that this can break the application or make your
data unusable. Only change something if you know what you are doing.</p>
</div>
<div class="{CONTAINER} border-top">
<h4>Color theme</h4>
<p>Choose a base color below, from that base color all other colors are derived.
When you are happy with the color save it and it will be applied immediately.</p>
</div>
<div class="row g-1">
<div class="col-md-auto {CONTAINER}">
<p>Base color:</p>
<p class="text-center"><input id="color-picker" name="record[color]" class="{INPUT} width-small" type="color" value="#186276" /></p>
<p class="text-center"><span id="color-value"></span></p>
</div>
<div class="col {CONTAINER}">
<p>Preview:</p>
<div class="mx-4 max-width-large border">
<!-- header example -->
<div id="preview-header" class="p-2 clearfix">
<span class="float-start">Lily ERP</span>
<span class="float-end me-2">{ICON_USER}</span>
</div>
<!-- body with table and stuff -->
<div class="p-2 text-small">
<p>Some random page content that has no meaning at all.</p>
<table id="preview-table" class="table-bordered">
<thead><tr><th>first name</th><th>last name</th><th>city</th><th>country</th></tr></thead>
<tbody>
<tr class="cursor-pointer"><td>George</td><td>Corral</td><td>Manchester</td><td>United Kingdom</td></tr>
<tr class="cursor-pointer"><td>Kelvin</td><td>Long</td><td>Phoenix</td><td>United States of America</td></tr>
<tr class="cursor-pointer"><td>James</td><td>Nowak</td><td>West Osbornsville</td><td>United States of America</td></tr>
</tbody>
</table>
<p class="p-3"><button id="preview-button" class="btn btn-sm">Button</button></p>
<p style="position:absolute">
<div id="preview-loader" style="position:relative;top:0px;left:20px;width:50px;height:50px;border:10px solid #eee;border-top:10px solid #000;border-radius:50%;animation:spin 2s linear infinite"></div>
</p>
<p><span id="preview-link" class="cursor-pointer">This is a link.</span></p>
</div>
</div>
</div>
</div>
<script>

'use strict';

function watchColorPicker(event)
{
    document.getElementById('color-value').innerHTML = event.target.value;
    applyColorToExample();
}

function applyColorToExample()
{
    let base_color = document.getElementById('color-picker').value;
    let c = new ColorTheme(base_color);
    // Apply theme
    c.setDivBgColor('preview-header');
    c.setTableColors('preview-table');
    c.setButtonColors('preview-button');
    c.setLoaderColor('preview-loader');
    c.setLinkColor('preview-link');
}

let elm = document.getElementById('color-picker');
elm.addEventListener('change', watchColorPicker, false);
document.getElementById('color-value').innerHTML = elm.value;
applyColorToExample();

</script>
