  $( document ).ready(function() { 
        
        var fav_res = Cookies.get("fav-res");
        var fav_res_arr = [];
        if(fav_res){
            fav_res_arr = fav_res.split(".");
            fav_res_arr = $.map( fav_res_arr, function(v){
                return v === "" ? null : v;
            });           
        }
        
        $(".btn-fav-res").each(function(){
            var id = $(this).attr("attr-id");

            if($.inArray(id.toString(),fav_res_arr) >= 0){
                $(this).addClass("rediconcolor");                
            }else{
                $(this).addClass("blackiconcolor");
            }
        });
        $(".btn-fav-res").on('click',function(){
            var id = $(this).attr("attr-id");
            
            var key = $.inArray(id.toString(),fav_res_arr);
            if(key >= 0){
                $(this).removeClass("rediconcolor");
                $(this).addClass("blackiconcolor");
                delete fav_res_arr[key];               
            }else{
                $(this).removeClass("blackiconcolor");
                $(this).addClass("rediconcolor");
                fav_res_arr.push(id);                
            }
            var fav_id_str = fav_res_arr.join(".").trim();
            Cookies.set("fav-res",fav_id_str,{expires:365, path: '/' });
            //setCookieFav(fav_id_str);
        });
    });
    function setCookieFav(favRes){
        $.ajax({
            method: "GET",
            url: "/cookie/favres",
            data: { favres: favRes}
        })
        .done(function( msg ) {
            //Salert( "Data Saved: " + msg );
        });
    }