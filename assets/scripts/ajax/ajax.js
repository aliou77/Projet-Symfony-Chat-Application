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
        var bool = true;
        // verification des champs
        $('#form-setting input').each(function(i, input){
            if($(this).prop('type') == 'text' || $(this).prop('type') == 'email'){
                if($(this).val() == ''){
                    $(this).css('border-color', 'red').css("background-color", "#ff000080")
                    bool = false;
                }  
            }
        })
        // si aucun champs n'est vide on send le form
        if(bool){
            const data = new FormData(this)
            $.ajax({
                type: "POST",
                url: action,
                data: data,
                dataType: "json",
                mimeType: "multipart/form-data",
                processData: false,
                contentType: false,
                success: function (response) {
                    // console.log(response)
                    if(response.status == "success"){    
                        location.reload()                
                        setFlash($("#success"), response)
                        // setField(this, response.user)
                    }else if(response.status == "failed"){
                        setFlash($("#failed"), response)
                    }
                }
            });
        }
        

    })

    async function sendUserDatas(url, data){
        const res = await fetch(url, {
            headers: {
                'X-Requested-Width': 'XMLHttpRequest'
            },
            method: "POST",
            body: data,
        })
        if(res.ok){
            const data = await res.json()
            console.log(data)
        }
    }

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
    formSearch($("form.contact"), $("#contact .contacts-content"));

    /**
     * send search terme to the php controller to get results for contacts
     * @param {HTMLElement} form the search form
     * @param {HTMLElement} container the container where result will be push in
     */
    function formSearch(form, container, links){
        $(form).submit((e)=>{
            e.preventDefault()
        })
        $(form).on("keyup", function(){
            const url = $(this).attr("action")
            const data = $(this).children('input').val()
            const content = $(container);
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
                        chatSectionLayout(links)
                    }else if(res.status == "not-found"){
                        $(content).html("<p style='text-align: center;'>User Not Found !</p>")
                    }
                }
            });
        })

    }
    
    
    
    
// -----------------------------------------------------------

    // search form messages focus
    $("form.message").children('svg').click(function(e){
        $("form.message").children("input").focus()
    })


// ------------------------------------------------------------

    // message section ajax 
    /**
     * layout the chat section when the connected click on a contact or message and include 
     * results of searches
     * @param {HTMLElement} links 
     */
    function chatSectionLayout(links){

        const get_started = $("div.get-started")
        const user_chat = $("section.user-chat")
        // console.log("avant click: "+chat_section)
        $(links).each(function(i, item){
            $(item).on("click", function(e){
                e.preventDefault()
                e.stopPropagation()
                const url = $(this).attr('href')
                get_started.css('display', 'none')
                // effet de chargement
                user_chat.html('<div class="loader-content active"><div id="loader"></div></div>')
                if(document.body.offsetWidth <= 885){
                    $(".loader-content").addClass('active')
                }else{
                    $(".loader-content").removeClass('active')
                }
                // user_chat.addClass('active').css('display', 'flex').css('align-items', 'center').css("justify-content", 'center')
                
                // retire le margin-top du main pour eviter que les tas-contents se voie en bas de page
                $("main.main-content").css('margin-top', '0')
                
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "",
                    dataType: "JSON",
                    success: function (res) {
                        // console.log(res)
                        if(res.status == 'success'){
                            user_chat.removeClass('active').css('display', 'block')
                            user_chat.html(res.content)
                            $("div.chat-section").css('display', 'block')
                            // $("form#form-chat").children('input[type="text"]').focus()
                            // renvoie le user au bottom de la discussion
                            goToBottom()
                            // active la feat du modal
                            showModal($(".chat-section .icons .more"), $(".chat-section #close-profile"))
                            // envoie le form du chat en ajax
                            sendChatForm($("form#form-chat")) 
                            
                            
                            // cache la chat-section apres un click sur la flex
                            $("div.chat-section .show-hide-arrow-chat").click(function(){
                                $("div.chat-section").css('display', 'none')
                                // rajoute le margin-top du main pour afficher les tabs-contents
                                $("main.main-content").css('margin-top', '4.5rem')
                            })
                            // emoji generation
                            createEmoji()

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

    // when click on links without search form contact submit
    chatSectionLayout($("#contact div.contact a"))
    chatSectionLayout($("#message div.all-users a"))

    // create emojies
    function createEmoji(){

        for (let i = 0; i < 80; i++) {
            var emoji = 128512
            $("div#emoji-section ul").append('<li data-code="'+(emoji + i)+'">&#'+ (emoji + i) +';</li>')
            
        }
        $("div#emoji-section ul").append('<li data-code="'+(129392)+'">&#129392;</li>')
        $("div#emoji-section ul").append('<li data-code="'+(129393)+'">&#129393;</li>')
        $("div#emoji-section ul").append('<li data-code="'+(129395)+'">&#129395;</li>')
        $("div#emoji-section ul").append('<li data-code="'+(129396)+'">&#129396;</li>')
        $("div#emoji-section ul").append('<li data-code="'+(129397)+'">&#129397;</li>')
        $("div#emoji-section ul").append('<li data-code="'+(129398)+'">&#129398;</li>')
        $("div#emoji-section ul").append('<li data-code="'+(129402)+'">&#129402;</li>')
        $("div#emoji-section ul").append('<li data-code="'+(129488)+'">&#129488;</li>')
        $("div#emoji-section ul").append('<li data-code="'+(129489)+'">&#129489;</li>')
        for (let i = 0; i < 59; i++) { 
            var emoji = 129295
            $("div#emoji-section ul").append('<li data-code="'+(emoji + i)+'">&#'+ (emoji + i) +';</li>')
            
        }
        $("div#emoji-section ul").append('<li data-code="'+(129505)+'">&#129505;</li>')
        $("div#emoji-section ul").append('<li data-code="'+(129489)+'">&#129489;</li>')
        $("div#emoji-section ul").append('<li data-code="'+(129467)+'">&#129467;</li>')

        // event click to show up emojis
        $("div.footer #emoji").on('click', function(e){
            $("div#emoji-section").toggleClass('active')
            $(this).parent().css('overflow', '')
            if($("div#emoji-section").hasClass('active')){
                $(".footer div.form-chat-container").css('overflow', 'visible')
            }else{
                $(".footer div.form-chat-container").css('overflow', 'hidden')
            }
        })
        $("#emoji-close").on("click", ()=>{
            $("div#emoji-section").removeClass("active")
            $(".footer div.form-chat-container").css('overflow', 'hidden')
        })

        

        // insert emoji in the input chat
        $("div#emoji-section ul li").each(function(i, li){
            $(li).on("click", (e)=>{
                const input = $('#form-chat input[type="text"]')
                input.val($(input).val() +" "+li.innerHTML)
            })
        })

    }

    function bodyChatLoading(){
        const r_id = $("form#form-chat").children("input#to").val(),
            s_id = $("form#form-chat").children("input#from").val(),
            data = {r_id: r_id, s_id: s_id}

        // console.log(r_id, s_id)
        if($("form#form-chat")){
            $.ajax({
                type: "POST",
                url: "http://localhost:10200/body-chat",
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
   function sendChatForm(form){
       
        $(form).on("submit", function(e){
            e.preventDefault()
            // verify if input has a content before sending form
            if($(this).children('input[type="text"]').val() == ''){
                $(this).children('input[type="text"]').css("border-color", "red")
            }else{
                chatFormAjax(this)
                $(this).children('input[type="text"]').css("border-color", "transparent")
            }
        })

        $("span#send").on("click", (e)=>{
            if($(form).children('input[type="text"]').val() == ''){
                $(form).children('input[type="text"]').css("border-color", "red")
            }else{
                chatFormAjax(form)
                $(form).children('input[type="text"]').css("border-color", "transparent")
            }
        })
        $(form).children('input[type="text"]').on('focus', function(){
            $(this).css("border-color", "transparent")
        })
        
    }

    function chatFormAjax(form){
        // verify if input has a content before sending form
        const datas = $(form).serializeArray()
        $('form#form-chat input[type="text"]').val('')
        // $("div.body").append('<div class="send"><p class="loading-msg"><span></span><span></span><span></span></p></div>')
        // goToBottom()
        $.ajax({
            type: "POST",
            url: $(form).attr('action'),
            data: datas,
            dataType: "JSON",
            success: function (res) {
                console.log(res)
                if(res.status == "success"){
                    bodyChatLoading() // refraish body chat
                    goToBottom()
                }
            }
        });
    }

    // send audio fonctionnality
    async function sendAudio(micro, pause, play, send){
        // demande l'authorisation de prendre la main sur les feat audio et video
        // return une Promesse
        const divice = navigator.mediaDevices.getUserMedia({audio: true}) // , video: true

        // utilisation de function flecher
        let chunks = []
        let recorder;
        divice.then(stream => {{
            // when got stream we can recoder (stream is like a permission)
            recorder = new MediaRecorder(stream)

            // visualize(stream);
            // when recordering will finish we send it via ajax
            if(recorder.state == 'inactive'){
                let blob = new Blob(chunks, {type: 'audio/webm'})
                // $("#audio").prop('src', URL.createObjectURL(blob))
                let recor = URL.createObjectURL(blob)
                const audio = '<audio src="'+ recor +'" type="audio/webm" controls></audio>';
                
            }

            // start recording
            // design for send audio icon
            $(micro).on("click", function(e){
                console.log("micro")
                $(send).css('display', 'block')
                $(pause).css('display', 'block')
                $(play).css('display', 'block')
                $(this).css('animation', '2s toggleColor ease infinite')
                
                recorder.start()
                
            })
            $(send).click(function(e){
                recorder.stop()
            })


            recorder.ondataavailable = e =>{
                chunks.push(e.data)
            }

            // var timeout;
            // timeout = setTimeout(()=>{
            //     recorder.start()
            // }, 100)
            

            
            // recorder.start(1000);
            // recorder.pause()
            // console.log(stream) // return un mediaStrem if user autorise audio uses
        }})
        
    }
    
    // sendAudio()

    // design for send audio icon
    

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