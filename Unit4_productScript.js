function buttonPressed(button){
    var x = button.id;
    var dataString = $("form").serialize();
    if(!document.getElementById("checkBox").checked){
        dataString += '&checkBox=false';
    }
    switch (x) {
        case 'daSubmit':
            dataString += '&type=add';
            alert(dataString);
            break;
        case 'Delete':
            dataString += '&type=delete';
            break;
        case 'Update':
            dataString += '&type=update';
            break;
        default:
            return false;
    }

    $.ajax({
        type: "POST",
        url: "Unit4_ajaxProduct.php",
        data: dataString,
        cache: false,
        success: function(result){
            alert(result);
            document.getElementById("myForm").reset();
        }
});
}