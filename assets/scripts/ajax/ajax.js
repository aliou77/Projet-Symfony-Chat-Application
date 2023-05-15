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
// ------------------------------------------------------------

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
// ------------------------------------------------------------

    // message section ajax 
    const get_started = $("div.get-started")
    const user_chat = $("section.user-chat")
    // console.log("avant click: "+chat_section)
    $("#contact div.contact a").each(function(i, item){
        $(item).on("click", function(e){
            e.preventDefault()
            const url = $(this).attr('href')
            get_started.css('display', 'none')
            $.ajax({
                type: "POST",
                url: url,
                data: "",
                dataType: "JSON",
                success: function (res) {
                    if(res.status == 'success'){
                        user_chat.html(res.content)
                        $("div.chat-section").css('display', 'block')
                        // renvoie le user au bottom de la discussion
                        const body = document.querySelector("div.body")
                        body.scrollTop = body.scrollHeight
                        // active la feat du modal
                        showModal($(".chat-section .icons .more"), $(".chat-section #close-profile"))
                        // envoie le form du chat en ajax
                        sendChatForm()

                    }
                }
            });
        })

    }) 

    function showModal(icon, close){
       $(icon).on("click", function(){
           $("#modal-user").addClass("active")
       })

       $(close).on("click", function(){
           $("#modal-user").removeClass("active")
       })
   }

   // send messages on the chat section
   function sendChatForm(){

        $("form#form-chat").on("submit", function(e){
            e.preventDefault()
            const datas = $(this).serializeArray()
            $('form#form-chat input[type="text"]').val('')
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: datas,
                dataType: "JSON",
                success: function (res) {
                    // console.log(res)
                    if(res.status == "success"){
                        // console.log(res)
                    }
                }
            });

        })

        // console.log($("form#form-chat"))
   }

   
        
})