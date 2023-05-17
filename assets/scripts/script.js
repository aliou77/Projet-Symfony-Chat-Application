
$(document).ready(function(){
    
    /**
     * class for tabs fonctionnality
     */
    class Tabs extends HTMLElement{

        // function qui sera appeler lorsque l'element sera connecter au DOM
        connectedCallback(){
            $(this).attr("role", "tab")
            const tabs = $(this).children('a')
            const hash = window.location.hash.replace('#', '')
            let currentTab = tabs[0]

            // NB: avec la boucle for l'index est en string et la recuperation des elements ne fonctinne pas
            // tres bien, on rencontre des errors
            // il faut utiliser foreach qui met l'index en entier
            tabs.each((i, tab) => { // (index, item)
                const id = tab.getAttribute("href").replace('#', '')
                const tabpanel = document.getElementById(id)

                if(hash == id){
                    currentTab = tab // sera = au tab contenu dans le hash
                }
                $(tab).attr("aria-selected", "false")
                $(tab).attr("tabindex", "-1")
                $(tab).attr("aria-controls", id)
                $(tab).attr("id", "tab-"+ id);
                $(tabpanel).attr("role", "tabpabel");
                $(tabpanel).attr("aria-labelledby", "tab-"+ id);
                $(tabpanel).attr("hidden","hidden");
                $(tabpanel).attr("tabindex", "0");

                // gestion de la navigation avec les touches arrow
                $(tab).keyup((e) => { 
                    let index = null
                    if(e.key === "ArrowRight"){
                        index = i == tabs.length -1 ? 0 : i + 1
                    }else if(e.key === "ArrowLeft"){
                        index = i == 0 ? tabs.length -1 : i - 1
                    }else if(e.key === "Home"){ // pour aller au debut
                        index = 0
                    }else if(e.key === "End"){ // pour aller a la fin
                        index = tabs.length -1
                    }
                    if(index !== null){
                        this.activate(tabs[index])
                        tabs[index].focus()
                    }
                    
                });
                // activation d'un element
                $(tab).click((e)=>{
                    e.preventDefault()
                    this.activate(tab)
                })
            });

            this.activate(currentTab, false)
        }

        /**
         * @param {HTMLElement} tab
         * @param {Boolean} changeHash
         */
        activate(tab, changeHash = true){
            const currentTab = document.querySelector('[aria-selected="true"]')
            // il desactive l'ongle actif avant le click
            if(currentTab !== null){
                const tabpanel = $('#'+ $(currentTab).attr('aria-controls'))
                // console.log(tabpanel)
                $(currentTab).attr("aria-selected", "false")
                $(currentTab).attr("tabindex", "-1")
                $(tabpanel).attr("hidden", "hidden");
            }

            // avant d'activer celui sur le quel on a cliker
            const id = tab.getAttribute("href").replace('#', '')
            const tabpanel = document.getElementById(id)
            $(tab).attr("aria-selected", "true");
            $(tab).attr("tabindex", "0");
            $(tabpanel).removeAttr("hidden");

            // gestion de l'url
            // window.location.hash = id // => cette methode effectue un scroll a chaque modificatio du hash
            // on utilisera 
            if(changeHash){
                // evite d'uploader le hash des le chargement de la page, ca se fera selement
                // lorsqu'on navigue sur un onglet
                window.history.replaceState({}, '', '#'+id)
            }
        }

        
    }
    // creation d'un element html personaliser
    customElements.define('nav-tabs', Tabs);

    // ---------------------------------------- //

    /**
     * class for projects fonctionnalties
     * 
     */

    class Wanna{

        /**
         * create a accordion fonctionnality
         * @param {array} accordions 
         */
        createAccordion(accordions){
            $.each(accordions, function (i, acc) { 
                $(acc).on("click", function(){
                    this.classList.toggle("active");
                    $(this).parent().next().fadeToggle()
                })
            });
        }

        /**
         * change color accordion onClick
         */
        changeAccordionColor(items){
            $.each(items, function(i, item){
                $(item).on("click", function(){
                    $(this).toggleClass("active")
                })
            })
        }

        /**
         * hide and show the chat slide menu
         */
        hideAndShowSlideMenu(button, slideMenu){
            
            $(button).on("click", function(){
                // console.log(navWidht)
                const navWidth = $("nav").width()
                const mainWidth = $("main").width()
                $(slideMenu).toggleClass("active")

                if($(this).children("svg").hasClass("fa-arrow-left")){
                    $(this).children("svg").removeClass("fa-arrow-left").addClass("fa-arrow-right")
                    $("main .user-chat").css("position", "fixed")
                    $("main .user-chat").css("top", "0")
                    $("main .user-chat").css("right", "-"+ Math.ceil(navWidth))
                    $("main .user-chat").css("height",  "100vh")
                    $("main .user-chat").css("width",  mainWidth-navWidth)

                }else{
                    $(this).children("svg").removeClass("fa-arrow-right").addClass("fa-arrow-left")
                    $("main .user-chat").css("position", "")
                    $("main .user-chat").css("width",  "100%")
                }
            })

            window.addEventListener("resize",(e)=>{
                // le probleme etait le moment de la creation de ces 2 constantes pour le calcule
                // il faut dans chaque event qu'il recupere les 2 width au lieu de les initialiser en haut des le debut du script
                // alhamdoulillah
                const navWidth = $("nav").width()
                const mainWidth = $("main").width()
                // si le svg est right et qu'on resize le window on recalcule le width
                if($(button).children("svg").hasClass("fa-arrow-right")){
                    // $("main .user-chat").css("right", "-"+ Math.ceil(navWidth))
                    $("main .user-chat").css("width",   mainWidth-navWidth) 
                }else{
                    $("main .user-chat").css("width",  "100%")
                }
                // console.log($(button).children("svg").hasClass("fa-arrow-right"))
            })

            
        }

        /**
         * create a dropdown
         */
        createDropdown(btns){
            $(btns).each(function(i, btn){
                $(btn).on("click", (e)=>{
                    $(btn).next("#dropdown").toggleClass("active")
                })
            })
        }

        /**
         * dark and light theme switch
         */
        lightDarkWwitchTheme(dark, light){
            $(dark).on("click", function(){
                if(!$(dark).hasClass("active")){
                    $(dark).addClass("active")
                    $(light).removeClass("active")
                    $("#root").removeClass("active")
                    $("footer").removeClass("active")
                }
            })

            $(light).on("click", function(){
                if(!$(light).hasClass("active")){
                    $(light).addClass("active")
                    $(dark).removeClass("active")
                    $("#root").addClass("active")
                    $("footer").addClass("active")
                }
            })
        }

        /**
         * show and hide password fonctionality
         */
        hideSowPassword(eye){
            $(eye).on("click", function(e){
                console.log()
                if($(this).children("svg").hasClass("fa-eye")){
                    $(this).children("svg").removeClass("fa-eye")
                    $(this).children("svg").addClass("fa-eye-slash")
                    $("#password input").attr("type", ()=>{ return "text" })
                }else{
                    $(this).children("svg").removeClass("fa-eye-slash")
                    $(this).children("svg").addClass("fa-eye")
                    $("#password input").attr("type", ()=>{ return "password" })
                }
            })
        }

        

        /**
         * discard effect when click on window
         * @param {string} item
         */
        discardEvents(){
           // Close the dropdown if the user clicks outside of it
            $(window).on("click", (event)=>{
                // console.log($("#close"))
                // console.log(event.target.matches("#btn-dropdown")) // => return true si l'evenement de l'element est declencher
                if (!event.target.matches("#btn-dropdown")) {
                    // si l'event du button dropdown est declencher on retire la class active
                    // pour masquer la dropdown
                    $(".contacts-content .dropdown").removeClass("active")
                }
                if (!event.target.matches("#open-profile")) {
                    $("#close-profile").removeClass("active")
                }
            })
        }

        /**
         * enable error color on fields
         */
        enableErrorColor(input){
            // console.log($(input).hasClass('isInvalid'))
            $(input).each(function(i, item){
                if($(item).hasClass('is-invalid')){
                    $(this).css("border-color", "red")
                    $(this).next().css("color", "red").css("font-size", "12px")
                }
            })
            
        }

        async fetchImage(url, inputFile){
            const form = new FormData()
            form.append("file", $(inputFile).prop('files')[0].name)
            console.log(form)
            const res = await fetch(url, {
                headers: {
                    'X-Requested-Width': 'XMLHttpRequest'
                },
                method: "POST",
                body: form
            })
            if(res.ok){
                const data = await res.json()
                console.log(data)
            }
        }

    }

    const w = new Wanna();
    try {
        w.createAccordion($(".parameter #accordion"))
        w.changeAccordionColor($(".parameter .button-accordion"))
        w.hideAndShowSlideMenu($("#tab .show-hide-arrow"), $("main .chat-slide-menu"))
        w.lightDarkWwitchTheme($("#setting .parameter .dark"), $("#setting .parameter .light"))
        w.hideSowPassword($("#eye"))
        w.discardEvents()
        w.enableErrorColor($("#form-signup input"))
        w.createDropdown($(".contacts-content .btn-dropdown"))
        
    } catch (error) {
        console.log("il ya eu un soucis dans script.js \n" + error)
    }

    
});