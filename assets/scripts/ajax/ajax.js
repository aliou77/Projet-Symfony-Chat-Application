// all ajax requests

// $("#success").fadeOut(3000)
$(document).ready(()=>{
    $("#form-setting").on("submit",function(e){
        e.preventDefault()
        const action = $(this).attr("action")
        $.ajax({
            type: "POST",
            url: action,
            data: $(this).serializeArray(),
            dataType: "json",
            success: function (response) {
                if(response.status == "success"){    
                    location.reload()                
                    setFlash($("#success"), response)
                    // setField(this, response.user)
                }else if(response.status == "failed"){
                    setFlash($("#failed"), response)
                }
            }
        });
        

    })

    function setFlash(element, data){
        element.attr('id', data.status)
        element.html("<p>"+data.message+"</p>")
        element.fadeIn().fadeOut(5000)
    }

    function setField(form, data){
        $(form).children("#fname").val(data.fname)
        $(form).children("#lname").val(data.lname)
        $(form).children("#email").val(data.email)
        $(form).children("#description").val(data.description)
    }
})