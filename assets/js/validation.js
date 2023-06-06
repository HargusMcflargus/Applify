$('#firstname').on('input', ()=>{
    if (/[^a-zA-Z \t]+/.test($('#firstname').val())){
        $('#firstname').val('');
        toastr.error("Invalid First name, Please Try Again");
        $('#firstname').addClass('is-invalid');
    }
    else{
        $('#firstname').removeClass('is-invalid');
    }
});
$('#middlename').on('input', (object)=>{
    if ( /[^a-zA-Z ]+/.test($('#middlename').val())){
        $('#middlename').val('');
        toastr.error("Invalid Middle Name, Please Try Again");
        $('#middlename').addClass('is-invalid');
    }
    else{
        $('#middlename').removeClass('is-invalid');
    }
});
$('#lastname').on('input', (object)=>{
    if (/[^a-zA-Z ]+/.test($('#lastname').val())){
        $('#lastname').val('');
        toastr.error("Invalid Last name, Please Try Again");
        $('#lastname').addClass('is-invalid');
    }
    else{
        $('#lastname').removeClass('is-invalid');
    }
});
$('#phonenumber').on('change', (object)=>{
    if (/[0-9]{3}-[0-9]{3}-[0-9]{4}$/.test($('#phonenumber').val()) == false){
        $('#phonenumber').val('');
        toastr.error("Please Follow the specified contact number format");
        $('#phonenumber').addClass('is-invalid');
    }
    else{
        $('#phonenumber').removeClass('is-invalid');
    }
});
function format(input, format, sep) {
    var output = "";
    var idx = 0;
    for (var i = 0; i < format.length && idx < input.length; i++) {
        output += input.substr(idx, format[i]);
        if (idx + format[i] < input.length) output += sep;
        idx += format[i];
    }

    output += input.substr(idx);

    return output;
}

$('#phonenumber').on("input", function() {
    var foo = $(this).val().replace(/-/g, ""); // remove hyphens
    // You may want to remove all non-digits here
    // var foo = $(this).val().replace(/\D/g, "");

    if (foo.length > 0) {
        foo = format(foo, [3, 3, 4], "-");
    }

    
    $(this).val(foo);
});
$('#userReg').on('change', ()=>{
    if (/[^a-zA-Z0-9-._@#]/.test($('#userReg').val())){
        $('#userReg').val('');
        toastr.error("Invalid Character Found in userReg");
        $('#userReg').addClass('is-invalid');
        $('#userReg').removeClass('is-valid');
    }
    else if($('#userReg').val().length < 8 || $('#userReg').val().length > 24){
        $('#userReg').val('');
        toastr.error("Username Must be 8-24 characters only");
        $('#userReg').addClass('is-invalid');
        $('#userReg').removeClass('is-valid');
    }
    else{
        $('#userReg').removeClass('is-invalid');
        $('#userReg').addClass('is-valid');
    }
});
$('#passReg').on('change', ()=>{
    if ( /^(.{0,7}|[^0-9]*|[^A-Z]*|[^a-z]*|[a-zA-Z0-9]*)$/.test($('#passReg').val())){
        toastr.error("Password Must have 1 Upper Case Letter, 1 number, and 1 Special character");
        $('#passReg').addClass('is-invalid');
        $('#passReg').remove('is-valid');
        $('#confirmPassword').prop('readonly', true);
    }
    else if($('#passReg').val().length < 8 || $('#passReg').val().length > 16){
        toastr.error("passReg Must be 8-16 characters only");
        $('#passReg').addClass('is-invalid');
        $('#passReg').removeClass('is-valid');
        $('#confirmPassword').prop('readonly', true);
    }
    else{
        $('#passReg').removeClass('is-invalid');
        $('#passReg').addClass('is-valid');
        $('#confirmPassword').prop('readonly', false);
    }
});
$('#confirmPassword').on('change', ()=>{
    if(!($('#passReg').val() == $('#confirmPassword').val())){
        toastr.error("Confirm Password does not match");
        $('#confirmPassword').addClass('is-invalid');
        $('#confirmPassword').removeClass('is-valid');
    }
    else{
        $('#confirmPassword').removeClass('is-invalid');
        $('#confirmPassword').addClass('is-valid');
    }
});