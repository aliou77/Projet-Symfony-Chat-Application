// all ajax requests
// setInterval(() => {
//     console.log(document.readyState)
// }, 100);
// if(document.readyState == 'interactive'){
//     console.log("internactive")
// }



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
                    // appliquer le layout chat section apres une recherche
                    chatSectionLayout()
                }else if(res.status == "not-found"){
                    $(content).html("<p style='text-align: center;'>User Not Found !</p>")
                }
            }
        });
    })
    
    
// ------------------------------------------------------------

    // message section ajax 
    function chatSectionLayout(){
        const get_started = $("div.get-started")
        const user_chat = $("section.user-chat")
        // console.log("avant click: "+chat_section)
        $("#contact div.contact a").each(function(i, item){
            $(item).on("click", function(e){
                e.preventDefault()
                const url = $(this).attr('href')
                get_started.css('display', 'none')
                // effet de chargement
                user_chat.html('<div style="display: flex; justify-content: center;"><div id="loader"></div></div>')
                user_chat.addClass('active')
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "",
                    dataType: "JSON",
                    success: function (res) {
                        if(res.status == 'success'){
                            user_chat.removeClass('active')
                            user_chat.html(res.content)
                            $("div.chat-section").css('display', 'block')
                            // $("form#form-chat").children('input[type="text"]').focus()
                            // renvoie le user au bottom de la discussion
                            goToBottom()
                            // active la feat du modal
                            showModal($(".chat-section .icons .more"), $(".chat-section #close-profile"))
                            // envoie le form du chat en ajax
                            sendChatForm() 
                            // charger le chat body
                            var loader;
                            // const interval = setInterval(bodyChatLoading, 3000)
                            // loader = interval
                            // $("form#form-chat").children('input[type="text"]').focusout((e)=>{
                            //     const interval = setInterval(bodyChatLoading, 3000)
                            //     loader = interval
                            // })
                            // $("form#form-chat").children('input[type="text"]').on('focus', (e)=>{
                            //     clearInterval(loader)
                            // })
                            
                            
                        }
                    }
                });
            })

        }) 
    }

    // lorsqu'il n'y a pas de rechercher
    chatSectionLayout()

    

    function bodyChatLoading(){
        const r_id = $("form#form-chat").children("input#to").val(),
            s_id = $("form#form-chat").children("input#from").val(),
            data = {r_id: r_id, s_id: s_id}

        // console.log(r_id, s_id)
        if($("form#form-chat")){
            $.ajax({
                type: "POST",
                url: "http://localhost:8081/body-chat",
                data: {
                    data: data
                },
                dataType: "json",
                success: function (res) {
                    // console.log(res)
                    $("div.body").html(res.content)
                    goToBottom()
                }
            });
        }
        
    }
    // send messages on the chat section
   function sendChatForm(){
        $("form#form-chat").on("submit", function(e){
            e.preventDefault()
            const datas = $(this).serializeArray()
            $('form#form-chat input[type="text"]').val('')
            // $("div.body").append('<div class="send"><p class="loading-msg"><span></span><span></span><span></span></p></div>')
            // goToBottom()
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: datas,
                dataType: "JSON",
                success: function (res) {
                    // console.log(res)
                    if(res.status == "success"){

                        // $("div.body div.send").each(function(i, div){
                        //     if($(div).children('p').hasClass('loading-msg')){
                        //         $(div).html(res.content)
                        //     }
                        // })
                        // $("div.body").append(res.content)
                        bodyChatLoading() // refraish body chat
                        goToBottom()
                    }
                }
            });

        })

    }

    // move the body chat to the bottom
    function goToBottom(){
        const body = document.querySelector("div.body")
        body.scrollTop = body.scrollHeight
    }

    function showModal(icon, close){
       $(icon).on("click", function(){
           $("#modal-user").addClass("active")
       })

       $(close).on("click", function(){
           $("#modal-user").removeClass("active")
       })
   }



   

//    console.log(document.readyState)

        
})