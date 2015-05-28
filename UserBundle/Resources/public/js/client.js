function togglePassword() {
    
    
    
    var obj1 = document.getElementById('dusk_user_edit_plainPassword_first');
    var obj2 = document.getElementById('dusk_user_edit_plainPassword_second');
    var obj3 = document.getElementById('form_password');
    
    if (obj1.type == 'text') {
        obj1.type = 'password';
        obj2.type = 'password';
        obj3.type = 'password'
    } else {
        obj1.type = 'text';
        obj2.type = 'text';
        obj3.type = 'text';
    }
    
}

function regPassword() {
    var obj4 = document.getElementById('fos_user_registration_form_plainPassword_first');
    var obj5 = document.getElementById('fos_user_registration_form_plainPassword_second');
    
    if (obj4.type == 'text') {
        obj4.type = 'password';
        obj5.type = 'password';
    } else {
        obj4.type = 'text';
        obj5.type = 'text';
    }
}
function toggleUPassword() {
    var obj = document.getElementById('form_password');
    if (obj.type == 'text') {
        obj.type = 'password';
    } else {
        obj.type = 'text';
    }
}