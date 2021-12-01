$(document).ready(function(){
    $("#submit").click(function(e){
        e.preventDefault(); 
        var dataString = $("form").serialize();

        var firstName = $("#name").val();
        var imageName = $("#secondname").val();
        var email = $("#email").val();
        var amount = $("#Quantity").val();
        var productID = $("#selection").val();
        var selected = $('#options option:selected').val()
        var quantity = document.getElementById("quantity").value; //jquery code wasn't working
        var timestamp = $("#timestamp").val();

        var check = 0;

        var difference = quantity - amount;

        var combo = document.getElementById("drinks");

        if(firstName=='' || lastName=='' ||email==''){
            alert("Please fill out all the fields");
            check += 1;
        }

        if(combo.selectedIndex <=0){
            alert("Please select a product");
            check += 1;
        }

        else if(difference < 0){
            alert("Sorry there are only " + quantity + " left you tried to order " + amount);
            check += 1;
        }

        if (check == 0){
            // AJAX Code To Submit Form.
            $.ajax({
                    type: "POST",
                    url: "Unit4_ajaxsubmit.php",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        document.getElementById("cusTable").innerHTML = result;
                        document.getElementById("myForm").reset();
                    }
            });
        }
        return false;
    });
});

function buttonPressed(button){
    alert(button.id)
}