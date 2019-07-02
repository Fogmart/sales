<?php
function dbc_container_template(){
    return '<div>@loop</div>';
}
function dbc_one_template(){
    return '<div><a href="@link">@name</a></div> >';
}

function dbc_last_template(){
    return '<div class="last_elem">@name</div>';
}
