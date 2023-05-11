// toutes les requetes d'ajax

$(document).ready(()=>{

    class SlideBarDatas{

        constructor(links){
            this.links = links
            this.bindEvents()
        }

        bindEvents(){
            $(this.links).each((i, a)=>{
                // console.log(a)
                // $(a).on("click", (e)=>{
                    // e.preventDefault()
                    // au lieu de recuperer les elements lors d'un click on les recupere tous et on les affiche
                    if($(a).attr("href") === "#contact"){
                        // go to /contact
                        this.loadUrl("/contact", $("#contact").children(".contacts-content"))
                    }else if($(a).attr("href") === "#message"){
                        // go to /message
                        // this.loadUrl("/messages")
                        console.log("not worked yet")
                    }else if($(a).attr("href") === "#profile"){
                        // go to /profile
                        // this.loadUrl("/profile")
                        console.log("not worked yet")
                    }else if($(a).attr("href") === "#setting"){
                        // got to /settings
                        // this.loadUrl("/settings")
                        console.log("not worked yet")
                    }
                // })

            })
            // this.loadUrl("/contact")
            
        }

        // une fonction asyncrone est une fonction qui renvoie toujours une Promesse{} objet JS
        async loadUrl(url, content){
            const res = await fetch(url, {
                headers: {
                    'X-Requested-Width': 'XMLHttpRequest'
                }
            })

            if(res.ok){
                // on recupere les data si tout se passe bien
                const data = await res.json()
                $(content).html(data.content);
                // console.log(data)
            }
        }
    
    }
    new SlideBarDatas($("#tab a"));
})