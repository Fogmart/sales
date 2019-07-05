<?php
function dbc_container_template(){
    return '<div class="breadcrumbs">@loop</div>';
}
function dbc_one_template(){
    return '<a class="breadcrumb" href="@link">@name</a>';
}

function dbc_last_template(){
    return '<span class="breadcrumb">@name</span>';
}
