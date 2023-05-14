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

    // search form contact focus
    $("form.contact").children('svg').click(function(e){
        $("form.contact").children("input").focus()
    })

    // search form contact 
    $("form.contact").submit((e)=>{
        e.preventDefault()
    })
    $("form.contact").on("keyup", function(){
        const url = $(this).attr("action")
        const data = $(this).children('input').val()
        const content = $("#contact .contacts-content")
        // console.log(content)
        $.ajax({
            type: "GET",
            url: url,
            data: {
                searchTerm: data
            },
            dataType: "json",
            success: function (res) {
                // console.log(res)
                if(res.status == "success"){
                    $(content).html(res.content)
                }else if(res.status == "not-found"){
                    $(content).html("<p style='text-align: center;'>User Not Found !</p>")
                }
            }
        });
    })
    // console.log()
})