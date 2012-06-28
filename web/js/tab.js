/*
$(function(){     
  //$("ul.panel li:not("+$("ul.tabrow li.selected a").attr("href")+")").hide()     
  $("ul.tabrow li a").click(function(){ 
    $("ul.tabrow li").removeClass("selected")   
    $(this.parentNode).addClass("selected")   
    //$("ul.panel li").hide()      
    //$($(this.parentNode).attr("href")).show()
    //  
    //$("a[href]").click()
    //return false   
    stopPropagation()
  })
}) 
*/
$(function(){    
  $("ul.panel li:not("+$("ul.tabrow li.selected a").attr("href")+")").hide()  
  $("ul.tabrow li a").click(function(){
    $("ul.tabrow li").removeClass("selected")  
    $(this.parentNode).addClass("selected")       
    $("ul.panel li").hide()    
    $($(this.parentNode).attr("href")).show()   
    //return false 
  })
})