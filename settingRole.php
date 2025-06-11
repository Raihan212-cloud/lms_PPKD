<?php
function group1()
{
    // 1 instructor
    return ['1'];
}
function group2()
{
    // 5 students
    return ['5'];
}
function group3()
{
    // 3:administrator, 2:admin, 4:PIC
    return ['3', '2', '4'];
}
function role_available()
{
    // 1: instructor 5:students
    return ['1', '5'];
}
// in_array
function canAddModul($role)
{
    if (in_array($role, group1())) {
        return true;
    }
}
